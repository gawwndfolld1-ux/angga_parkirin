<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('owner', 'admin', 'petugas'));

require_once __DIR__ . '/../models/user.php';

$model = new User($conn);
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lama = isset($_POST['password_lama']) ? $_POST['password_lama'] : '';
    $baru = isset($_POST['password_baru']) ? $_POST['password_baru'] : '';
    $konfirmasi = isset($_POST['konfirmasi']) ? $_POST['konfirmasi'] : '';
    $user = $model->getById($_SESSION['id_user']);

    if (!$user || $lama !== $user['password']) {
        $error = 'Password lama tidak sesuai.';
    } elseif ($baru === '') {
        $error = 'Password baru wajib diisi.';
    } elseif ($baru !== $konfirmasi) {
        $error = 'Konfirmasi password tidak sama.';
    } else {
        $model->ubahPassword($_SESSION['id_user'], $baru);
        $model->logAktivitas($_SESSION['id_user'], 'mengubah password');
        $success = 'Password berhasil diubah.';
    }
}

require __DIR__ . '/../views/password/index.php';

?>
