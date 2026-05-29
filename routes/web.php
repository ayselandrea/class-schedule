<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProfessorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Main route logic
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Schedules
    Route::resource('schedule', ScheduleController::class)->only(['index', 'store', 'update', 'destroy']);

    // Users Management
    Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);

    // Subjects & Professors
    Route::resource('subjects', SubjectController::class);
    Route::resource('professors', ProfessorController::class);

    // Logout Route
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    })->name('logout');

});

Route::middleware(['guest'])->group(function () {

    // LOGIN DISPLAY & ACTION
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Welcome back! Login Successful.');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });

    // REGISTER DISPLAY & ACTION
    Route::get('/register', function () {
        return view('auth.register'); 
    })->name('register');

    Route::post('/register', function (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    });

});
/*
|--------------------------------------------------------------------------
| Profile / Account Settings Routes  (add inside your routes/web.php)
|--------------------------------------------------------------------------
*/


Route::middleware('auth')->group(function () {
    Route::get('/settings',                 [SettingsController::class, 'index'])->name('profile.settings');
    Route::put('/profile/update',           [SettingsController::class, 'update'])->name('profile.update');
    Route::put('/profile/account/update',   [SettingsController::class, 'updateAccount'])->name('profile.account.update');
    Route::delete('/profile/avatar/remove', [SettingsController::class, 'removeAvatar'])->name('profile.avatar.remove');
    Route::post('/profile/avatar',          [SettingsController::class, 'uploadAvatar'])->name('profile.avatar');
});