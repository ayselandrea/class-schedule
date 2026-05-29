@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">My Profile</h1>
    <p class="page-subtitle">Manage your account settings</p>
  </div>
</div>

<div class="page-body">
  <div class="profile-hero">
    <div class="profile-avatar-xl">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    <div class="profile-info">
      <h2>{{ auth()->user()->name }}</h2>
      <p>{{ auth()->user()->email }}</p>
      <p style="margin-top:4px;">
        @if(auth()->user()->role === 'admin')
          <span class="badge badge-admin">Admin</span>
        @else
          <span class="badge badge-lavender">User</span>
        @endif
        &nbsp; Joined {{ auth()->user()->created_at->format('F Y') }}
      </p>
    </div>
  </div>

  <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; align-items:start;">

    {{-- Update Profile --}}
    <div class="profile-form-card">
      <h3>Update Information</h3>
      @if(session('profile_updated'))
        <div class="alert alert-success">Profile updated successfully.</div>
      @endif
      <form action="{{ route('profile.update') }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}"
            value="{{ old('name', auth()->user()->name) }}" required />
          @error('name')<p class="error-msg">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
            value="{{ old('email', auth()->user()->email) }}" required />
          @error('email')<p class="error-msg">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary" style="width:auto; margin-top:0.5rem;">Save Changes</button>
      </form>
    </div>

    {{-- Change Password --}}
    <div class="profile-form-card">
      <h3>Change Password</h3>
      @if(session('password_updated'))
        <div class="alert alert-success">Password changed successfully.</div>
      @endif
      <form action="{{ route('profile.password') }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-group">
          <label class="form-label">Current Password</label>
          <input type="password" name="current_password" class="form-input {{ $errors->has('current_password') ? 'error' : '' }}"
            placeholder="Current password" required />
          @error('current_password')<p class="error-msg">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">New Password</label>
          <input type="password" name="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}"
            placeholder="Min. 8 characters" required />
          @error('password')<p class="error-msg">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Confirm New Password</label>
          <input type="password" name="password_confirmation" class="form-input"
            placeholder="Repeat new password" required />
        </div>
        <button type="submit" class="btn btn-primary" style="width:auto; margin-top:0.5rem;">Update Password</button>
      </form>
    </div>

    {{-- Danger Zone --}}
    <div class="profile-form-card" style="grid-column:1/-1; border-color:var(--pink);">
      <h3 style="color:#993556;">Danger Zone</h3>
      <p style="font-size:0.875rem; color:var(--text-secondary); margin-bottom:1.25rem;">
        Permanently delete your account. This action cannot be undone.
      </p>
      <form action="{{ route('profile.destroy') }}" method="POST"
            onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.')">
        @csrf @method('DELETE')
        <div class="form-group">
          <label class="form-label">Confirm your password to proceed</label>
          <input type="password" name="password" class="form-input" placeholder="Your password" required />
        </div>
        <button type="submit" class="btn btn-danger" style="width:auto;">Delete My Account</button>
      </form>
    </div>
  </div>
</div>
@endsection

@section('right-panel')
<div class="panel-section">
  <h3>Account Stats</h3>
  <div style="display:flex; flex-direction:column; gap:10px;">
    <div style="background:var(--lavender-light); border:1px solid var(--lavender); border-radius:var(--radius-md); padding:12px 14px;">
      <div style="font-size:1.5rem; font-weight:700;">{{ $mySchedules ?? 0 }}</div>
      <div style="font-size:0.75rem; color:var(--text-secondary);">My schedules</div>
    </div>
    <div style="background:var(--mint-light); border:1px solid var(--mint); border-radius:var(--radius-md); padding:12px 14px;">
      <div style="font-size:1.5rem; font-weight:700;">{{ auth()->user()->created_at->diffInDays() }}</div>
      <div style="font-size:0.75rem; color:var(--text-secondary);">Days as member</div>
    </div>
  </div>
</div>

<div class="panel-section" style="border-top:1px solid var(--border); padding-top:1.5rem;">
  <h3>Quick Actions</h3>
  <div style="display:flex; flex-direction:column; gap:8px;">
    <a href="{{ route('schedule.index') }}" class="btn btn-secondary" style="justify-content:flex-start; gap:10px;">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
      View Schedules
    </a>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="justify-content:flex-start; gap:10px;">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Dashboard
    </a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-danger" style="width:100%; justify-content:flex-start; gap:10px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Sign Out
      </button>
    </form>
  </div>
</div>
@endsection
