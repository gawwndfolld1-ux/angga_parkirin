<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Kendaraan - Parkirin</title>
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
                    <h2>Edit Data Kendaraan</h2>
                    <form method="POST" action="index.php?page=kendaraan&aksi=update">
                        <input type="hidden" name="id_kendaraan" value="<?= (int)$kendaraan['id_kendaraan']; ?>">
                        <div class="form-row">
                            <label for="plat_nomor">Plat Nomor</label>
                            <input
                                id="plat_nomor"
                                type="text"
                                name="plat_nomor"
                                value="<?= htmlspecialchars($kendaraan['plat_nomor']); ?>"
                                required
                            >
                        </div>
                        <div class="form-row">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <select id="jenis_kendaraan" name="jenis_kendaraan" required>
                                <option
                                    value="motor"
                                    <?= $kendaraan['jenis_kendaraan'] === 'motor' ? 'selected' : ''; ?>
                                >
                                    Motor
                                </option>
                                <option
                                    value="mobil"
                                    <?= $kendaraan['jenis_kendaraan'] === 'mobil' ? 'selected' : ''; ?>
                                >
                                    Mobil
                                </option>
                                <option
                                    value="lainnya"
                                    <?= $kendaraan['jenis_kendaraan'] === 'lainnya' ? 'selected' : ''; ?>
                                >
                                    Lainnya
                                </option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label for="warna">Warna</label>
                            <input id="warna" type="text" name="warna" value="<?= htmlspecialchars($kendaraan['warna']); ?>" required>
                        </div>
                        <div class="form-row">
                            <label for="pemilik">Nama Tamu / Karyawan Hotel</label>
                            <input id="pemilik" type="text" name="pemilik" value="<?= htmlspecialchars($kendaraan['pemilik']); ?>" required>
                        </div>
                        <div class="form-row">
                            <label for="id_user">Pengguna / Role</label>
                            <select id="id_user" name="id_user" required>
                                <?php while ($user=mysqli_fetch_assoc($dataUser)): ?>
                                    <option
                                        value="<?= (int)$user['id_user']; ?>"
                                        <?= (int)$user['id_user'] === (int)$kendaraan['id_user'] ? 'selected' : ''; ?>
                                    >
                                        <?= htmlspecialchars($user['nama_lengkap']); ?>
                                        - <?= ucfirst(htmlspecialchars($user['role'])); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-buttons">
                            <button class="btn btn-green" type="submit">Simpan Perubahan</button>
                            <a class="btn btn-back" href="index.php?page=kendaraan">Kembali</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>
