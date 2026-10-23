<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/auth.php';
requireRole(array('admin'));

require_once __DIR__ . '/../models/log.php';

$model = new LogAktivitas($conn);
$dataLog = $model->getAll();

require __DIR__ . '/../views/log/index.php';

?>
