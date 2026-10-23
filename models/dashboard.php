<?php

class Dashboard
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    private function one($sql)
    {
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            return 0;
        }

        $row = mysqli_fetch_assoc($result);
        return $row ? $row['total'] : 0;
    }

    public function jumlahJenis()
    {
        return $this->one("SELECT COUNT(DISTINCT jenis_kendaraan) AS total FROM tb_kendaraan");
    }

    public function jumlahPengguna()
    {
        return $this->one("SELECT COUNT(*) AS total FROM tb_user WHERE status_aktif = 1");
    }

    public function kendaraanHariIni()
    {
        return $this->one("SELECT COUNT(*) AS total FROM tb_transaksi WHERE DATE(waktu_masuk) = CURDATE()");
    }

    public function kendaraanBulanIni()
    {
        return $this->one(
            "SELECT COUNT(*) AS total
             FROM tb_transaksi
             WHERE MONTH(waktu_masuk) = MONTH(CURDATE())
             AND YEAR(waktu_masuk) = YEAR(CURDATE())"
        );
    }

    public function kendaraanTahunIni()
    {
        return $this->one("SELECT COUNT(*) AS total FROM tb_transaksi WHERE YEAR(waktu_masuk) = YEAR(CURDATE())");
    }

    public function totalKendaraan()
    {
        return $this->one("SELECT COUNT(*) AS total FROM tb_kendaraan");
    }

    public function pemasukanHariIni()
    {
        return $this->one(
            "SELECT COALESCE(SUM(biaya_total), 0) AS total
             FROM tb_transaksi
             WHERE status = 'keluar'
             AND DATE(waktu_keluar) = CURDATE()"
        );
    }

    public function pemasukanBulanIni()
    {
        return $this->one(
            "SELECT COALESCE(SUM(biaya_total), 0) AS total
             FROM tb_transaksi
             WHERE status = 'keluar'
             AND MONTH(waktu_keluar) = MONTH(CURDATE())
             AND YEAR(waktu_keluar) = YEAR(CURDATE())"
        );
    }

    public function pemasukanTahunIni()
    {
        return $this->one(
            "SELECT COALESCE(SUM(biaya_total), 0) AS total
             FROM tb_transaksi
             WHERE status = 'keluar'
             AND YEAR(waktu_keluar) = YEAR(CURDATE())"
        );
    }

    public function totalPemasukan()
    {
        return $this->one("SELECT COALESCE(SUM(biaya_total), 0) AS total FROM tb_transaksi WHERE status = 'keluar'");
    }

    public function parkirMasuk()
    {
        return $this->one("SELECT COUNT(*) AS total FROM tb_transaksi WHERE status = 'masuk'");
    }

    public function parkirKeluar()
    {
        return $this->one("SELECT COUNT(*) AS total FROM tb_transaksi WHERE status = 'keluar'");
    }
}

?>
