@extends('layouts.app')

@section('title', 'Фильмы')

@section('content')
<div style="padding-top:64px">
    <div class="catalog-layout">

        {{-- SIDEBAR FILTERS --}}
        <div class="catalog-sidebar">
            <div style="padding-top:20px">
                <div class="filter-title">Жанр</div>
                <div class="filter-option"><div class="filter-check checked"></div>Все жанры</div>
                <div class="filter-option"><div class="filter-check"></div>Боевик</div>
                <div class="filter-option"><div class="filter-check"></div>Драма</div>
                <div class="filter-option"><div class="filter-check"></div>Комедия</div>
                <div class="filter-option"><div class="filter-check"></div>Триллер</div>
                <div class="filter-option"><div class="filter-check"></div>Фантастика</div>
                <div class="filter-option"><div class="filter-check"></div>Ужасы</div>
                <div class="filter-option"><div class="filter-check"></div>Анимация</div>

                <div class="filter-title">Год</div>
                <div class="filter-option"><div class="filter-check checked"></div>Все годы</div>
                <div class="filter-option"><div class="filter-check"></div>2026</div>
                <div class="filter-option"><div class="filter-check"></div>2025</div>
                <div class="filter-option"><div class="filter-check"></div>2024</div>

                <div class="filter-title">Рейтинг</div>
                <div class="filter-option"><div class="filter-check checked"></div>Любой</div>
                <div class="filter-option"><div class="filter-check"></div>4+ звезды</div>
                <div class="filter-option"><div class="filter-check"></div>5 звезд</div>
            </div>
        </div>

        {{-- CATALOG GRID --}}
        <div class="catalog-main">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px">
                <div class="section-title" style="font-size:36px">Все фильмы</div>
                <input
                    class="form-input"
                    placeholder="Поиск..."
                    style="width:200px;padding:8px 14px;font-size:13px"
                    id="movie-search"
                >
            </div>

            <div class="movies-grid" id="movies-grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr))">
                @foreach($movies as $movie)
                    @include('components.movie-card', ['movie' => $movie])
                @endforeach
            </div>

            {{-- PAGINATION --}}
            @if($movies->hasPages())
                <div class="pagination">
                    {{-- Previous --}}
                    @if($movies->onFirstPage())
                        <div class="page-btn" style="opacity:.3">←</div>
                    @else
                        <a href="{{ $movies->previousPageUrl() }}" class="page-btn">←</a>
                    @endif

                    {{-- Pages --}}
                    @foreach($movies->getUrlRange(1, $movies->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="page-btn {{ $page == $movies->currentPage() ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Next --}}
                    @if($movies->hasMorePages())
                        <a href="{{ $movies->nextPageUrl() }}" class="page-btn">→</a>
                    @else
                        <div class="page-btn" style="opacity:.3">→</div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('movie-search').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#movies-grid .movie-card').forEach(card => {
        const name = card.querySelector('.movie-card-name')?.textContent.toLowerCase() ?? '';
        card.style.display = name.includes(q) ? '' : 'none';
    });
});
</script>
@endpush
