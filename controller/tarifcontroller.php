<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('admin'));

require_once __DIR__ . '/../models/tarif.php';
require_once __DIR__ . '/../models/user.php';

$model = new Tarif($conn);
$userModel = new User($conn);
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'index';

switch ($aksi) {
    case 'tambah':
        require __DIR__ . '/../views/tarif/tambah.php';
        break;

    case 'simpan':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $model->tambah($_POST['jenis_kendaraan'], $_POST['tarif_per_jam']);
            $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'menambah tarif parkir' : 'gagal menambah tarif parkir');
        }
        header('Location: index.php?page=tarif');
        exit;

    case 'edit':
        $tarif = $model->getById(isset($_GET['id']) ? $_GET['id'] : 0);
        if (!$tarif) {
            header('Location: index.php?page=tarif');
            exit;
        }
        require __DIR__ . '/../views/tarif/edit.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $model->edit($_POST['id_tarif'], $_POST['jenis_kendaraan'], $_POST['tarif_per_jam']);
            $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'mengubah tarif parkir' : 'gagal mengubah tarif parkir');
        }
        header('Location: index.php?page=tarif');
        exit;

    case 'hapus':
        $ok = $model->hapus(isset($_GET['id']) ? $_GET['id'] : 0);
        $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'menghapus tarif parkir' : 'gagal menghapus tarif parkir');
        header('Location: index.php?page=tarif');
        exit;

    default:
        $dataTarif = $model->getAll();
        require __DIR__ . '/../views/tarif/index.php';
        break;
}

?>
