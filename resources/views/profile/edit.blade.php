@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<div style="margin-bottom: 1rem;"><a href="{{ route('coins.index') }}"><span class="coin-badge" aria-hidden="true">C</span> Saldo coin: {{ auth()->user()->coins }}</a></div>
<div class="page-header">
    <div class="container">
        <h1 class="page-title">👤 Pengaturan Profil</h1>
        <p class="page-subtitle">Perbarui informasi profil, bio, foto avatar, dan kata sandi Anda.</p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width: 800px;">
        
        @if(session('status') === 'password-updated')
        <div class="flash-toast flash-success" style="position: static; margin-bottom: 1.5rem; width: 100%;">
            <span>✅ Kata sandi Anda berhasil diperbarui!</span>
        </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
            
            <!-- UPDATE PROFILE INFORMATION -->
            <div style="background: var(--bg-card); padding: 2rem; border-radius: var(--radius); border: 1px solid var(--border);">
                        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #fff; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">⚙️ Informasi Profil & Avatar</h2>
                
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="admin-form">
                    @csrf
                    @method('patch')

                    <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                        <div class="avatar-preview-container">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-light);">
                            @else
                                <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 700; color: #fff;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <label class="form-label" for="avatar">Foto Profil (Avatar)</label>
                            <input type="file" id="avatar" name="avatar" class="form-input" accept="image/*">
                            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">Format: JPG, PNG, WEBP. Maksimal 2MB.</span>
                            @error('avatar') <span class="field-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                        @error('name') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        @error('email') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="bio">Bio / Deskripsi Diri</label>
                        <textarea id="bio" name="bio" class="form-textarea" rows="4" placeholder="Tulis sedikit tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- UPDATE PASSWORD -->
            <div style="background: var(--bg-card); padding: 2rem; border-radius: var(--radius); border: 1px solid var(--border);">
                <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #fff; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">🔒 Perbarui Kata Sandi</h2>
                
                <form method="POST" action="{{ route('password.update') }}" class="admin-form">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label class="form-label" for="update_password_current_password">Kata Sandi Saat Ini</label>
                        <input type="password" id="update_password_current_password" name="current_password" class="form-input" autocomplete="current-password" required>
                        @error('current_password') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="update_password_password">Kata Sandi Baru</label>
                        <input type="password" id="update_password_password" name="password" class="form-input" autocomplete="new-password" required>
                        @error('password', 'updatePassword') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="update_password_password_confirmation">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-input" autocomplete="new-password" required>
                        @error('password_confirmation', 'updatePassword') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">🔑 Perbarui Kata Sandi</button>
                    </div>
                </form>
            </div>

            <!-- WRITER REQUEST -->
            <div style="background: var(--bg-card); padding: 2rem; border-radius: var(--radius); border: 1px solid var(--border);">
                <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #fff; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">✍️ Status Penulis</h2>

                @if(auth()->user()->writer_status === 'pending')
                    <div class="flash-toast flash-warning" style="position: static; width: 100%; margin-bottom: 1rem;">
                        <span>⏳ Pengajuan Anda sedang menunggu persetujuan admin.</span>
                    </div>
                @elseif(auth()->user()->writer_status === 'approved')
                    <div class="flash-toast flash-success" style="position: static; width: 100%; margin-bottom: 1rem;">
                        <span>✅ Anda sudah disetujui sebagai penulis.</span>
                    </div>
                    <a href="{{ route('writer.dashboard') }}" class="btn btn-primary">📚 Buka Dashboard Penulis</a>
                @elseif(auth()->user()->writer_status === 'rejected')
                    <div class="flash-toast flash-error" style="position: static; width: 100%; margin-bottom: 1rem;">
                        <span>❌ Pengajuan Anda sebelumnya ditolak. Silakan ajukan kembali.</span>
                    </div>
                    @if(auth()->user()->writer_rejection_reason)
                        <p style="color: var(--text-muted); margin-bottom: 1rem;"><strong>Catatan admin:</strong> {{ auth()->user()->writer_rejection_reason }}</p>
                    @endif
                    @include('profile.partials.writer-application-form', ['buttonText' => '📩 Ajukan Lagi Menjadi Penulis'])
                @else
                    <p style="color: var(--text-muted); margin-bottom: 1.25rem;">Ajukan diri sebagai penulis untuk dapat menulis dan mengelola novel di platform ini.</p>
                    @include('profile.partials.writer-application-form', ['buttonText' => '📩 Ajukan Menjadi Penulis'])
                @endif
            </div>

        </div>
    </div>
</section>
@endsection
