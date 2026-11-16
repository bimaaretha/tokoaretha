<?php
    session_start();

    // Wajib login. exit penting supaya kode di bawah tidak ikut jalan.
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    include 'koneksi.php';
    include 'fungsi.php';

    $query = "SELECT * FROM product ORDER BY id DESC";
    $sql = mysqli_query($koneksi, $query);

    $produk = [];
    while ($data = mysqli_fetch_assoc($sql)) {
        $produk[] = $data;
    }

    // Pesan hasil aksi (dikirim lewat ?status=...)
    $daftar_pesan = [
        "tambah"      => ["pesan-sukses", "Produk berhasil ditambahkan."],
        "update"      => ["pesan-sukses", "Produk berhasil diupdate."],
        "hapus"       => ["pesan-sukses", "Produk berhasil dihapus."],
        "gambar_gagal" => ["pesan-gagal", "Upload gambar gagal. Gunakan JPG/PNG/WEBP maksimal 2 MB."],
        "kosong"      => ["pesan-gagal", "Nama dan harga produk wajib diisi."]
    ];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Toko Amba</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="container">
        <h1>Selamat datang, <?= e($_SESSION['nama_akun']) ?> 👋</h1>

        <?php if (isset($_GET['status']) && isset($daftar_pesan[$_GET['status']])) { ?>
            <div class="pesan <?= $daftar_pesan[$_GET['status']][0] ?>">
                <?= $daftar_pesan[$_GET['status']][1] ?>
            </div>
        <?php } ?>

        <div class="box">
            <h2>Tambah Produk</h2>
            <form action="create.php" method="POST" enctype="multipart/form-data">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" placeholder="Masukkan nama produk..." required>

                <label for="deskripsi_produk">Deskripsi</label>
                <textarea name="deskripsi_produk" id="deskripsi_produk"></textarea>

                <label for="harga_produk">Harga</label>
                <input type="number" name="harga_produk" id="harga_produk" placeholder="Masukkan harga produk" min="0" required>

                <label for="gambar_produk">Gambar Produk</label>
                <input type="file" name="gambar_produk" id="gambar_produk" accept="image/*" required>

                <button type="submit" name="simpan" class="btn">Simpan Produk</button>
            </form>
        </div>

        <div class="box">
            <h2>Daftar Produk (<?= count($produk) ?>)</h2>
            <div class="tabel-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($produk); $i++) { ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><img src="<?= alamatGambar($produk[$i]['gambar']) ?>" alt=""></td>
                                <td><?= e($produk[$i]['nama']) ?></td>
                                <td><?= e(potong($produk[$i]['deskripsi'], 50)) ?></td>
                                <td><?= rupiah($produk[$i]['harga']) ?></td>
                                <td>
                                    <a href="detail.php?id=<?= (int) $produk[$i]['id'] ?>" class="btn btn-biru">Detail</a>
                                    <a href="edit.php?id=<?= (int) $produk[$i]['id'] ?>" class="btn">Edit</a>
                                    <a href="delete.php?id=<?= (int) $produk[$i]['id'] ?>" class="btn btn-merah" onclick="return konfirmasiHapus()">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (count($produk) == 0) { ?>
                            <tr><td colspan="6">Belum ada produk.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function konfirmasiHapus(){
            let yakin = confirm("Apakah anda yakin ingin menghapus data ini?")

            if(yakin == true){
                return true
            }else{
                return false
            }
        }
    </script>
</body>
</html>
