<?php

class Transaksi
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT t.*, k.plat_nomor, k.jenis_kendaraan, a.nama_area, tr.tarif_per_jam, u.nama_lengkap
                FROM tb_transaksi t
                LEFT JOIN tb_kendaraan k ON t.id_kendaraan=k.id_kendaraan
                LEFT JOIN tb_area_parkir a ON t.id_area=a.id_area
                LEFT JOIN tb_tarif tr ON t.id_tarif=tr.id_tarif
                LEFT JOIN tb_user u ON t.id_user=u.id_user
                ORDER BY t.id_parkir DESC";
        return mysqli_query($this->conn, $sql);
    }

    public function getById($id)
    {
        $id = (int) $id;
        $sql = "SELECT t.*, k.plat_nomor, k.jenis_kendaraan, a.nama_area, tr.tarif_per_jam
                FROM tb_transaksi t
                LEFT JOIN tb_kendaraan k ON t.id_kendaraan=k.id_kendaraan
                LEFT JOIN tb_area_parkir a ON t.id_area=a.id_area
                LEFT JOIN tb_tarif tr ON t.id_tarif=tr.id_tarif
                WHERE t.id_parkir=$id LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        return $result ? mysqli_fetch_assoc($result) : false;
    }

    public function getKendaraan()
    {
        return mysqli_query($this->conn, "SELECT id_kendaraan, plat_nomor, jenis_kendaraan FROM tb_kendaraan ORDER BY plat_nomor ASC");
    }

    public function getArea()
    {
        return mysqli_query($this->conn, "SELECT id_area, nama_area, kapasitas, terisi FROM tb_area_parkir ORDER BY nama_area ASC");
    }

    public function getTarif ()
    {
        return mysqli_query($this->conn, "SELECT id_tarif, jenis_kendaraan, tarif_per_jam FROM tb_tarif ORDER BY jenis_kendaraan ASC");
    }

    public function tambah($platNomor, $jenisKendaraan, $idTarif, $idArea, $idUser, $waktuMasuk)
    {
        $platNomor = strtoupper(trim($platNomor));
        $platNomor = mysqli_real_escape_string($this->conn, $platNomor);
        $jenisKendaraan = mysqli_real_escape_string($this->conn, trim($jenisKendaraan));
        $idTarif = (int) $idTarif;
        $idArea = (int) $idArea;
        $idUser = (int) $idUser;
        $waktuMasuk = mysqli_real_escape_string($this->conn, $waktuMasuk);

        if (!in_array($jenisKendaraan, array('motor', 'mobil', 'lainnya'), true) || $platNomor === '') {
            return false;
        }

        $kendaraanResult = mysqli_query($this->conn, "SELECT id_kendaraan FROM tb_kendaraan WHERE plat_nomor='$platNomor' LIMIT 1");
        if ($kendaraanResult && mysqli_num_rows($kendaraanResult) > 0) {
            $kendaraan = mysqli_fetch_assoc($kendaraanResult);
            $idKendaraan = (int) $kendaraan['id_kendaraan'];
            $cekJenis = mysqli_query($this->conn, "SELECT jenis_kendaraan FROM tb_kendaraan WHERE id_kendaraan=$idKendaraan LIMIT 1");
            $jenisData = $cekJenis ? mysqli_fetch_assoc($cekJenis) : false;
            if (!$jenisData || $jenisData['jenis_kendaraan'] !== $jenisKendaraan) {
                return false;
            }
        } else {
            $pemilik = mysqli_real_escape_string($this->conn, 'Tamu/Karyawan Hotel');
            $buatKendaraan = mysqli_query($this->conn, "INSERT INTO tb_kendaraan (plat_nomor, jenis_kendaraan, pemilik, id_user) VALUES ('$platNomor', '$jenisKendaraan', '$pemilik', $idUser)");
            if (!$buatKendaraan) {
                return false;
            }
            $idKendaraan = (int) mysqli_insert_id($this->conn);
        }

        $aktif = mysqli_query($this->conn, "SELECT id_parkir FROM tb_transaksi WHERE id_kendaraan=$idKendaraan AND status='masuk' LIMIT 1");
        if (!$aktif || mysqli_num_rows($aktif) > 0) {
            return false;
        }

        $areaResult = mysqli_query($this->conn, "SELECT kapasitas, terisi FROM tb_area_parkir WHERE id_area=$idArea LIMIT 1");
        $areaData = $areaResult ? mysqli_fetch_assoc($areaResult) : false;
        if (!$areaData || (int)$areaData['terisi'] >= (int)$areaData['kapasitas']) {
            return false;
        }

        mysqli_begin_transaction($this->conn);
        $sql = "INSERT INTO tb_transaksi (id_kendaraan, waktu_masuk, id_tarif, status, id_user, id_area)
                VALUES ($idKendaraan, '$waktuMasuk', $idTarif, 'masuk', $idUser, $idArea)";
        $ok = mysqli_query($this->conn, $sql);
        if ($ok) {
            $ok = mysqli_query($this->conn, "UPDATE tb_area_parkir SET terisi=terisi+1 WHERE id_area=$idArea AND terisi < kapasitas");
        }
        if ($ok && mysqli_affected_rows($this->conn) > 0) {
            mysqli_commit($this->conn);
            return true;
        }
        mysqli_rollback($this->conn);
        return false;
    }

    public function keluar($id, $waktuKeluar)
    {
        $id = (int) $id;
        $waktuKeluar = mysqli_real_escape_string($this->conn, $waktuKeluar);
        $data = $this->getById($id);

        if (!$data || $data['status'] !== 'masuk') {
            return false;
        }

        $masuk = strtotime($data['waktu_masuk']);
        $keluar = strtotime($waktuKeluar);
        $durasi = max(1, (int) ceil(($keluar - $masuk) / 3600));
        $tarif = (int) $data['tarif_per_jam'];
        $biaya = $durasi * $tarif;
        $area = (int) $data['id_area'];

        $sql = "UPDATE tb_transaksi
                SET waktu_keluar = '$waktuKeluar',
                    durasi_jam = $durasi,
                    biaya_total = $biaya,
                    status = 'keluar'
                WHERE id_parkir = $id";
        $ok = mysqli_query($this->conn, $sql);

        if ($ok && $area > 0) {
            mysqli_query($this->conn, "UPDATE tb_area_parkir SET terisi=GREATEST(terisi-1, 0) WHERE id_area=$area");
        }

        return $ok;
    }
}

?>
