@extends('layouts.app')

@section('title', 'Edit Chapter')

@section('content')
<div class="container" style="padding: 2rem 0 4rem; max-width: 900px;">
    <div class="section-header" style="margin-bottom: 1.5rem;">
        <div>
            <p class="eyebrow">Area Penulis</p>
            <h1>Edit Chapter - {{ $novel->title }}</h1>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-body">
            <form method="POST" action="{{ route('writer.chapters.update', [$novel, $chapter]) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="chapter_number">Nomor Chapter</label>
                        <input type="number" id="chapter_number" name="chapter_number" min="1" value="{{ old('chapter_number', $chapter->chapter_number) }}" required>
                        @error('chapter_number')<span class="error-text">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Judul Chapter</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $chapter->title) }}" required>
                        @error('title')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Isi Chapter</label>
                    <textarea id="content" name="content" rows="18" required>{{ old('content', $chapter->content) }}</textarea>
                    @error('content')<span class="error-text">{{ $message }}</span>@enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="is_premium">Chapter Premium</label>
                        <input type="checkbox" id="is_premium" name="is_premium" value="1" {{ old('is_premium', $chapter->is_premium) ? 'checked' : '' }}>
                        @error('is_premium')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="coin_price">Harga Coin</label>
                        <input type="number" id="coin_price" name="coin_price" min="1" value="{{ old('coin_price', $chapter->coin_price ?: 5) }}">
                        @error('coin_price')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div style="display:flex; gap:1rem; justify-content:flex-end; margin-top: 1.5rem;">
                    <a href="{{ route('writer.novels.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Chapter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
