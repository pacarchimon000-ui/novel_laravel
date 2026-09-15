@extends('layouts.admin')

@section('title', 'Kelola User')
@section('page_title', '👥 Kelola User')

@section('content')
<div class="admin-card">
    <div class="admin-card-header" style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap;">
        <h3>Daftar User ({{ $users->total() }})</h3>
        <a href="{{ route('admin.users.pending-writers') }}" class="btn btn-sm btn-outline">📋 Pending Writer</a>
    </div>
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-bottom:1.25rem;">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="form-input" style="flex:1; min-width:220px;">
            <select name="role" class="form-input" style="max-width:160px;">
                <option value="">Semua role</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                <option value="writer" @selected(request('role') === 'writer')>Writer</option>
                <option value="user" @selected(request('role') === 'user')>User</option>
            </select>
            <select name="writer_status" class="form-input" style="max-width:180px;">
                <option value="">Semua status writer</option>
                <option value="pending" @selected(request('writer_status') === 'pending')>Pending</option>
                <option value="approved" @selected(request('writer_status') === 'approved')>Approved</option>
                <option value="rejected" @selected(request('writer_status') === 'rejected')>Rejected</option>
            </select>
            <button type="submit" class="btn btn-primary">🔎 Cari</button>
            @if(request()->hasAny(['search', 'role', 'writer_status']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Reset</a>
            @endif
        </form>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status Penulis</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="table-user-info">
                                <div class="table-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <strong>{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                    <span class="you-tag">Anda</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge {{ $user->role === 'admin' ? 'role-admin' : 'role-user' }}">
                                {{ $user->role === 'admin' ? '👑 Admin' : ($user->role === 'writer' ? '✍️ Writer' : '👤 User') }}
                            </span>
                        </td>
                        <td>
                            @if($user->writer_status === 'pending')
                                <span class="role-badge" style="background:#f59e0b;color:#fff;">⏳ Pending</span>
                            @elseif($user->writer_status === 'approved')
                                <span class="role-badge" style="background:#22c55e;color:#fff;">✅ Approved</span>
                            @elseif($user->writer_status === 'rejected')
                                <span class="role-badge" style="background:#ef4444;color:#fff;">❌ Rejected</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="table-actions">
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" class="action-btn action-edit" title="{{ $user->role === 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}">
                                            {{ $user->role === 'admin' ? '👤' : '👑' }}
                                        </button>
                                    </form>

                                    @if($user->writer_status === 'pending')
                                        <form method="POST" action="{{ route('admin.users.approve-writer', $user) }}" class="inline-form">
                                            @csrf
                                            <button type="submit" class="action-btn action-edit" title="Setujui penulis">✅</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.reject-writer', $user) }}" class="inline-form">
                                            @csrf
                                            <button type="submit" class="action-btn action-delete" title="Tolak penulis">❌</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-form" onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn action-delete" title="Hapus">🗑️</button>
                                    </form>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $users->links('partials.pagination') }}
        </div>
    </div>
</div>
@endsection
