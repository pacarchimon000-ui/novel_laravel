@extends('layouts.app')

@section('title', 'Dashboard Penulis')

@section('content')
<div class="container" style="padding: 2rem 0 4rem;">
    <div class="section-header" style="margin-bottom: 1.5rem;">
        <div>
            <p class="eyebrow">Area Penulis</p>
            <h1>Dashboard Penulis</h1>
        </div>
        <a href="{{ route('writer.novels.create') }}" class="btn btn-primary">+ Tambah Novel</a>
    </div>

    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
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
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe)">👀</div>
            <div class="stat-card-info">
                <div class="stat-card-number">{{ $stats['views'] }}</div>
                <div class="stat-card-label">Total Views</div>
            </div>
        </div>
    </div>

    <div class="admin-card" style="margin-top: 2rem;">
        <div class="admin-card-header">
                    <h3>📚 Novel Saya</h3>
            <a href="{{ route('writer.novels.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
        </div>
        <div class="admin-card-body">
            @forelse($novels as $novel)
                <div class="dashboard-item" style="display:flex; justify-content:space-between; align-items:center; gap:1rem;">
                    <div class="di-info">
                        <div class="di-title">{{ $novel->title }}</div>
                        <div class="di-meta">{{ $novel->genre }} • {{ $novel->chapters_count }} chapter • {{ $novel->views }} views</div>
                    </div>
                    <div style="display:flex; gap:.5rem;">
                        <a href="{{ route('writer.novels.edit', $novel) }}" class="btn btn-sm btn-outline">Edit</a>
                        <a href="{{ route('novels.show', $novel) }}" class="btn btn-sm btn-primary">Lihat</a>
                    </div>
                </div>
            @empty
                <p>Belum ada novel yang kamu buat.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
