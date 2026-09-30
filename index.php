<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/HomeController.php';

$page = $_GET['page'] ?? 'home';
$auth = new AuthController($db);

switch ($page) {
    case 'login':    $auth->login();    break;
    case 'register': $auth->register(); break;
    case 'logout':   $auth->logout();   break;
    case 'home':     (new HomeController)->index($db); break;
    default:
        http_response_code(404);
        echo 'Halaman belum tersedia. <a href="index.php?page=home">Kembali ke beranda</a>';
}
