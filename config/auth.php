<?php

function userRole()
{
    return isset($_SESSION['level']) ? $_SESSION['level'] : '';
}

function isLoggedIn()
{
    return isset($_SESSION['id_user']);
}

function hasRole($roles)
{
    $roles = (array) $roles;
    return in_array(userRole(), $roles, true);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: index.php?page=login');
        exit;
    }
}

function requireRole($roles)
{
    requireLogin();

    if (!hasRole($roles)) {
        header('Location: index.php?page=dashboard&error=akses');
        exit;
    }
}

function canAccessPage($page)
{
    $permissions = array(
        'dashboard' => array('owner', 'admin', 'petugas'),
        'transaksi' => array('petugas'),
        'kendaraan' => array('admin'),
        'area' => array('admin'),
        'tarif' => array('admin'),
        'user' => array('admin'),
        'laporan' => array('owner'),
        'log' => array('admin'),
        'password' => array('owner', 'admin', 'petugas')
    );

    return isset($permissions[$page]) && hasRole($permissions[$page]);
}

function menuItems()
{
    $items = array(
        'dashboard' => array('icon' => '▣', 'label' => 'Dashboard'),
        'transaksi' => array('icon' => '↔', 'label' => 'Parkir'),
        'kendaraan' => array('icon' => '🚗', 'label' => 'Kendaraan'),
        'area' => array('icon' => '▦', 'label' => 'Area Parkir Hotel'),
        'tarif' => array('icon' => '💳', 'label' => 'Tarif Parkir'),
        'user' => array('icon' => '👥', 'label' => 'Data Pengguna'),
        'laporan' => array('icon' => '▤', 'label' => 'Rekap Transaksi'),
        'log' => array('icon' => '◷', 'label' => 'Log Aktivitas')
    );

    return $items;
}

function renderNavigation()
{
    $currentPage = isset($_GET['page']) && $_GET['page'] !== '' ? $_GET['page'] : 'dashboard';

    foreach (menuItems() as $page => $item) {
        if (!canAccessPage($page)) {
            continue;
        }

        $active = ($currentPage === $page) ? ' active' : '';
        echo '<a class="' . $active . '" href="index.php?page=' . $page . '" aria-current="' . ($active !== '' ? 'page' : 'false') . '">';
        echo '<span class="nav-icon">' . $item['icon'] . '</span>';
        echo '<span>' . $item['label'] . '</span>';
        echo '</a>';
    }

    if (canAccessPage('password')) {
        $active = ($currentPage === 'password') ? ' active' : '';
        echo '<a class="' . $active . '" href="index.php?page=password" aria-current="' . ($active !== '' ? 'page' : 'false') . '">';
        echo '<span class="nav-icon">⚙</span>';
        echo '<span>Ganti Password</span>';
        echo '</a>';
    }
}

function roleDescription()
{

    $role = userRole();
    return isset($descriptions[$role]) ? $descriptions[$role] : '';
}

?>
