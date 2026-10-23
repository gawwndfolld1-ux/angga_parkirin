<?php
require_once __DIR__ . '/../../config/auth.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapan Transaksi - PARKIRIN</title>
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
            <nav><?php renderNavigation(); ?></nav>
        </aside>
        <main class="content">
            <div class="page-header">
                <div>
                    <h1>Rekapan Transaksi</h1>
                    <p>Ringkasan transaksi parkir setiap bulan berdasarkan tahun yang dipilih.</p>
                </div>
            </div>
            <form method="get" class="filter-form">
                <input type="hidden" name="page" value="laporan">
                <div class="form-row">
                    <label for="tahun">Pilih tahun</label>
                    <select id="tahun" name="tahun">
                        <?php for ($opsiTahun = (int) date('Y'); $opsiTahun >= (int) $tahunAwal; $opsiTahun--): ?>
                            <option value="<?= $opsiTahun; ?>" <?= $opsiTahun === (int) $periode['tahun'] ? 'selected' : ''; ?>><?= $opsiTahun; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button class="btn btn-green" type="submit">Tampilkan Rekapan</button>
            </form>
            <div class="summary-grid">
                <div class="summary-box">
                    <span>Total Transaksi Tahun <?= (int) $periode['tahun']; ?></span>
                    <strong><?= (int) $summary['total_transaksi']; ?></strong>
                </div>
                <div class="summary-box">
                    <span>Masih Parkir</span>
                    <strong><?= (int) $summary['sedang_parkir']; ?></strong>
                </div>
                <div class="summary-box">
                    <span>Total Pendapatan</span>
                    <strong>Rp<?= number_format((int) $summary['total_pendapatan'], 0, ',', '.'); ?></strong>
                </div>
            </div>
            <div class="table-card">
                <table class="crud-table">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Transaksi</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rekapBulanan as $row): ?>
                            <tr>
                                <td>Bulan <?= (int) $row['nomor_bulan']; ?> — <?= htmlspecialchars($row['nama_bulan']); ?></td>
                                <td><?= (int) $row['jumlah_transaksi']; ?></td>
                                <td><b>Rp<?= number_format((int) $row['pendapatan'], 0, ',', '.'); ?></b></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p class="login-note" style="margin-top: 14px;">Bulan tanpa transaksi tetap ditampilkan dengan nilai 0. Pendapatan dihitung dari transaksi yang sudah selesai.</p>
        </main>
    </div>
</body>
</html>
