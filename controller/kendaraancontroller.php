<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('admin'));

require_once __DIR__ . '/../models/kendaraan.php';
require_once __DIR__ . '/../models/user.php';

$model = new Kendaraan($conn);
$userModel = new User($conn);
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'index';

switch ($aksi) {
    case 'tambah':
        $dataUser = $model->getUsers();
        require __DIR__ . '/../views/kendaraan/tambah.php';
        break;

    case 'simpan':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $model->tambah($_POST['plat_nomor'], $_POST['jenis_kendaraan'], $_POST['warna'], $_POST['pemilik'], $_POST['id_user']);
            $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'menambah kendaraan' : 'gagal menambah kendaraan');
        }
        header('Location: index.php?page=kendaraan');
        exit;

    case 'edit':
        $id = (int) (isset($_GET['id']) ? $_GET['id'] : 0);
        $kendaraan = $model->getById($id);
        if (!$kendaraan) {
            header('Location: index.php?page=kendaraan&error=Data kendaraan tidak ditemukan');
            exit;
        }
        $dataUser = $model->getUsers();
        require __DIR__ . '/../views/kendaraan/edit.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $model->edit(
                $_POST['id_kendaraan'],
                $_POST['plat_nomor'],
                $_POST['jenis_kendaraan'],
                $_POST['warna'],
                $_POST['pemilik'],
                $_POST['id_user']
            );
            $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'mengubah kendaraan' : 'gagal mengubah kendaraan');
        }
        header('Location: index.php?page=kendaraan');
        exit;

    case 'hapus':
        $id = (int) (isset($_GET['id']) ? $_GET['id'] : 0);
        $ok = $id > 0 ? $model->hapus($id) : false;
        $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'menghapus kendaraan' : 'gagal menghapus kendaraan');
        header('Location: index.php?page=kendaraan');
        exit;

    default:
        $dataKendaraan = $model->getAll();
        require __DIR__ . '/../views/kendaraan/index.php';
        break;
}

?>
