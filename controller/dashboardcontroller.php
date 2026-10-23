<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('owner', 'admin', 'petugas'));

require_once __DIR__ . '/../models/dashboard.php';

$dashboard = new Dashboard($conn);

$data = array(
    'jenis' => $dashboard->jumlahJenis(),
    'pengguna' => $dashboard->jumlahPengguna(),
    'hari_ini' => $dashboard->kendaraanHariIni(),
    'bulan_ini' => $dashboard->kendaraanBulanIni(),
    'tahun_ini' => $dashboard->kendaraanTahunIni(),
    'total_kendaraan' => $dashboard->totalKendaraan(),
    'pemasukan_hari_ini' => $dashboard->pemasukanHariIni(),
    'pemasukan_bulan_ini' => $dashboard->pemasukanBulanIni(),
    'pemasukan_tahun_ini' => $dashboard->pemasukanTahunIni(),
    'total_pemasukan' => $dashboard->totalPemasukan(),
    'parkir_masuk' => $dashboard->parkirMasuk(),
    'parkir_keluar' => $dashboard->parkirKeluar()
);

require __DIR__ . '/../views/dashboard.php';

?>
