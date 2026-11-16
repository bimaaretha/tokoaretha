<?php
    include 'koneksi.php';

    if (isset($_POST['daftar'])) {

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // 1. Validasi input
        if ($username == "" || $email == "" || $password == "") {
            header("Location: register.php?error=kosong");
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: register.php?error=email");
            exit;
        }
        if (strlen($password) < 6) {
            header("Location: register.php?error=pendek");
            exit;
        }

        // 2. Cek apakah email sudah dipakai
        $cek = mysqli_prepare($koneksi, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($cek, "s", $email);
        mysqli_stmt_execute($cek);
        $hasil_cek = mysqli_stmt_get_result($cek);

        if (mysqli_num_rows($hasil_cek) > 0) {
            header("Location: register.php?error=ada");
            exit;
        }

        // 3. Simpan user baru (password di-hash)
        $password_rahasia = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($koneksi, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_rahasia);
        mysqli_stmt_execute($stmt);

        header("Location: login.php?daftar=sukses");
        exit;
    }

    header("Location: register.php");
    exit;
