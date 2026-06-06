@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div style="padding-top:64px">

    <section style="padding-top:80px">
        <div style="max-width:800px">
            <div style="font-size:11px;letter-spacing:4px;text-transform:uppercase;color:var(--red);margin-bottom:20px;display:flex;align-items:center;gap:12px">
                <span style="width:40px;height:1px;background:var(--red);display:inline-block"></span>О нас
            </div>
            <h1 style="font-family:'Bebas Neue',sans-serif;font-size:clamp(60px,8vw,100px);line-height:.92;letter-spacing:2px;margin-bottom:32px">
                КИНО —<br>ЭТО <span style="color:var(--red)">ЖИЗНЬ</span>
            </h1>
            <p style="font-size:15px;color:var(--text2);max-width:600px;line-height:1.9;font-weight:300;margin-bottom:48px">
                LimitLess — кинотеатр нового поколения, открытый в 2020 году. Мы верим, что поход в кино должен быть
                незабываемым событием. Каждый зал оборудован передовыми технологиями звука и изображения,
                а наша команда делает всё, чтобы каждый визит был особенным.
            </p>
        </div>
    </section>

    <section style="background:var(--bg2);padding:64px 40px">
        <div class="section-header">
            <div class="section-title">
                <small>Цифры</small>
                LimitLess в цифрах
            </div>
        </div>
        <div class="features-grid">
            <div class="feature">
                <div class="feature-icon">◈</div>
                <div class="feature-title">8 залов</div>
                <p class="feature-text">От стандартных залов до VIP с кожаными креслами и индивидуальным обслуживанием.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">◉</div>
                <div class="feature-title">1200 мест</div>
                <p class="feature-text">Более 1200 мест различных категорий: стандарт, комфорт, VIP и IMAX.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">◫</div>
                <div class="feature-title">С 2020 года</div>
                <p class="feature-text">6 лет мы радуем зрителей лучшими фильмами и непревзойдённым сервисом.</p>
            </div>
        </div>
    </section>

    <section>
        <div class="section-header">
            <div class="section-title">
                <small>Технологии</small>
                Наше оборудование
            </div>
        </div>
        <div class="features-grid">
            <div class="feature">
                <div class="feature-icon">▣</div>
                <div class="feature-title">Dolby Atmos</div>
                <p class="feature-text">Объёмный звук с 64 динамиками создаёт полное погружение. Звук движется вокруг вас в трёхмерном пространстве.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">▤</div>
                <div class="feature-title">4K Laser HDR</div>
                <p class="feature-text">Лазерные проекторы Christie нового поколения. Контраст 10000:1, яркость 60000 люменов.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">▦</div>
                <div class="feature-title">IMAX</div>
                <p class="feature-text">Один зал IMAX с экраном 26×16 метров и фирменной системой звука IMAX Enhanced.</p>
            </div>
        </div>
    </section>

</div>
@endsection
