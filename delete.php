<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    include 'koneksi.php';

    $id_produk = (int) ($_GET['id'] ?? 0);

    $stmt = mysqli_prepare($koneksi, "DELETE FROM product WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_produk);
    mysqli_stmt_execute($stmt);

    header("Location: dashboard.php?status=hapus");
    exit;
