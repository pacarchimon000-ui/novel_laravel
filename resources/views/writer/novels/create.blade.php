@extends('layouts.app')

@section('title', 'Tambah Novel')

@section('content')
<div class="container" style="padding: 2rem 0 4rem; max-width: 900px;">
    <div class="section-header" style="margin-bottom: 1.5rem;">
        <div>
            <p class="eyebrow">Area Penulis</p>
            <h1>Tambah Novel Baru</h1>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-body">
            <form method="POST" action="{{ route('writer.novels.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label for="title">Judul Novel</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')<span class="error-text">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <select id="genre" name="genre" required>
                            <option value="">Pilih genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre }}" {{ old('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                            @endforeach
                        </select>
                        @error('genre')<span class="error-text">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')<span class="error-text">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="cover">Cover Novel</label>
                        <input type="file" id="cover" name="cover" accept="image/*">
                        @error('cover')<span class="error-text">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="synopsis">Sinopsis</label>
                    <textarea id="synopsis" name="synopsis" rows="8" required>{{ old('synopsis') }}</textarea>
                    @error('synopsis')<span class="error-text">{{ $message }}</span>@enderror
                </div>

                <div style="display:flex; gap:1rem; justify-content:flex-end; margin-top: 1.5rem;">
                    <a href="{{ route('writer.dashboard') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Novel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
