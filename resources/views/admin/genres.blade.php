@extends('layouts.admin')

@section('title', 'Жанры')

@section('content')
<div class="admin-page-title">Жанры</div>

<div style="display:grid;grid-template-columns:360px 1fr;gap:2px;align-items:start">

     
    <div class="admin-form">
        <div style="font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:1px;margin-bottom:20px">
            Добавить жанр
        </div>

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('createGenre') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Название жанра</label>
                <input
                    type="text"
                    name="name"
                    class="form-input"
                    placeholder="Например: Документальный"
                    value="{{ old('name') }}"
                    minlength="3"
                    maxlength="30"
                    required
                    autocomplete="off"
                >
                <div style="font-size:11px;color:var(--text3);margin-top:6px">От 3 до 30 символов</div>
            </div>

            <button type="submit" class="btn btn-red">Добавить жанр</button>
        </form>
    </div>

     
    <div style="background:var(--bg2);padding:32px;border:1px solid var(--border)">
        <div style="font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:1px;margin-bottom:20px">
            Все жанры
        </div>

        @forelse($genres as $genre)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border)">
                <div>
                    <div style="font-size:14px;font-weight:500">{{ $genre->name }}</div>
                </div>
                <form
                    method="POST"
                    action="{{ route('deleteGenre') }}"
                    onsubmit="return confirm('Удалить жанр «{{ $genre->name }}»? Он будет отвязан от всех фильмов.')"
                >
                    @csrf
                    <input type="hidden" name="id" value="{{ $genre->id }}">
                    <button type="submit" class="action-btn action-btn-red">Удалить</button>
                </form>
            </div>
        @empty
            <div style="color:var(--text3);font-size:13px;padding:20px 0">
                Жанры ещё не добавлены
            </div>
        @endforelse
    </div>

</div>
@endsection
