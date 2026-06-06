@extends('layouts.app')

@section('title', 'Бронирование — ' . ($session->movie->name ?? 'Сеанс'))

@section('content')
<div style="padding-top:64px">

@php
    $movie   = $session->movie;
    $room    = $session->room;
    $types   = ['Стандарт', 'Dolby Atmos', 'VIP', 'IMAX'];
    $roomType = $types[$room->type ?? 0] ?? 'Стандарт';
    $totalSeats = $room->plases    ?? 120;
    $rowCols    = $room->row_plases ?? 12;
    $totalRows  = max(1, intval(ceil($totalSeats / $rowCols)));

    // Занятые места (plase_id из существующих бронирований)
    $takenIds = $session->bookings->pluck('plase_id')->toArray();
    // VIP — первый ряд
    $vipIds = range(0, $rowCols - 1);
@endphp

 
<div style="background:var(--bg2);border-bottom:1px solid var(--border);padding:20px 40px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
    <div style="display:flex;align-items:center;gap:24px">
         
        <a href="{{ route('movie_page', ['id' => $movie->id]) }}" style="color:var(--text2);font-size:12px;letter-spacing:1px;display:flex;align-items:center;gap:6px;transition:color .2s" onmouseover="this.style.color='var(--text)'" onmouseout="this.style.color='var(--text2)'">
            ← Назад
        </a>

        <div style="width:1px;height:28px;background:var(--border)"></div>

         
        <div>
            <div style="font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:1px;line-height:1">
                {{ $movie->name ?? 'Фильм' }}
            </div>
            <div style="font-size:11px;color:var(--text2);margin-top:3px;display:flex;gap:10px">
                <span>{{ \Carbon\Carbon::parse($session->date)->translatedFormat('j F Y') }}</span>
                <span style="color:var(--text3)">·</span>
                <span>{{ \Carbon\Carbon::parse($session->time)->format('H:i') }}</span>
                <span style="color:var(--text3)">·</span>
                <span>{{ $room->name ?? 'Зал' }}</span>
                <span style="color:var(--text3)">·</span>
                <span>{{ $roomType }}</span>
            </div>
        </div>
    </div>

     
    <div style="display:flex;align-items:center;gap:8px;font-size:11px;letter-spacing:1px;text-transform:uppercase">
        <div style="display:flex;align-items:center;gap:6px;color:var(--red)">
            <div style="width:22px;height:22px;border-radius:50%;background:var(--red);color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600">1</div>
            Выбор места
        </div>
        <div style="width:32px;height:1px;background:var(--border2)"></div>
        <div style="display:flex;align-items:center;gap:6px;color:var(--text3)" id="step2-indicator">
            <div style="width:22px;height:22px;border-radius:50%;border:1px solid var(--border2);color:var(--text3);display:flex;align-items:center;justify-content:center;font-size:11px">2</div>
            Подтверждение
        </div>
    </div>
