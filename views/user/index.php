<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Pengguna - Parkirin</title>
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
                        <h1>Data Pengguna</h1>
                        <p>Kelola akun Admin, Petugas, dan Owner.</p>
                    </div>
                    <div class="actions">
                        <a class="btn btn-green" href="index.php?page=user&aksi=tambah">+ Tambah Pengguna</a>
                    </div>
                </div>
                <div class="table-card">
                    <table class="crud-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($dataUser)):
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <b><?= htmlspecialchars($row['nama_lengkap']); ?></b>
                                </td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= ucfirst(htmlspecialchars($row['role'])); ?></td>
                                <td>
                                    <span class="badge <?= $row['status_aktif']?'green':'red'; ?>">
                                        <?= $row['status_aktif']?'Aktif':'Nonaktif'; ?>
                                    </span>
                                </td>
                                <td class="action-cell">
                                    <a
                                        class="link-edit"
                                        href="index.php?page=user&aksi=edit&id=<?= (int)$row['id_user']; ?>"
                                    >
                                        Edit
                                    </a>

                                    <?php if ((int) $row['id_user'] !== (int) $_SESSION['id_user']): ?>
                                        <a
                                            class="link-delete"
                                            href="index.php?page=user&aksi=hapus&id=<?= (int)$row['id_user']; ?>"
                                            onclick="return confirm('Anda yakin ingin menghapus pengguna ini?');"
                                        >
                                            Hapus
                                        </a>
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
