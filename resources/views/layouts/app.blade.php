<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'NovelKu - Platform membaca novel online terbaik. Temukan ribuan novel seru dan nikmati pengalaman membaca yang menyenangkan.')">
    <title>@yield('title', 'NovelKu') - Novel Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
    @stack('scripts')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="mainNavbar">
    <div class="container nav-container">
        <a href="{{ route('home') }}" class="nav-brand">
            <span class="brand-icon">📖</span>
            <span class="brand-text">Novel<span class="brand-accent">Ku</span></span>
        </a>

        <div class="nav-links" id="navLinks">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('novels.index') }}" class="nav-link {{ request()->routeIs('novels.*') ? 'active' : '' }}">Novel</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">⚙️ Admin</a>
                @elseif(auth()->user()->isWriter())
                    <a href="{{ route('writer.dashboard') }}" class="nav-link {{ request()->routeIs('writer.*') ? 'active' : '' }}">✍️ Writer</a>
                @else
                    <a href="{{ route('bookmarks.index') }}" class="nav-link {{ request()->routeIs('bookmarks.*') ? 'active' : '' }}">🔖 Bookmark</a>
                @endif
                <a href="{{ route('coins.index') }}" class="nav-link {{ request()->routeIs('coins.*') ? 'active' : '' }}"><span class="coin-badge" aria-hidden="true">C</span> Coin ({{ auth()->user()->coins }})</a>
            @endauth
        </div>

        <div class="nav-actions">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
            @else
                <a href="{{ route('notifications.index') }}" class="btn btn-outline" style="padding: 0.4rem 0.75rem; position: relative;" title="Notifikasi">
                    🔔
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span style="position: absolute; top: -5px; right: -5px; background: var(--danger); color: #fff; border-radius: 50%; font-size: 0.7rem; font-weight: 700; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <div class="user-dropdown" id="userDropdown">
                    <button class="user-btn" onclick="toggleDropdown()">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        @endif
                        <span class="user-name">{{ Str::limit(auth()->user()->name, 15) }}</span>
                        <span class="dropdown-arrow">▾</span>
                    </button>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <div class="dropdown-header">
                            <div class="dh-name">{{ auth()->user()->name }}</div>
                            <div class="dh-role">
                                @if(auth()->user()->isAdmin())
                                    👑 Admin
                                @elseif(auth()->user()->isWriter())
                                    ✍️ Writer
                                @else
                                    👤 Pengguna
                                @endif
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">👤 Pengaturan Profil</a>
                        <a href="{{ route('coins.index') }}" class="dropdown-item"><span class="coin-badge" aria-hidden="true">C</span> Coin: {{ auth()->user()->coins }}</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">⚙️ Dashboard Admin</a>
                        @elseif(auth()->user()->isWriter())
                            <a href="{{ route('writer.dashboard') }}" class="dropdown-item">✍️ Dashboard Writer</a>
                        @else
                            <a href="{{ route('bookmarks.index') }}" class="dropdown-item">🔖 Bookmark Saya</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">🚪 Keluar</button>
                        </form>
                    </div>
                </div>
            @endguest

            <button class="hamburger" id="hamburger" onclick="toggleNav()">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<!-- FLASH MESSAGES -->
@if(session('success'))
<div class="flash-toast flash-success" id="flashToast">
    <span>✅ {{ session('success') }}</span>
    <button onclick="this.parentElement.remove()">×</button>
</div>
@endif
@if(session('error'))
<div class="flash-toast flash-error" id="flashToast">
    <span>❌ {{ session('error') }}</span>
    <button onclick="this.parentElement.remove()">×</button>
</div>
@endif

<!-- MAIN CONTENT -->
<main class="main-content">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logo">📖 Novel<span class="brand-accent">Ku</span></div>
                <p class="footer-desc">Platform membaca novel online terbaik. Temukan cerita-cerita seru dari berbagai genre pilihan.</p>
            </div>
            <div class="footer-links">
                <h4>Navigasi</h4>
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('novels.index') }}">Semua Novel</a>
                @auth
                    <a href="{{ route('bookmarks.index') }}">Bookmark</a>
                    <a href="{{ route('coins.index') }}">Coin</a>
                @endauth
            </div>
            <div class="footer-links">
                <h4>Genre</h4>
                <a href="{{ route('novels.index', ['genre' => 'Fantasy']) }}">Fantasy</a>
                <a href="{{ route('novels.index', ['genre' => 'Romance']) }}">Romance</a>
                <a href="{{ route('novels.index', ['genre' => 'Action']) }}">Action</a>
                <a href="{{ route('novels.index', ['genre' => 'Mystery']) }}">Mystery</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} NovelKu • 🚀 <strong>Buatan Sebastian Botu</strong>. Dibuat dengan ❤️ untuk para pecinta novel.</p>
        </div>
    </div>
</footer>

<script>
function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('show');
}
function toggleNav() {
    document.getElementById('navLinks').classList.toggle('show');
}
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown && !dropdown.contains(e.target)) {
        document.getElementById('dropdownMenu')?.classList.remove('show');
    }
});
// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
// Auto-hide toast
setTimeout(() => {
    const toast = document.getElementById('flashToast');
    if (toast) toast.style.opacity = '0';
}, 4000);
</script>
@stack('scripts')
</body>
</html>