</div>

 
<div style="display:grid;grid-template-columns:1fr 320px;min-height:calc(100vh - 130px)">

     
    <div style="padding:40px;border-right:1px solid var(--border)" id="step-seats">

        <div style="margin-bottom:28px">
            <div style="font-family:'Bebas Neue',sans-serif;font-size:32px;letter-spacing:1px;margin-bottom:6px">Выберите место</div>
            <div style="font-size:13px;color:var(--text2)">Нажмите на свободное место, чтобы выбрать его</div>
        </div>

         
        <div style="text-align:center;margin-bottom:36px">
            <div style="display:inline-block;width:55%;height:5px;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.18),transparent);border-radius:3px"></div>
            <div style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--text3);margin-top:10px">Экран</div>
        </div>

         
        <div id="seats-container" style="display:flex;flex-direction:column;gap:7px;align-items:center">
            @for($r = 0; $r < $totalRows; $r++)
                <div style="display:flex;gap:5px;align-items:center">
                    <div style="font-size:10px;color:var(--text3);width:18px;text-align:center;font-weight:500">
                        {{ chr(65 + $r) }}
                    </div>

                    @for($c = 0; $c < $rowCols; $c++)
                        @php
                            $idx    = $r * $rowCols + $c;
                            $taken  = in_array($idx, $takenIds);
                            $isVip  = in_array($idx, $vipIds);
                            $cls    = $taken ? 'seat-taken' : ($isVip ? 'seat-vip' : 'seat-free');
                        @endphp

                         
                        @if($rowCols > 8 && $c === intval($rowCols / 2))
                            <div style="width:14px"></div>
                        @endif

                        <div
                            class="seat {{ $cls }}"
                            data-idx="{{ $idx }}"
                            data-row="{{ $r }}"
                            data-col="{{ $c }}"
                            data-vip="{{ $isVip ? '1' : '0' }}"
                            @if(!$taken)
                                onclick="toggleSeat(this, {{ $idx }})"
                                title="{{ $taken ? 'Занято' : ($isVip ? 'VIP — Ряд ' . chr(65+$r) . ', Место ' . ($c+1) : 'Ряд ' . chr(65+$r) . ', Место ' . ($c+1)) }}"
                            @else
                                title="Занято"
                            @endif
                            style="width:26px;height:22px;border-radius:3px 3px 0 0;cursor:{{ $taken ? 'not-allowed' : 'pointer' }};border:1px solid transparent;transition:all .12s"
                        ></div>
                    @endfor

                    <div style="font-size:10px;color:var(--text3);width:18px;text-align:center;font-weight:500">
                        {{ chr(65 + $r) }}
                    </div>
                </div>
            @endfor
        </div>

         
        <div style="display:flex;gap:28px;margin-top:32px;justify-content:center;flex-wrap:wrap">
            <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--text2)">
                <div style="width:22px;height:18px;border-radius:3px 3px 0 0;background:var(--bg4);border:1px solid var(--border2)"></div>
                Свободно
            </div>
            <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--text2)">
                <div style="width:22px;height:18px;border-radius:3px 3px 0 0;background:rgba(201,168,76,0.2);border:1px solid var(--gold)"></div>
                VIP (ряд А)
            </div>
            <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--text2)">
                <div style="width:22px;height:18px;border-radius:3px 3px 0 0;background:var(--red);border:1px solid var(--red-dark)"></div>
                Выбрано
            </div>
            <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--text2)">
                <div style="width:22px;height:18px;border-radius:3px 3px 0 0;background:var(--bg3);border:1px solid var(--border);opacity:.4"></div>
                Занято
            </div>
        </div>

         
        <div style="display:flex;gap:24px;margin-top:20px;justify-content:center">
            @php $freeCount = $totalSeats - count($takenIds); @endphp
            <div style="text-align:center">
                <div style="font-family:'Bebas Neue',sans-serif;font-size:28px;color:var(--text)">{{ max(0, $freeCount) }}</div>
                <div style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text3)">Свободно</div>
            </div>
            <div style="width:1px;background:var(--border)"></div>
            <div style="text-align:center">
                <div style="font-family:'Bebas Neue',sans-serif;font-size:28px;color:var(--text3)">{{ count($takenIds) }}</div>
                <div style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text3)">Занято</div>
            </div>
            <div style="width:1px;background:var(--border)"></div>
            <div style="text-align:center">
                <div style="font-family:'Bebas Neue',sans-serif;font-size:28px;color:var(--text)">{{ $totalSeats }}</div>
                <div style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text3)">Всего</div>
            </div>
        </div>
    </div>

     
    <div style="padding:32px 28px;background:var(--bg2);display:flex;flex-direction:column;gap:0">

         
        <div style="display:flex;gap:14px;margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid var(--border)">
            <div style="width:56px;height:80px;border-radius:2px;overflow:hidden;background:var(--bg3);flex-shrink:0">
                @if($movie->title_image ?? false)
                    <img src="{{ asset('storage/' . $movie->title_image) }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:14px;color:var(--text3)">
                        {{ Str::upper(Str::limit($movie->name ?? '', 3)) }}
                    </div>
                @endif
            </div>
            <div>
                <div style="font-size:14px;font-weight:500;line-height:1.3;margin-bottom:6px">{{ $movie->name ?? '—' }}</div>
                <div style="font-size:11px;color:var(--text2)">{{ \Carbon\Carbon::parse($session->date)->translatedFormat('j F') }}</div>
                <div style="font-size:11px;color:var(--text2)">{{ \Carbon\Carbon::parse($session->time)->format('H:i') }} · {{ $room->name ?? 'Зал' }}</div>
                <div style="font-size:11px;color:var(--text3);margin-top:2px">{{ $roomType }}</div>
            </div>
        </div>

         
        <div style="flex:1">
            <div style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text3);margin-bottom:14px;font-weight:500">
                Выбранные места
            </div>

            <div id="selected-list" style="display:flex;flex-direction:column;gap:6px;min-height:60px">
                <div id="no-seat-msg" style="font-size:13px;color:var(--text3);padding:12px 0">
                    Выберите место на схеме
                </div>
            </div>
        </div>

         
        <div style="border-top:1px solid var(--border);padding-top:20px;margin-top:20px">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
                <div style="font-size:13px;color:var(--text2)">Итого</div>
                <div style="font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:1px;color:var(--gold)" id="total-price">0 ₽</div>
            </div>

            @auth
                <form method="POST" action="{{ route('createBooking') }}" id="booking-form">
                    @csrf
                    <input type="hidden" name="session_id" value="{{ $session->id }}">
                    <input type="hidden" name="plase_id"   id="plase-id-input" value="">

                    @if($errors->any())
                        <div class="alert alert-error" style="font-size:12px;margin-bottom:14px">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <button
                        type="submit"
                        id="confirm-btn"
                        class="btn btn-red"
                        style="width:100%;justify-content:center;padding:14px;font-size:13px;opacity:.4;pointer-events:none"
                        disabled
                    >
                        Подтвердить бронирование
                    </button>
                </form>

                <div style="font-size:11px;color:var(--text3);text-align:center;margin-top:10px;line-height:1.6">
                    После подтверждения билет<br>появится в вашем профиле
                </div>
            @else
                <a
                    href="{{ route('login') }}"
                    class="btn btn-ghost"
                    style="width:100%;justify-content:center;padding:14px;font-size:12px"
                >
                    Войдите для бронирования
                </a>
            @endauth
        </div>
    </div>

