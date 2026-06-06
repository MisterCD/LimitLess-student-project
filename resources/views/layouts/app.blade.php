<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LimitLess') — Кинотеатр</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

{{-- NAVIGATION --}}
<nav>
    <a href="{{ route('main') }}" class="nav-logo">LIMIT<span>LESS</span></a>

    <div class="nav-links">
        <a href="{{ route('main') }}"     class="{{ request()->routeIs('main')     ? 'active' : '' }}">Главная</a>
        <a href="{{ route('movies') }}"   class="{{ request()->routeIs('movies')   ? 'active' : '' }}">Фильмы</a>
        <a href="{{ route('about') }}"    class="{{ request()->routeIs('about')    ? 'active' : '' }}">О нас</a>
        <a href="{{ route('contacts') }}" class="{{ request()->routeIs('contacts') ? 'active' : '' }}">Контакты</a>
    </div>

    <div class="nav-actions">
        @if(!empty(session("user_id")))
            @if(session('role') == 1)
                <a href="{{ route('admin_movies') }}" class="btn btn-ghost" style="font-size:11px">Панель</a>
            @endif
            <a href="{{ route('user') }}" class="btn btn-ghost" style="font-size:11px">
                {{ Str::limit(auth()->user()->name ?? 'Профиль', 12) }}
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-red">Выйти</button>
            </form>
        @else
            <a href="{{ route('login') }}"    class="btn btn-ghost">Войти</a>
            <a href="{{ route('register') }}" class="btn btn-red">Регистрация</a>
        @endif
    </div>
</nav>

{{-- FLASH ERRORS --}}
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

{{-- PAGE CONTENT --}}
@yield('content')

{{-- FOOTER --}}
@unless(request()->routeIs('login') || request()->routeIs('createUser') || str_starts_with(request()->path(), 'admin'))
<footer>
    <div class="footer-top">
        <div>
            <div class="footer-brand">LIMIT<span>LESS</span></div>
            <p class="footer-desc">Кинотеатр нового поколения в сердце города. Мы создаём незабываемые впечатления для каждого зрителя.</p>
        </div>
        <div class="footer-col">
            <h4>Навигация</h4>
            <a href="{{ route('main') }}">Главная</a>
            <a href="{{ route('movies') }}">Фильмы</a>
            <a href="{{ route('about') }}">О нас</a>
            <a href="{{ route('contacts') }}">Контакты</a>
        </div>
        <div class="footer-col">
            <h4>Аккаунт</h4>
            <a href="{{ route('login') }}">Войти</a>
            <a href="{{ route('createUser') }}">Регистрация</a>
            @auth
                <a href="{{ route('user') }}">Профиль</a>
            @endauth
        </div>
        <div class="footer-col">
            <h4>Контакты</h4>
            <a href="mailto:info@limitless.ru">info@limitless.ru</a>
            <a href="tel:+74950000000">+7 (495) 000-00-00</a>
            <a href="#">ул. Кинематографистов, 1</a>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} LimitLess. Все права защищены.</span>
        <span>Сделано с ♥ для кино</span>
    </div>
</footer>
@endunless

{{-- NOTIFICATION TOAST --}}
<div class="notif" id="notif"></div>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
