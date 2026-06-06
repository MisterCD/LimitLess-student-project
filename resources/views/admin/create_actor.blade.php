@extends('layouts.admin')

@section('title', 'Добавить актёра')

@section('content')
<div class="admin-page-title">Добавить актёра</div>

@if ($errors->any())
    <div class="alert alert-error" style="max-width:560px">{{ $errors->first() }}</div>
@endif

<div class="admin-form">
    <form method="POST" action="{{ route('createActor') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Имя актёра</label>
            <input
                type="text"
                name="name"
                class="form-input"
                placeholder="Полное имя"
                value="{{ old('name') }}"
                minlength="6"
                maxlength="30"
                required
            >
        </div>

        <div class="form-group">
            <label class="form-label">Фильм</label>
            <select name="movie_id" class="form-input" required>
                <option value="" disabled selected>Выберите фильм</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                        {{ $movie->name }} ({{ $movie->year }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display:flex;gap:12px">
            <button type="submit" class="btn btn-red">Добавить актёра</button>
            <a href="{{ route('admin_movies') }}" class="btn btn-ghost">Отмена</a>
        </div>
    </form>
</div>

{{-- EXISTING ACTORS TABLE --}}
@if(isset($actors) && $actors->count())
<div style="margin-top:40px">
    <div style="font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:1px;margin-bottom:20px">
        Все актёры
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Фильм</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actors as $actor)
                <tr>
                    <td style="font-weight:500">{{ $actor->name }}</td>
                    <td style="color:var(--text2)">{{ $actor->movie->name ?? '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('deleteActor') }}" style="display:inline"
                              onsubmit="return confirm('Удалить актёра «{{ $actor->name }}»?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $actor->id }}">
                            <button type="submit" class="action-btn action-btn-red">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
