<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .table-container {
            background: #ffffff;
            border: 1px solid #e0dcd5;
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.01);
            margin-top: 1rem;
        }
        .table-header { margin-bottom: 1.5rem; }
        .search-input { 
            padding: 10px 14px; border: 1px solid #e0dcd5; 
            border-radius: 10px; outline: none; background: #faf9f5; font-size: 0.9rem;
        }
        .form-select { 
            padding: 10px 14px; border: 1px solid #e0dcd5; 
            border-radius: 10px; background: #faf9f5; outline: none; font-size: 0.9rem;
        }
.form-group { margin-bottom: 0.4rem; }
.form-label { font-size: 0.75rem; font-weight: 600; color: #666; margin-bottom: 2px; display: block; }
.form-input, .form-select { padding: 8px 10px !important; font-size: 0.85rem !important; border-radius: 8px !important; }
.form-row { display: flex; gap: 8px; }
.form-row > .form-group { flex: 1; }
.error-msg { font-size: 0.7rem; color: #c62828; margin-top: 1px; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 16px; border-radius: 12px; font-weight: 600;
            font-size: 0.9rem; border: 1px solid #e0dcd5;
            cursor: pointer; transition: 0.2s; background: white; color: #1c1c1e;
        }
        .btn-primary { background: #1c1c1e; color: white; border: none; }
        .btn-primary:hover { background: #333333; }
        .btn-secondary:hover { background: #f5f4ee; }
        .btn-danger { background: #ffebee; color: #c62828; border-color: #ffcdd2; }
        .btn-danger:hover { background: #ffcdd2; }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; border-radius: 8px; }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 12px; color: #666666; font-size: 0.85rem; font-weight: 600; border-bottom: 1px solid #e0dcd5; }
        td { padding: 14px 12px; border-bottom: 1px solid #e0dcd5; font-size: 0.9rem; color: #1c1c1e; }
        
        .badge { padding: 4px 8px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .badge-pink { background: #fdf0f0; color: #c62828; }
        .badge-lavender { background: #f0ecf9; color: #6b46c1; }
        .badge-mint { background: #eef8f3; color: #2f855a; }
        .badge-peach { background: #fdf3eb; color: #dd6b20; }
        .td-actions { display: flex; gap: 6px; }

        .schedule-table { width: 100%; table-layout: fixed; }
        .time-col { width: 70px; font-weight: 600; color: #666666; font-size: 0.8rem; }
        .sched-cell { 
            padding: 10px; border-radius: 10px; font-size: 0.8rem; line-height: 1.4; 
            border: 1px solid #e0dcd5; margin-bottom: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        }

        .alert-conflict { 
            background: #ffebee; color: #c62828; padding: 14px; 
            border-radius: 12px; margin-bottom: 1.5rem; display: flex; 
            align-items: center; gap: 10px; border: 1px solid #ffcdd2; font-size: 0.9rem;
        }

        .modal-overlay { 
    position: fixed; top:0; left:0; right:0; bottom:0; 
    background: rgba(0,0,0,0.4); display: flex; 
    align-items: center; justify-content: center; z-index: 999; 
    overflow: hidden; 
}
.modal-box { 
    background: white; padding: 1.25rem 1.5rem; border-radius: 20px; 
    width: 100%; max-width: 460px; max-height: 90vh;
    border: 1px solid #e0dcd5; box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
    display: flex; flex-direction: column; overflow-y: auto; 
}
        .modal-title { margin-top: 0; font-size: 1.4rem; font-weight: 700; letter-spacing: -0.5px; color: #1c1c1e; }
        .sidebar { 
    display: flex; 
    flex-direction: column; 
    height: 100vh; 
        }
.sidebar-menu { 
    display: flex; 
    flex-direction: column; 
    flex: 1; 
}
    </style>
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
      Schedule <span style="color: #5b3ca8;">Management.</span>
    </h1>
  </div>

  <div style="padding-bottom: 2px;">
    <button class="btn btn-primary" onclick="openModal('modal-create')" style="
      display: inline-flex; 
      align-items: center; 
      gap: 8px;
      padding: 10px 16px; 
      border-radius: 12px; 
      font-weight: 600;
      font-size: 0.9rem; 
      background: #1c1c1e; 
      color: white; 
      border: none;
      cursor: pointer;
      transition: 0.2s;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    " onmouseover="this.style.background='#333333'" onmouseout="this.style.background='#1c1c1e'">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <line x1="12" y1="5" x2="12" y2="19"/>
        <line x1="5" y1="12" x2="19" y2="12"/>
      </svg>
      Add Schedule
    </button>
  </div>
</div>

        <div class="page-body">

          @if(session('conflict'))
            <div class="alert alert-conflict">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/></svg>
              <strong>Conflict Detected:</strong> {{ session('conflict') }}
            </div>
          @endif

          <div class="filter-tabs" style="margin-bottom: 1.5rem;">
            <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}" class="filter-tab {{ ($view ?? 'list') === 'list' ? 'active' : '' }}">List View</a>
            <a href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}" class="filter-tab {{ ($view ?? 'list') === 'grid' ? 'active' : '' }}">Weekly Overview</a>
          </div>

            @if(($view ?? 'list') === 'grid')
            <div class="table-container" style="overflow-x:auto;">
              <table class="schedule-table">
                <thead>
                  <tr>
                    <th class="time-col">Time</th>
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $d)
                      <th>{{ $d }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @php
                    $timeSlots = ['07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00'];
                    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                    $colors2 = ['pink' => '#fdf0f0','lavender' => '#f0ecf9','mint' => '#eef8f3','peach' => '#fdf3eb'];
                    $colorKeys = array_keys($colors2);
                  @endphp
                  @foreach($timeSlots as $time)
  <tr>
    <td class="time-col">{{ $time }}</td>
    @foreach($days as $day)
      <td>
        {{-- Dito ang pagbabago: --}}
        @foreach($schedules as $s)
            @php
                // Kinukuha lang ang HH:MM para mag-match sa $time variable mo
                $schedStart = substr($s->time_start, 0, 5); 
            @endphp

            @if($s->day == $day && $schedStart == $time)
                <div class="sched-cell" style="background: #f0f4ff; border-color: #c3dafe;">
                    <strong style="display:block; font-size: 0.75rem;">{{ $s->subject }}</strong>
                    <span style="font-size: 0.7rem; color: #4a5568;">{{ $s->professor }}</span>
                </div>
            @endif
        @endforeach
      </td>
    @endforeach
  </tr>
@endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="table-container">
              <div class="table-header">
              <form action="{{ route('schedule.index') }}" method="GET" style="display:flex; gap:0.5rem; align-items: center; flex-wrap:wrap;">
  @if(request('view'))<input type="hidden" name="view" value="{{ request('view') }}">@endif
  
  <div style="position:relative; display:flex; align-items:center; flex:1; min-width: 250px;">
    <input type="text" name="search" class="search-input" placeholder="Search subject, professor..." value="{{ request('search') }}" style="width: 100%; padding-right: 40px;">
    
    <button type="submit" style="
      position: absolute; right: 8px; background: transparent; border: none; 
      cursor: pointer; color: #666; display: flex; align-items: center;
    ">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
    </button>
  </div>

  <select name="day" class="form-select" onchange="this.form.submit()">
    <option value="">All Days</option>
    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $d)
      <option value="{{ $d }}" {{ request('day') === $d ? 'selected' : '' }}>{{ $d }}</option>
    @endforeach
  </select>
</form>
              </div>

              <table>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Professor</th>
                    <th>Section</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Room</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($schedules ?? [] as $i => $s)
                  @php $colors3 = ['badge-pink','badge-lavender','badge-mint','badge-peach']; @endphp
                  <tr>
                    <td style="color:#999999;">{{ $i + 1 }}</td>
                    <td><strong>{{ $s->subject }}</strong></td>
                    <td>{{ $s->professor }}</td>
                    <td><span class="badge badge-lavender">{{ $s->section }}</span></td>
                    <td><span class="badge {{ $colors3[$i % 4] }}">{{ $s->day }}</span></td>
                    <td>{{ $s->time_start }} – {{ $s->time_end }}</td>
                    <td>{{ $s->room }}</td>
                    <td>
  <div class="td-actions" style="display: flex; gap: 6px;">
    <button class="btn btn-secondary btn-sm" onclick='openEditModal(@json($s))'>Edit</button>
    
    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $s->id }}')">
        Delete
    </button>
    <form id="delete-form-{{ $s->id }}" action="{{ route('schedule.destroy', $s->id) }}" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>
  </div>
</td>
                  </tr>
                  @empty
                  <tr><td colspan="8" style="text-align:center; padding:3rem; color:#999999;">No schedules found.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          @endif

        </div>
      </main>

      <aside class="right-panel" style="
  background: #f4f7fc; 
  border-left: 1px solid #e2e8f0; 
  padding: 1.25rem 1rem; 
  overflow: hidden; 
  display: flex; 
  flex-direction: column; 
  justify-content: space-between; 
  height: 100%; 
  box-sizing: border-box;
">

  <div>
    <div class="panel-section" style="margin-bottom: 1rem; text-align: center;">
      <div class="profile-card-mini" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
        <div class="profile-avatar-lg" style="
          width: 52px; 
          height: 52px; 
          background: #dbeafe; 
          color: #1e40af; 
          border-radius: 50%; 
          display: flex; 
          align-items: center; 
          justify-content: center; 
          font-weight: 700; 
          font-size: 1.2rem;
          box-shadow: 0 4px 10px rgba(30, 64, 175, 0.08);
        ">
          {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'N' }}
        </div>
        <div class="profile-name" style="font-weight: 700; color: #1e293b; font-size: 1rem; margin-top: 2px;">
          {{ auth()->check() ? auth()->user()->name : 'Ningning Louise' }}
        </div>
        <div class="profile-role" style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
          {{ auth()->check() ? ucfirst(auth()->user()->role ?? 'User') : 'User' }}
        </div>
      </div>
    </div>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 1rem 0;">

    <div class="panel-section" style="margin-bottom: 1rem;">
  <h3 style="...">Day Summary</h3>
  
  <div style="display: flex; flex-direction: column; gap: 10px;">
    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $d)
      {{-- DITO: Gamitin ang $allSchedules --}}
      @php $cnt = collect($allSchedules ?? [])->where('day',$d)->count(); @endphp
      
      <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem;">
        <span style="font-weight: 600; color: #334155;">{{ $d }}</span>
        <div style="display: flex; align-items: center; gap: 8px;">
          <div style="height: 5px; width: 50px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
            <div style="height: 100%; width: {{ $cnt > 0 ? min(100, $cnt * 25) : 0 }}%; background: #3b82f6; border-radius: 10px;"></div>
          </div>
          <span style="color: #64748b; font-size: 0.75rem; font-weight: 700;">{{ $cnt }}</span>
        </div>
      </div>
    @endforeach
  </div>
</div>

  <div class="panel-section" style="
    background: #eff6ff; 
    border: 1px dashed #bfdbfe; 
    border-radius: 12px; 
    padding: 1rem;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.02);
    margin-top: auto;
  ">
    <h3 style="
      font-size: 0.7rem; 
      font-weight: 700; 
      color: #2563eb; 
      text-transform: uppercase; 
      letter-spacing: 1px; 
      margin: 0 0 0.4rem 0;
      display: flex;
      align-items: center;
      gap: 6px;
    ">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="color: #2563eb; transform: rotate(30deg);">
        <path d="M16 12V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v8l-2 2v2h5.2v6l1.3 1.5 1.3-1.5v-6H18v-2l-2-2z"/>
      </svg>
      Quick Tips
    </h3>
    <p style="font-size: 0.75rem; color: #1e3a8a; line-height: 1.5; margin: 0; font-weight: 500;">
      Conflicts are automatically triggered if the same professor or room gets double-booked within identical time frames.
    </p>
  </div>

</aside>

    </div>
  </div>

  </div> 
  </div> 
  <div id="modal-create" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h2 class="modal-title" style="margin-bottom: 0.75rem;">Add Schedule</h2>
        
        <form action="{{ route('schedule.store') }}" method="POST" style="display:flex; flex-direction:column; gap:0.5rem; flex:1; overflow-y:auto;">
            @csrf
            {{-- Dito nakalagay yung inputs mo --}}
            @include('schedule._form')
            
            <div style="display:flex; gap:0.5rem; margin-top:1rem;">
                <button type="button" class="btn" onclick="closeModal('modal-create')">Cancel</button>
                <button type="submit" class="btn btn-primary" style="flex:1;">Save Schedule</button>
            </div>
        </form>
    </div>
</div>

  <div id="modal-edit" class="modal-overlay" style="display:none;">
    <div class="modal-box">
      <h2 class="modal-title">Edit Schedule</h2>
      <form id="edit-form" action="" method="POST">
        @csrf @method('PUT')
        <div style="display:flex; flex-direction:column; gap:0.6rem;">
          @include('schedule._form', ['edit' => true])
        </div>
        <div style="display:flex; gap:0.75rem; margin-top:1.25rem;">
          <button type="button" class="btn" onclick="closeModal('modal-edit')">Cancel</button>
          <button type="submit" class="btn btn-primary" style="flex:1;">Update Schedule</button>
        </div>
      </form>
    </div>
  </div>

  <script>
  function confirmDelete(id) {
    Swal.fire({
        title: 'Delete this schedule?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c62828',
        cancelButtonColor: '#666',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
    function openModal(id) { document.getElementById(id).style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; document.body.style.overflow = ''; }
    
    function openEditModal(data) {
      const form = document.getElementById('edit-form');
      form.action = `/schedule/${data.id}`;
      // I-fill ang fields base sa data object
      Object.keys(data).forEach(key => {
        const input = form.querySelector(`[name="${key}"]`);
        if (input) input.value = data[key];
      });
      openModal('modal-edit');
    }
  </script>
</body>
</html>