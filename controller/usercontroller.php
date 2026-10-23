<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('admin'));

require_once __DIR__ . '/../models/user.php';

$model = new User($conn);

if (hasRole('admin') && isset($_GET['aksi']) && $_GET['aksi'] === 'tambah') {
    $adminMode = true;
} else {
    $adminMode = false;
}

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'index';

switch ($aksi) {
    case 'tambah':
        require __DIR__ . '/../views/user/tambah.php';
        break;

    case 'simpan':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $model->tambah($_POST['nama_lengkap'], $_POST['username'], $_POST['password'], $_POST['role'], $_POST['status_aktif']);
            $model->logAktivitas($_SESSION['id_user'], $ok ? 'menambah pengguna' : 'gagal menambah pengguna');
        }
        header('Location: index.php?page=user');
        exit;

    case 'edit':
        $user = $model->getById(isset($_GET['id']) ? $_GET['id'] : 0);

        if (!$user) {
            header('Location: index.php?page=user');
            exit;
        }
        require __DIR__ . '/../views/user/edit.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $target = $model->getById($_POST['id_user']);

            $ok = $model->edit(
                $_POST['id_user'],
                $_POST['nama_lengkap'],
                $_POST['username'],
                $_POST['password'],
                $_POST['role'],
                $_POST['status_aktif']
            );
            $model->logAktivitas($_SESSION['id_user'], $ok ? 'mengubah pengguna' : 'gagal mengubah pengguna');
        }
        header('Location: index.php?page=user');
        exit;

    case 'hapus':
        $id = (int) (isset($_GET['id']) ? $_GET['id'] : 0);
        $target = $model->getById($id);

        if ($id === (int) $_SESSION['id_user']) {
            header('Location: index.php?page=user');
            exit;
        }
        $ok = $model->hapus($id);
        $model->logAktivitas($_SESSION['id_user'], $ok ? 'menghapus pengguna' : 'gagal menghapus pengguna');
        header('Location: index.php?page=user');
        exit;

    default:
        $dataUser = $model->getAll();
        require __DIR__ . '/../views/user/index.php';
        break;
}

?>
