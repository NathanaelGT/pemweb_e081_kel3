<header>
    <nav>
        <a href="./" class="home-link">
            <img src="<?= $basePath ?? './' ?>assets/logo.svg" alt="Logo" class="logo"/>
            <span>Jelajah<br/>Pustaka</span>
        </a>

        <div class="spacer"></div>

        <ul>
            <li><a href="./">Beranda</a></li>

            <?php if ($pengguna = pengguna()): ?>
                <?php if ($pengguna->getAdmin()): ?>
                    <li><a href="./admin/buku.php">Daftar Buku</a></li>
                <?php endif ?>

                <li><a href="./keluar.php">Keluar</a></li>
                <li><a href="./akun_pengguna.php">Profile</a></li>
            <?php else: ?>
                <li><a href="./masuk.php">Masuk</a></li>
                <li><a href="./daftar.php">Daftar</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>
