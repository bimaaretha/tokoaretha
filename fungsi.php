<?php
    // Fungsi bantu yang dipakai di banyak halaman

    // Mengamankan teks sebelum ditampilkan di HTML (mencegah XSS)
    function e($teks){
        return htmlspecialchars($teks ?? '');
    }

    // Format harga: 25000 -> Rp 25.000
    function rupiah($angka){
        return "Rp " . number_format($angka, 0, ',', '.');
    }

    // Memotong teks panjang: "Deskripsi yang sangat panjang..." 
    function potong($teks, $panjang){
        $teks = $teks ?? '';

        if (function_exists('mb_strimwidth')) {
            return mb_strimwidth($teks, 0, $panjang, '...');
        }
        if (strlen($teks) > $panjang) {
            return substr($teks, 0, $panjang) . "...";
        }
        return $teks;
    }

    // Alamat gambar produk (spasi di nama file diubah agar aman di URL)
    function alamatGambar($nama_file){
        return "tempat_gambar/" . rawurlencode($nama_file ?? '');
    }

    // Upload gambar produk. Mengembalikan nama file baru, atau false kalau gagal.
    function uploadGambar($file){
        if ($file['error'] != 0) {
            return false;
        }

        $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $boleh = ["jpg", "jpeg", "png", "webp"];

        if (!in_array($ekstensi, $boleh)) {
            return false;
        }
        if ($file['size'] > 2 * 1024 * 1024) { // maksimal 2 MB
            return false;
        }
        if (getimagesize($file['tmp_name']) === false) { // pastikan benar-benar gambar
            return false;
        }

        // Nama baru yang unik supaya tidak menimpa gambar lain
        $nama_baru = uniqid() . "." . $ekstensi;
        move_uploaded_file($file['tmp_name'], "tempat_gambar/" . $nama_baru);

        return $nama_baru;
    }
