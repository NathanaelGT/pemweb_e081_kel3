<?php
include './core/core.php';

$buku = Buku::cari(@$_GET['id']);

$head = <<<HTML
<title>Detail Buku {$buku->getJudul()}</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<section class="page-title">
    <h1 class="page-title__title">Detail Buku</h1>

    <div class="page-title__content">
        <a
            href="review.php?id=<?= $buku->getId() ?>"
            style="view-transition-name: subheader-item-1"
            class="btn btn--yellow"
        >
            Lihat Ulasan
        </a>
        <?php if (pengguna() !== null): ?>
            <?php if (!empty(Peminjaman::query(['id_buku', '=', $buku], ['id_pengguna', '=', pengguna()], ['tanggal_dikembalikan', 'is', null]))): ?>
                <a
                    href="kembalikan_buku.php?id=<?= $buku->getId() ?>"
                    style="view-transition-name: subheader-item-2"
                    class="btn btn--blue"
                >
                    Kembalikan Buku
                </a>
            <?php elseif(empty(StokBuku::query(['id_buku', '=', $buku], ['id_peminjaman', 'is', null]))): ?>
                <button
                    disabled
                    title="Stok buku ini sedang tidak tersedia"
                    style="view-transition-name: subheader-item-2"
                    class="btn btn--blue"
                >
                    Pinjam Buku
                </button>
            <?php else: ?>
                <a
                    href="pinjam_buku.php?id=<?= $buku->getId() ?>"
                    style="view-transition-name: subheader-item-2"
                    class="btn btn--blue"
                >
                    Pinjam Buku
                </a>
            <?php endif ?>
        <?php endif ?>
    </div>
</section>

<div class="book-detail__wrapper">
    <div class="book-detail">
        <img
            src="<?= $buku->getCover() ?>"
            alt="Poster <?= $buku->getJudul() ?>"
            class="book-detail__image"
            style="view-transition-name: buku-cover-<?= $buku->getId() ?>"
        />

        <div class="book-detail__content">
            <div class="book-detail__header">
                <div>
                    <h2
                        style="view-transition-name: buku-judul-<?= $buku->getId() ?>"
                        class="book-detail__title"
                    >
                        <?= $buku->getJudul() ?>
                    </h2>

                    <div class="book-detail__rating">
                        <?php $rating = Database::query('SELECT (SUM(penilaian) / COUNT(*)) AS penilaian FROM penilaian WHERE id_buku = ' . $buku->getId())[0]['penilaian'] ?>
                        <?php include './komponen/rating.php' ?>
                    </div>
                </div>

                <div>
                    <?php include './komponen/info.php' ?>
                </div>
            </div>

            <p style="view-transition-name: buku-sinopsis-<?= $buku->getId() ?>" class="book-detail__synopsis">
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
