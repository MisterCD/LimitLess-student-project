@extends('layouts.admin')

@section('title', 'Сеансы')

@section('content')
<div class="admin-page-title">Сеансы</div>

<div style="display:grid;grid-template-columns:400px 1fr;gap:2px;align-items:start">

     
    <div class="admin-form">
        <div style="font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:1px;margin-bottom:20px">
            Добавить сеанс
        </div>

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('createSession') }}">
            @csrf

             
            <div class="form-group">
                <label class="form-label">Фильм</label>
                <select name="movie_id" class="form-input" required id="movie-select">
                    <option value="" disabled selected>Выберите фильм</option>
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                            {{ $movie->name }} ({{ $movie->year }})
                        </option>
                    @endforeach
                </select>
            </div>

             
            <div class="form-group">
                <label class="form-label">Зал</label>
                <select name="rooms_id" class="form-input" required id="room-select">
                    <option value="" disabled selected>Выберите зал</option>
                    @foreach($rooms as $room)
                        @php
                            $types = ['Стандарт', 'Dolby Atmos', 'VIP', 'IMAX'];
                        @endphp
                        <option value="{{ $room->id }}" {{ old('rooms_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->name }} — {{ $types[$room->type] ?? 'Стандарт' }} ({{ $room->plases }} мест)
                        </option>
                    @endforeach
                </select>
            </div>

             
            <div class="form-group">
                <label class="form-label">Дата</label>
                <input
                    type="date"
                    name="date"
                    class="form-input"
                    value="{{ old('date', date('Y-m-d')) }}"
                    min="{{ date('Y-m-d') }}"
                    required
                >
            </div>

             
            <div class="form-group">
                <label class="form-label">Время начала</label>
                <input
                    type="time"
                    name="time"
                    class="form-input"
                    value="{{ old('time', '10:00') }}"
                    required
                >
            </div>

            <button type="submit" class="btn btn-red" style="width:100%;justify-content:center;padding:12px">
                Создать сеанс
            </button>
        </form>
    </div>

     
    <div style="background:var(--bg2);padding:32px;border:1px solid var(--border)">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
            <div style="font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:1px">
                Все сеансы
            </div>

             
            <form method="GET" action="{{ route('createSessionPage') }}" style="display:flex;gap:8px;align-items:center">
                <input
                    type="date"
                    name="filter_date"
                    class="form-input"
                    value="{{ request('filter_date', date('Y-m-d')) }}"
                    style="padding:6px 12px;font-size:12px;width:160px"
                >
                <button type="submit" class="btn btn-ghost" style="font-size:11px;padding:6px 14px">Фильтр</button>
                @if(request('filter_date'))
                    <a href="{{ route('createSessionPage') }}" class="btn btn-ghost" style="font-size:11px;padding:6px 14px">Сброс</a>
                @endif
            </form>
        </div>

        @forelse($sessions as $session)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid var(--border)">
                <div style="display:flex;align-items:center;gap:20px">

                     
                    <div style="font-family:'Bebas Neue',sans-serif;font-size:28px;color:var(--text);letter-spacing:1px;min-width:64px">
                        {{ \Carbon\Carbon::parse($session->time)->format('H:i') }}
                    </div>

                    <div>
                         
                        <div style="font-size:14px;font-weight:500">
                            {{ $session->movie_name ?? '—' }}
                        </div>
                         
                        <div style="font-size:11px;color:var(--text2);margin-top:3px;display:flex;gap:12px;align-items:center">
                            <span>{{ $session->room_name ?? 'Зал' }}</span>
                            <span style="color:var(--text3)">·</span>
                            <span>{{ \Carbon\Carbon::parse($session->date)->translatedFormat('j M Y') }}</span>
                        </div>
                    </div>
                </div>

                 
                <form
                    method="POST"
                    action="{{ route('deleteSession') }}"
                    onsubmit="return confirm('Удалить сеанс?')"
                >
                    @csrf
                    <input type="hidden" name="id" value="{{ $session->id }}">
                    <button type="submit" class="action-btn action-btn-red">Удалить</button>
                </form>
            </div>
        @empty
            <div style="color:var(--text3);font-size:13px;padding:24px 0;text-align:center">
                @if(request('filter_date'))
                    На {{ \Carbon\Carbon::parse(request('filter_date'))->translatedFormat('j F') }} сеансов нет
                @else
                    Сеансы ещё не добавлены
                @endif
            </div>
        @endforelse

         
        @if($sessions->hasPages())
            <div class="pagination" style="margin-top:20px">
                @if(!$sessions->onFirstPage())
                    <a href="{{ $sessions->previousPageUrl() }}" class="page-btn">←</a>
                @endif
                @foreach($sessions->getUrlRange(1, $sessions->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-btn {{ $page == $sessions->currentPage() ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach
                @if($sessions->hasMorePages())
                    <a href="{{ $sessions->nextPageUrl() }}" class="page-btn">→</a>
                @endif
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
// Подсвечиваем выбранный вариант в селектах после old()
document.querySelectorAll('select').forEach(sel => {
    const chosen = sel.querySelector('option[selected]');
    if (chosen) sel.value = chosen.value;
});
</script>
@endpush
