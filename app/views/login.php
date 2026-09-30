<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk - Diarify</title>
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
<div class="phone">
<section class="hero">
<svg class="logo" viewBox="0 0 64 64" aria-hidden="true"><rect x="12" y="4" width="40" height="56" rx="7" fill="#fff"/><rect x="18" y="14" width="22" height="5" rx="2.5" fill="#800000"/><rect x="18" y="24" width="22" height="5" rx="2.5" fill="#800000"/><path d="M40 60V44l6 4 6-4v16z" fill="#800000"/></svg>
<h1>Diarify</h1>
<p>Jurnal, waktu, tugas, dan acara<br>dalam satu tempat</p>
</section>
<form class="sheet" method="post" action="index.php?page=login">
<h2>Masuk ke akun</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<label for="email">Email</label>
<div class="input"><svg class="i "><use href="#i-mail"/></svg><input type="email" id="email" name="email" placeholder="Nama@gmail.com" value="<?= htmlspecialchars($email) ?>" required></div>
<label for="password">Password</label>
<div class="input"><svg class="i "><use href="#i-lock"/></svg><input type="password" id="password" name="password" placeholder="Masukan password" required></div>
<a class="forgot" href="#">Lupa password?</a>
<button type="submit">Masuk</button>
<div class="or"><span>Atau</span></div>
<p class="alt">Belum punya akun? <a href="index.php?page=register">Daftar sekarang</a></p>
</form>
</div>
<script src="public/js/app.js"></script>
</body>
</html>
