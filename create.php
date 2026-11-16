<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    include 'koneksi.php';
    include 'fungsi.php';

    if (isset($_POST['simpan'])) {
        $nama_produk = trim($_POST['nama_produk']);
        $deskripsi_produk = $_POST['deskripsi_produk'] ?? '';
        $harga_produk = (int) $_POST['harga_produk'];

        if ($nama_produk == "") {
            header("Location: dashboard.php?status=kosong");
            exit;
        }

        // Upload gambar (sudah divalidasi di fungsi uploadGambar)
        $gambar = uploadGambar($_FILES['gambar_produk']);

        if ($gambar === false) {
            header("Location: dashboard.php?status=gambar_gagal");
            exit;
        }

        $stmt = mysqli_prepare($koneksi, "INSERT INTO product (nama, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssis", $nama_produk, $deskripsi_produk, $harga_produk, $gambar);
        mysqli_stmt_execute($stmt);

        header("Location: dashboard.php?status=tambah");
        exit;
    }

    header("Location: dashboard.php");
    exit;
