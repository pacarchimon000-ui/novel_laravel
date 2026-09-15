<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NovelKu') }} - Masuk / Daftar</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            body {
                background: #0f0a1e;
                color: #e2d9f3;
                font-family: 'Poppins', sans-serif;
            }
            .auth-card-wrap {
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 2rem 1rem;
                background: radial-gradient(circle at 15% 10%, rgba(124,58,237,0.18), transparent 32%), #0f0a1e;
            }
            .auth-shell { width: 100%; max-width: 980px; display: grid; grid-template-columns: 0.9fr 1.1fr; overflow: hidden; border: 1px solid #2d1f55; border-radius: 24px; background: rgba(26,16,48,0.92); box-shadow: 0 24px 80px rgba(0,0,0,0.45); }
            .auth-side { display: flex; flex-direction: column; justify-content: space-between; min-height: 560px; padding: 2.5rem; background: linear-gradient(150deg, #291358 0%, #17102f 70%); border-right: 1px solid #2d1f55; }
            .auth-side-copy { max-width: 280px; margin-top: auto; }
            .auth-side-copy h2 { margin: 0.75rem 0; color: #fff; font-size: 2rem; line-height: 1.15; letter-spacing: -0.02em; }
            .auth-side-copy p { color: #b7a8d0; line-height: 1.7; font-size: 0.9rem; }
            .auth-side-mark { display: inline-flex; width: 3.25rem; height: 3.25rem; align-items: center; justify-content: center; border: 1px solid #a78bfa; border-radius: 1rem; color: #fff; font-size: 1.35rem; font-weight: 800; background: linear-gradient(145deg, #8b5cf6, #5b21b6); box-shadow: 0 10px 30px rgba(124,58,237,0.35); }
            .auth-side-note { color: #8f7eaf; font-size: 0.75rem; letter-spacing: 0.04em; text-transform: uppercase; }
            .auth-form-panel { padding: 2.5rem; }
            .auth-brand {
                display: block;
                font-size: 1.35rem;
                font-weight: 800;
                color: #fff;
                margin-bottom: 2rem;
                text-decoration: none;
            }
            .auth-brand .brand-accent { color: #8b5cf6; }
            .auth-card {
                width: 100%;
                max-width: 520px;
            }
            .auth-heading { margin-bottom: 1.75rem; }
            .auth-kicker { color: #a78bfa; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; }
            .auth-heading h1 { margin: 0.55rem 0 0.6rem; color: #fff; font-size: 2rem; line-height: 1.15; letter-spacing: -0.02em; }
            .auth-heading p { max-width: 420px; color: #9d8ec0; font-size: 0.88rem; line-height: 1.7; }
            .auth-card input[type="text"],
            .auth-card input[type="email"],
            .auth-card input[type="password"] {
                width: 100%;
                padding: 0.7rem 1rem;
                background: #0f0a1e;
                border: 1px solid #2d1f55;
                border-radius: 8px;
                color: #fff;
                margin-top: 0.3rem;
                font-size: 0.9rem;
            }
            .auth-card input:focus {
                outline: none;
                border-color: #7c3aed;
                box-shadow: 0 0 0 3px rgba(124,58,237,0.2);
            }
            .auth-card label {
                font-size: 0.85rem;
                font-weight: 600;
                color: #c4b4e0;
            }
            .auth-card .btn-primary {
                width: 100%;
                justify-content: center;
                padding: 0.75rem;
                font-size: 0.95rem;
                margin-top: 1rem;
            }
            .auth-card a {
                color: #8b5cf6;
                font-size: 0.85rem;
            }
            .auth-card a:hover {
                text-decoration: underline;
            }
            .auth-card .mt-4 { margin-top: 1rem; }
            .auth-card .flex { display: flex; }
            .auth-card .items-center { align-items: center; }
            .auth-card .justify-end { justify-content: flex-end; }
            .auth-card .ms-3, .auth-card .ms-4 { margin-left: 0.75rem; }
            .auth-card .block { display: block; }
            .auth-card .text-sm { font-size: 0.85rem; }
            .auth-card .text-gray-600 { color: #9d8ec0; }
            .auth-card .rounded-md { border-radius: 6px; }
            .auth-card .text-red-600 { color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem; }
            .auth-options { display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
            .auth-actions { gap: 1rem; }
            .auth-actions a:first-child { margin-right: auto; }
            @media (max-width: 720px) {
                .auth-shell { display: block; max-width: 520px; }
                .auth-side { min-height: auto; padding: 1.5rem; border-right: 0; border-bottom: 1px solid #2d1f55; }
                .auth-side-copy { margin-top: 1.75rem; }
                .auth-side-copy h2 { font-size: 1.45rem; }
                .auth-side-copy p { display: none; }
                .auth-form-panel { padding: 1.5rem; }
                .auth-heading h1 { font-size: 1.65rem; }
            }
        </style>
    </head>
    <body>
        <div class="auth-card-wrap">
            <div class="auth-shell">
                <aside class="auth-side">
                    <a href="/" class="auth-brand">📖 Novel<span class="brand-accent">Ku</span></a>
                    <div class="auth-side-copy">
                        <span class="auth-side-mark" aria-hidden="true">N</span>
                        <h2>Cerita yang baik selalu punya tempat untuk pulang.</h2>
                        <p>Bangun kebiasaan membaca, ikuti novel favoritmu, dan dapatkan reward dari progresmu.</p>
                    </div>
                    <span class="auth-side-note">Baca. Simpan. Lanjutkan.</span>
                </aside>
                <div class="auth-form-panel">
                    <div class="auth-card">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