</div>
</div>
@endsection

@push('scripts')
<script>
// ── CONFIG ──────────────────────────────────────────────────────────────────
const ROW_COLS  = {{ $rowCols }};
const IS_VIP    = new Set({{ json_encode($vipIds) }});
const PRICE_STD = 450;   // ₽ — replace with real price from model if available
const PRICE_VIP = 850;

// ── STATE ────────────────────────────────────────────────────────────────────
let selectedSeat = null;   // only one seat at a time

// ── SEAT TOGGLE ──────────────────────────────────────────────────────────────
function toggleSeat(el, idx) {
    if (el.classList.contains('seat-taken')) return;

    // Deselect previous
    if (selectedSeat !== null && selectedSeat !== idx) {
        const prev = document.querySelector(`.seat[data-idx="${selectedSeat}"]`);
        if (prev) {
            const wasVip = prev.dataset.vip === '1';
            prev.classList.remove('seat-selected');
            prev.classList.add(wasVip ? 'seat-vip' : 'seat-free');
        }
    }

    if (selectedSeat === idx) {
        // Deselect current
        el.classList.remove('seat-selected');
        el.classList.add(el.dataset.vip === '1' ? 'seat-vip' : 'seat-free');
        selectedSeat = null;
    } else {
        el.classList.remove('seat-free', 'seat-vip');
        el.classList.add('seat-selected');
        selectedSeat = idx;
    }

    updateSummary();
}

