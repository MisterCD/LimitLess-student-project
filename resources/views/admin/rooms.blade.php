@extends('layouts.admin')

@section('title', 'Залы')

@section('content')
<div class="admin-page-title">Залы</div>

 
<div class="admin-form" style="margin-bottom:40px">
    <div style="font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:1px;margin-bottom:20px">Добавить зал</div>

    @if ($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('addRoom') }}">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
                <label class="form-label">Название зала</label>
                <input type="text" name="name" class="form-input" placeholder="Зал 4" minlength="6" maxlength="30" required>
            </div>
            <div class="form-group">
                <label class="form-label">Тип зала</label>
                <select name="type" class="form-input" required>
                    <option value="0">Стандарт</option>
                    <option value="1">Dolby Atmos</option>
                    <option value="2">VIP</option>
                    <option value="3">IMAX</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Всего мест</label>
                <input type="number" name="plases" class="form-input" placeholder="120" min="1" required>
            </div>
            <div class="form-group">
                <label class="form-label">Мест в ряду</label>
                <input type="number" name="row_plases" class="form-input" placeholder="12" min="1" required>
            </div>
        </div>
        <button type="submit" class="btn btn-red">Создать зал</button>
    </form>
</div>

 
<table class="admin-table">
    <thead>
        <tr>
            <th>Название</th>
            <th>Всего мест</th>
            <th>Мест в ряду</th>
            <th>Тип</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rooms as $room)
            <tr>
                <td style="font-weight:500">{{ $room->name }}</td>
                <td style="color:var(--text2)">{{ $room->plases }}</td>
                <td style="color:var(--text2)">{{ $room->row_plases }}</td>
                <td>
                    @php
                        $types = ['Стандарт','Dolby Atmos','VIP','IMAX'];
                        $colors = ['status-approved','status-pending','status-approved','status-pending'];
                    @endphp
                    <span class="status-badge {{ $colors[$room->type] ?? 'status-approved' }}">
                        {{ $types[$room->type] ?? 'Стандарт' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('changeRoomPage', ['id' => $room->id]) }}" class="action-btn action-btn-red">
                            Изменить
                        </a>
                        <form method="POST" action="{{ route('deleteRoom') }}" style="display:inline"
                              onsubmit="return confirm('Удалить зал «{{ $room->name }}»?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $room->id }}">
                            <button type="submit" class="action-btn action-btn-red">Удалить</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center;color:var(--text3);padding:32px">Залы не добавлены</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($rooms->hasPages())
    <div class="pagination">
        @if(!$rooms->onFirstPage())
            <a href="{{ $rooms->previousPageUrl() }}" class="page-btn">←</a>
        @endif
        @foreach($rooms->getUrlRange(1, $rooms->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-btn {{ $page == $rooms->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($rooms->hasMorePages())
            <a href="{{ $rooms->nextPageUrl() }}" class="page-btn">→</a>
        @endif
    </div>
@endif
@endsection
