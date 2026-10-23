<?php

class Kendaraan
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT k.*, u.nama_lengkap, u.role
                FROM tb_kendaraan k
                LEFT JOIN tb_user u ON k.id_user = u.id_user
                ORDER BY k.id_kendaraan DESC";

        return mysqli_query($this->conn, $sql);
    }

    public function getById($id)
    {
        $id = (int) $id;
        $sql = "SELECT k.*, u.nama_lengkap, u.role
                FROM tb_kendaraan k
                LEFT JOIN tb_user u ON k.id_user = u.id_user
                WHERE k.id_kendaraan = $id
                LIMIT 1";

        $result = mysqli_query($this->conn, $sql);
        return $result ? mysqli_fetch_assoc($result) : false;
    }

    public function getUsers()
    {
        return mysqli_query($this->conn, "SELECT id_user, nama_lengkap, role FROM tb_user WHERE status_aktif=1 ORDER BY nama_lengkap ASC");
    }

    public function tambah($plat, $jenis, $warna, $pemilik, $idUser)
    {
        $plat = mysqli_real_escape_string($this->conn, trim($plat));
        $jenis = mysqli_real_escape_string($this->conn, trim($jenis));
        $warna = mysqli_real_escape_string($this->conn, trim($warna));
        $pemilik = mysqli_real_escape_string($this->conn, trim($pemilik));
        $idUser = (int) $idUser;

        $sql = "INSERT INTO tb_kendaraan
                (plat_nomor, jenis_kendaraan, warna, pemilik, id_user)
                VALUES ('$plat', '$jenis', '$warna', '$pemilik', $idUser)";

        return mysqli_query($this->conn, $sql);
    }

    public function edit($id, $plat, $jenis, $warna, $pemilik, $idUser)
    {
        $id = (int) $id;
        $plat = mysqli_real_escape_string($this->conn, trim($plat));
        $jenis = mysqli_real_escape_string($this->conn, trim($jenis));
        $warna = mysqli_real_escape_string($this->conn, trim($warna));
        $pemilik = mysqli_real_escape_string($this->conn, trim($pemilik));
        $idUser = (int) $idUser;

        $sql = "UPDATE tb_kendaraan
                SET plat_nomor = '$plat',
                    jenis_kendaraan = '$jenis',
                    warna = '$warna',
                    pemilik = '$pemilik',
                    id_user = $idUser
                WHERE id_kendaraan = $id";

        return mysqli_query($this->conn, $sql);
    }

    public function hapus($id)
    {
        $id = (int) $id;
        return mysqli_query($this->conn, "DELETE FROM tb_kendaraan WHERE id_kendaraan=$id");
    }
}

?>
