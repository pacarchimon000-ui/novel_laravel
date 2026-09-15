@extends('layouts.admin')

@section('title', 'Pengajuan Penulis')
@section('page_title', '📋 Pengajuan Penulis')

@section('content')
<div class="admin-card">
    <div class="admin-card-header" style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap;">
        <h3>Daftar Pengajuan Penulis ({{ $users->total() }})</h3>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline">← Kembali ke User</a>
    </div>
    <div class="admin-card-body">
        @if($users->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Tidak ada pengajuan pending</h3>
                <p>Semua user sudah diproses atau belum ada yang mendaftar menjadi penulis.</p>
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Detail Pengajuan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
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
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <strong>{{ $user->writer_application_email }}</strong><br>
                                    <small><b>Alasan:</b> {{ $user->writer_application_motivation }}</small><br>
                                    <small><b>Pengalaman:</b> {{ $user->writer_application_experience }}</small><br>
                                    <small><b>Genre:</b> {{ $user->writer_application_genre }}</small>
                                </td>
                                <td>
                                    <span class="role-badge" style="background:#f59e0b;color:#fff;">⏳ Pending</span>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="table-actions">
                                        <form method="POST" action="{{ route('admin.users.approve-writer', $user) }}" class="inline-form">
                                            @csrf
                                            <button type="submit" class="action-btn action-edit" title="Setujui penulis">✅</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.reject-writer', $user) }}" class="inline-form">
                                            @csrf
                                            <input type="text" name="writer_rejection_reason" placeholder="Alasan penolakan" required minlength="10" maxlength="2000">
                                            <button type="submit" class="action-btn action-delete" title="Tolak penulis">❌</button>
                                        </form>
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
        @endif
    </div>
</div>
@endsection
