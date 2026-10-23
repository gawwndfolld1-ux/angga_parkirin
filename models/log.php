<?php

class LogAktivitas
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT l.*, u.nama_lengkap, u.role
                FROM tb_log_aktivitas l
                LEFT JOIN tb_user u ON l.id_user = u.id_user
                ORDER BY l.id_log DESC";

        return mysqli_query($this->conn, $sql);
    }
}

?>
