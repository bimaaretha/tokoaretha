<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    include 'koneksi.php';
    include 'fungsi.php';

    $id_edit = (int) ($_GET['id'] ?? 0);

    // Ambil data produk yang mau diedit
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM product WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_edit);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$data) {
        header("Location: dashboard.php");
        exit;
    }

    $error = "";

    if (isset($_POST['update'])) {

        $nama_produk = trim($_POST['nama_produk']);
        $deskripsi_produk = $_POST['deskripsi_produk'] ?? '';
        $harga_produk = (int) $_POST['harga_produk'];
        $gambar = $data['gambar']; // default: pakai gambar lama

        if ($nama_produk == "") {
            $error = "Nama produk wajib diisi.";
        }

        // Kalau user memilih gambar baru, upload dan ganti
        if ($error == "" && isset($_FILES['gambar_produk']) && $_FILES['gambar_produk']['error'] != 4) {
            $gambar_baru = uploadGambar($_FILES['gambar_produk']);

            if ($gambar_baru === false) {
                $error = "Upload gambar gagal. Gunakan JPG/PNG/WEBP maksimal 2 MB.";
            } else {
                $gambar = $gambar_baru;
            }
        }

        if ($error == "") {
            $stmt_update = mysqli_prepare($koneksi, "UPDATE product SET nama = ?, deskripsi = ?, harga = ?, gambar = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt_update, "ssisi", $nama_produk, $deskripsi_produk, $harga_produk, $gambar, $id_edit);
            mysqli_stmt_execute($stmt_update);

            header("Location: dashboard.php?status=update");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Toko Amba</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="container">
        <div class="box" style="max-width:600px; margin:0 auto;">
            <h2>Edit Produk: <?= e($data['nama']) ?></h2>

            <?php if ($error != "") { ?>
                <div class="pesan pesan-gagal"><?= $error ?></div>
            <?php } ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" value="<?= e($data['nama']) ?>" required>

                <label for="deskripsi_produk">Deskripsi Produk</label>
                <textarea name="deskripsi_produk" id="deskripsi_produk"><?= e($data['deskripsi']) ?></textarea>

                <label for="harga_produk">Harga Produk</label>
                <input type="number" name="harga_produk" id="harga_produk" value="<?= (int) $data['harga'] ?>" min="0" required>

                <label>Gambar Saat Ini</label>
                <img src="<?= alamatGambar($data['gambar']) ?>" alt="" width="120" style="border-radius:6px;">

                <label for="gambar_produk">Ganti Gambar (opsional)</label>
                <input type="file" name="gambar_produk" id="gambar_produk" accept="image/*">

                <button type="submit" name="update" class="btn">Simpan Perubahan</button>
                <a href="dashboard.php" class="btn btn-abu">Batal</a>
            </form>
        </div>
    </main>
</body>
</html>
