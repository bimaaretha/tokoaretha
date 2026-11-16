<?php
include 'koneksi.php';

    if(isset($_POST['tombol'])){
       $nama_produk = $_POST['nama_produk'];
       $deskripsi_produk = $_POST['deskripsi_produk'];
       $alamat = $_POST['alamat'];

       $query = "INSERT INTO challange (nama, deskripsi, alamat) VALUES ('$nama_produk', '$deskripsi_produk', '$alamat')";
       mysqli_query($koneksi, $query);
    }