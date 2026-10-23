<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($username, $password)
    {
        $username = mysqli_real_escape_string($this->conn, trim($username));

        $sql = "SELECT * FROM tb_user
                WHERE username = '$username'
                AND status_aktif = 1
                LIMIT 1";

        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            return false;
        }

        $user = mysqli_fetch_assoc($result);

        if (!$user || $password !== $user['password']) {
            return false;
        }

        return $user;
    }

    public function getAll()
    {
        return mysqli_query($this->conn, "SELECT * FROM tb_user ORDER BY id_user ASC");
    }

    public function getById($id)
    {
        $id = (int) $id;
        $result = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE id_user = $id LIMIT 1");
        return $result ? mysqli_fetch_assoc($result) : false;
    }

    public function tambah($nama, $username, $password, $role, $status)
    {
        $nama = mysqli_real_escape_string($this->conn, trim($nama));
        $username = mysqli_real_escape_string($this->conn, trim($username));
        $password = mysqli_real_escape_string($this->conn, $password);
        $role = mysqli_real_escape_string($this->conn, $role);
        $status = (int) $status;

        $sql = "INSERT INTO tb_user
                (nama_lengkap, username, password, role, status_aktif)
                VALUES ('$nama', '$username', '$password', '$role', $status)";

        return mysqli_query($this->conn, $sql);
    }

    public function edit($id, $nama, $username, $password, $role, $status)
    {
        $id = (int) $id;
        $nama = mysqli_real_escape_string($this->conn, trim($nama));
        $username = mysqli_real_escape_string($this->conn, trim($username));
        $role = mysqli_real_escape_string($this->conn, $role);
        $status = (int) $status;

        if ($password !== '') {
            $password = mysqli_real_escape_string($this->conn, $password);
            $sql = "UPDATE tb_user
                    SET nama_lengkap = '$nama',
                        username = '$username',
                        password = '$password',
                        role = '$role',
                        status_aktif = $status
                    WHERE id_user = $id";
        } else {
            $sql = "UPDATE tb_user SET nama_lengkap='$nama', username='$username', role='$role', status_aktif=$status WHERE id_user=$id";
        }

        return mysqli_query($this->conn, $sql);
    }

    public function hapus($id)
    {
        $id = (int) $id;
        return mysqli_query($this->conn, "DELETE FROM tb_user WHERE id_user=$id");
    }

    public function ubahPassword($id, $password)
    {
        $id = (int) $id;
        $password = mysqli_real_escape_string($this->conn, $password);
        return mysqli_query($this->conn, "UPDATE tb_user SET password='$password' WHERE id_user=$id");
    }

    public function logAktivitas($idUser, $aktivitas)
    {
        $idUser = (int) $idUser;
        $aktivitas = mysqli_real_escape_string($this->conn, $aktivitas);
        $sql = "INSERT INTO tb_log_aktivitas
                (id_user, aktivitas, waktu_aktivitas)
                VALUES ($idUser, '$aktivitas', NOW())";

        return mysqli_query($this->conn, $sql);
    }
}

?>
