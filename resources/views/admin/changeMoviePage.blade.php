@extends('layouts.admin')

@section('title', 'Изменить фильм')

@section('content')
<div class="admin-page-title">Изменить фильм</div>

@if ($errors->any())
    <div class="alert alert-error" style="max-width:560px">{{ $errors->first() }}</div>
@endif

<div class="admin-form">
    <form method="POST" action="{{ route('changeMovie') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $movie->id }}">

        <div class="form-group">
            <label class="form-label">Название фильма</label>
            <input
                type="text"
                name="name"
                class="form-input"
                value="{{ old('name', $movie->name) }}"
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
                value="{{ old('author', $movie->author) }}"
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
                    value="{{ old('year', $movie->year) }}"
                    min="1900"
                    required
                >
            </div>
            <div class="form-group">
                <label class="form-label">Жанр</label>
                <select name="genre" class="form-input">
                    @foreach($genres ?? [] as $genre)
                        <option value="{{ $genre->id }}" {{ $movie->genre_id == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Описание</label>
            <textarea
                name="description"
                class="form-input"
                rows="3"
                maxlength="200"
                style="resize:none"
                required
            >{{ old('description', $movie->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Текущая обложка</label>
            @if($movie->title_image)
                <div style="margin-bottom:12px">
                    <img
                        src="{{ asset('storage/' . $movie->title_image) }}"
                        alt="{{ $movie->name }}"
                        style="height:120px;border-radius:2px;object-fit:cover"
                    >
                </div>
            @endif
            <label class="form-label">Заменить обложку (необязательно)</label>
            <input
                type="file"
                name="title_image"
                class="form-input"
                accept="image/png,image/jpeg"
                style="padding:8px"
            >
        </div>

        <div style="display:flex;gap:12px;align-items:center">
            <button type="submit" class="btn btn-red">Сохранить</button>
            <a href="{{ route('admin_movies') }}" class="btn btn-ghost">Отмена</a>
        </div>
    </form>
</div>
@endsection
