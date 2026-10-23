<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Parkir Masuk - Parkirin</title>
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
                    <h2>Catat Parkir Masuk</h2>
                    <form method="POST" action="index.php?page=transaksi&aksi=simpan">
                        <div class="form-row">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <select id="jenis_kendaraan" name="jenis_kendaraan" required>
                                <option value="">-- Pilih Jenis Kendaraan --</option>
                                <option value="mobil">Mobil</option>
                                <option value="motor">Motor</option>
                                <option value="lainnya">Kendaraan Lainnya</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label for="plat_nomor">Plat Nomor</label>
                            <input id="plat_nomor" type="text" name="plat_nomor" maxlength="15" placeholder="Contoh: D 1234 ABC" required autocomplete="off">
                        </div>
                        <div class="form-row">
                            <label>Tarif</label>
                            <select name="id_tarif" id="id_tarif" required>
                                <option value="">-- Pilih Jenis Kendaraan Dahulu --</option>
                                <?php while ($t = mysqli_fetch_assoc($dataTarif)): ?>
                                    <option value="<?= (int)$t['id_tarif']; ?>" data-jenis="<?= htmlspecialchars($t['jenis_kendaraan']); ?>">
                                        <?= ucfirst(htmlspecialchars($t['jenis_kendaraan'])); ?> - Rp<?= number_format((int)$t['tarif_per_jam'], 0, ',', '.'); ?>/jam
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <label>Area Parkir</label>
                            <select name="id_area" required>
                                <option value="">-- Pilih Area --</option>
                                <?php while ($a = mysqli_fetch_assoc($dataArea)): ?>
                                    <option
                                        value="<?= (int)$a['id_area']; ?>"
                                        <?= (int)$a['terisi'] >= (int)$a['kapasitas'] ? 'disabled' : ''; ?>
                                    >
                                        Area <?= htmlspecialchars($a['nama_area']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <label>Waktu Masuk</label>
                            <input type="datetime-local" name="waktu_masuk" value="<?= date('Y-m-d\TH:i'); ?>" required>
                        </div>
                        <div class="form-buttons">
                            <button class="btn btn-green" type="submit">Simpan Parkir Masuk</button>
                            <a class="btn btn-back" href="index.php?page=transaksi">Kembali</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
        <script>
            const jenisKendaraan = document.getElementById('jenis_kendaraan');
            const tarifKendaraan = document.getElementById('id_tarif');
            const opsiTarif = Array.from(tarifKendaraan.options);
            function sesuaikanTarif() {
                const jenis = jenisKendaraan.value;
                tarifKendaraan.value = '';
                opsiTarif.forEach(function(opsi) {
                    if (!opsi.value) return;
                    opsi.hidden = opsi.dataset.jenis !== jenis;
                    opsi.disabled = opsi.dataset.jenis !== jenis;
                    if (opsi.dataset.jenis === jenis) tarifKendaraan.value = opsi.value;
                });
            }
            jenisKendaraan.addEventListener('change', sesuaikanTarif);
            sesuaikanTarif();
        </script>
    </body>
</html>
