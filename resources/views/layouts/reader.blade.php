<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca: @yield('title') | NovelKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reader.css') }}">
</head>
<body class="reader-body" id="readerBody">

<!-- READER NAVBAR -->
<div class="reader-navbar" id="readerNav">
    <div class="reader-nav-inner">
        <a href="{{ route('novels.show', $novel) }}" class="reader-back-btn">
            ← Kembali ke Novel
        </a>
        <div class="reader-title-info">
            <span class="reader-novel-title">{{ $novel->title }}</span>
            <span class="reader-chapter-info">Chapter {{ $chapter->chapter_number }}</span>
        </div>
        <div class="reader-controls">
            <button onclick="decreaseFontSize()" class="reader-ctrl-btn" title="Perkecil teks">A-</button>
            <button onclick="increaseFontSize()" class="reader-ctrl-btn" title="Perbesar teks">A+</button>
            <button onclick="toggleTheme()" class="reader-ctrl-btn" id="themeBtn" title="Ganti tema">🌙</button>
        </div>
    </div>
</div>

<main class="reader-main">
    @yield('content')
</main>

<script>
let fontSize = parseInt(localStorage.getItem('readerFontSize')) || 18;
let isDark = localStorage.getItem('readerTheme') !== 'light';

function applyFontSize() {
    document.querySelector('.reader-content')?.style.setProperty('font-size', fontSize + 'px');
}
function increaseFontSize() {
    if (fontSize < 28) { fontSize += 2; localStorage.setItem('readerFontSize', fontSize); applyFontSize(); }
}
function decreaseFontSize() {
    if (fontSize > 14) { fontSize -= 2; localStorage.setItem('readerFontSize', fontSize); applyFontSize(); }
}
function toggleTheme() {
    isDark = !isDark;
    document.body.classList.toggle('reader-light', !isDark);
    document.getElementById('themeBtn').textContent = isDark ? '🌙' : '☀️';
    localStorage.setItem('readerTheme', isDark ? 'dark' : 'light');
}
document.addEventListener('DOMContentLoaded', () => {
    applyFontSize();
    if (!isDark) {
        document.body.classList.add('reader-light');
        document.getElementById('themeBtn').textContent = '☀️';
    }
});
</script>
@stack('scripts')
</body>
</html>
