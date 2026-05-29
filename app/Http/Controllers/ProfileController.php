<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the Account Settings page.
     */
    public function index()
    {
        return view('profile.settings', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update basic profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'date_of_birth' => ['nullable', 'date'],
            'gender'      => ['nullable', 'in:male,female,non-binary,prefer_not_to_say'],
            'address'     => ['nullable', 'string', 'max:500'],
            'phone'       => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Upload / change profile picture.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        // Delete old avatar if it exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Profile picture updated.');
    }

    /**
     * Remove profile picture (revert to default).
     */
    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return back()->with('success', 'Profile picture removed.');
    }

    /**
     * Update account credentials (username & password).
     */
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username'              => ['required', 'string', 'max:30', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'current_password'      => ['nullable', 'required_with:new_password', 'string'],
            'new_password'          => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Verify current password before allowing a change
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->username = $validated['username'];
        $user->save();

        return back()->with('success', 'Account info updated successfully.');
    }
}