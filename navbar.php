<?php
    // Navbar dipakai di banyak halaman. Pastikan session_start() sudah dipanggil sebelum include file ini.
?>
<nav class="navbar">
    <a href="index.php" class="logo">🛍️ Toko Amba</a>
    <div class="menu">
        <a href="index.php">Beranda</a>
        <?php if (isset($_SESSION['user_id'])) { ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php } ?>
    </div>
</nav>
