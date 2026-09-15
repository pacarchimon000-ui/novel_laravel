@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'NovelKu - Platform membaca novel online terbaik. Ribuan novel seru menanti kamu!')

@section('content')

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="container hero-container">
        <div class="hero-content">
            <div class="hero-badge">✨ Platform Novel Online #1</div>
            <h1 class="hero-title">Temukan Dunia Baru<br>di Setiap <span class="hero-highlight">Halaman</span></h1>
            <p class="hero-subtitle">Ribuan novel seru dari berbagai genre. Baca kapan saja, di mana saja. Gratis!</p>
            <div class="hero-actions">
                <a href="{{ route('novels.index') }}" class="btn btn-primary btn-lg">🚀 Mulai Membaca</a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline btn-lg">Daftar Gratis</a>
                @endguest
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="stat-number">{{ \App\Models\Novel::count() }}+</span>
                    <span class="stat-label">Novel</span>
                </div>
                <div class="hero-stat">
                    <span class="stat-number">{{ \App\Models\Chapter::count() }}+</span>
                    <span class="stat-label">Chapter</span>
                </div>
                <div class="hero-stat">
                    <span class="stat-number">{{ \App\Models\User::count() }}+</span>
                    <span class="stat-label">Pembaca</span>
                </div>
            </div>
        </div>
        <div class="hero-illustration">
            <div class="floating-cards">
                <div class="float-card fc1">📚</div>
                <div class="float-card fc2">✍️</div>
                <div class="float-card fc3">🌟</div>
                <div class="float-card fc4">💫</div>
            </div>
            <div class="hero-book">
                <div class="book-cover">
                    <div class="book-spine"></div>
                    <div class="book-face">
                        <span>Novel<br>Ku</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GENRE PILLS -->
@if($genres->isNotEmpty())
<section class="genres-section">
    <div class="container">
        <div class="genre-pills">
            @foreach($genres as $genre)
                <a href="{{ route('novels.index', ['genre' => $genre]) }}" class="genre-pill">{{ $genre }}</a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- LANJUT BACA (READING HISTORY) -->
@if(isset($recentHistories) && $recentHistories->isNotEmpty())
<section class="section" style="padding-bottom: 1rem;">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">🔖 Lanjut Baca</h2>
                <p class="section-subtitle">Terakhir dibaca olehmu</p>
            </div>
        </div>
        <div class="history-grid">
            @foreach($recentHistories as $history)
            <div class="history-card">
                <div class="history-info">
                    <span class="history-novel">{{ $history->novel->title }}</span>
                    <span class="history-chapter">Chapter {{ $history->chapter->chapter_number }}: {{ $history->chapter->title }}</span>
                </div>
                <a href="{{ route('chapters.show', [$history->novel, $history->chapter]) }}" class="btn btn-primary btn-sm">▶ Lanjut</a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- NOVEL TERBARU -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">🆕 Novel Terbaru</h2>
                <p class="section-subtitle">Cerita-cerita baru yang siap menemani harimu</p>
            </div>
            <a href="{{ route('novels.index') }}" class="btn btn-outline-sm">Lihat Semua →</a>
        </div>

        @if($latestNovels->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>Belum ada novel. Admin belum menambahkan novel apapun.</p>
            </div>
        @else
        <div class="novels-grid">
            @foreach($latestNovels as $novel)
                @include('partials.novel-card', ['novel' => $novel])
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- NOVEL POPULER -->
@if($popularNovels->isNotEmpty())
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-title">🔥 Novel Populer</h2>
                <p class="section-subtitle">Paling banyak dibaca oleh para pecinta novel</p>
            </div>
            <a href="{{ route('novels.index', ['sort' => 'popular']) }}" class="btn btn-outline-sm">Lihat Semua →</a>
        </div>
        <div class="novels-grid">
            @foreach($popularNovels as $novel)
                @include('partials.novel-card', ['novel' => $novel])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA SECTION -->
@guest
<section class="cta-section">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title">Siap Memulai Petualangan?</h2>
            <p class="cta-desc">Daftar sekarang dan nikmati akses ke semua novel secara gratis. Bookmark favoritmu, beri like, dan tinggalkan komentar!</p>
            <div class="cta-actions">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="btn btn-outline btn-lg">Sudah punya akun?</a>
            </div>
        </div>
    </div>
</section>
@endguest

@endsection
