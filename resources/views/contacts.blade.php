@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div style="padding-top:64px">
    <section>
        <div class="section-title" style="margin-bottom:40px">
            <small>Найти нас</small>
            Контакты
        </div>

        <div class="contacts-grid">
            <div class="contacts-block">
                <div class="contact-item">
                    <div class="contact-label">Адрес</div>
                    <div class="contact-value">ул. Кинематографистов, 1</div>
                    <div class="contact-sub">Москва, 101000</div>
                </div>
                <div class="contact-item">
                    <div class="contact-label">Телефон</div>
                    <div class="contact-value">+7 (495) 000-00-00</div>
                    <div class="contact-sub">Ежедневно 9:00 — 23:00</div>
                </div>
                <div class="contact-item">
                    <div class="contact-label">Email</div>
                    <div class="contact-value">info@limitless.ru</div>
                    <div class="contact-sub">Отвечаем в течение часа</div>
                </div>
                <div class="contact-item">
                    <div class="contact-label">Парковка</div>
                    <div class="contact-value">Бесплатно</div>
                    <div class="contact-sub">300 мест, подземная</div>
                </div>
            </div>

            <div class="contacts-block" style="padding:0">
                <div style="background:var(--bg3);height:100%;min-height:300px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px">
                    <div style="font-size:48px;color:var(--text3)">◎</div>
                    <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:var(--text3)">Карта</div>
                </div>
            </div>
        </div>

        {{-- CONTACT FORM --}}
        <div style="margin-top:2px;background:var(--bg2);padding:40px">
            <div style="font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:1px;margin-bottom:24px">
                Написать нам
            </div>

            @if(session('contact_sent'))
                <div class="alert alert-success">Сообщение отправлено! Мы ответим в течение часа.</div>
            @endif

            <form method="POST" action="{{ route('contacts') }}">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;max-width:560px">
                    <div class="form-group" style="margin:0">
                        <input class="form-input" name="contact_name" placeholder="Ваше имя" required>
                    </div>
                    <div class="form-group" style="margin:0">
                        <input class="form-input" name="contact_email" type="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-group" style="margin:16px 0;max-width:560px">
                    <textarea
                        class="form-input"
                        name="contact_message"
                        rows="4"
                        placeholder="Сообщение..."
                        style="resize:none"
                        required
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-red">Отправить</button>
            </form>
        </div>
    </section>
</div>
@endsection
