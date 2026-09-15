@extends('layouts.admin')

@section('title', 'Kelola Laporan')
@section('page_title', '🚩 Kelola Laporan Komentar')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3>Daftar Laporan Komentar ({{ $reports->total() }})</h3>
            <p class="card-subtitle">Tinjau laporan dari pembaca mengenai komentar yang melanggar aturan.</p>
        </div>
    </div>
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}" style="display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap; margin-bottom:1.25rem;">
            <select name="status" class="form-input" style="max-width:220px;">
                <option value="">Semua status</option>
                <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                <option value="resolved" @selected(request('status') === 'resolved')>Diselesaikan</option>
                <option value="dismissed" @selected(request('status') === 'dismissed')>Ditolak</option>
            </select>
            <button type="submit" class="btn btn-primary">🔎 Filter</button>
            @if(request()->filled('status'))
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline">Reset</a>
            @endif
        </form>
        @if($reports->isEmpty())
            <div class="empty-state" style="padding: 3rem 1rem;">
                <div class="empty-icon">✅</div>
                <h3>Tidak ada laporan komentar</h3>
                <p>Semua komentar dalam keadaan aman dan belum ada laporan baru.</p>
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>Komentar Dilaporkan</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>
                                <strong>{{ $report->user->name ?? 'User dihapus' }}</strong>
                            </td>
                            <td>
                                @if($report->comment)
                                    <div style="font-size: 0.85rem; color: #fff; max-width: 300px; margin-bottom: 0.25rem;">
                                        "{{ $report->comment->content }}"
                                    </div>
                                    <div class="table-novel-meta">
                                        Oleh: <strong>{{ $report->comment->user->name ?? 'Anonim' }}</strong> 
                                        @if(isset($report->comment->chapter->novel))
                                            • Pada: <em>{{ $report->comment->chapter->novel->title }} (Ch. {{ $report->comment->chapter->chapter_number }})</em>
                                        @endif
                                    </div>
                                @else
                                    <span style="color: var(--danger); font-style: italic;">(Komentar sudah dihapus)</span>
                                @endif
                            </td>
                            <td>
                                <span style="background: rgba(239, 68, 68, 0.15); color: #f87171; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: 500;">
                                    {{ $report->reason }}
                                </span>
                            </td>
                            <td>
                                @if($report->status === 'pending')
                                    <span class="role-badge role-admin" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">⏳ Menunggu</span>
                                @elseif($report->status === 'resolved')
                                    <span class="role-badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">✅ Dihapus</span>
                                @else
                                    <span class="role-badge role-user">🚫 Ditolak</span>
                                @endif
                            </td>
                            <td style="font-size: 0.8rem; color: #9d8ec0;">
                                {{ $report->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <div class="table-actions">
                                    @if($report->status === 'pending' && $report->comment)
                                        <form method="POST" action="{{ route('admin.reports.resolve', $report) }}" class="inline-form" onsubmit="return confirm('Hapus komentar ini dan setujui laporan?')">
                                            @csrf
                                            <button type="submit" class="action-btn action-delete" title="Hapus Komentar (Setujui)">🗑️</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reports.dismiss', $report) }}" class="inline-form">
                                            @csrf
                                            <button type="submit" class="action-btn" title="Tolak / Abaikan Laporan">❌</button>
                                        </form>
                                    @else
                                        <span style="color: #6b5f8a; font-size: 0.8rem;">Selesai</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper" style="margin-top: 1.5rem;">
                {{ $reports->links('partials.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
