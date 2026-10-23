<?php

require_once __DIR__ . '/../config/auth.php';

?>
<?php
$error = isset($_GET['error']) ? $_GET['error'] : '';
$logout = isset($_GET['logout']) ? $_GET['logout'] : '';
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Parkirin</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-header">
                <h1>PARKIRIN</h1>
                <p>Parkir lebih tertata, aktivitas lebih mudah.</p>
            </div>
            <div class="login-body">
                <?php if ($logout): ?>
                    <div class="success">Anda berhasil logout dari akun.</div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="error">Username atau password salah.</div>
                <?php endif; ?>
                <form action="controller/logincontroller.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn-login">LOGIN</button>
                </form>
            </div>
        </div>
    </body>
</html>
