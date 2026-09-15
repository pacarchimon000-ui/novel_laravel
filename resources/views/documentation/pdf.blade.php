<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dokumentasi NovelKu</title>
    <style>
        @page { margin: 2cm; }
        body { color: #241b35; font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.6; }
        h1 { color: #5128a5; font-size: 28px; margin-bottom: 4px; }
        h2 { color: #5128a5; border-bottom: 1px solid #d8c9f0; padding-bottom: 5px; margin-top: 24px; }
        h3 { color: #36205f; margin-bottom: 4px; }
        p { margin: 6px 0; }
        ul { margin-top: 4px; padding-left: 20px; }
        li { margin-bottom: 3px; }
        .cover { border-bottom: 4px solid #8b5cf6; padding: 100px 0 30px; }
        .subtitle { color: #6b5f8a; font-size: 15px; }
        .identity { margin-top: 70px; color: #6b5f8a; }
        .box { background: #f4effc; border-left: 4px solid #8b5cf6; padding: 10px 14px; margin: 10px 0; }
        .two-col { width: 100%; }
        .two-col td { width: 50%; vertical-align: top; padding-right: 15px; }
        table { border-collapse: collapse; width: 100%; margin: 8px 0; }
        th, td { border: 1px solid #d8c9f0; padding: 7px; text-align: left; }
        th { background: #f0eafb; color: #36205f; }
        code { background: #f0eafb; padding: 2px 4px; }
        .footer { border-top: 1px solid #d8c9f0; color: #6b5f8a; margin-top: 30px; padding-top: 10px; }
    </style>
</head>
<body>
    <section class="cover">
        <h1>NovelKu</h1>
        <div class="subtitle">Platform membaca dan publikasi novel berbasis Laravel</div>
        <div class="identity">
            <strong>Dokumentasi Project Sekolah</strong><br>
            Nama: Sebastian Botu<br>
            Kelas: XII RPL 1<br>
            Sekolah: SMK Wahidin Kota Cirebon
        </div>
    </section>

    <h2>1. Deskripsi Project</h2>
    <p>NovelKu adalah aplikasi web untuk membaca, menerbitkan, dan mengelola novel secara online. Aplikasi menyediakan pengalaman membaca untuk pengguna, ruang kerja untuk writer, serta panel administrasi untuk mengelola konten dan pengguna.</p>
    <div class="box"><strong>Tujuan:</strong> membangun platform literasi digital sederhana yang memiliki pembagian role, pengelolaan konten, sistem interaksi, dan reward membaca.</div>

    <h2>2. Teknologi</h2>
    <table><tr><th>Bagian</th><th>Teknologi</th></tr>
        <tr><td>Backend</td><td>PHP 8.2 dan Laravel 12</td></tr>
        <tr><td>Database</td><td>MySQL atau SQLite untuk testing</td></tr>
        <tr><td>Frontend</td><td>Blade Template, CSS, JavaScript</td></tr>
        <tr><td>Autentikasi</td><td>Laravel Breeze</td></tr>
        <tr><td>PDF</td><td>barryvdh/laravel-dompdf</td></tr>
        <tr><td>Testing</td><td>PHPUnit melalui Laravel Feature Test</td></tr>
    </table>

    <h2>3. Role dan Hak Akses</h2>
    <table><tr><th>Role</th><th>Hak Akses</th></tr>
        <tr><td>User</td><td>Membaca novel, bookmark, like, komentar, rating, mengajukan writer, dan mengumpulkan reward.</td></tr>
        <tr><td>Writer</td><td>Mengelola novel dan chapter miliknya sendiri melalui dashboard writer.</td></tr>
        <tr><td>Admin</td><td>Mengelola novel, chapter, user, laporan komentar, serta menyetujui atau menolak pengajuan writer.</td></tr>
    </table>

    <h2>4. Fitur Utama</h2>
    <table><tr><th>Fitur</th><th>Penjelasan</th></tr>
        <tr><td>Katalog novel</td><td>Pencarian berdasarkan judul, sinopsis, atau penulis, filter genre/status, dan sorting.</td></tr>
        <tr><td>Reader</td><td>Membaca chapter, mengatur ukuran teks, memilih tema, mengunduh PDF, dan berpindah chapter.</td></tr>
        <tr><td>Reward membaca</td><td>Chapter yang diselesaikan memberi 10 poin. Reward chapter hanya dapat diterima satu kali.</td></tr>
        <tr><td>Coin dan level</td><td>Setiap 100 poin memberi 1 atau 2 coin secara bergantian. Coin dapat digunakan membuka chapter premium.</td></tr>
        <tr><td>Pengajuan writer</td><td>User mengisi form di Profile, admin meninjau detail pengajuan, lalu menyetujui atau menolak.</td></tr>
        <tr><td>Interaksi sosial</td><td>Bookmark, like, rating, komentar, laporan komentar, dan notifikasi.</td></tr>
    </table>

    <h2>5. Alur Pengguna</h2>
    <ol>
        <li>User mendaftar atau login.</li>
        <li>User memilih novel dan membaca chapter.</li>
        <li>Setelah membaca minimal 80%, tombol selesai aktif.</li>
        <li>User menerima poin membaca satu kali untuk chapter tersebut.</li>
        <li>Poin dikonversi menjadi coin saat milestone tercapai.</li>
        <li>Coin dapat digunakan untuk membuka chapter premium.</li>
    </ol>

    <h2>6. Alur Pengajuan Writer</h2>
    <ol>
        <li>User membuka halaman Profile.</li>
        <li>User mengisi email pengajuan, motivasi, pengalaman, genre, dan persetujuan.</li>
        <li>Status berubah menjadi <code>pending</code>.</li>
        <li>Admin melihat pengajuan di Dashboard atau Pengajuan Writer.</li>
        <li>Admin menyetujui atau menolak pengajuan.</li>
        <li>Jika disetujui, role berubah menjadi <code>writer</code> dan akses dashboard writer aktif.</li>
    </ol>

    <h2>7. Struktur Direktori Penting</h2>
    <table><tr><th>Direktori</th><th>Isi</th></tr>
        <tr><td><code>app/Models</code></td><td>Model User, Novel, Chapter, Comment, Reward, dan lainnya.</td></tr>
        <tr><td><code>app/Http/Controllers</code></td><td>Logika autentikasi, pembaca, writer, admin, dan reward.</td></tr>
        <tr><td><code>resources/views</code></td><td>Halaman publik, reader, profile, writer, admin, dan autentikasi.</td></tr>
        <tr><td><code>database/migrations</code></td><td>Struktur tabel dan perubahan database.</td></tr>
        <tr><td><code>database/seeders</code></td><td>Data akun dan novel bawaan untuk demo.</td></tr>
        <tr><td><code>tests/Feature</code></td><td>Pengujian autentikasi, novel, writer, admin, dan reward.</td></tr>
    </table>

    <h2>8. Relasi Database Utama</h2>
    <ul>
        <li>User dapat menulis banyak novel.</li>
        <li>Novel memiliki banyak chapter.</li>
        <li>User dapat menerima reward dari chapter yang diselesaikan.</li>
        <li>User dapat membuka chapter premium melalui tabel unlock.</li>
        <li>Chapter dapat memiliki komentar, like, rating, dan riwayat reward.</li>
    </ul>

    <h2>9. Alur Sistem</h2>
    <h3>Reward Membaca</h3>
    <ol>
        <li>User membuka chapter yang dapat diakses.</li>
        <li>User membaca sampai 80 persen.</li>
        <li>Tombol selesai menjadi aktif.</li>
        <li>Sistem memeriksa agar chapter tidak memberi reward dua kali.</li>
        <li>Sistem menambah 10 poin dan coin jika milestone tercapai.</li>
    </ol>
    <h3>Pengajuan Writer</h3>
    <ol>
        <li>User mengisi form pengajuan dari Profile.</li>
        <li>Status pengajuan menjadi pending.</li>
        <li>Admin membaca detail pengajuan.</li>
        <li>Admin menyetujui atau menolak pengajuan.</li>
        <li>User yang disetujui memperoleh akses dashboard writer.</li>
    </ol>

    <h2>10. Instalasi dan Menjalankan Project</h2>
    <p>Pastikan PHP 8.2, Composer, Node.js, dan MySQL tersedia.</p>
    <ol>
        <li>Masuk ke folder project.</li>
        <li>Jalankan <code>composer install</code>.</li>
        <li>Salin <code>.env.example</code> menjadi <code>.env</code>, lalu atur database.</li>
        <li>Jalankan <code>php artisan key:generate</code>.</li>
        <li>Jalankan <code>php artisan migrate</code>.</li>
        <li>Jalankan <code>php artisan db:seed --class=DatabaseSeeder</code>.</li>
        <li>Jalankan <code>php artisan serve</code>.</li>
    </ol>

    <h2>11. Checklist Demo</h2>
    <ul>
        <li>Database dan novel bawaan sudah tersedia.</li>
        <li>Login dan register dapat digunakan.</li>
        <li>Reward membaca dan coin dapat diuji.</li>
        <li>Pengajuan writer dapat diproses admin.</li>
        <li>Writer dapat membuat novel dan chapter.</li>
        <li>PDF dokumentasi dapat diunduh.</li>
    </ul>

    <h2>12. Pengujian</h2>
    <p>Project memiliki pengujian feature untuk login, alur novel, role writer, admin, pencarian katalog, dan reward membaca. Perintah pengujian:</p>
    <div class="box"><code>php artisan test</code></div>
    <p>Dokumentasi ini tidak mencantumkan password akun demo agar tidak menjadi kredensial yang tersebar.</p>

    <div class="footer">NovelKu · Dokumentasi Project Sekolah · Sebastian Botu · XII RPL 1 · SMK Wahidin Kota Cirebon</div>
</body>
</html>