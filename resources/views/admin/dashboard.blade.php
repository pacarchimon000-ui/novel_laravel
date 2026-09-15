@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', '📊 Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #6c63ff, #4a42d1)">📚</div>
        <div class="stat-card-info">
            <div class="stat-card-number">{{ $stats['novels'] }}</div>
            <div class="stat-card-label">Total Novel</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c)">📖</div>
        <div class="stat-card-info">
            <div class="stat-card-number">{{ $stats['chapters'] }}</div>
            <div class="stat-card-label">Total Chapter</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe)">👥</div>
        <div class="stat-card-info">
            <div class="stat-card-number">{{ $stats['users'] }}</div>
            <div class="stat-card-label">Total User</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7)">💬</div>
        <div class="stat-card-info">
            <div class="stat-card-number">{{ $stats['comments'] }}</div>
            <div class="stat-card-label">Total Komentar</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #f59e0b, #ef4444)">✍️</div>
        <div class="stat-card-info">
            <div class="stat-card-number">{{ $stats['pending_writers'] }}</div>
            <div class="stat-card-label">Pengajuan Writer</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background: linear-gradient(135deg, #ef4444, #be123c)">🚩</div>
        <div class="stat-card-info">
            <div class="stat-card-number">{{ $stats['pending_reports'] }}</div>
            <div class="stat-card-label">Laporan Pending</div>
        </div>
    </div>
</div>

<div class="admin-card" style="margin-bottom: 1.75rem;">
    <div class="admin-card-header">
        <h3>✍️ Pengajuan Writer Terbaru</h3>
        <a href="{{ route('admin.users.pending-writers') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
    </div>
    <div class="admin-card-body">
        @forelse($pendingWriters as $user)
            <div class="dashboard-item">
                <div class="user-avatar-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="di-info">
                    <div class="di-title">{{ $user->name }}</div>
                    <div class="di-meta">{{ $user->writer_application_email ?: $user->email }} • {{ $user->created_at->format('d M Y') }}</div>
                    <div class="di-meta" style="margin-top: 0.25rem;">
                        Genre: {{ $user->writer_application_genre ?: 'Belum diisi' }}
                        • Motivasi: {{ \Illuminate\Support\Str::limit($user->writer_application_motivation ?: 'Belum diisi', 100) }}
                    </div>
                </div>
                <a href="{{ route('admin.users.pending-writers') }}" class="btn btn-sm btn-outline">Review</a>
            </div>
        @empty
            <p style="color: var(--text-muted); margin: 0;">Belum ada pengajuan writer yang menunggu review.</p>
        @endforelse
    </div>
</div>

<!-- CHART ANALYTICS -->
<div class="admin-card" style="margin-bottom: 1.75rem;">
    <div class="admin-card-header">
        <h3>📈 Popularitas Novel (Total Views)</h3>
    </div>
    <div class="admin-card-body">
        <canvas id="novelChart" height="90"></canvas>
    </div>
</div>

<div class="admin-two-col">
    <!-- LATEST NOVELS -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>📚 Novel Terbaru</h3>
            <a href="{{ route('admin.novels.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
        </div>
        <div class="admin-card-body">
            @foreach($latestNovels as $novel)
            <div class="dashboard-item">
                <div class="di-info">
                    <div class="di-title">{{ $novel->title }}</div>
                    <div class="di-meta">{{ $novel->genre }} • {{ $novel->chapters_count }} chapter</div>
                </div>
                <a href="{{ route('admin.novels.show', $novel) }}" class="btn btn-sm btn-outline">Lihat</a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- LATEST USERS -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>👥 User Terbaru</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
        </div>
        <div class="admin-card-body">
            @foreach($latestUsers as $user)
            <div class="dashboard-item">
                <div class="user-avatar-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="di-info">
                    <div class="di-title">{{ $user->name }}</div>
                    <div class="di-meta">{{ $user->email }} • {{ $user->role === 'admin' ? 'Admin' : 'User' }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div class="admin-card" style="margin-top:1.5rem">
    <div class="admin-card-header"><h3>⚡ Aksi Cepat</h3></div>
    <div class="admin-card-body quick-actions">
        <a href="{{ route('admin.novels.create') }}" class="quick-action-btn">
            <span>➕</span> Tambah Novel
        </a>
        <a href="{{ route('admin.novels.index') }}" class="quick-action-btn">
            <span>📚</span> Kelola Novel
        </a>
        <a href="{{ route('admin.users.index') }}" class="quick-action-btn">
            <span>👥</span> Kelola User
        </a>
        <a href="{{ route('home') }}" class="quick-action-btn">
            <span>🌐</span> Lihat Website
        </a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('novelChart').getContext('2d');
    const novelTitles = {!! json_encode($latestNovels->pluck('title')) !!};
    const novelViews = {!! json_encode($latestNovels->pluck('views')) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: novelTitles,
            datasets: [{
                label: 'Jumlah Pembaca (Views)',
                data: novelViews,
                backgroundColor: 'rgba(124, 58, 237, 0.6)',
                borderColor: 'rgba(124, 58, 237, 1)',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: '#e2d9f3' } }
            },
            scales: {
                x: { ticks: { color: '#9d8ec0' }, grid: { color: '#281b47' } },
                y: { ticks: { color: '#9d8ec0' }, grid: { color: '#281b47' } }
            }
        }
    });
});
</script>
@endpush
@endsection
