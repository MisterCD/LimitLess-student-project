@extends('layouts.admin')

@section('title', 'Добавить фильм')

@section('content')
<div class="admin-page-title">Добавить фильм</div>

@if ($errors->any())
    <div class="alert alert-error" style="max-width:560px">{{ $errors->first() }}</div>
@endif

<div class="admin-form">
    <form method="POST" action="{{ route('createMovie') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">Название фильма</label>
            <input
                type="text"
                name="name"
                class="form-input"
                placeholder="Минимум 6 символов"
                value="{{ old('name') }}"
                minlength="6" maxlength="50"
                required
            >
        </div>

        <div class="form-group">
            <label class="form-label">Режиссёр</label>
            <input
                type="text"
                name="author"
                class="form-input"
                placeholder="Имя режиссёра"
                value="{{ old('author') }}"
                minlength="6" maxlength="30"
                required
            >
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
                <label class="form-label">Год</label>
                <input
                    type="number"
                    name="year"
                    class="form-input"
                    placeholder="{{ date('Y') }}"
                    value="{{ old('year') }}"
                    min="1900" max="{{ date('Y') + 2 }}"
                    required
                >
            </div>
            <div class="form-group">
                <label class="form-label">Жанр</label>
                <select name="genre_id" class="form-input" required>
                    <option value="" disabled selected>Выберите жанр</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Описание (до 200 символов)</label>
            <textarea
                name="description"
                class="form-input"
                rows="3"
                maxlength="200"
                placeholder="Краткое описание фильма..."
                style="resize:none"
                required
            >{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Обложка (PNG / JPEG)</label>
            <input
                type="file"
                name="title_image"
                class="form-input"
                accept="image/png,image/jpeg"
                style="padding:8px"
                required
            >
        </div>

        <div style="display:flex;gap:12px;align-items:center">
            <button type="submit" class="btn btn-red">Создать фильм</button>
            <a href="{{ route('admin_movies') }}" class="btn btn-ghost">Отмена</a>
        </div>
    </form>
</div>
@endsection
