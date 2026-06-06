{{--
    Component: movie-card
    Variables: $movie (Movie model)
--}}
<div class="movie-card">
    <a href="{{ route('movie_page', ['id' => $movie->id]) }}" style="display:block">
        <div class="movie-card-poster">
            @if($movie->title_image)
                <img
                    src="{{ asset('storage/' . $movie->title_image) }}"
                    alt="{{ $movie->name }}"
                    class="movie-poster-img"
                >
            @else
                <div class="movie-poster-placeholder">
                    {{ Str::upper(Str::limit($movie->name, 8)) }}
                </div>
            @endif

            <div class="movie-card-overlay">
                <div>
                    <div style="font-size:13px;font-weight:500;color:#fff;margin-bottom:8px">{{ $movie->name }}</div>
                    <span class="overlay-btn">Купить билет</span>
                </div>
            </div>
        </div>

        <div class="movie-card-info">
            <div class="movie-card-name">{{ $movie->name }}</div>
            <div class="movie-card-meta">
                <span>{{ $movie->year }}</span>
                <span style="color:var(--gold)">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $movie->stars)★@else<span style="color:var(--text3)">★</span>@endif
                    @endfor
                </span>
            </div>
        </div>
    </a>
</div>