// ── UPDATE RIGHT PANEL ────────────────────────────────────────────────────────
function updateSummary() {
    const list    = document.getElementById('selected-list');
    const noMsg   = document.getElementById('no-seat-msg');
    const btn     = document.getElementById('confirm-btn');
    const priceEl = document.getElementById('total-price');
    const input   = document.getElementById('plase-id-input');

    if (selectedSeat === null) {
        noMsg.style.display = 'block';
        // Remove seat rows
        list.querySelectorAll('.seat-row-item').forEach(e => e.remove());
        if (btn) { btn.disabled = true; btn.style.opacity = '.4'; btn.style.pointerEvents = 'none'; }
        if (priceEl) priceEl.textContent = '0 ₽';
        if (input)   input.value = '';
        return;
    }

    noMsg.style.display = 'none';
    list.querySelectorAll('.seat-row-item').forEach(e => e.remove());

    const idx    = selectedSeat;
    const row    = Math.floor(idx / ROW_COLS);
    const col    = idx % ROW_COLS;
    const isVip  = IS_VIP.has(idx);
    const price  = isVip ? PRICE_VIP : PRICE_STD;
    const rowLbl = String.fromCharCode(65 + row);
    const colLbl = col + 1;

    const item = document.createElement('div');
    item.className = 'seat-row-item';
    item.style.cssText = 'display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:var(--bg3);border-radius:2px;border:1px solid var(--border2)';
    item.innerHTML = `
        <div>
            <div style="font-size:13px;font-weight:500">Ряд ${rowLbl}, Место ${colLbl}</div>
            <div style="font-size:11px;color:${isVip ? 'var(--gold)' : 'var(--text3)'};margin-top:2px">
                ${isVip ? '★ VIP' : 'Стандарт'}
            </div>
        </div>
        <div style="font-size:14px;font-weight:500;color:var(--gold)">${price} ₽</div>
    `;
    list.appendChild(item);

    if (priceEl) priceEl.textContent = price.toLocaleString('ru-RU') + ' ₽';
    if (input)   input.value = idx;
    if (btn)     { btn.disabled = false; btn.style.opacity = '1'; btn.style.pointerEvents = 'auto'; }

    // Highlight step 2
    const s2 = document.getElementById('step2-indicator');
    if (s2) {
        s2.style.color = 'var(--text)';
        s2.querySelector('div').style.background = 'var(--bg3)';
        s2.querySelector('div').style.borderColor = 'var(--border2)';
        s2.querySelector('div').style.color = 'var(--text)';
    }
}

// ── APPLY CSS TO SEATS (inline style fallback for blade-rendered seats) ─────
document.querySelectorAll('.seat').forEach(el => {
    if (el.classList.contains('seat-free')) {
        el.style.background    = 'var(--bg4)';
        el.style.borderColor   = 'var(--border2)';
    } else if (el.classList.contains('seat-vip')) {
        el.style.background    = 'rgba(201,168,76,0.2)';
        el.style.borderColor   = 'var(--gold)';
    } else if (el.classList.contains('seat-taken')) {
        el.style.background    = 'var(--bg3)';
        el.style.borderColor   = 'var(--border)';
        el.style.opacity       = '0.4';
    }

    el.addEventListener('mouseover', function() {
        if (this.classList.contains('seat-taken') || this.classList.contains('seat-selected')) return;
        this.style.background  = 'rgba(232,37,26,0.35)';
        this.style.borderColor = 'var(--red)';
    });
    el.addEventListener('mouseout', function() {
        if (this.classList.contains('seat-selected')) return;
        if (this.classList.contains('seat-free')) {
            this.style.background  = 'var(--bg4)';
            this.style.borderColor = 'var(--border2)';
        } else if (this.classList.contains('seat-vip')) {
            this.style.background  = 'rgba(201,168,76,0.2)';
            this.style.borderColor = 'var(--gold)';
        }
    });
});

// Highlight seat-selected on load (after errors redirect back)
document.querySelectorAll('.seat-selected').forEach(el => {
    el.style.background  = 'var(--red)';
    el.style.borderColor = 'var(--red-dark)';
});
</script>
@endpush
