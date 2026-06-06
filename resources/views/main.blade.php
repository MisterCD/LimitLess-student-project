@extends('layouts.app')

@section('title', 'Главная')

@section('content')

 
<div class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-accent"></div>

    <div class="hero-stats">
        <div class="stat">
            <div class="stat-num">120+</div>
            <div class="stat-label">Фильмов</div>
        </div>
        <div class="stat">
            <div class="stat-num">8</div>
            <div class="stat-label">Залов</div>
        </div>
        <div class="stat">
            <div class="stat-num">4K</div>
            <div class="stat-label">Качество</div>
        </div>
    </div>

    <div class="hero-content">
        <div class="hero-eyebrow">Кинотеатр нового поколения</div>
        <h1 class="hero-title">КИНО БЕЗ<br><span>ГРАНИЦ</span></h1>
        <p class="hero-sub">Погрузитесь в мир кино с непревзойдённым звуком Dolby Atmos и кристальным изображением 4K HDR.</p>
        <div class="hero-cta">
            <a href="{{ route('movies') }}" class="btn btn-red" style="padding:14px 32px;font-size:13px">Смотреть расписание</a>
            <a href="{{ route('about') }}"  class="btn btn-ghost" style="padding:14px 32px;font-size:13px">О кинотеатре</a>
        </div>
    </div>

    <div class="hero-scroll">
        <div class="hero-scroll-line"></div>
        Прокрутить
    </div>
</div>

 
<section style="padding-top:60px">
    <div class="section-header">
        <div class="section-title">
            <small>Сейчас в прокате</small>
            Популярные фильмы
        </div>
        <a href="{{ route('movies') }}" class="btn btn-ghost">Все фильмы →</a>
    </div>

    

    <div class="movies-grid">
        @foreach($movies as $movie)
            @include('components.movie-card', ['movie' => $movie])
        @endforeach
    </div>
</section>

 
<section style="background:var(--bg2);padding:64px 40px">
    <div class="section-header">
        <div class="section-title">
            <small>Почему мы</small>
            Преимущества
        </div>
    </div>
    <div class="features-grid">
        <div class="feature">
            <div class="feature-icon">◈</div>
            <div class="feature-title">Dolby Atmos</div>
            <p class="feature-text">Объёмный звук с 64 динамиками создаёт полное погружение в каждый звук фильма.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">◉</div>
            <div class="feature-title">4K HDR экраны</div>
            <p class="feature-text">Лазерные проекторы нового поколения с HDR10+ и широким цветовым охватом P3.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">◫</div>
            <div class="feature-title">VIP залы</div>
            <p class="feature-text">Кресла с подогревом, персональное обслуживание и меню от шеф-повара прямо в зале.</p>
        </div>
    </div>
</section>

@endsection
