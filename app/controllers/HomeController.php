<?php
require_once __DIR__ . '/../models/HomeModel.php';

class HomeController
{
    public function index(PDO $db): void
    {
        // Middleware sederhana: hanya user yang sudah login boleh masuk
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $model  = new HomeModel($db);
        $userId = (int) $_SESSION['user_id'];

        $nama   = $_SESSION['nama'] ?? 'Teman';
        $tugas  = $model->tugasTerdekat($userId);
        $acara  = $model->acaraHariIni($userId);

        require __DIR__ . '/../views/home.php';
    }
}
