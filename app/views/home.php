<?php
function namaBulan(int $n): string {
    return ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$n - 1];
}
function tglIndo(string $d): string {
    $t = strtotime($d);
    $s = date('Y-m-d', $t);
    $awal = $s === date('Y-m-d') ? 'Hari ini, ' : ($s === date('Y-m-d', strtotime('+1 day')) ? 'Besok, ' : '');
    return $awal . date('j', $t) . ' ' . namaBulan((int) date('n', $t)) . ' ' . date('Y', $t);
}
$today = new DateTime('today');
$start = (clone $today)->modify('-' . $today->format('w') . ' days');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beranda - Diarify</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="public/css/app.css">
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
<symbol id="i-mail" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></symbol>
<symbol id="i-lock" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></symbol>
<symbol id="i-user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></symbol>
<symbol id="i-book" viewBox="0 0 24 24"><path d="M5 4h11a3 3 0 0 1 3 3v13H8a3 3 0 0 1-3-3z"/><path d="M9 8h6M9 12h6"/></symbol>
<symbol id="i-mark" viewBox="0 0 24 24"><path d="M6 3h12v18l-6-4-6 4z"/></symbol>
<symbol id="i-cal" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></symbol>
<symbol id="i-home" viewBox="0 0 24 24"><path d="M3 11l9-8 9 8v10h-6v-6H9v6H3z"/></symbol>
<symbol id="i-go" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M8 12h8m-3-3 3 3-3 3"/></symbol>
<symbol id="i-prev" viewBox="0 0 24 24"><path d="m15 6-6 6 6 6"/></symbol>
<symbol id="i-next" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></symbol>
<symbol id="i-back" viewBox="0 0 24 24"><path d="M19 12H5m6-6-6 6 6 6"/></symbol>
</defs></svg>
<div class="phone home">
<section class="top">
<h1>Diarify</h1>
<div class="who"><svg class="i "><use href="#i-user"/></svg><div><b>Halo, <?= htmlspecialchars($nama) ?></b>Semangat menjalani hari mu</div></div>
</section>
<section class="cal" aria-label="Kalender minggu ini" data-today="<?= $today->format('Y-m-d') ?>">
<header><button type="button" class="cal-nav" data-dir="-1" aria-label="Minggu sebelumnya"><svg class="i "><use href="#i-prev"/></svg></button><span class="cal-title" aria-live="polite"><?= namaBulan((int) $today->format('n')) . ' ' . $today->format('Y') ?></span><button type="button" class="cal-nav" data-dir="1" aria-label="Minggu berikutnya"><svg class="i "><use href="#i-next"/></svg></button></header>
<div class="row"><span>M</span><span>S</span><span>S</span><span>R</span><span>K</span><span>J</span><span>S</span><?php for ($i = 0; $i < 7; $i++): $d = (clone $start)->modify("+$i days"); ?><span class="day<?= $d == $today ? ' on' : '' ?>"><?= $d->format('j') ?></span><?php endfor; ?></div>
</section>
<section class="card">
<header><svg class="i big"><use href="#i-book"/></svg><h2>Tugas Mendatang</h2><a class="all" href="index.php?page=tugas">Lihat semua <svg class="i "><use href="#i-go"/></svg></a></header>
<?php if (!$tugas): ?><p class="empty">Belum ada tugas.</p><?php endif; ?>
<?php foreach ($tugas as $t): ?>
<div class="item"><span class="dot"></span><div><b><?= htmlspecialchars($t['judul']) ?></b><small><?= tglIndo($t['tenggat']) ?></small></div></div>
<?php endforeach; ?>
</section>
<section class="card">
<header><svg class="i big"><use href="#i-cal"/></svg><h2>Acara Hari Ini</h2><a class="all" href="index.php?page=acara">Lihat semua <svg class="i "><use href="#i-go"/></svg></a></header>
<?php if (!$acara): ?><p class="empty">Tidak ada acara hari ini.</p><?php endif; ?>
<?php foreach ($acara as $a): ?>
<div class="item plain"><b><?= htmlspecialchars($a['judul']) ?></b><small><?= tglIndo($a['tanggal']) ?></small></div>
<?php endforeach; ?>
</section>
<nav class="tabbar"><a class="on" href="index.php?page=home"><svg class="i "><use href="#i-home"/></svg>Home</a><a class="" href="index.php?page=tugas"><svg class="i "><use href="#i-book"/></svg>Tugas</a><a class="" href="index.php?page=jurnal"><svg class="i "><use href="#i-mark"/></svg>Jurnal</a><a class="" href="index.php?page=acara"><svg class="i "><use href="#i-cal"/></svg>Acara</a></nav>
</div>
<script src="public/js/app.js"></script>
</body>
</html>
