@extends('layouts.admin')

@section('title', 'Изменить зал')

@section('content')
<div class="admin-page-title">Изменить зал</div>

@if ($errors->any())
    <div class="alert alert-error" style="max-width:560px">{{ $errors->first() }}</div>
@endif

<div class="admin-form">
    <form method="POST" action="{{ route('changeRoom') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $room->id }}">

        <div class="form-group">
            <label class="form-label">Название зала</label>
            <input
                type="text"
                name="name"
                class="form-input"
                value="{{ old('name', $room->name) }}"
                minlength="6" maxlength="30"
                required
            >
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
                <label class="form-label">Всего мест</label>
                <input
                    type="number"
                    name="plases"
                    class="form-input"
                    value="{{ old('plases', $room->plases) }}"
                    min="1"
                    required
                >
            </div>
            <div class="form-group">
                <label class="form-label">Мест в ряду</label>
                <input
                    type="number"
                    name="row_plases"
                    class="form-input"
                    value="{{ old('row_plases', $room->row_plases) }}"
                    min="1"
                    required
                >
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Тип зала</label>
            <select name="type" class="form-input" required>
                <option value="0" {{ $room->type == 0 ? 'selected' : '' }}>Стандарт</option>
                <option value="1" {{ $room->type == 1 ? 'selected' : '' }}>Dolby Atmos</option>
                <option value="2" {{ $room->type == 2 ? 'selected' : '' }}>VIP</option>
                <option value="3" {{ $room->type == 3 ? 'selected' : '' }}>IMAX</option>
            </select>
        </div>

        <div style="display:flex;gap:12px">
            <button type="submit" class="btn btn-red">Сохранить</button>
            <a href="{{ route('admin_rooms') }}" class="btn btn-ghost">Отмена</a>
        </div>
    </form>
</div>
@endsection
