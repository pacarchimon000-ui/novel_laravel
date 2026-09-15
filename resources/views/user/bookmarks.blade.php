@extends('layouts.app')

@section('title', 'Bookmark Saya')

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title">🔖 Bookmark Saya</h1>
        <p class="page-subtitle">Novel yang sudah kamu simpan</p>
    </div>
</div>

<section class="section">
    <div class="container">
        @if($bookmarks->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🔖</div>
                <h3>Belum ada bookmark</h3>
                <p>Temukan novel yang kamu suka dan tambahkan ke bookmark!</p>
                <a href="{{ route('novels.index') }}" class="btn btn-primary">Jelajahi Novel</a>
            </div>
        @else
            <div class="novels-grid">
                @foreach($bookmarks as $bookmark)
                    @include('partials.novel-card', ['novel' => $bookmark->novel])
                @endforeach
            </div>
            <div class="pagination-wrapper">
                {{ $bookmarks->links('partials.pagination') }}
            </div>
        @endif
    </div>
</section>
@endsection
