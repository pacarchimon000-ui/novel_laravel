<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Admin NovelKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <span>📖</span> Novel<span class="brand-accent">Ku</span>
            <span class="admin-badge">Admin</span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="sidebar-icon">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.novels.index') }}" class="sidebar-link {{ request()->routeIs('admin.novels.*') ? 'active' : '' }}">
                <span class="sidebar-icon">📚</span> Kelola Novel
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="sidebar-icon">👥</span> Kelola User
            </a>
            <a href="{{ route('admin.users.pending-writers') }}" class="sidebar-link {{ request()->routeIs('admin.users.pending-writers') ? 'active' : '' }}">
                <span class="sidebar-icon">✍️</span> Pengajuan Writer
            </a>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <span class="sidebar-icon">🚩</span> Kelola Laporan
            </a>
            <div class="sidebar-divider"></div>
            <a href="{{ route('home') }}" class="sidebar-link">
                <span class="sidebar-icon">🌐</span> Lihat Website
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link sidebar-logout">
                    <span class="sidebar-icon">🚪</span> Keluar
                </button>
            </form>
            <div style="padding: 1rem 1.5rem; font-size: 0.72rem; color: #7c6d9c; margin-top: auto; border-top: 1px solid #281b47;">
                ✨ Buatan <strong>Sebastian Botu</strong>
            </div>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="admin-main">
        <!-- TOP BAR -->
        <header class="admin-topbar">
            <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
            <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
            <div class="topbar-user">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                @else
                    <div class="user-avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                @endif
                <span>{{ auth()->user()->name }}</span>
            </div>
        </header>

        <!-- FLASH -->
        @if(session('success'))
        <div class="admin-flash flash-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="admin-flash flash-error">❌ {{ session('error') }}</div>
        @endif

        <!-- CONTENT -->
        <div class="admin-content">
            @yield('content')
        </div>
    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('collapsed');
}
</script>
@stack('scripts')
</body>
</html>
