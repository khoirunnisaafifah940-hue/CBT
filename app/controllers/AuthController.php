<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    private UserModel $users;

    public function __construct(PDO $db)
    {
        $this->users = new UserModel($db);
    }

    public function login(): void
    {
        if (!empty($_SESSION['user_id'])) {
            header('Location: index.php?page=home');
            exit;
        }

        $error = '';
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $user     = $this->users->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama']    = $user['nama'];
                header('Location: index.php?page=home');
                exit;
            }
            $error = 'Email atau kata sandi salah.';
        }

        require __DIR__ . '/../views/login.php';
    }

    public function register(): void
    {
        $error = '';
        $nama = $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama     = trim($_POST['nama'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($nama === '' || $email === '' || $password === '') {
                $error = 'Semua kolom wajib diisi.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Format email tidak valid.';
            } elseif (strlen($password) < 8) {
                $error = 'Kata sandi minimal 8 karakter.';
            } elseif ($this->users->findByEmail($email)) {
                $error = 'Email sudah terdaftar. Silakan masuk.';
            } else {
                $this->users->create($nama, $email, $password);
                header('Location: index.php?page=login');
                exit;
            }
        }

        require __DIR__ . '/../views/register.php';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
