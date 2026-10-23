<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/auth.php';

$page = isset($_GET['page']) ? $_GET['page'] : '';

if ($page !== 'login' && !isLoggedIn()) {
    require __DIR__ . '/views/login.php';
    exit;
}

if ($page !== '' && $page !== 'login' && !canAccessPage($page)) {
    header('Location: index.php?page=dashboard&error=akses');
    exit;
}

switch ($page) {
    case 'login':
        require __DIR__ . '/views/login.php';
        break;

    case 'dashboard':
        require __DIR__ . '/controller/dashboardcontroller.php';
        break;

    case 'kendaraan':
        require __DIR__ . '/controller/kendaraancontroller.php';
        break;

    case 'tarif':
        require __DIR__ . '/controller/tarifcontroller.php';
        break;

    case 'area':
        require __DIR__ . '/controller/areacontroller.php';
        break;

    case 'user':
        require __DIR__ . '/controller/usercontroller.php';
        break;

    case 'transaksi':
        require __DIR__ . '/controller/transaksicontroller.php';
        break;

    case 'laporan':
        require __DIR__ . '/controller/laporancontroller.php';
        break;

    case 'log':
        require __DIR__ . '/controller/logcontroller.php';
        break;

    case 'password':
        require __DIR__ . '/controller/passwordcontroller.php';
        break;

    default:
        if (isLoggedIn()) {
            require __DIR__ . '/controller/dashboardcontroller.php';
        } else {
            require __DIR__ . '/views/login.php';
        }
        break;
}

?>
