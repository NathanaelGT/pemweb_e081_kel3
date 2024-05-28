<?php
include './core/core.php';

$buku = Buku::cari($_GET['id']);
?>

<?php $head = <<<HTML
<title>Home</title>
HTML ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Detail Buku</title>
        <link rel="stylesheet" href="assets/detailinfobuku.css">
    </head>

    <body> 
        <?php include './komponen/open.php' ?>
        <?php include './komponen/header.php' ?>
        
        <div class="grid-atas">
            <div class="grid-item_atas">
                <h1>Detail Buku</h1>
            </div>
            <div class="button">
                <a href="review.php?id=<?= $buku->getId() ?>">Lihat Ulasan</a>
            </div>
            <div class="button1">
                <a href="review.php?id=<?= $buku->getId() ?>">Pinjam Buku</a>
            </div>
        </div>

        <div class="grid-container">
            <div class="grid-item">
                <div class="cover">
                    <img src="<?= $buku->getCover() ?>" alt="<?= $buku->getJudul() ?>"> 
                    <!-- diganti upload foto cover buku -->
                </div>
            </div>
            <div class="grid-item">
                <div class="kanan">
                    <h1><?= $buku->getJudul() ?></h1>
                    <p>Rating-wip</p>
                    <p>"<?= $buku->getSinopsis() ?>"</p>
                    <br>
                    <p><b>Detail Informasi</b></p>
                    <p>
                    <table>
                        <tr>
                            <td>Judul Buku</td>
                            <td>: <?= $buku->getJudul() ?></td>
                        </tr>
                        <tr>
                            <td>Penulis</td>
                            <td>: <?= $buku->getPenulis() ?></td>
                        </tr>
                        <tr>
                            <td>Penerbit</td>
                            <td>: <?= $buku->getPenerbit() ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Terbit</td>
                            <td>: <?= $buku->getTerbit()->format('Y-m-d') ?></td>
                        </tr>
                        <tr>
                            <td>ISBN</td>
                            <td>: <?= $buku->getIsbn() ?></td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>: <?= $buku->getKategori() ?></td>
                        </tr>
                        <tr>
                            <td>Stok Buku</td>
                            <td>: <?= (StokBuku::query(['id_buku', '=', $buku->getId()])) ? count(StokBuku::query(['id_buku', '=', $buku->getId()])) : 'Tidak tersedia' ?></td>
                        </tr>
                    </table>
                    </p>

                    <!-- Bagian Admin -->
                    <?php if ($isAdmin): ?>
                    <br>
                    <p><b>Admin Actions</b></p>
                    <div class="admin-buttons">
                        <div class="button">
                            <a href="edit_buku.php?id=<?= $buku->getId() ?>">Edit Buku</a>
                        </div>
                        <div class="button">
                            <a href="hapus_buku.php?id=<?= $buku->getId() ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus Buku</a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
