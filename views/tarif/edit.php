<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Tarif - Parkirin</title>
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
                    <h2>Edit Biaya Parkir</h2>
                    <form method="POST" action="index.php?page=tarif&aksi=update">
                        <input type="hidden" name="id_tarif" value="<?= (int)$tarif['id_tarif']; ?>">
                        <div class="form-row">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <select id="jenis_kendaraan" name="jenis_kendaraan" required>
                                <option
                                    value="motor"
                                    <?= $tarif['jenis_kendaraan'] === 'motor' ? 'selected' : ''; ?>
                                >
                                    Motor
                                </option>
                                <option
                                    value="mobil"
                                    <?= $tarif['jenis_kendaraan'] === 'mobil' ? 'selected' : ''; ?>
                                >
                                    Mobil
                                </option>
                                <option
                                    value="lainnya"
                                    <?= $tarif['jenis_kendaraan'] === 'lainnya' ? 'selected' : ''; ?>
                                >
                                    Lainnya
                                </option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label for="tarif_per_jam">Tarif per Jam</label>
                            <input
                                id="tarif_per_jam"
                                type="number"
                                name="tarif_per_jam"
                                min="0"
                                value="<?= (int)$tarif['tarif_per_jam']; ?>"
                                required
                            >
                        </div>
                        <div class="form-buttons">
                            <button class="btn btn-green" type="submit">Simpan Perubahan</button>
                            <a class="btn btn-back" href="index.php?page=tarif">Kembali</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>
