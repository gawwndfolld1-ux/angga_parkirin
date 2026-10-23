<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ganti Password - Parkirin</title>
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
                    <h2>Ganti Password</h2>
                    <?php if ($error): ?>
                        <div class="error">
                            <?= htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="success">
                            <?= htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>
                <form method="POST" action="index.php?page=password">
                    <div class="form-row">
                        <label>Password Lama</label>
                        <input type="password" name="password_lama" required>
                    </div>
                    <div class="form-row">
                        <label>Password Baru</label>
                        <input type="password" name="password_baru" required>
                    </div>
                    <div class="form-row">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi" required>
                    </div>
                    <div class="form-buttons">
                        <button class="btn btn-green" type="submit">Simpan Password</button>
                        <a class="btn btn-back" href="index.php?page=dashboard">Kembali</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
