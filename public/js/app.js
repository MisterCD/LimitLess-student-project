// ── NOTIFICATION ──────────────────────────────────────────────
function showNotif(msg) {
    const n = document.getElementById('notif');
    if (!n) return;
    n.textContent = msg;
    n.classList.add('show');
    clearTimeout(n._t);
    n._t = setTimeout(() => n.classList.remove('show'), 3000);
}

// ── GENRE / FILTER CHIPS ──────────────────────────────────────
document.querySelectorAll('.genre-chip').forEach(chip => {
    chip.addEventListener('click', () => {
        chip.closest('.genres-row')
            .querySelectorAll('.genre-chip')
            .forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
    });
});

document.querySelectorAll('.filter-option').forEach(opt => {
    opt.addEventListener('click', () => {
        opt.querySelector('.filter-check')?.classList.toggle('checked');
    });
});

// ── STAR RATING INPUT ─────────────────────────────────────────
let selectedStars = 3;
document.querySelectorAll('.star-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        selectedStars = parseInt(btn.dataset.val);
        document.querySelectorAll('.star-btn').forEach(b => {
            b.classList.toggle('active', parseInt(b.dataset.val) <= selectedStars);
        });
        const hiddenInput = document.getElementById('stars-value');
        if (hiddenInput) hiddenInput.value = selectedStars;
    });
});

// ── SEAT MAP ──────────────────────────────────────────────────
let selectedSeats = [];

function openBooking(el, time) {
    document.querySelectorAll('.session-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selected-time').textContent = time;
    const wrap = document.getElementById('seat-map-wrap');
    if (!wrap) return;
    wrap.style.display = 'block';

    const sessionInput = document.getElementById('session-id-input');
    if (sessionInput) sessionInput.value = el.dataset.sessionId || '';

    renderSeats();
    wrap.scrollIntoView({ behavior: 'smooth' });
}

function renderSeats() {
    const rows = 10, cols = 12;
    const taken = new Set([3,7,15,22,33,44,55,67,78,88,90,101,112,5,18,29]);
    const vip   = new Set([1,2,3,4,5,6,7,8,9,10,11,12]);
    selectedSeats = [];
    updateBookBtn();

    let html = '';
    for (let r = 0; r < rows; r++) {
        html += `<div class="seat-row"><div class="seat-row-label">${String.fromCharCode(65+r)}</div>`;
        for (let c = 0; c < cols; c++) {
            const idx = r * cols + c;
            const cls = taken.has(idx) ? 'seat-taken' : vip.has(idx) ? 'seat-vip' : 'seat-free';
            if (c === 5) html += '<div style="width:16px"></div>';
            html += `<div class="seat ${cls}" data-idx="${idx}" onclick="toggleSeat(this,${idx})"></div>`;
        }
        html += '</div>';
    }
    document.getElementById('seats-grid').innerHTML = html;
}

function toggleSeat(el, idx) {
    if (el.classList.contains('seat-taken')) return;
    if (el.classList.contains('seat-selected')) {
        el.classList.remove('seat-selected');
        el.classList.add(idx < 12 ? 'seat-vip' : 'seat-free');
        selectedSeats = selectedSeats.filter(s => s !== idx);
    } else {
        el.classList.remove('seat-free', 'seat-vip');
        el.classList.add('seat-selected');
        selectedSeats.push(idx);
    }
    updateBookBtn();
}

function updateBookBtn() {
    const btn = document.getElementById('book-btn');
    if (!btn) return;
    btn.style.display = selectedSeats.length ? 'flex' : 'none';
    btn.textContent = `Забронировать ${selectedSeats.length} ${seatWord(selectedSeats.length)}`;
}

function seatWord(n) {
    if (n === 1) return 'место';
    if (n >= 2 && n <= 4) return 'места';
    return 'мест';
}
