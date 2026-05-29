<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects - Class Schedule</title>
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
          <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
        </svg>
        <span class="nav-tooltip">Settings</span>
      </a>

      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
         style="display: flex; align-items: center; justify-content: center; color: #c62828 !important; margin-top: auto; padding: 20px 0;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
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

  {{-- ── App Shell ── --}}
  <div class="app-shell">

    <main class="main-content">

    <div class="page-header" style="justify-content: center; text-align: center;">
  <div>
    <h1 class="page-title">Subjects</h1>
    <p class="page-subtitle">All unique subjects from your schedules</p>
  </div>
</div>

      <div class="page-body">

        <div style="
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        ">

          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0;">Subject List</h3>
            <div class="search-input-wrap">
              <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <input type="text" class="search-input" placeholder="Search subjects..." id="subjectSearch" onkeyup="filterSubjects()">
            </div>
          </div>

          <table id="subjectTable" style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                <th style="padding: 12px;">#</th>
                <th style="padding: 12px;">Subject Name</th>
                <th style="padding: 12px;">Sections</th>
                <th style="padding: 12px;">Professors</th>
                <th style="padding: 12px;">Days</th>
              </tr>
            </thead>
            <tbody>
              @forelse($subjects as $i => $subject)
                @php
                  $colors = ['badge-pink','badge-lavender','badge-mint','badge-peach'];
                  $color  = $colors[$i % count($colors)];
                @endphp
                <tr style="border-bottom: 1px solid #f8fafc;">
                  <td style="padding: 12px; color: #94a3b8; font-size: 0.85rem;">{{ $i + 1 }}</td>
                  <td style="padding: 12px;">
                    <span class="badge {{ $color }}" style="white-space: nowrap;">{{ $subject->subject }}</span>
                  </td>
                  <td style="padding: 12px; font-size: 0.85rem; color: #475569;">{{ $subject->sections }}</td>
                  <td style="padding: 12px; font-size: 0.85rem; color: #475569;">{{ $subject->professors }}</td>
                  <td style="padding: 12px; font-size: 0.85rem; color: #475569;">{{ $subject->days }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" style="text-align: center; padding: 2rem; color: #94a3b8;">No subjects found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>

        </div>
      </div>

    </main>

  </div>{{-- /.app-shell --}}

</div>{{-- /.dashboard-wrapper --}}

<script>
function filterSubjects() {
  const input = document.getElementById('subjectSearch').value.toLowerCase();
  const rows = document.querySelectorAll('#subjectTable tbody tr');
  rows.forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(input) ? '' : 'none';
  });
}
</script>

</body>
</html>