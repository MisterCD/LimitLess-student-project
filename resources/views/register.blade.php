@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="auth-page">
    <div class="auth-box">
        <a href="{{ route('main') }}" class="auth-logo">LIMIT<span>LESS</span></a>

        <div class="auth-title">Регистрация</div>
        <p class="auth-sub">Создайте аккаунт для бронирования</p>

        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('createUser') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Имя</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-input"
                    placeholder="Иван Иванов"
                    value="{{ old('name') }}"
                    minlength="6"
                    maxlength="30"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input"
                    placeholder="your@email.com"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="telefon">Телефон</label>
                <input
                    type="text"
                    id="telefon"
                    name="telefon"
                    class="form-input"
                    placeholder="+7-(999)-00-00-000"
                    value="{{ old('telefon') }}"
                    required
                >
                <div style="font-size:11px;color:var(--text3);margin-top:4px">Формат: +7-(XXX)-XX-XX-XXX</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Пароль</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    placeholder="Минимум 6 символов"
                    minlength="6"
                    maxlength="50"
                    required
                >
            </div>

            <button type="submit" class="btn btn-red form-submit">Создать аккаунт</button>
        </form>

        <div class="auth-switch">
            Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
        </div>
    </div>
</div>
@endsection
