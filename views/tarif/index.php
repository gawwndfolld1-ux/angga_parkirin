<?php

require_once __DIR__ . '/../../config/auth.php';

?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Biaya Parkir - Parkirin</title>
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
                        <h1>Tarif Parkir Hotel</h1>
                        <p>Atur tarif per jam berdasarkan jenis kendaraan.</p>
                    </div>
                    <div class="actions">
                        <a class="btn btn-green" href="index.php?page=tarif&aksi=tambah">+ Tambah Tarif</a>
                    </div>
                </div>
                <div class="summary-grid">
                    <?php
                    $ringkas = array();

                    while ($t = mysqli_fetch_assoc($dataTarif)) {
                        $ringkas[$t['jenis_kendaraan']] = (int) $t['tarif_per_jam'];
                    }
                    ?>
                    <div class="summary-box">
                        <span>Tarif Motor</span>
                        <strong>Rp<?= number_format(isset($ringkas['motor'])?$ringkas['motor']:0,0,',','.'); ?></strong>
                    </div>
                    <div class="summary-box">
                        <span>Tarif Mobil</span>
                        <strong>Rp<?= number_format(isset($ringkas['mobil'])?$ringkas['mobil']:0,0,',','.'); ?></strong>
                    </div>
                    <div class="summary-box">
                        <span>Tarif Lainnya</span>
                        <strong>Rp<?= number_format(isset($ringkas['lainnya'])?$ringkas['lainnya']:0,0,',','.'); ?></strong>
                    </div>
                </div>
                <?php mysqli_data_seek($dataTarif,0); ?>
                <div class="table-card">
                    <table class="crud-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Kendaraan</th>
                                <th>Tarif / Jam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($dataTarif)):
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= ucfirst(htmlspecialchars($row['jenis_kendaraan'])); ?></td>
                                <td>
                                    <b>Rp<?= number_format((int)$row['tarif_per_jam'],0,',','.'); ?></b>
                                </td>
                                <td class="action-cell">
                                    <a
                                        class="link-edit"
                                        href="index.php?page=tarif&aksi=edit&id=<?= (int)$row['id_tarif']; ?>"
                                    >
                                        Edit
                                    </a>
                                    &nbsp;
                                    <a
                                        class="link-delete"
                                        href="index.php?page=tarif&aksi=hapus&id=<?= (int)$row['id_tarif']; ?>"
                                        onclick="return confirm('Anda yakin ingin menghapus tarif ini?');"
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
