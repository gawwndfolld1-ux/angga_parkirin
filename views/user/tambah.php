<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tambah Pengguna - Parkirin</title>
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
                <div class="form-card">
                    <h2>Tambah Pengguna</h2>
                    <form method="POST" action="index.php?page=user&aksi=simpan">
                        <div class="form-row">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required>
                        </div>
                        <div class="form-row">
                            <label>Username</label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="form-row">
                            <label>Password</label>
                            <input type="text" name="password" required>
                        </div>
                        <div class="form-row">
                            <label>Role</label>
                            <select name="role" required>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                                <?php if (hasRole('owner')): ?>
                                    <option value="owner">Owner</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <label>Status</label>
                            <select name="status_aktif">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                        <div class="form-buttons">
                            <button class="btn btn-green" type="submit">Simpan</button>
                            <a class="btn btn-back" href="index.php?page=user">Kembali</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>
