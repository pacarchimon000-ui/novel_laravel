@extends('layouts.admin')

@section('title', 'Edit Chapter')
@section('page_title', '✏️ Edit Chapter')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3>Edit Chapter {{ $chapter->chapter_number }} — <em>{{ $novel->title }}</em></h3>
        <a href="{{ route('admin.novels.show', $novel) }}" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.chapters.update', [$novel, $chapter]) }}" class="admin-form">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group form-col-1">
                    <label for="chapter_number" class="form-label">Nomor Chapter <span class="required">*</span></label>
                    <input type="number" id="chapter_number" name="chapter_number" class="form-input"
                        value="{{ old('chapter_number', $chapter->chapter_number) }}" min="1" required>
                </div>
                <div class="form-group form-col-3">
                    <label for="title" class="form-label">Judul Chapter <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-input"
                        value="{{ old('title', $chapter->title) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="content" class="form-label">Isi Chapter <span class="required">*</span></label>
                <textarea id="content" name="content" class="form-textarea form-textarea-lg"
                    rows="20" required>{{ old('content', $chapter->content) }}</textarea>
                <div class="word-count" id="wordCount">0 kata</div>
            </div>

            <div class="form-row">
                <div class="form-group form-col-1">
                    <label for="is_premium" class="form-label">Chapter Premium</label>
                    <input type="checkbox" id="is_premium" name="is_premium" value="1" {{ old('is_premium', $chapter->is_premium) ? 'checked' : '' }}>
                    @error('is_premium') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group form-col-1">
                    <label for="coin_price" class="form-label">Harga Coin</label>
                    <input type="number" id="coin_price" name="coin_price" class="form-input" min="1" value="{{ old('coin_price', $chapter->coin_price ?: 5) }}">
                    @error('coin_price') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">💾 Update Chapter</button>
                <a href="{{ route('admin.novels.show', $novel) }}" class="btn btn-outline btn-lg">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const content = document.getElementById('content');
const wordCount = document.getElementById('wordCount');
function updateCount() {
    const words = content.value.trim().split(/\s+/).filter(w => w.length > 0).length;
    wordCount.textContent = words + ' kata';
}
content.addEventListener('input', updateCount);
updateCount();
</script>
@endpush
@endsection
