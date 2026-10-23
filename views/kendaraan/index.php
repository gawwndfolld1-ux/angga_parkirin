<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kendaraan Tamu Hotel - PARKIRIN</title>
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
                <div class="page-header">
                    <div>
                        <h1>Kendaraan Tamu Hotel</h1>
                        <p>Kelola kendaraan milik tamu atau karyawan yang terdaftar di hotel.</p>
                    </div>
                    <div class="actions">
                        <a class="btn btn-green" href="index.php?page=kendaraan&aksi=tambah">+ Tambah Kendaraan</a>
                    </div>
                </div>
                <?php if (isset($_GET['error'])): ?>
                    <div class="error">
                        <?= htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
                <div class="table-card">
                    <table class="crud-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Plat Nomor</th>
                                <th>Jenis</th>
                                <th>Warna</th>
                                <th>Tamu / Karyawan</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($dataKendaraan)):
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <b><?= htmlspecialchars($row['plat_nomor']); ?></b>
                                </td>
                                <td><?= ucfirst(htmlspecialchars($row['jenis_kendaraan'])); ?></td>
                                <td><?= htmlspecialchars($row['warna'] ? $row['warna'] : '-'); ?></td>
                                <td><?= htmlspecialchars($row['pemilik'] ? $row['pemilik'] : '-'); ?></td>
                                <td><?= ucfirst(htmlspecialchars($row['role'] ? $row['role'] : '-')); ?></td>
                                <td class="action-cell">
                                    <a
                                        class="link-edit"
                                        href="index.php?page=kendaraan&aksi=edit&id=<?= (int)$row['id_kendaraan']; ?>"
                                    >
                                        Edit
                                    </a>
                                    &nbsp;
                                    <a
                                        class="link-delete"
                                        href="index.php?page=kendaraan&aksi=hapus&id=<?= (int)$row['id_kendaraan']; ?>"
                                        onclick="return confirm('Anda yakin ingin menghapus kendaraan ini?');"
                                    >
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
