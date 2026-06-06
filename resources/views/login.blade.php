@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="auth-page">
    <div class="auth-box">
        <a href="{{ route('main') }}" class="auth-logo">LIMIT<span>LESS</span></a>

        <div class="auth-title">Вход</div>
        <p class="auth-sub">Введите данные для входа в аккаунт</p>

        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                <label class="form-label" for="password">Пароль</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    placeholder="••••••••"
                    required
                >
            </div>

            <button type="submit" class="btn btn-red form-submit">Войти</button>
        </form>

        <div class="auth-switch">
            Нет аккаунта? <a href="{{ route('createUser') }}">Зарегистрироваться</a>
        </div>
    </div>
</div>
@endsection
