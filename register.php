<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
        header('Location: dashboard.php');
        exit;
    }

    // Daftar pesan error dari registerAction.php
    $daftar_error = [
        "kosong"  => "Semua kolom wajib diisi.",
        "email"   => "Format email tidak valid.",
        "pendek"  => "Password minimal 6 karakter.",
        "ada"     => "Email sudah terdaftar, gunakan email lain."
    ];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Toko Amba</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="box box-kecil">
        <h2>Halaman Register</h2>

        <?php if (isset($_GET['error']) && isset($daftar_error[$_GET['error']])) { ?>
            <div class="pesan pesan-gagal"><?= $daftar_error[$_GET['error']] ?></div>
        <?php } ?>

        <form action="registerAction.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="kolom_password">Password</label>
            <input type="password" name="password" id="kolom_password" required>
            <br><br>
            <input type="checkbox" id="cek_lihat" onclick="lihatPassword()">
            <label for="cek_lihat" style="display:inline; font-weight:normal;">Lihat password</label>
            <br>
            <button type="submit" name="daftar" class="btn">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </div>

    <script>
        function lihatPassword(){
            let lihat_password = document.getElementById("kolom_password")

            if(lihat_password.type == 'password'){
                lihat_password.type = 'text'
            }else{
                lihat_password.type = 'password'
            }
        }
    </script>
</body>
</html>
