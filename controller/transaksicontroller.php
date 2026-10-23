<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('petugas'));

require_once __DIR__ . '/../models/transaksi.php';
require_once __DIR__ . '/../models/user.php';

$model = new Transaksi($conn);
$userModel = new User($conn);
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'index';

switch ($aksi) {
    case 'tambah':
        $cekTarif = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_tarif");
        $jumlahTarif = $cekTarif ? (int) mysqli_fetch_assoc($cekTarif)['total'] : 0;
        if ($jumlahTarif === 0) {
            mysqli_query($conn, "INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES ('motor',3000),('mobil',5000),('lainnya',7000)");
        }

        $cekArea = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_area_parkir");
        $jumlahArea = $cekArea ? (int) mysqli_fetch_assoc($cekArea)['total'] : 0;
        if ($jumlahArea === 0) {
            mysqli_query($conn, "INSERT INTO tb_area_parkir (nama_area, kapasitas, terisi) VALUES ('Gedung A',50,0),('Gedung B',50,0)");
        }

        $dataKendaraan = $model->getKendaraan();
        $dataArea = $model->getArea();
        $dataTarif = $model->getTarif();
        require __DIR__ . '/../views/transaksi/tambah.php';
        break;

    case 'simpan':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $waktu = !empty($_POST['waktu_masuk']) ? str_replace('T', ' ', $_POST['waktu_masuk']) . ':00' : date('Y-m-d H:i:s');
            $ok = $model->tambah($_POST['plat_nomor'], $_POST['jenis_kendaraan'], $_POST['id_tarif'], $_POST['id_area'], $_SESSION['id_user'], $waktu);
            $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'input transaksi parkir masuk' : 'gagal input transaksi parkir masuk');
        }
        header('Location: index.php?page=transaksi');
        exit;

    case 'struk':
        $id = (int) (isset($_GET['id']) ? $_GET['id'] : 0);
        $struk = $model->getById($id);
        if (!$struk) { header('Location: index.php?page=transaksi&error=struk'); exit; }
        require __DIR__ . '/../views/transaksi/struk.php';
        break;

    case 'keluar':
        $id = (int) (isset($_GET['id']) ? $_GET['id'] : 0);
        $ok = $model->keluar($id, date('Y-m-d H:i:s'));
        $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'memproses parkir keluar' : 'gagal memproses parkir keluar');
        header('Location: index.php?page=transaksi');
        exit;

    default:
        $dataTransaksi = $model->getAll();
        require __DIR__ . '/../views/transaksi/index.php';
        break;
}

?>
