<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Class Schedule</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

  <div class="dashboard-wrapper">

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

        <a href="{{ route('profile.settings') }}" class="menu-item">
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

    <div class="app-shell">

      <main class="main-content">

      <div class="page-header" style="
  margin-bottom: 2rem; 
  padding: 0.5rem 1.5rem 0 1.5rem; 
  display: flex; 
  justify-content: space-between; 
  align-items: flex-end;
">
  <div>
    <div style="
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.85rem;
      color: #666666;
      margin-bottom: 0.4rem;
    ">
      <span style="display: inline-flex; align-items: center;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dd6b20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v5" />
          <path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v6" />
          <path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8" />
          <path d="M6 14v-1.5a1.5 1.5 0 0 0-3 0V18a6 6 0 0 0 6 6h4a6 6 0 0 0 6-6v-3" />
        </svg>
      </span>
      <span>Hello,</span>
      
      <span style="
        background: #fdf0f0; 
        color: #c62828; 
        padding: 2px 8px; 
        border-radius: 6px; 
        font-weight: 600;
        font-size: 0.8rem;
      ">
        {{ auth()->check() ? explode(' ', auth()->user()->name)[0] : 'Guest' }}
      </span>
    </div>

    <h1 style="
      font-size: 1.85rem;
      font-weight: 700;
      letter-spacing: -0.5px;
      color: #1c1c1e;
      margin: 0;
    ">
      Invest in your <span style="color: #5b3ca8;">education.</span>
    </h1>
  </div>

  <div style="text-align: right; padding-bottom: 2px;">
    <span style="
      font-size: 0.65rem; 
      font-weight: 700; 
      color: #999999; 
      text-transform: uppercase; 
      letter-spacing: 1px; 
      display: block;
      margin-bottom: 2px;
    ">Today</span>
    <span style="
      font-size: 0.9rem; 
      font-weight: 600; 
      color: #1c1c1e;
    ">
      {{ now()->setTimezone('Asia/Manila')->format('D, M d, Y') }}
    </span>
  </div>
</div>

        <div class="page-body">

          <div class="stats-row">
            <div class="stat-card pink">
              <div class="stat-card-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
              </div>
              <div class="stat-card-num">{{ $totalSchedules ?? 0 }}</div>
              <div class="stat-card-lbl">Total Schedules</div>
            </div>
            <div class="stat-card lavender">
              <div class="stat-card-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
              </div>
              <div class="stat-card-num">{{ $totalSubjects ?? 0 }}</div>
              <div class="stat-card-lbl">Subjects</div>
            </div>
            <div class="stat-card mint">
              <div class="stat-card-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
              </div>
              <div class="stat-card-num">{{ $totalProfessors ?? 0 }}</div>
              <div class="stat-card-lbl">Professors</div>
            </div>
            <div class="stat-card peach">
              <div class="stat-card-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
              </div>
              <div class="stat-card-num">{{ $totalRooms ?? 0 }}</div>
              <div class="stat-card-lbl">Rooms</div>
            </div>
          </div>

          <div class="filter-tabs">
            <a href="{{ route('dashboard') }}" class="filter-tab {{ !$selectedDay ? 'active' : '' }}">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
              All
            </a>
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
              <a href="{{ route('dashboard', ['day' => $day]) }}" class="filter-tab {{ $selectedDay === $day ? 'active' : '' }}">{{ $day }}</a>
            @endforeach
          </div>

          <h2 class="section-heading">{{ $selectedDay ? $selectedDay . '\'s' : 'All' }} schedules</h2>
          <div class="cards-grid">
            @php $colors = ['pink','lavender','mint','peach']; @endphp
            @forelse($schedules as $i => $schedule)
              <div class="course-card {{ $colors[$i % count($colors)] }}">
                <div class="badge-time">{{ $schedule->time_start }}</div>
                <div class="card-tag">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                  {{ $schedule->section }} · {{ $schedule->year_level }}
                </div>
                <div class="card-title">{{ $schedule->subject }}</div>
                <div class="card-meta">{{ $schedule->professor }}</div>
                <div class="card-meta" style="margin-top:4px;">
                  Room {{ $schedule->room }} · {{ $schedule->time_start }} – {{ $schedule->time_end }}
                </div>
              </div>
            @empty
              <div class="course-card pink" style="grid-column: 1 / -1; text-align: center; padding: 2rem;">
                <div style="font-size: 1rem; color: var(--text-secondary);">No schedules found for this day.</div>
              </div>
            @endforelse
          </div>

        </div>
      </main>

      <aside class="right-panel">

        <div class="panel-section">
          <div class="profile-card-mini">
            <div class="profile-avatar-lg">{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'G' }}</div>
            <div class="profile-name">{{ auth()->check() ? auth()->user()->name : 'Annette Black' }}</div>
            <div class="profile-role">{{ auth()->check() ? ucfirst(auth()->user()->role ?? 'User') : 'Student' }}</div>
          </div>
        </div>

        <div class="panel-section panel-section--bordered">
          <h3>Activity · {{ now()->format('Y') }}</h3>
          <div class="activity-bar-chart">
            @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $m)
              @php $h = rand(20, 80); @endphp
              <div class="bar-col">
                <div class="bar-fill {{ $m === now()->format('M') ? 'bar-fill--active' : '' }}" style="height:{{ $h }}%"></div>
                <span class="bar-label">{{ $m }}</span>
              </div>
            @endforeach
          </div>
        </div>

        <div class="panel-section panel-section--bordered">
          <h3>My schedules</h3>
          <div class="my-schedules-list">
            @forelse($mySchedules ?? [] as $s)
              <div class="schedule-mini-card">
                <div class="schedule-mini-title">{{ $s->subject }}</div>
                <div class="schedule-mini-meta">{{ $s->section }}</div>
              </div>
            @empty
              <div class="schedule-mini-card">
                <div class="schedule-mini-title">Flutter Masterclass (Dart, APIs)</div>
                <div class="schedule-mini-meta">9,530 students</div>
              </div>
            @endforelse
          </div>
        </div>

      </aside>

    </div>

  </div>

</body>
</html>