<form method="POST" action="{{ route('profile.request-writer') }}">
    @csrf
    <div class="form-group">
        <label class="form-label" for="writer_application_email">Alamat email untuk dihubungi</label>
        <input type="email" id="writer_application_email" name="writer_application_email" class="form-input" value="{{ old('writer_application_email', auth()->user()->writer_application_email ?? auth()->user()->email) }}" required>
        @error('writer_application_email') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="writer_application_motivation">Mengapa ingin menjadi writer?</label>
        <textarea id="writer_application_motivation" name="writer_application_motivation" class="form-input" rows="4" required>{{ old('writer_application_motivation', auth()->user()->writer_application_motivation) }}</textarea>
        @error('writer_application_motivation') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="writer_application_experience">Ceritakan pengalaman menulis</label>
        <textarea id="writer_application_experience" name="writer_application_experience" class="form-input" rows="4" required>{{ old('writer_application_experience', auth()->user()->writer_application_experience) }}</textarea>
        @error('writer_application_experience') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="writer_application_genre">Genre yang ingin ditulis</label>
        <input type="text" id="writer_application_genre" name="writer_application_genre" class="form-input" value="{{ old('writer_application_genre', auth()->user()->writer_application_genre) }}" placeholder="Contoh: romance, fantasi" required>
        @error('writer_application_genre') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label style="display:flex; gap:.5rem; align-items:flex-start; color:var(--text-muted);">
            <input type="checkbox" name="writer_application_agreement" value="1" {{ old('writer_application_agreement') ? 'checked' : '' }} required>
            <span>Saya bersedia mengikuti aturan penulis dan bertanggung jawab atas karya yang saya terbitkan.</span>
        </label>
        @error('writer_application_agreement') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
</form>