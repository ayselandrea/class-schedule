<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'EduSched') }} — @yield('title', 'App')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @stack('styles')
</head>
<body>
<div class="app-layout">

  <aside class="sidebar">

    <div class="sidebar-logo">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <path d="M16 2v4M8 2v4M3 10h18"/>
        <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>
      </svg>
    </div>

    <nav class="sidebar-menu">

      <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1"/>
          <rect x="14" y="3" width="7" height="7" rx="1"/>
          <rect x="3" y="14" width="7" height="7" rx="1"/>
          <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        <span class="nav-tooltip">Dashboard</span>
      </a>

      <a href="{{ route('schedule.index') }}" class="menu-item {{ request()->routeIs('schedule.*') ? 'active' : '' }}">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>
        <span class="nav-tooltip">Schedules</span>
      </a>

      <a href="{{ route('subjects.index') }}" class="menu-item {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
          <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
        </svg>
        <span class="nav-tooltip">Subjects</span>
      </a>

      @if(auth()->check() && auth()->user()->role === 'admin')
      <a href="{{ route('users.index') }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        <span class="nav-tooltip">Users</span>
      </a>
      @endif

      <a href="{{ route('profile.settings') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="3"/>
          <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
        </svg>
        <span class="nav-tooltip">Settings</span>
      </a>

      <div class="sidebar-item logout-section" style="margin-top: auto; padding: 15px 0;">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           style="display: flex; align-items: center; gap: 12px; color: #e53e3e; text-decoration: none; font-weight: 600; padding: 10px 16px; border-radius: 12px; transition: 0.2s;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>

    </nav>

    <div class="sidebar-footer">
      <a href="{{ route('profile.settings') }}" class="profile-avatar-sm">
        @if(auth()->check() && auth()->user()->avatar)
          <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Profile">
        @else
          {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'G' }}
        @endif
      </a>
    </div>

  </aside>

  <div class="main-content">
    <div class="app-shell">
      <div class="content-area">
        @yield('content')
      </div>

      @hasSection('right-panel')
        <aside class="right-panel">
          @yield('right-panel')
        </aside>
      @endif
    </div>
  </div>

</div>

<div id="toast-container"></div>

<div id="flash-data"
     data-success="{{ session('success') }}"
     data-error="{{ session('error') }}"
     style="display:none;"></div>

@stack('scripts')
<script>
  (function() {
    var el = document.getElementById('flash-data');
    if (!el) return;
    var msg = el.getAttribute('data-success') || el.getAttribute('data-error');
    var type = el.getAttribute('data-success') ? 'success' : 'error';
    if (!msg) return;

    var container = document.getElementById('toast-container');
    var toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    toast.innerHTML =
      '<div class="toast-icon">' +
      (type === 'success'
        ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
        : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>') +
      '</div>' +
      '<span class="toast-msg">' + msg + '</span>' +
      '<button class="toast-close" onclick="this.parentElement.remove()">&times;</button>';
    container.appendChild(toast);

    setTimeout(function() {
      toast.classList.add('toast-fade');
      setTimeout(function() { toast.remove(); }, 300);
    }, 4000);

    toast.addEventListener('click', function() {
      toast.classList.add('toast-fade');
      setTimeout(function() { toast.remove(); }, 300);
    });
  })();
</script>
</body>
</html>