<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
        header('Location: dashboard.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Amba</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="box box-kecil">
        <h2>Halaman Login</h2>

        <?php if (isset($_GET['error'])) { ?>
            <div class="pesan pesan-gagal">Email atau password salah.</div>
        <?php } ?>
        <?php if (isset($_GET['daftar'])) { ?>
            <div class="pesan pesan-sukses">Registrasi berhasil, silakan login.</div>
        <?php } ?>

        <form action="loginAction.php" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="kolom_password">Password</label>
            <input type="password" name="password" id="kolom_password" required>
            <br><br>
            <input type="checkbox" id="cek_lihat" onclick="lihatPassword()">
            <label for="cek_lihat" style="display:inline; font-weight:normal;">Lihat password</label>
            <br>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Register</a></p>
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
