<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('admin'));

require_once __DIR__ . '/../models/area.php';
require_once __DIR__ . '/../models/user.php';

$model = new Area($conn);
$userModel = new User($conn);
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'index';

switch ($aksi) {
    case 'tambah':
        require __DIR__ . '/../views/area/tambah.php';
        break;

    case 'simpan':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $model->tambah($_POST['nama_area'], $_POST['kapasitas'], $_POST['terisi']);
            $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'menambah area parkir' : 'gagal menambah area parkir');
        }
        header('Location: index.php?page=area');
        exit;

    case 'edit':
        $area = $model->getById(isset($_GET['id']) ? $_GET['id'] : 0);
        if (!$area) {
            header('Location: index.php?page=area');
            exit;
        }
        require __DIR__ . '/../views/area/edit.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $model->edit($_POST['id_area'], $_POST['nama_area'], $_POST['kapasitas'], $_POST['terisi']);
            $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'mengubah area parkir' : 'gagal mengubah area parkir');
        }
        header('Location: index.php?page=area');
        exit;

    case 'hapus':
        $ok = $model->hapus(isset($_GET['id']) ? $_GET['id'] : 0);
        $userModel->logAktivitas($_SESSION['id_user'], $ok ? 'menghapus area parkir' : 'gagal menghapus area parkir');
        header('Location: index.php?page=area');
        exit;

    default:
        $dataArea = $model->getAll();
        require __DIR__ . '/../views/area/index.php';
        break;
}

?>
