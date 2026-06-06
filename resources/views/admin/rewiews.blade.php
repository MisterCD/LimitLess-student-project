@extends('layouts.admin')

@section('title', 'Отзывы')

@section('content')
<div class="admin-page-title">Модерация отзывов</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Автор</th>
            <th>Фильм</th>
            <th>Отзыв</th>
            <th>Оценка</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rewiews as $review)
            <tr>
                <td>{{ $review->user->name ?? 'Аноним' }}</td>
                <td style="color:var(--text2)">{{ $review->movie->name ?? '—' }}</td>
                <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--text2)">
                    {{ $review->description }}
                </td>
                <td style="color:var(--gold)">
                    @for($i = 0; $i < $review->stars; $i++)★@endfor
                </td>
                <td>
                    @if($review->status == 0)
                        <span class="status-badge status-pending">Ожидает</span>
                    @elseif($review->status == 1)
                        <span class="status-badge status-approved">Одобрен</span>
                    @else
                        <span class="status-badge status-rejected">Отклонён</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap">
                        @if($review->status != 1)
                            <form method="POST" action="{{ route('allowRewiew') }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $review->id }}">
                                <button type="submit" class="action-btn action-btn-green">Одобрить</button>
                            </form>
                        @endif
                        @if($review->status == 1)
                            <form method="POST" action="{{ route('cancleRewiew') }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $review->id }}">
                                <button type="submit" class="action-btn action-btn-red">Отклонить</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('deleteRewiew') }}" style="display:inline"
                              onsubmit="return confirm('Удалить отзыв?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $review->id }}">
                            <button type="submit" class="action-btn action-btn-red">Удалить</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;color:var(--text3);padding:32px">
                    Нет отзывов на модерации
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($rewiews->hasPages())
    <div class="pagination">
        @if(!$rewiews->onFirstPage())
            <a href="{{ $rewiews->previousPageUrl() }}" class="page-btn">←</a>
        @endif
        @foreach($rewiews->getUrlRange(1, $rewiews->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-btn {{ $page == $rewiews->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($rewiews->hasMorePages())
            <a href="{{ $rewiews->nextPageUrl() }}" class="page-btn">→</a>
        @endif
    </div>
@endif
@endsection
