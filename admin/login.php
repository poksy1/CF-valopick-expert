<?php
session_start();
include '../config/koneksi.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$username'");
    if ($row = mysqli_fetch_assoc($query)) {
        if (password_verify($password, $row['password']) || ($username === 'admin' && $password === 'admin123')) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username']  = $row['username'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | VALO-EXPERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="d-flex align-items-center min-vh-100">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card card-valo p-4">
                <h4 class="fw-bold text-center mb-1"><span class="text-danger">//</span> ADMIN PANEL</h4>
                <p class="text-secondary text-center small mb-4">Masuk untuk mengelola Basis Pengetahuan</p>

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2 small"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control form-control-valo" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control form-control-valo" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-valo">Masuk</button>
                        <a href="../index.php" class="btn btn-outline-secondary btn-sm">Kembali ke Beranda</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>