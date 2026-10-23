<?php

require_once __DIR__ . '/../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Parkirin</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <header class="topbar fade-in">
            <div class="logo">PARKIRIN</div>
            <a href="controller/logout.php" onclick="return confirm('Anda yakin ingin logout dari akun ini?');">⇥ Logout</a>
        </header>
        <div class="layout">
            <aside class="sidebar fade-in">
                <div class="profile">
                    <h3><?= htmlspecialchars($_SESSION['nama']); ?></h3>
                    <span>● <?= ucfirst(htmlspecialchars($_SESSION['level'])); ?></span>
                </div>
                <div class="nav-title">MAIN NAVIGATION</div>
                <nav>
                    <?php renderNavigation(); ?>
                </nav>
            </aside>
            <main class="content">
                <h1>Dashboard <small>Control Panel</small>
                </h1>
                <div class="cards">
                    <div class="card green big">
                        <strong><?= (int)$data['jenis']; ?></strong>
                        <span>Jenis Kendaraan</span>
                    </div>
                    <div class="card orange big">
                        <strong><?= (int)$data['pengguna']; ?></strong>
                        <span>Pengguna Aktif</span>
                    </div>
                    <div class="card blue">
                        <strong><?= (int)$data['hari_ini']; ?></strong>
                        <span>Kendaraan Hari Ini</span>
                    </div>
                    <div class="card blue">
                        <strong><?= (int)$data['parkir_masuk']; ?></strong>
                        <span>Sedang Parkir</span>
                    </div>
                    <div class="card blue">
                        <strong><?= (int)$data['parkir_keluar']; ?></strong>
                        <span>Transaksi Selesai</span>
                    </div>
                    <div class="card blue">
                        <strong><?= (int)$data['total_kendaraan']; ?></strong>
                        <span>Total Data Kendaraan</span>
                    </div>
                    <div class="card green">
                        <strong>Rp<?= number_format($data['pemasukan_hari_ini'], 0, ',', '.'); ?></strong>
                        <span>Pemasukan Hari Ini</span>
                    </div>
                    <div class="card green">
                        <strong>Rp<?= number_format($data['pemasukan_bulan_ini'], 0, ',', '.'); ?></strong>
                        <span>Pemasukan Bulan Ini</span>
                    </div>
                </div>
                <div class="welcome">
                    <h2>Selamat datang, <?= htmlspecialchars($_SESSION['nama']); ?> 👋</h2>
                    <p>
                        Login sebagai
                        <b><?= ucfirst(htmlspecialchars($_SESSION['level'])); ?></b>.
                    </p>
                    <p><?= htmlspecialchars(roleDescription()); ?></p>
                </div>
                <div class="quick-links">
                    <?php if (canAccessPage('transaksi')): ?>
                        <a class="quick-link" href="index.php?page=transaksi">+ Catat Parkir Masuk</a>
                    <?php endif; ?>

                    <?php if (canAccessPage('tarif')): ?>
                        <a class="quick-link" href="index.php?page=tarif">Kelola Biaya Parkir</a>
                    <?php endif; ?>

                    <?php if (canAccessPage('laporan')): ?>
                        <a class="quick-link" href="index.php?page=laporan">Lihat Laporan</a>
                    <?php endif; ?>

                    <?php if (canAccessPage('log')): ?>
                        <a class="quick-link" href="index.php?page=log">Lihat Aktivitas</a>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </body>
</html>
