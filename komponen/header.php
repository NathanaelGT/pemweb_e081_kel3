<header style="view-transition-name: header">
    <nav>
        <a href="<?= $basePath ?>" class="home-link">
            <img src="<?= $basePath ?>assets/logo.svg" alt="Logo" class="logo"/>
            <span>Jelajah<br/>Pustaka</span>
        </a>

        <div class="spacer"></div>

        <ul>
            <?php if (pengguna()?->getAdmin()): ?>
                <li><a href="<?= $basePath ?>admin/buku.php">Daftar Buku</a></li>
                <li><a href="<?= $basePath ?>admin/pengguna.php">Daftar Pengguna</a></li>
            <?php endif ?>

            <li><a href="<?= $basePath ?>">Beranda</a></li>

            <?php if (pengguna()): ?>
                <li><a href="<?= $basePath ?>koleksi_buku_saya.php">Koleksi Saya</a></li>

                <li><a href="<?= $basePath ?>keluar.php">Keluar</a></li>
                <li><a href="<?= $basePath ?>akun_pengguna.php">Profile</a></li>
            <?php else: ?>
                <li><a href="<?= $basePath ?>masuk.php">Masuk</a></li>
                <li><a href="<?= $basePath ?>daftar.php">Daftar</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>
