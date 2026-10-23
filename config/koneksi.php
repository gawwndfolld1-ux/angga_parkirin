<?php

mysqli_report(MYSQLI_REPORT_OFF);

$host = 'sql211.infinityfree.com';
$user = 'if0_43221124';
$pass = 'AnggaParkir';
$db   = 'if0_43221124_db_parkirin';
$port = 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');

?>
