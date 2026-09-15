@extends('layouts.admin')

@section('title', 'Tambah Chapter')
@section('page_title', '➕ Tambah Chapter')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3>Tambah Chapter — <em>{{ $novel->title }}</em></h3>
        <a href="{{ route('admin.novels.show', $novel) }}" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.chapters.store', $novel) }}" class="admin-form">
            @csrf

            <div class="form-row">
                <div class="form-group form-col-1">
                    <label for="chapter_number" class="form-label">Nomor Chapter <span class="required">*</span></label>
                    <input type="number" id="chapter_number" name="chapter_number" class="form-input @error('chapter_number') is-error @enderror"
                        value="{{ old('chapter_number', $nextNumber) }}" min="1" required>
                    @error('chapter_number') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group form-col-3">
                    <label for="title" class="form-label">Judul Chapter <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-input @error('title') is-error @enderror"
                        value="{{ old('title') }}" placeholder="Contoh: Awal Mula Petualangan" required>
                    @error('title') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="content" class="form-label">Isi Chapter <span class="required">*</span></label>
                <textarea id="content" name="content" class="form-textarea form-textarea-lg @error('content') is-error @enderror"
                    rows="20" placeholder="Tulis isi chapter di sini..." required>{{ old('content') }}</textarea>
                <div class="word-count" id="wordCount">0 kata</div>
                @error('content') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group form-col-1">
                    <label for="is_premium" class="form-label">Chapter Premium</label>
                    <input type="checkbox" id="is_premium" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }}>
                    @error('is_premium') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group form-col-1">
                    <label for="coin_price" class="form-label">Harga Coin</label>
                    <input type="number" id="coin_price" name="coin_price" class="form-input" min="1" value="{{ old('coin_price', 5) }}">
                    @error('coin_price') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">💾 Simpan Chapter</button>
                <a href="{{ route('admin.novels.show', $novel) }}" class="btn btn-outline btn-lg">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const content = document.getElementById('content');
const wordCount = document.getElementById('wordCount');
content.addEventListener('input', () => {
    const words = content.value.trim().split(/\s+/).filter(w => w.length > 0).length;
    wordCount.textContent = words + ' kata';
});
</script>
@endpush
@endsection
