<?php

include './core/core.php';

$filter = array_filter([
    isset($_GET['kategori']) && $_GET['kategori'] ? ['kategori', '=', $_GET['kategori']] : null,
    isset($_GET['kueri']) && $_GET['kueri'] ? ['judul', 'LIKE', "%$_GET[kueri]%"] : null,
]);

$daftarBuku = Buku::query(...$filter);

$daftarBukuKategori = array_group(fn (Buku $buku) => [
    $buku->getKategori() => $buku,
], $daftarBuku);

$daftarKategori = $filter
    ? array_map(fn (array $k) => $k['kategori'], Database::query('SELECT DISTINCT kategori FROM buku'))
    : array_keys($daftarBukuKategori);

if (empty($daftarBukuKategori)) {
    $stok = [];
    $penilaian = [];
} else {
    $idBukuTerescape = Database::escape(
        array_map(fn (Buku $buku) => $buku->getId(), $daftarBuku)
    );

    $stok = array_map_with_keys(fn (array $stok) => [
        $stok['id_buku'] => (int) $stok['stok'],
    ], Database::query(
        'SELECT id_buku, COUNT(*) AS stok FROM stok_buku WHERE id_buku IN ' . $idBukuTerescape . ' GROUP BY id_buku'
    ));

    $penilaian = array_map_with_keys(fn (array $penilaian) => [
        $penilaian['id_buku'] => (float) $penilaian['penilaian'],
    ], Database::query(
        'SELECT id_buku, (SUM(penilaian) / COUNT(*)) AS penilaian FROM penilaian WHERE id_buku IN ' . $idBukuTerescape . ' GROUP BY id_buku'
    ));
}

$judulHalaman = 'Katalog Buku Perpustakaan';
$head = <<<HTML
<title>Home</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>
<?php include './komponen/subheader.php' ?>

<?php if (empty($daftarBukuKategori)): ?>
    <div class="jumbotron">
        <p>Tidak ada buku yang ditemukan</p>
    </div>
<?php else: ?>
    <?php foreach ($daftarBukuKategori as $kategori => $daftarBuku): ?>
        <section class="page-section">
            <h2 class="page-section__title"><?= $kategori ?></h2>

            <div class="page-section__content">
                <?php /** @var Buku $buku */ ?>
                <?php foreach ($daftarBuku as $buku): ?>
                    <div class="book-overview">
                        <a href="./detailbuku.php?id=<?= $buku->getId() ?>">
                            <img
                                src="<?= $buku->getCover() ?>"
                                alt="Poster <?= $buku->getJudul() ?>"
                                class="book-overview__image"
                            />
                        </a>

                        <div class="book-overview__info">
                            <h3 class="book-overview__title">
                                <a href="./detailbuku.php?id=<?= $buku->getId() ?>">
                                    <?= $buku->getJudul() ?>
                                </a>
                            </h3>
                            <div class="book-overview__rating">
                                <?php $rating = $penilaian[$buku->getId()] ?? null ?>
                                <?php include './komponen/rating.php' ?>

                                <a href="#" class="book-overview__rating__review">Lihat ulasan</a>
                            </div>

                            <table class="book-overview__table">
                                <tr>
                                    <td>Stok</td>
                                    <td>: <?= $stok[$buku->getId()] ?? 0 ?></td>
                                </tr>
                                <tr>
                                    <td>Kategori</td>
                                    <td>: <?= $kategori ?></td>
                                </tr>
                                <tr>
                                    <td>Penulis</td>
                                    <td>: <?= $buku->getPenulis() ?></td>
                                </tr>
                            </table>

                            <p class="book-overview__synopsis">
                                “<?= $buku->getSinopsis() ?>”
                            </p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </section>
    <?php endforeach ?>
<?php endif ?>

<?php include './komponen/close.php' ?>
