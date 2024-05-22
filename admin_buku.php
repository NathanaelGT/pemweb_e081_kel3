<?php
include 'core.php';

$bukuList = Buku::semua();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Daftar Buku</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Katalog Buku Perpustakaan</h1>
            <a href="tambah_buku.php" class="btn">Tambah Buku</a>
        </header>

        <div class="book-list">
            <?php foreach ($bukuList as $buku): ?>
                <div class="book-item">
                    <img src="cover.jpg" alt="<?= $buku->getJudul() ?>">
                    <div class="book-details">
                        <h2><?= $buku->getJudul() ?></h2>
                        <?php
                        $stokBuku = StokBuku::query(['id_buku', '=', $buku->getId()]);
                        if (isset($stokBuku[0])) {
                            $jumlahStok = $stokBuku[0]->getJumlah();
                        } else {
                            $jumlahStok = 'Tidak tersedia';
                        }
                        ?>
                        <p>Stok: <?= $jumlahStok ?></p>
                        <p>Kategori: <?= $buku->getKategori() ?></p>
                        <p>Penulis: <?= $buku->getPenulis() ?></p>
                        <p><?= $buku->getSinopsis() ?></p>
                        <a href="edit_buku.php?id=<?= $buku->getId() ?>" class="btn">Edit Buku</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
