<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Transaksi Parkir - Parkirin</title>
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
                        <h1>Parkir Tamu Hotel</h1>
                        <p>Catat kendaraan tamu hotel yang masuk dan keluar. Area ini bukan untuk parkir umum.</p>
                    </div>
                    <div class="actions">
                        <a class="btn btn-green" href="index.php?page=transaksi&aksi=tambah">+ Parkir Masuk</a>
                    </div>
                </div>
                <?php if (isset($_GET['error'])): ?><div class="error">Data struk tidak ditemukan.</div><?php endif; ?>
                <div class="table-card">
                    <table class="crud-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Plat</th>
                                <th>Jenis</th>
                                <th>Area</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Durasi</th>
                                <th>Biaya</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while ($row=mysqli_fetch_assoc($dataTransaksi)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <b><?= htmlspecialchars($row['plat_nomor']?$row['plat_nomor']:'-'); ?></b>
                                </td>
                                <td><?= ucfirst(htmlspecialchars($row['jenis_kendaraan']?$row['jenis_kendaraan']:'-')); ?></td>
                                <td><?= htmlspecialchars($row['nama_area']?$row['nama_area']:'-'); ?></td>
                                <td><?= htmlspecialchars($row['waktu_masuk']?$row['waktu_masuk']:'-'); ?></td>
                                <td><?= htmlspecialchars($row['waktu_keluar']?$row['waktu_keluar']:'-'); ?></td>
                                <td><?= $row['durasi_jam'] !== null ? (int)$row['durasi_jam'].' jam' : '-'; ?></td>
                                <td>Rp<?= number_format((int)$row['biaya_total'],0,',','.'); ?></td>
                                <td>
                                    <span class="badge <?= $row['status']==='masuk'?'green':'blue'; ?>">
                                        <?= ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td class="action-cell">
                                    <a class="link-edit" target="_blank" href="index.php?page=transaksi&aksi=struk&id=<?= (int)$row['id_parkir']; ?>">Cetak Struk</a>
                                    <?php if ($row['status'] === 'masuk'): ?>
                                        &nbsp;
                                        <a
                                            class="btn btn-green"
                                            href="index.php?page=transaksi&aksi=keluar&id=<?= (int)$row['id_parkir']; ?>"
                                            onclick="return confirm('Proses kendaraan ini keluar sekarang?');"
                                        >Parkir Keluar</a>
                                    <?php endif; ?>
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
