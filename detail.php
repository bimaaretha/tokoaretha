<?php
    session_start();
    include 'koneksi.php';
    include 'fungsi.php';

    // (int) memastikan id selalu angka
    $id_produk = (int) ($_GET['id'] ?? 0);

    $stmt = mysqli_prepare($koneksi, "SELECT * FROM product WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_produk);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($hasil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Toko Amba</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="container">
        <?php if ($data) { ?>
            <div class="box detail">
                <img src="<?= alamatGambar($data['gambar']) ?>" alt="<?= e($data['nama']) ?>">
                <div class="teks">
                    <h1><?= e($data['nama']) ?></h1>
                    <h2 class="harga"><?= rupiah($data['harga']) ?></h2>
                    <p><?= nl2br(e($data['deskripsi'])) ?></p>
                    <a href="index.php" class="btn btn-abu">&laquo; Kembali</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="box">
                <h2>Produk tidak ditemukan</h2>
                <a href="index.php" class="btn">Kembali ke beranda</a>
            </div>
        <?php } ?>
    </main>
</body>
</html>
