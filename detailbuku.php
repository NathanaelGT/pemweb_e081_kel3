<?php
include './core/core.php';

$buku = Buku::cari($_GET['id']);
?>

<?php $head = <<<HTML
<title>Detail Buku {$buku->getJudul()}</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<section class="page-title">
    <h1 class="page-title__title">Detail Buku</h1>

    <div class="page-title__content">
        <a href="review.php?id=<?= $buku->getId() ?>" class="btn btn--yellow">Lihat Ulasan</a>
        <a href="review.php?id=<?= $buku->getId() ?>" class="btn btn--blue">Pinjam Buku</a>
    </div>
</section>

<div class="book-detail__wrapper">
    <div class="book-detail">
        <img
            src="<?= $buku->getCover() ?>"
            alt="Poster <?= $buku->getJudul() ?>"
            class="book-detail__image"
        />

        <div class="book-detail__content">
            <h2 class="book-detail__title"><?= $buku->getJudul() ?></h2>

            <div class="book-detail__rating">
                <?php $rating = Database::query('SELECT (SUM(penilaian) / COUNT(*)) AS penilaian FROM penilaian WHERE id_buku = ' . $buku->getId())[0]['penilaian'] ?>
                <?php include './komponen/rating.php' ?>
            </div>

            <p class="book-detail__synopsis">
                “<?= $buku->getSinopsis() ?>”
            </p>

            <section class="book-detail__info">
                <h3 class="book-detail__info__title">Detail Informasi</h3>

                <table class="book-detail__info__table">
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
                        <td>: <?= Database::query('SELECT COUNT(*) as aggregate FROM stok_buku WHERE id_buku = ' . $buku->getId())[0]['aggregate'] ?></td>
                    </tr>
                </table>
            </section>
        </div>
    </div>
</div>