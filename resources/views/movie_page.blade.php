@extends('layouts.app')

@section('title', $movie->name)

@section('content')
<div style="padding-top:64px">

    {{-- MOVIE HERO --}}
    <div class="movie-hero">
        <div>
            <div class="movie-poster">
                @if($movie->title_image)
                    <img src="{{ asset('storage/' . $movie->title_image) }}" alt="{{ $movie->name }}">
                @else
                    <div class="movie-poster-ph">{{ Str::upper(Str::limit($movie->name, 4)) }}</div>
                @endif
            </div>
        </div>

        <div>
            <div class="movie-eyebrow">{{ $movie->genre->name ?? 'Кино' }}</div>
            <h1 class="movie-title">{{ $movie->name }}</h1>

            <div class="movie-badges">
                <div class="badge">{{ $movie->year }}</div>
                <div class="badge badge-red">
                    ★&nbsp;{{ number_format($movie->stars, 1) }}
                </div>
                <div class="badge">Реж. {{ $movie->author }}</div>
            </div>

            <p class="movie-desc">{{ $movie->description }}</p>

            <div class="movie-meta-row">
                <div class="meta-item">
                    <div class="meta-label">Режиссёр</div>
                    <div class="meta-value">{{ $movie->author }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Год</div>
                    <div class="meta-value">{{ $movie->year }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Рейтинг</div>
                    <div class="meta-value">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $movie->stars)
                                <span style="color:var(--gold)">★</span>
                            @else
                                <span style="color:var(--text3)">★</span>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

            {{-- ACTORS --}}
            @if($movie->actors && $movie->actors->count())
                <div class="movie-badges" style="gap:6px">
                    @foreach($movie->actors as $actor)
                        <div class="badge">{{ $actor->name }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- SESSIONS --}}
    <div class="sessions-section">
        <div class="sessions-title">Сеансы</div>

        <div class="genres-row" id="sessions-dates">
            <div class="genre-chip active">Сегодня</div>
            <div class="genre-chip">Завтра</div>
            <div class="genre-chip">{{ now()->addDays(2)->format('j M') }}</div>
            <div class="genre-chip">{{ now()->addDays(3)->format('j M') }}</div>
        </div>

        <div class="sessions-grid" id="sessions-grid">
            @forelse($sessions ?? [] as $session)
                <div
                    class="session-card"
                    data-session-id="{{ $session->id }}"
                    onclick="openBooking(this, '{{ \Carbon\Carbon::parse($session->time)->format('H:i') }}')"
                >
                    <div class="session-time">{{ \Carbon\Carbon::parse($session->time)->format('H:i') }}</div>
                    <div class="session-room">{{ $session->room->name ?? 'Зал' }}</div>
                    <div class="session-seats">Мест свободно: {{ $session->freeSeats ?? '—' }}</div>
                    <div class="session-price">{{ number_format($session->price ?? 450, 0, '', ' ') }} ₽</div>
                </div>
            @empty
                {{-- Demo sessions for layout --}}
                <div class="session-card selected" data-session-id="1" onclick="openBooking(this,'14:30')">
                    <div class="session-time">14:30</div>
                    <div class="session-room">Зал 1 — Стандарт</div>
                    <div class="session-seats">84 / 120 мест свободно</div>
                    <div class="session-price">450 ₽</div>
                </div>
                <div class="session-card" data-session-id="2" onclick="openBooking(this,'17:00')">
                    <div class="session-time">17:00</div>
                    <div class="session-room">Зал 3 — Dolby</div>
                    <div class="session-seats">56 / 100 мест свободно</div>
                    <div class="session-price">650 ₽</div>
                </div>
                <div class="session-card" data-session-id="3" onclick="openBooking(this,'19:45')">
                    <div class="session-time">19:45</div>
                    <div class="session-room">Зал 5 — VIP</div>
                    <div class="session-seats">12 / 30 мест свободно</div>
                    <div class="session-price">1 200 ₽</div>
                </div>
                <div class="session-card" data-session-id="4" onclick="openBooking(this,'22:15')">
                    <div class="session-time">22:15</div>
                    <div class="session-room">Зал 2 — Стандарт</div>
                    <div class="session-seats">100 / 120 мест свободно</div>
                    <div class="session-price">450 ₽</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- SEAT MAP --}}
    <div class="seat-map-wrap" id="seat-map-wrap" style="display:none">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
            <div style="font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:1px">
                Выбор места — <span id="selected-time">—</span>
            </div>

            @auth
                <form method="POST" action="{{ route('createBooking') }}" id="booking-form">
                    @csrf
                    <input type="hidden" name="session_id" id="session-id-input" value="">
                    <input type="hidden" name="plase_id"   id="seat-id-input"    value="">
                    <button
                        type="submit"
                        class="btn btn-red"
                        id="book-btn"
                        style="display:none"
                        onclick="return submitBooking()"
                    >Забронировать</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost" style="font-size:11px">
                    Войдите для бронирования
                </a>
            @endauth
        </div>

        <div class="screen-line">
            <div class="screen-bar"></div>
            <div class="screen-label">Экран</div>
        </div>

        <div class="seats-grid" id="seats-grid"></div>

        <div class="seat-legend">
            <div class="legend-item">
                <div class="legend-swatch" style="background:var(--bg4);border-color:var(--border2)"></div>Свободно
            </div>
            <div class="legend-item">
                <div class="legend-swatch" style="background:var(--red);border-color:var(--red-dark)"></div>Выбрано
            </div>
            <div class="legend-item">
                <div class="legend-swatch" style="background:var(--bg3);border-color:var(--border);opacity:.4"></div>Занято
            </div>
            <div class="legend-item">
                <div class="legend-swatch" style="background:rgba(201,168,76,0.2);border-color:var(--gold)"></div>VIP
            </div>
        </div>
    </div>

    {{-- REVIEWS --}}
    <section style="padding:40px">
        <div class="section-title" style="font-size:36px;margin-bottom:24px">Отзывы</div>

        {{-- REVIEW FORM --}}
        @auth
            <div class="review-form">
                <div style="font-size:14px;font-weight:500;margin-bottom:16px">Оставить отзыв</div>
                <form method="POST" action="{{ route('createRewiew') }}">
                    @csrf
                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                    <input type="hidden" name="stars" id="stars-value" value="3">

                    <div class="stars-input">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn {{ $i <= 3 ? 'active' : '' }}" data-val="{{ $i }}">★</button>
                        @endfor
                    </div>

                    <textarea
                        name="description"
                        class="form-input"
                        rows="3"
                        maxlength="200"
                        placeholder="Ваш отзыв (до 200 символов)..."
                        style="resize:none;margin-bottom:12px"
                        required
                    ></textarea>

                    <button type="submit" class="btn btn-red">Отправить</button>
                    <span style="font-size:12px;color:var(--text3);margin-left:12px">
                        Отзыв появится после модерации
                    </span>
                </form>
            </div>
        @else
            <div style="padding:20px;background:var(--bg2);border:1px solid var(--border);margin-bottom:2px;font-size:13px;color:var(--text2)">
                <a href="{{ route('login') }}" style="color:var(--text);border-bottom:1px solid var(--text3)">Войдите</a>, чтобы оставить отзыв.
            </div>
        @endauth

        {{-- REVIEWS LIST --}}
        <div class="reviews-list">
            @forelse($rewiews as $review)
                @if($review->status == 1)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-author">{{ $review->user->name ?? 'Аноним' }}</div>
                            <div style="display:flex;align-items:center;gap:12px">
                                <div class="movie-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->stars)
                                            <span style="color:var(--gold)">★</span>
                                        @else
                                            <span style="color:var(--text3)">★</span>
                                        @endif
                                    @endfor
                                </div>
                                @if(auth()->id() === $review->user_id)
                                    <form method="POST" action="{{ route('deleteRewiew') }}" style="display:inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $review->id }}">
                                        <button type="submit" class="action-btn action-btn-red" style="font-size:10px;padding:2px 8px">Удалить</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <p class="review-text">{{ $review->description }}</p>
                    </div>
                @endif
            @empty
                <div style="padding:32px;text-align:center;color:var(--text3);font-size:13px">
                    Пока нет отзывов. Будьте первым!
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
function submitBooking() {
    if (selectedSeats.length === 0) return false;
    document.getElementById('seat-id-input').value = selectedSeats[0];
    return true;
}
</script>
@endpush
