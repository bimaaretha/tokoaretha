<?php
    // File ini TIDAK boleh menampilkan teks apa pun (echo),
    // kalau tidak header("Location: ...") di halaman lain akan gagal.
    $koneksi = mysqli_connect("localhost", "root", "", "toko_db");

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
