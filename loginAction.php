<?php
    session_start();
    include "koneksi.php";

    if (isset($_POST['login'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepared statement: input user tidak langsung dimasukkan ke query (aman dari SQL Injection)
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($hasil);

        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true); // ganti ID session setelah login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama_akun'] = $user['username'];

            header('Location: dashboard.php');
            exit;
        } else {
            header('Location: login.php?error=1');
            exit;
        }
    }

    // Kalau halaman ini dibuka langsung tanpa submit form
    header('Location: login.php');
    exit;
