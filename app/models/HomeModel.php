<?php
class HomeModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    private function fetch(string $sql, int $userId): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tugasTerdekat(int $userId): array
    {
        return $this->fetch(
            "SELECT judul, tenggat FROM tugas
             WHERE user_id = ? AND status = 'belum' ORDER BY tenggat ASC LIMIT 5",
            $userId
        );
    }

    public function acaraHariIni(int $userId): array
    {
        return $this->fetch(
            "SELECT judul, tanggal, lokasi FROM acara
             WHERE user_id = ? AND tanggal = CURDATE() ORDER BY judul ASC LIMIT 5",
            $userId
        );
    }

    public function jurnalTerbaru(int $userId): array
    {
        return $this->fetch(
            "SELECT judul, isi, created_at FROM jurnal
             WHERE user_id = ? ORDER BY created_at DESC LIMIT 3",
            $userId
        );
    }
}
