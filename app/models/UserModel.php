<?php
class UserModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(string $nama, string $email, string $password): bool
    {
        $stmt = $this->db->prepare('INSERT INTO users (nama, email, password) VALUES (?, ?, ?)');
        return $stmt->execute([$nama, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }
}
