@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<div style="padding-top:64px">

    {{-- USER HEADER --}}
    <div class="user-header">
        <div class="user-avatar">
            {{ Str::upper(Str::substr($user->name, 0, 2)) }}
        </div>
        <div>
            <div class="user-name">{{ $user->name }}</div>
            <div class="user-email">{{ $user->email }}</div>
            <div style="margin-top:12px;display:flex;gap:8px">
                <button
                    class="btn btn-ghost"
                    id="tab-btn-bookings"
                    onclick="switchTab('bookings')"
                    style="font-size:11px;padding:6px 16px"
                >Бронирования</button>
                <button
                    class="btn btn-ghost"
                    id="tab-btn-settings"
                    onclick="switchTab('settings')"
                    style="font-size:11px;padding:6px 16px"
                >Настройки</button>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button
                        type="submit"
                        class="btn btn-ghost"
                        style="font-size:11px;padding:6px 16px;color:var(--red);border-color:rgba(232,37,26,0.3)"
                    >Выйти</button>
                </form>
            </div>
        </div>
    </div>

    {{-- BOOKINGS TAB --}}
    <div id="tab-bookings">
        <div class="user-section" style="border-bottom:1px solid var(--border)">
            <div class="user-section-title">Мои бронирования</div>

            @forelse($user->bookings ?? [] as $booking)
                <div class="booking-item">
                    <div>
                        <div class="booking-movie">{{ $booking->session->movie->name ?? '—' }}</div>
                        <div class="booking-details">
                            {{ $booking->session->date ?? '—' }} ·
                            {{ $booking->session->time ?? '—' }} ·
                            {{ $booking->session->room->name ?? '—' }} ·
                            Место {{ $booking->plase_id }}
                        </div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:14px;font-weight:500;color:var(--gold)">
                            {{ number_format($booking->session->price ?? 0, 0, '', ' ') }} ₽
                        </div>
                        <div style="font-size:11px;color:var(--text3);margin-top:2px">Подтверждено</div>
                    </div>
                </div>
            @empty
                <div style="padding:32px 0;color:var(--text3);font-size:13px">
                    У вас пока нет бронирований.
                    <a href="{{ route('movies') }}" style="color:var(--text);border-bottom:1px solid var(--text3)">Смотреть фильмы →</a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- SETTINGS TAB --}}
    <div id="tab-settings" style="display:none">
        <div class="user-section">
            <div class="user-section-title">Настройки профиля</div>
            <div style="max-width:440px">

                @if ($errors->any())
                    <div class="alert alert-error">{{ $errors->first() }}</div>
                @endif

                {{-- PROFILE FORM --}}
                <form method="POST" action="{{ route('changeUser') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label class="form-label">Имя</label>
                        <input
                            type="text"
                            name="name"
                            class="form-input"
                            value="{{ $user->name }}"
                            minlength="6" maxlength="30"
                        >
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-input"
                            value="{{ $user->email }}"
                        >
                    </div>
                    <div class="form-group">
                        <label class="form-label">Телефон</label>
                        <input
                            type="text"
                            name="telefon"
                            class="form-input"
                            value="{{ $user->telefon }}"
                        >
                    </div>
                    <button type="submit" class="btn btn-red">Сохранить</button>
                </form>

                {{-- PASSWORD FORM --}}
                <div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border)">
                    <div style="font-size:14px;font-weight:500;margin-bottom:16px;color:var(--text2)">Изменить пароль</div>
                    <form method="POST" action="{{ route('changeUser') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <div class="form-group">
                            <label class="form-label">Текущий пароль</label>
                            <input type="password" name="password_old" class="form-input" placeholder="••••••••">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Новый пароль</label>
                            <input type="password" name="password" class="form-input" placeholder="Минимум 6 символов" minlength="6">
                        </div>
                        <button type="submit" class="btn btn-outline">Изменить пароль</button>
                    </form>
                </div>

                {{-- DELETE ACCOUNT --}}
                <div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border)">
                    <form
                        method="POST"
                        action="{{ route('deleteUser') }}"
                        onsubmit="return confirm('Удалить аккаунт? Это действие необратимо.')"
                    >
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button
                            type="submit"
                            class="btn"
                            style="background:transparent;border:1px solid rgba(232,37,26,0.4);color:var(--red);font-size:11px;letter-spacing:1px"
                        >Удалить аккаунт</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function switchTab(tab) {
    document.getElementById('tab-bookings').style.display = tab === 'bookings' ? 'block' : 'none';
    document.getElementById('tab-settings').style.display = tab === 'settings' ? 'block' : 'none';
}

// Auto-open settings tab if there were validation errors
@if($errors->any())
    switchTab('settings');
@endif
</script>
@endpush
