@extends('layouts.admin')

@section('title', 'Фильмы')

@section('content')
<div class="admin-page-title">Управление фильмами</div>

<div style="margin-bottom:20px">
    <a href="{{ route('createMoviePage') }}" class="btn btn-red" style="font-size:11px">+ Добавить фильм</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Фильм</th>
            <th>Жанр</th>
            <th>Год</th>
            <th>Режиссёр</th>
            <th>Рейтинг</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($movies as $movie)
            <tr>
                <td style="font-weight:500">{{ $movie->name }}</td>
                <td style="color:var(--text2)">{{ $movie->genre_name ?? '—' }}</td>
                <td style="color:var(--text2)">{{ $movie->year }}</td>
                <td style="color:var(--text2)">{{ $movie->author }}</td>
                <td>
                    <span style="color:var(--gold)">
                        @for($i = 0; $i < $movie->stars; $i++)★@endfor
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('changeMoviePage', ['id' => $movie->id]) }}" class="action-btn action-btn-red">
                            Изменить
                        </a>
                        <form method="POST" action="{{ route('deleteMovie') }}" style="display:inline"
                              onsubmit="return confirm('Удалить фильм «{{ $movie->name }}»?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $movie->id }}">
                            <button type="submit" class="action-btn action-btn-red">Удалить</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;color:var(--text3);padding:32px">
                    Нет фильмов. <a href="{{ route('createMoviePage') }}" style="color:var(--text)">Добавить первый →</a>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- PAGINATION --}}
@if($movies->hasPages())
    <div class="pagination">
        @if(!$movies->onFirstPage())
            <a href="{{ $movies->previousPageUrl() }}" class="page-btn">←</a>
        @endif
        @foreach($movies->getUrlRange(1, $movies->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-btn {{ $page == $movies->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($movies->hasMorePages())
            <a href="{{ $movies->nextPageUrl() }}" class="page-btn">→</a>
        @endif
    </div>
@endif
@endsection
