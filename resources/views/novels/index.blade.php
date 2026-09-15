@extends('layouts.app')

@section('title', 'Daftar Novel')
@section('meta_description', 'Temukan semua novel terbaik di NovelKu. Filter berdasarkan genre, status, dan sorting sesuai preferensimu.')

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title">📚 Semua Novel</h1>
        <p class="page-subtitle">Temukan novel yang cocok untukmu</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <!-- FILTER BAR -->
        <form method="GET" action="{{ route('novels.index') }}" class="filter-bar" id="filterForm">
            <div class="filter-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari judul novel..." class="filter-input">
            </div>
            <div class="filter-group">
                <select name="genre" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Genre</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre }}" {{ request('genre') === $genre ? 'selected' : '' }}>{{ $genre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>🔄 Ongoing</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>✅ Tamat</option>
                </select>
            </div>
            <div class="filter-group">
                <select name="sort" class="filter-select" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>🆕 Terbaru</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>🔥 Terpopuler</option>
                    <option value="likes" {{ request('sort') === 'likes' ? 'selected' : '' }}>❤️ Paling Disukai</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(request()->anyFilled(['search', 'genre', 'status', 'sort']))
                <a href="{{ route('novels.index') }}" class="btn btn-outline">Reset</a>
            @endif
        </form>

        <!-- RESULTS INFO -->
        <div class="results-info">
            Menampilkan {{ $novels->firstItem() ?? 0 }}-{{ $novels->lastItem() ?? 0 }} dari {{ $novels->total() }} novel
            @if(request('search'))
                untuk "<strong>{{ request('search') }}</strong>"
            @endif
        </div>

        <!-- GRID -->
        @if($novels->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🔍</div>
                <h3>Tidak ada novel ditemukan</h3>
                <p>Coba ubah filter atau kata kunci pencarian.</p>
                <a href="{{ route('novels.index') }}" class="btn btn-primary">Reset Filter</a>
            </div>
        @else
            <div class="novels-grid">
                @foreach($novels as $novel)
                    @include('partials.novel-card', ['novel' => $novel])
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="pagination-wrapper">
                {{ $novels->links('partials.pagination') }}
            </div>
        @endif
    </div>
</section>
@endsection
