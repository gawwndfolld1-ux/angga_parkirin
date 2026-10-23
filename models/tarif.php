<?php

class Tarif
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        return mysqli_query($this->conn, "SELECT * FROM tb_tarif ORDER BY id_tarif ASC");
    }

    public function getById($id)
    {
        $id = (int) $id;
        $result = mysqli_query($this->conn, "SELECT * FROM tb_tarif WHERE id_tarif=$id LIMIT 1");
        return $result ? mysqli_fetch_assoc($result) : false;
    }

    public function tambah($jenis, $tarif)
    {
        $jenis = mysqli_real_escape_string($this->conn, $jenis);
        $tarif = (int) $tarif;
        return mysqli_query($this->conn, "INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES ('$jenis',$tarif)");
    }

    public function edit($id, $jenis, $tarif)
    {
        $id = (int) $id;
        $jenis = mysqli_real_escape_string($this->conn, $jenis);
        $tarif = (int) $tarif;
        return mysqli_query($this->conn, "UPDATE tb_tarif SET jenis_kendaraan='$jenis', tarif_per_jam=$tarif WHERE id_tarif=$id");
    }

    public function hapus($id)
    {
        $id = (int) $id;
        return mysqli_query($this->conn, "DELETE FROM tb_tarif WHERE id_tarif=$id");
    }
}

?>
