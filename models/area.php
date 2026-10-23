<?php

class Area
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        return mysqli_query($this->conn, "SELECT * FROM tb_area_parkir ORDER BY id_area ASC");
    }

    public function getById($id)
    {
        $id = (int) $id;
        $result = mysqli_query($this->conn, "SELECT * FROM tb_area_parkir WHERE id_area=$id LIMIT 1");
        return $result ? mysqli_fetch_assoc($result) : false;
    }

    public function tambah($nama, $kapasitas, $terisi)
    {
        $nama = mysqli_real_escape_string($this->conn, trim($nama));
        $kapasitas = (int) $kapasitas;
        $terisi = (int) $terisi;
        return mysqli_query($this->conn, "INSERT INTO tb_area_parkir (nama_area, kapasitas, terisi) VALUES ('$nama',$kapasitas,$terisi)");
    }

    public function edit($id, $nama, $kapasitas, $terisi)
    {
        $id = (int) $id;
        $nama = mysqli_real_escape_string($this->conn, trim($nama));
        $kapasitas = (int) $kapasitas;
        $terisi = (int) $terisi;
        $sql = "UPDATE tb_area_parkir
                SET nama_area = '$nama',
                    kapasitas = $kapasitas,
                    terisi = $terisi
                WHERE id_area = $id";

        return mysqli_query($this->conn, $sql);
    }

    public function hapus($id)
    {
        $id = (int) $id;
        return mysqli_query($this->conn, "DELETE FROM tb_area_parkir WHERE id_area=$id");
    }
}

?>
