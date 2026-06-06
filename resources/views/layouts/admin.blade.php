<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ — @yield('title', 'LimitLess')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

<nav>
    <a href="{{ route('main') }}" class="nav-logo">LIMIT<span>LESS</span></a>
    <div class="nav-links">
        <span style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text3)">Панель администратора</span>
    </div>
    <div class="nav-actions">
        <a href="{{ route('main') }}" class="btn btn-ghost" style="font-size:11px">← Сайт</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-ghost" style="font-size:11px;color:var(--red);border-color:rgba(232,37,26,0.3)">Выйти</button>
        </form>
    </div>
</nav>

@if ($errors->any())
    <div style="position:fixed;top:72px;right:20px;z-index:200;max-width:360px">
        @foreach ($errors->all() as $error)
            <div class="alert alert-error">{{ $error }}</div>
        @endforeach
    </div>
@endif

@if (session('success'))
    <div style="position:fixed;top:72px;right:20px;z-index:200;max-width:360px">
        <div class="alert alert-success">{{ session('success') }}</div>
    </div>
@endif

<div class="admin-layout" style="padding-top:64px">

    {{-- SIDEBAR --}}
    <div class="admin-sidebar">
        <div class="sidebar-section">
            <div class="sidebar-label">Управление</div>

            <a href="{{ route('admin_movies') }}" class="sidebar-link {{ request()->routeIs('admin_movies') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="1"/><path d="M8 21h8M12 17v4"/></svg>
                Фильмы
            </a>
            <a href="{{ route('admin_rooms') }}" class="sidebar-link {{ request()->routeIs('admin_rooms') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="1"/><path d="M3 9h18M9 21V9"/></svg>
                Залы
            </a>
            <a href="{{ route('admin_rewiews') }}" class="sidebar-link {{ request()->routeIs('admin_rewiews') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Отзывы
            </a>
            <a href="{{ route('admin_users') }}" class="sidebar-link {{ request()->routeIs('admin_users') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Пользователи
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Создать</div>
            <a href="{{ route('createMoviePage') }}" class="sidebar-link {{ request()->routeIs('createMoviePage') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                Добавить фильм
            </a>
            <a href="{{ route('createActorPage') }}" class="sidebar-link {{ request()->routeIs('createActorPage') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                Добавить актёра
            </a>
            <a href="{{ route('addRoomPage') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                Добавить зал
            </a>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="admin-main">
        @yield('content')
    </div>

</div>

<div class="notif" id="notif"></div>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
