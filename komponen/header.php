<header>
    <nav>
        <a href="./" class="home-link">
            <img src="<?= $basePath ?>assets/logo.svg" alt="Logo" class="logo"/>
            <span>Jelajah<br/>Pustaka</span>
        </a>

        <div class="spacer"></div>

        <ul>
            <li><a href="<?= $basePath ?>">Beranda</a></li>

            <?php if ($pengguna = pengguna()): ?>
                <?php if ($pengguna->getAdmin()): ?>
                    <li><a href="<?= $basePath ?>admin/buku.php">Daftar Buku</a></li>
                <?php endif ?>

                <li><a href="<?= $basePath ?>keluar.php">Keluar</a></li>
            <?php else: ?>
                <li><a href="<?= $basePath ?>masuk.php">Masuk</a></li>
                <li><a href="<?= $basePath ?>daftar.php">Daftar</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>
