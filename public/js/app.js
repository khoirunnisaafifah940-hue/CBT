/* Diarify - peningkatan interaksi sisi klien.
 * Semua fitur bersifat progressive enhancement: tanpa JS, halaman tetap
 * berfungsi (validasi utama tetap dilakukan di server). */
(function () {
    'use strict';

    var BULAN = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    var ICON_EYE = '<svg class="i" viewBox="0 0 24 24" aria-hidden="true">' +
        '<path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>';
    var ICON_EYE_OFF = '<svg class="i" viewBox="0 0 24 24" aria-hidden="true">' +
        '<path d="M10.6 5.1A10 10 0 0 1 12 5c6.4 0 10 7 10 7a17 17 0 0 1-3.2 4M6.5 6.6C3.8 8.4 2 12 2 12s3.6 7 10 7c1.7 0 3.2-.4 4.5-1"/>' +
        '<path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/><path d="M3 3l18 18"/></svg>';

    /* "YYYY-MM-DD" -> Date lokal (hindari geseran zona waktu dari new Date(string)) */
    function parseYMD(s) {
        var p = s.split('-');
        return new Date(+p[0], +p[1] - 1, +p[2]);
    }

    function sameDay(a, b) {
        return a.getFullYear() === b.getFullYear() &&
               a.getMonth() === b.getMonth() &&
               a.getDate() === b.getDate();
    }

    /* ---------- 1. Kalender mingguan di beranda ---------- */
    function judulMinggu(first, last) {
        if (first.getMonth() === last.getMonth() && first.getFullYear() === last.getFullYear()) {
            return BULAN[first.getMonth()] + ' ' + first.getFullYear();
        }
        if (first.getFullYear() === last.getFullYear()) {
            return BULAN[first.getMonth()] + ' \u2013 ' + BULAN[last.getMonth()] + ' ' + first.getFullYear();
        }
        return BULAN[first.getMonth()] + ' ' + first.getFullYear() + ' \u2013 ' +
               BULAN[last.getMonth()] + ' ' + last.getFullYear();
    }

    function initCalendar() {
        var cal = document.querySelector('.cal');
        if (!cal) return;

        var cells = cal.querySelectorAll('.row .day');
        var title = cal.querySelector('.cal-title');
        if (cells.length !== 7 || !title) return;

        // Tanggal "hari ini" mengikuti server agar konsisten dengan data di kartu
        var base = cal.dataset.today ? parseYMD(cal.dataset.today) : new Date();
        var today = new Date(base.getFullYear(), base.getMonth(), base.getDate());
        var start = new Date(today);
        start.setDate(today.getDate() - today.getDay()); // minggu dimulai hari Minggu

        function render() {
            var last = new Date(start);
            for (var i = 0; i < 7; i++) {
                var d = new Date(start);
                d.setDate(start.getDate() + i);
                var isToday = sameDay(d, today);
                cells[i].textContent = d.getDate();
                cells[i].classList.toggle('on', isToday);
                if (isToday) cells[i].setAttribute('aria-current', 'date');
                else cells[i].removeAttribute('aria-current');
                last = d;
            }
            title.textContent = judulMinggu(start, last);
        }

        cal.addEventListener('click', function (e) {
            var btn = e.target.closest('.cal-nav');
            if (!btn) return;
            start.setDate(start.getDate() + 7 * parseInt(btn.dataset.dir, 10));
            render();
        });

        render();
    }

    /* ---------- 2. Tombol lihat/sembunyikan password ---------- */
    function initPasswordToggle() {
        var inputs = document.querySelectorAll('.input input[type="password"]');
        Array.prototype.forEach.call(inputs, function (input) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'eye';
            btn.setAttribute('aria-label', 'Tampilkan kata sandi');
            btn.setAttribute('aria-pressed', 'false');
            btn.innerHTML = ICON_EYE;

            btn.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.innerHTML = show ? ICON_EYE_OFF : ICON_EYE;
                btn.setAttribute('aria-pressed', String(show));
                btn.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
                input.focus();
            });

            input.parentNode.appendChild(btn);
        });
    }

    /* ---------- 3. Form: pesan validasi Indonesia + cegah submit ganda ---------- */
    function pesanValidasi(field) {
        var v = field.validity;
        if (v.valueMissing) return 'Kolom ini wajib diisi.';
        if (v.typeMismatch && field.type === 'email') return 'Format email tidak valid.';
        if (v.tooShort) return 'Kata sandi minimal ' + field.minLength + ' karakter.';
        return '';
    }

    function initForms() {
        var forms = document.querySelectorAll('form');
        Array.prototype.forEach.call(forms, function (form) {
            Array.prototype.forEach.call(form.querySelectorAll('input'), function (field) {
                field.addEventListener('invalid', function () {
                    field.setCustomValidity(pesanValidasi(field));
                });
                field.addEventListener('input', function () {
                    field.setCustomValidity('');
                });
            });

            // 'submit' hanya terpicu setelah validasi lolos
            form.addEventListener('submit', function () {
                var btn = form.querySelector('button[type="submit"]');
                if (!btn) return;
                btn.dataset.label = btn.textContent;
                btn.textContent = 'Memproses\u2026';
                btn.disabled = true;
            });
        });

        // Tombol "Kembali" browser bisa memulihkan halaman dari cache dalam keadaan terkunci
        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            var locked = document.querySelectorAll('button[type="submit"][disabled]');
            Array.prototype.forEach.call(locked, function (btn) {
                if (btn.dataset.label) btn.textContent = btn.dataset.label;
                btn.disabled = false;
            });
        });
    }

    function init() {
        initCalendar();
        initPasswordToggle();
        initForms();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
