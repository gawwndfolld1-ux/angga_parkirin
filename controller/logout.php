<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idUser = isset($_SESSION['id_user']) ? (int) $_SESSION['id_user'] : 0;

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../models/user.php';

if ($idUser > 0) {
    $userModel = new User($conn);
    $userModel->logAktivitas($idUser, 'logout');
}

$_SESSION = array();
session_destroy();

header('Location: ../index.php?page=login&logout=1');
exit;

?>
