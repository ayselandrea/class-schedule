<?php

// app/Http/Controllers/SettingsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        return view('profile.settings', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . auth()->id(),
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|in:male,female,non-binary,prefer_not_to_say',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();
        $user->update($request->only('name', 'email', 'date_of_birth', 'gender', 'phone', 'address'));

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'username'         => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'current_password' => 'nullable|required_with:new_password',
            'new_password'     => 'nullable|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->username = $request->username;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Account updated successfully.');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Profile picture updated.');
    }

    public function removeAvatar()
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return back()->with('success', 'Profile picture removed.');
    }
}