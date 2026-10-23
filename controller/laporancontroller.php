<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('owner'));

$tahun = isset($_GET['tahun']) && preg_match('/^\d{4}$/', $_GET['tahun'])
    ? (int) $_GET['tahun']
    : (int) date('Y');
$tahun = max(2000, min(2100, $tahun));
$tahunEsc = mysqli_real_escape_string($conn, (string) $tahun);
$tahunAwalResult = mysqli_query($conn, "SELECT MIN(YEAR(waktu_masuk)) AS tahun_awal FROM tb_transaksi");
$tahunAwalData = $tahunAwalResult ? mysqli_fetch_assoc($tahunAwalResult) : array('tahun_awal' => null);
$tahunAwal = !empty($tahunAwalData['tahun_awal']) ? (int) $tahunAwalData['tahun_awal'] : (int) date('Y') - 10;
$tahunAwal = min($tahunAwal, (int) date('Y') - 10);

$summaryQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total_transaksi,
            COALESCE(SUM(CASE WHEN status='keluar' THEN biaya_total ELSE 0 END), 0) AS total_pendapatan,
            COALESCE(SUM(status='masuk'), 0) AS sedang_parkir,
            COALESCE(SUM(status='keluar'), 0) AS selesai
     FROM tb_transaksi
     WHERE YEAR(waktu_masuk) = '$tahunEsc'"
);
$summary = $summaryQuery ? mysqli_fetch_assoc($summaryQuery) : array(
    'total_transaksi' => 0,
    'total_pendapatan' => 0,
    'sedang_parkir' => 0,
    'selesai' => 0
);

$dataLaporan = mysqli_query(
    $conn,
    "SELECT MONTH(waktu_masuk) AS nomor_bulan,
            COUNT(*) AS jumlah_transaksi,
            COALESCE(SUM(CASE WHEN status='keluar' THEN biaya_total ELSE 0 END), 0) AS pendapatan
     FROM tb_transaksi
     WHERE YEAR(waktu_masuk) = '$tahunEsc'
     GROUP BY MONTH(waktu_masuk)
     ORDER BY nomor_bulan ASC"
);

$namaBulan = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$rekapBulanan = array();
for ($bulan = 1; $bulan <= 12; $bulan++) {
    $rekapBulanan[$bulan] = array(
        'nomor_bulan' => $bulan,
        'nama_bulan' => $namaBulan[$bulan],
        'jumlah_transaksi' => 0,
        'pendapatan' => 0
    );
}
if ($dataLaporan) {
    while ($row = mysqli_fetch_assoc($dataLaporan)) {
        $bulan = (int) $row['nomor_bulan'];
        $rekapBulanan[$bulan]['jumlah_transaksi'] = (int) $row['jumlah_transaksi'];
        $rekapBulanan[$bulan]['pendapatan'] = (int) $row['pendapatan'];
    }
}

$periode = array('tahun' => $tahun);
require __DIR__ . '/../views/laporan/index.php';

?>
