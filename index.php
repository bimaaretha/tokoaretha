<?php
    session_start();
    include 'koneksi.php';
    include 'fungsi.php';

    $query = "SELECT * FROM product ORDER BY id DESC";
    $sql = mysqli_query($koneksi, $query);

    $produk = [];
    while ($data = mysqli_fetch_assoc($sql)) {
        $produk[] = $data;
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Amba</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <header class="hero">
        <h1>Selamat datang di Toko Amba</h1>
        <p>Temukan produk pilihan dengan harga terbaik</p>
    </header>

    <main class="container">
        <h2 class="judul-section">Produk Kami</h2>

        <div class="produk-container">
            <?php if (count($produk) > 0) { ?>
                <?php foreach ($produk as $p) { ?>
                    <div class="produk-card">
                        <img src="<?= alamatGambar($p['gambar']) ?>" alt="<?= e($p['nama']) ?>">
                        <div class="produk-info">
                            <h3><?= e($p['nama']) ?></h3>
                            <p><?= e(potong($p['deskripsi'], 60)) ?></p>
                            <div class="harga"><?= rupiah($p['harga']) ?></div>
                            <br>
                            <a href="detail.php?id=<?= (int) $p['id'] ?>" class="btn">Lihat Detail</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>Belum ada produk.</p>
            <?php } ?>
        </div>
    </main>

    <footer class="footer">
        &copy; <?= date('Y') ?> Toko Amba
    </footer>
</body>
</html>
