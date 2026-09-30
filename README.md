# Diarify

1. Import `database.sql` lewat phpMyAdmin (buat database `diarify`).
2. Sesuaikan user/password MySQL di `config/database.php`.
3. Taruh folder ini di htdocs (XAMPP), buka `http://localhost/diarify-home/index.php`.
4. Daftar akun baru, masuk, lalu beranda akan tampil.

Struktur MVC: `index.php` (router), `app/controllers`, `app/models`, `app/views`, `config`, `public/css`.

JavaScript: `public/js/app.js` (kalender mingguan, tampil/sembunyi password, pesan validasi, cegah submit ganda), dimuat di tiga view.
