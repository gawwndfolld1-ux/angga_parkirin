<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Area - Parkirin</title>
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
                    <h2>Edit Area Parkir</h2>
                    <form method="POST" action="index.php?page=area&aksi=update">
                        <input type="hidden" name="id_area" value="<?= (int)$area['id_area']; ?>">
                        <div class="form-row">
                            <label>Nama Area</label>
                            <input type="text" name="nama_area" value="<?= htmlspecialchars($area['nama_area']); ?>" required>
                        </div>
                        <div class="form-row">
                            <label>Kapasitas</label>
                            <input type="number" name="kapasitas" min="1" value="<?= (int)$area['kapasitas']; ?>" required>
                        </div>
                        <div class="form-row">
                            <label>Terisi</label>
                            <input type="number" name="terisi" min="0" value="<?= (int)$area['terisi']; ?>" required>
                        </div>
                        <div class="form-buttons">
                            <button class="btn btn-green" type="submit">Simpan Perubahan</button>
                            <a class="btn btn-back" href="index.php?page=area">Kembali</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>
