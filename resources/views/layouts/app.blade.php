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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        :root {
            --primary: #7c3aed;
            --primary-light: #8b5cf6;
            --primary-dark: #5b21b6;
            --accent: #f59e0b;
            --accent-light: #fbbf24;
            --danger: #ef4444;
            --success: #10b981;
            --bg: #0f0a1e;
            --bg-card: #1a1030;
            --bg-surface: #211540;
            --bg-hover: #2d1f55;
            --text: #e2d9f3;
            --text-muted: #9d8ec0;
            --text-dim: #6b5f8a;
            --border: #2d1f55;
            --border-light: #3d2f65;
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 20px;
            --shadow: 0 4px 24px rgba(0,0,0,0.4);
            --shadow-lg: 0 8px 48px rgba(0,0,0,0.6);
    --font-body: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Color Emoji', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', sans-serif;
    --font-reading: 'Merriweather', Georgia, serif;
            --nav-h: 68px;
            --transition: all 0.25s ease;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
            min-height: 100vh;
        }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        button { cursor: pointer; font-family: inherit; border: none; background: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        
        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            height: var(--nav-h);
            background: rgba(15,10,30,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }
        .nav-container { display: flex; align-items: center; gap: 2rem; height: var(--nav-h); }
        .nav-brand { display: flex; align-items: center; gap: 0.5rem; font-size: 1.5rem; font-weight: 800; }
        .brand-accent { color: var(--primary-light); }
        .nav-links { display: flex; gap: 0.25rem; margin-left: auto; }
        .nav-link {
            padding: 0.45rem 1rem; border-radius: var(--radius-sm);
            color: var(--text-muted); font-size: 0.9rem; font-weight: 500;
            transition: var(--transition);
        }
        .nav-link:hover, .nav-link.active { color: var(--text); background: var(--bg-surface); }
        
        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.55rem 1.25rem; border-radius: var(--radius-sm);
            font-size: 0.9rem; font-weight: 600; transition: var(--transition);
            border: 2px solid transparent;
        }
        .btn-primary {
            background: var(--primary); color: #fff;
        }
        .btn-primary:hover { background: var(--primary-light); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(124,58,237,0.4); }
        
        /* MAIN */
        .main-content { margin-top: var(--nav-h); min-height: calc(100vh - var(--nav-h)); padding: 2rem 0; }
        
        /* PAGES */
        .novels-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(195px, 1fr)); gap: 1.5rem; margin-top: 2rem; }
        .novel-card { background: var(--bg-card); border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); transition: var(--transition); }
        .novel-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary); }
        .novel-card-body { padding: 1rem; }
        .novel-card-title { font-size: 0.92rem; font-weight: 700; margin-bottom: 0.4rem; line-height: 1.4; }
        
        /* FORMS */
        input, select, textarea {
            width: 100%;
            padding: 0.65rem 1rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: inherit;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        input[type="checkbox"] {
            width: auto;
            margin-right: 0.5rem;
            margin-bottom: 0;
            vertical-align: middle;
            cursor: pointer;
        }
        input[type="radio"] {
            width: auto;
            margin-right: 0.5rem;
            margin-bottom: 0;
            vertical-align: middle;
            cursor: pointer;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(124,58,237,0.15);
        }
        label {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            font-size: 0.9rem;
        }
        label input[type="checkbox"],
        label input[type="radio"] {
            margin-right: 0.5rem;
        }
        
        /* SECTION */
        .section { padding: 2rem 0; }
        .section-title { font-size: 1.6rem; font-weight: 700; margin-bottom: 1.5rem; }
        
        @media (max-width: 640px) {
            .nav-links { display: none; }
            .novels-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
    
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
                <a href="{{ route('coins.index') }}" class="nav-link {{ request()->routeIs('coins.*') ? 'active' : '' }}">⚡ EXP & Koin ({{ auth()->user()->coins }})</a>
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
                        <a href="{{ route('coins.index') }}" class="dropdown-item">⚡ EXP & Koin: {{ auth()->user()->coins }}</a>
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
                    <a href="{{ route('coins.index') }}">EXP & Koin</a>
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
