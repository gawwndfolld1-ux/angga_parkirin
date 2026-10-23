<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../models/user.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?page=login');
    exit;
}

$username = trim(isset($_POST['username']) ? $_POST['username'] : '');
$password = isset($_POST['password']) ? $_POST['password'] : '';

$userModel = new User($conn);
$user = $userModel->login($username, $password);

if (!$user) {
    header('Location: ../index.php?page=login&error=1');
    exit;
}

$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama'] = $user['nama_lengkap'];
$_SESSION['username'] = $user['username'];
$_SESSION['level'] = $user['role'];

$userModel->logAktivitas($user['id_user'], 'login');

header('Location: ../index.php?page=dashboard');
exit;

?>
