<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Area Parkir - Parkirin</title>
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
                        <h1>Area Parkir Hotel</h1>
                        <p>Kelola kapasitas dan jumlah kendaraan pada setiap area.</p>
                    </div>
                    <div class="actions">
                        <a class="btn btn-green" href="index.php?page=area&aksi=tambah">+ Tambah Area</a>
                    </div>
                </div>
                <div class="table-card">
                    <table class="crud-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Area</th>
                                <th>Kapasitas</th>
                                <th>Terisi</th>
                                <th>Tersedia</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;

                            while ($row = mysqli_fetch_assoc($dataArea)):
                                $tersedia = max(
                                    0,
                                    (int) $row['kapasitas'] - (int) $row['terisi']
                                );
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <b>Area <?= htmlspecialchars($row['nama_area']); ?></b>
                                </td>
                                <td><?= (int)$row['kapasitas']; ?></td>
                                <td><?= (int)$row['terisi']; ?></td>
                                <td>
                                    <span class="badge <?= $tersedia>0?'green':'red'; ?>"><?= $tersedia; ?> slot</span>
                                </td>
                                <td class="action-cell">
                                    <a
                                        class="link-edit"
                                        href="index.php?page=area&aksi=edit&id=<?= (int)$row['id_area']; ?>"
                                    >
                                        Edit
                                    </a>
                                    &nbsp;
                                    <a
                                        class="link-delete"
                                        href="index.php?page=area&aksi=hapus&id=<?= (int)$row['id_area']; ?>"
                                        onclick="return confirm('Anda yakin ingin menghapus area ini?');"
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
