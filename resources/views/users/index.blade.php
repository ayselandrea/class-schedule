@extends('layouts.app')
@section('title', 'User Management')

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">User Management</h1>
    <p class="page-subtitle">Manage system users and permissions</p>
  </div>
  <button class="btn btn-primary" onclick="openModal('modal-create-user')" style="width:auto; margin-top:1.5rem;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add User
  </button>
</div>

<div class="page-body">
  <div class="table-container">
    <div class="table-header">
      <form action="{{ route('users.index') }}" method="GET" style="display:flex; gap:0.75rem; flex-wrap:wrap;">
        <div class="search-input-wrap">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" name="search" class="search-input" placeholder="Search name or email…" value="{{ request('search') }}">
        </div>
        <select name="role" class="form-select" style="width:auto; padding:0.55rem 1rem;">
          <option value="">All Roles</option>
          <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        @if(request()->hasAny(['search','role']))
          <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Clear</a>
        @endif
      </form>
      <div style="font-size:0.82rem; color:var(--text-muted);">{{ $users->total() ?? 0 }} users</div>
    </div>

    <table>
      <thead>
        <tr>
          <th>User</th>
          <th>Email</th>
          <th>Role</th>
          <th>Joined</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
        <tr>
          <td>
            <div style="display:flex; align-items:center; gap:10px;">
              <div style="width:36px; height:36px; border-radius:50%; background:var(--lavender); display:flex; align-items:center; justify-content:center; font-weight:600; font-size:0.85rem; color:#3C3489; flex-shrink:0;">
                {{ strtoupper(substr($u->name,0,1)) }}
              </div>
              <strong>{{ $u->name }}</strong>
            </div>
          </td>
          <td style="color:var(--text-secondary);">{{ $u->email }}</td>
          <td>
            @if($u->role === 'admin')
              <span class="badge badge-admin">Admin</span>
            @else
              <span class="badge badge-lavender">User</span>
            @endif
          </td>
          <td style="color:var(--text-muted);">{{ $u->created_at->format('M d, Y') }}</td>
          <td>
            <div class="td-actions">
              @if($u->id !== auth()->id())
                <button class="btn btn-secondary btn-sm"
                  onclick='openEditUserModal({{ json_encode($u) }})'>
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  Edit
                </button>
                <form action="{{ route('users.destroy', $u->id) }}" method="POST"
                      onsubmit="return confirm('Delete {{ $u->name }}?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Delete
                  </button>
                </form>
              @else
                <span style="font-size:0.8rem; color:var(--text-muted);">You</span>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="text-align:center; padding:3rem; color:var(--text-muted);">
            <div style="font-size:2rem; margin-bottom:0.5rem;">👥</div>
            No users found.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div class="pagination">{{ $users->links() }}</div>
  </div>
</div>

{{-- Create Modal --}}
<div id="modal-create-user" class="modal-overlay" style="display:none;" onclick="closeModalOnBg(event,'modal-create-user')">
  <div class="modal-box">
    <h2 class="modal-title">Add User</h2>
    <form action="{{ route('users.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Maria Santos" required />
      </div>
      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="maria@school.edu" required />
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" placeholder="Min. 8 chars" required />
        </div>
        <div class="form-group">
          <label class="form-label">Role</label>
          <select name="role" class="form-select" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
      </div>
      <div style="display:flex; gap:0.75rem; margin-top:1.5rem; justify-content:flex-end;">
        <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create-user')">Cancel</button>
        <button type="submit" class="btn btn-primary" style="width:auto;">Create User</button>
      </div>
    </form>
  </div>
</div>

{{-- Edit Modal --}}
<div id="modal-edit-user" class="modal-overlay" style="display:none;" onclick="closeModalOnBg(event,'modal-edit-user')">
  <div class="modal-box">
    <h2 class="modal-title">Edit User</h2>
    <form id="edit-user-form" action="" method="POST">
      @csrf @method('PUT')
      <div class="form-group">
        <label class="form-label">Full Name</label>
        <input type="text" id="edit-name" name="name" class="form-input" required />
      </div>
      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" id="edit-email" name="email" class="form-input" required />
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">New Password <span style="color:var(--text-muted); font-weight:400;">(leave blank to keep)</span></label>
          <input type="password" name="password" class="form-input" placeholder="New password…" />
        </div>
        <div class="form-group">
          <label class="form-label">Role</label>
          <select id="edit-role" name="role" class="form-select" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
      </div>
      <div style="display:flex; gap:0.75rem; margin-top:1.5rem; justify-content:flex-end;">
        <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-user')">Cancel</button>
        <button type="submit" class="btn btn-primary" style="width:auto;">Update User</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function openModal(id) { document.getElementById(id).style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).style.display = 'none'; document.body.style.overflow = ''; }
function closeModalOnBg(e, id) { if (e.target.id === id) closeModal(id); }
function openEditUserModal(u) {
  document.getElementById('edit-user-form').action = `/users/${u.id}`;
  document.getElementById('edit-name').value = u.name;
  document.getElementById('edit-email').value = u.email;
  document.getElementById('edit-role').value = u.role;
  openModal('modal-edit-user');
}
</script>
@endpush
@endsection

@section('right-panel')
<div class="panel-section">
  <h3>Role Overview</h3>
  @php
    $adminCount = $users->where('role','admin')->count();
    $userCount  = $users->where('role','user')->count();
  @endphp
  <div style="display:flex; flex-direction:column; gap:10px;">
    <div style="background:var(--sidebar-bg); border-radius:var(--radius-md); padding:12px 14px; display:flex; justify-content:space-between; align-items:center;">
      <span style="color:white; font-size:0.85rem;">Admins</span>
      <span style="color:white; font-weight:600;">{{ $adminCount }}</span>
    </div>
    <div style="background:var(--lavender-light); border:1px solid var(--lavender); border-radius:var(--radius-md); padding:12px 14px; display:flex; justify-content:space-between; align-items:center;">
      <span style="font-size:0.85rem;">Users</span>
      <span style="font-weight:600;">{{ $userCount }}</span>
    </div>
  </div>
</div>
@endsection
