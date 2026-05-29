{{-- resources/views/profile/settings.blade.php --}}
@extends('layouts.app')

@section('title', 'Account Settings')

@push('styles')
<style>
    :root {
        --pink-50:  #fdf2f4;
        --pink-100: #fce7eb;
        --pink-300: #f4a3b5;
        --pink-400: #ef7f99;
        --pink-500: #e8536f;
        --pink-600: #d63558;
        --gray-50:  #f8f9fa;
        --gray-100: #f1f3f5;
        --gray-200: #e9ecef;
        --gray-300: #dee2e6;
        --gray-500: #adb5bd;
        --gray-700: #495057;
        --gray-900: #212529;
        --radius:   12px;
        --shadow:   0 2px 12px rgba(0,0,0,.07);
        --shadow-md:0 4px 24px rgba(0,0,0,.10);
    }

    /* ── Page wrapper ──────────────────────────────────── */
    .settings-wrap {
        width: 100%;
        max-width: 680px;
        margin: 0 auto;
        padding: 48px 20px 80px;
        min-height: 100%;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 36px;
        letter-spacing: -.5px;
    }

    /* ── Section card ──────────────────────────────────── */
    .section-card {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 32px;
        margin-bottom: 24px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        color: var(--gray-900);
        margin-bottom: 24px;
        padding-bottom: 14px;
        border-bottom: 2px solid var(--pink-100);
    }

    /* ── Avatar area ───────────────────────────────────── */
    .avatar-row {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 28px;
    }

    .avatar-wrapper {
        position: relative;
        width: 88px;
        height: 88px;
        flex-shrink: 0;
    }

    .avatar-img {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--pink-300);
    }

    .avatar-placeholder {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--pink-300), var(--pink-500));
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #fff;
        border: 3px solid var(--pink-300);
    }

    .avatar-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .avatar-actions label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .85rem;
        font-weight: 600;
        color: var(--pink-600);
        cursor: pointer;
        padding: 7px 16px;
        border: 1.5px solid var(--pink-300);
        border-radius: 8px;
        transition: background .18s, color .18s;
        width: fit-content;
    }

    .avatar-actions label:hover {
        background: var(--pink-50);
    }

    .avatar-actions label svg { width: 14px; height: 14px; }

    #avatar-input { display: none; }

    .btn-remove {
        background: none;
        border: none;
        font-size: .85rem;
        color: var(--gray-500);
        cursor: pointer;
        padding: 4px 0;
        text-align: left;
        font-family: inherit;
        transition: color .18s;
    }

    .btn-remove:hover { color: #c0392b; }

    /* ── Form fields ───────────────────────────────────── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-grid .full { grid-column: 1 / -1; }

    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field label {
        font-size: .78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--gray-500);
    }

    .field input,
    .field select,
    .field textarea {
        padding: 11px 14px;
        border: 1.5px solid var(--gray-200);
        border-radius: 9px;
        font-family: 'DM Sans', sans-serif;
        font-size: .93rem;
        color: var(--gray-900);
        background: var(--gray-50);
        transition: border-color .18s, background .18s, box-shadow .18s;
        outline: none;
        width: 100%;
    }

    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        border-color: var(--pink-400);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(232,83,111,.12);
    }

    .field textarea { resize: vertical; min-height: 80px; }

    .field .error {
        font-size: .78rem;
        color: #c0392b;
        margin-top: 2px;
    }

    /* ── Divider label ─────────────────────────────────── */
    .divider-label {
        font-size: .8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--gray-500);
        margin: 22px 0 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .divider-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--gray-200);
    }

    /* ── Save button ───────────────────────────────────── */
    .btn-save {
        margin-top: 24px;
        padding: 12px 32px;
        background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: .93rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity .18s, transform .12s, box-shadow .18s;
        box-shadow: 0 4px 14px rgba(214,53,88,.28);
    }

    .btn-save:hover  { opacity: .92; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(214,53,88,.34); }
    .btn-save:active { transform: translateY(0); }

    /* ── Password toggle ───────────────────────────────── */
    .pw-wrapper {
        position: relative;
    }

    .pw-wrapper input { padding-right: 42px; }

    .pw-toggle {
        position: absolute;
        right: 13px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--gray-500);
        padding: 0;
        line-height: 1;
        display: flex;
        align-items: center;
    }

    .pw-toggle:hover { color: var(--pink-500); }
    .pw-toggle svg   { width: 17px; height: 17px; }

    /* ── Responsive ────────────────────────────────────── */
    @media (max-width: 768px) {
        .settings-wrap { padding: 32px 16px 60px; }
        .section-card { padding: 24px 20px; }
        .page-title { font-size: 1.6rem; margin-bottom: 28px; }
    }

    @media (max-width: 520px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .full { grid-column: 1; }
        .avatar-row { flex-direction: column; align-items: flex-start; }
        .avatar-actions { width: 100%; }
        .avatar-actions label { width: 100%; justify-content: center; }
        .settings-wrap { padding: 24px 12px 48px; }
        .section-card { padding: 20px 16px; }
        .page-title { font-size: 1.35rem; }
        .section-title { font-size: 1.1rem; }
        .btn-save { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="settings-wrap">

    <h1 class="page-title">Account Settings</h1>

    {{-- ═══════════════════════════════════════════════════
         SECTION 1 — Basic Info + Profile Picture
    ══════════════════════════════════════════════════════ --}}
    <div class="section-card">
        <h2 class="section-title">Basic Info</h2>

        {{-- Profile Picture --}}
        <div class="avatar-row">
            <div class="avatar-wrapper">
                @if($user->avatar)
                    <img id="avatar-preview"
                         class="avatar-img"
                         src="{{ Storage::url($user->avatar) }}"
                         alt="Profile picture">
                @else
                    <div class="avatar-placeholder" id="avatar-preview-placeholder">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <img id="avatar-preview"
                         class="avatar-img"
                         src=""
                         alt="Profile picture"
                         style="display:none;">
                @endif
            </div>

            <div class="avatar-actions">
                {{-- Separate form just for avatar upload --}}
                <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatar-upload-form">
                    @csrf
                    <input type="file" name="avatar" id="avatar-input"
                           accept="image/jpg,image/jpeg,image/png,image/webp"
                           style="display:none;">
                    @error('avatar')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <label for="avatar-input">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 12l-4-4-4 4M12 8v8"/></svg>
                        Upload new picture
                    </label>
                </form>

                @if($user->avatar)
                <form method="POST" action="{{ route('profile.avatar.remove') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-remove">Remove</button>
                </form>
                @endif
            </div>
        </div>

        {{-- Profile Info form (no avatar here) --}}
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="field full">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $user->name) }}"
                           placeholder="Juan dela Cruz"
                           required>
                    @error('name')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field full">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           placeholder="you@example.com"
                           required>
                    @error('email')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth"
                           value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}">
                    @error('date_of_birth')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">— Select —</option>
                        <option value="male"              {{ old('gender', $user->gender) === 'male'              ? 'selected' : '' }}>Male</option>
                        <option value="female"            {{ old('gender', $user->gender) === 'female'            ? 'selected' : '' }}>Female</option>
                        <option value="non-binary"        {{ old('gender', $user->gender) === 'non-binary'        ? 'selected' : '' }}>Non-binary</option>
                        <option value="prefer_not_to_say" {{ old('gender', $user->gender) === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                    </select>
                    @error('gender')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="+63 912 345 6789">
                    @error('phone')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field full">
                    <label for="address">Address</label>
                    <textarea id="address" name="address"
                              placeholder="House / Unit, Street, Barangay, City, Province">{{ old('address', $user->address) }}</textarea>
                    @error('address')<span class="error">{{ $message }}</span>@enderror
                </div>

            </div>

            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════
         SECTION 2 — Account Info
    ══════════════════════════════════════════════════════ --}}
    <div class="section-card">
        <h2 class="section-title">Account Info</h2>

        <form method="POST" action="{{ route('profile.account.update') }}">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="field full">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username"
                           value="{{ old('username', $user->username) }}"
                           placeholder="juandelacruz98"
                           required>
                    @error('username')<span class="error">{{ $message }}</span>@enderror
                </div>

            </div>

            <div class="divider-label">Change Password</div>

            <div class="form-grid">

                <div class="field full">
                    <label for="current_password">Current Password</label>
                    <div class="pw-wrapper">
                        <input type="password" id="current_password" name="current_password"
                               placeholder="Enter current password">
                        <button type="button" class="pw-toggle" onclick="togglePw('current_password', this)" aria-label="Show password">
                            <svg id="eye-current_password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('current_password')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="new_password">New Password</label>
                    <div class="pw-wrapper">
                        <input type="password" id="new_password" name="new_password"
                               placeholder="Min. 8 characters">
                        <button type="button" class="pw-toggle" onclick="togglePw('new_password', this)" aria-label="Show password">
                            <svg id="eye-new_password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('new_password')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <div class="pw-wrapper">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                               placeholder="Repeat new password">
                        <button type="button" class="pw-toggle" onclick="togglePw('new_password_confirmation', this)" aria-label="Show password">
                            <svg id="eye-new_password_confirmation" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn-save">Update Account</button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    /* ── Live avatar preview + auto-submit ───────────── */
    document.getElementById('avatar-input').addEventListener('change', function () {
        if (!this.files.length) return;
        const file = this.files[0];
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-preview-placeholder');
            if (preview) { preview.src = e.target.result; preview.style.display = 'block'; }
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
        // Auto-submit the avatar upload form
        document.getElementById('avatar-upload-form').submit();
    });

    /* ── Password visibility toggle ──────────────────── */
    function togglePw(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';

        const eye = document.getElementById('eye-' + fieldId);
        // Swap icon: closed eye when visible
        eye.innerHTML = isText
            ? `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`
            : `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.23-3.592M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.02 5.292M3 3l18 18"/>`;
    }
</script>
@endpush