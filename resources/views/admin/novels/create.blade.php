@extends('layouts.admin')

@section('title', 'Tambah Novel')
@section('page_title', '➕ Tambah Novel')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3>Form Tambah Novel</h3>
        <a href="{{ route('admin.novels.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.novels.store') }}" enctype="multipart/form-data" class="admin-form">
            @csrf

            <div class="form-row">
                <div class="form-group form-col-2">
                    <label for="title" class="form-label">Judul Novel <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-input @error('title') is-error @enderror"
                        value="{{ old('title') }}" placeholder="Masukkan judul novel..." required>
                    @error('title') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group form-col-1">
                    <label for="genre" class="form-label">Genre <span class="required">*</span></label>
                    <select id="genre" name="genre" class="form-select @error('genre') is-error @enderror" required>
                        <option value="">Pilih genre...</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" {{ old('genre') === $genre ? 'selected' : '' }}>{{ $genre }}</option>
                        @endforeach
                    </select>
                    @error('genre') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group form-col-1">
                    <label for="status" class="form-label">Status <span class="required">*</span></label>
                    <select id="status" name="status" class="form-select @error('status') is-error @enderror" required>
                        <option value="ongoing" {{ old('status', 'ongoing') === 'ongoing' ? 'selected' : '' }}>🔄 Ongoing</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                    </select>
                    @error('status') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="synopsis" class="form-label">Sinopsis <span class="required">*</span></label>
                <textarea id="synopsis" name="synopsis" class="form-textarea @error('synopsis') is-error @enderror"
                    rows="5" placeholder="Tulis sinopsis novel..." required>{{ old('synopsis') }}</textarea>
                @error('synopsis') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="cover" class="form-label">Cover Novel</label>
                <div class="file-upload-area" id="coverUpload" onclick="document.getElementById('cover').click()">
                    <div class="file-upload-icon">🖼️</div>
                    <div class="file-upload-text">Klik untuk upload cover</div>
                    <div class="file-upload-hint">JPG, PNG, WEBP — Max 2MB</div>
                    <input type="file" id="cover" name="cover" accept="image/*" style="display:none"
                        onchange="previewCover(this)">
                </div>
                <img id="coverPreview" src="" alt="" class="cover-preview" style="display:none">
                @error('cover') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">💾 Simpan Novel</button>
                <a href="{{ route('admin.novels.index') }}" class="btn btn-outline btn-lg">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('coverPreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
            document.querySelector('.file-upload-text').textContent = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
