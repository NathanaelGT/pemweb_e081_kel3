<?php

include './core/core.php';

if (pengguna() === null) {
    header('Location: masuk.php');
    die;
}

$koleksiBuku = Buku::query([
    'id', 'IN', StokBuku::query([
        'dipinjam_oleh_id_pengguna', '=', pengguna()->getId()
    ])
]);

$judulHalaman = 'Koleksi Buku Saya';
?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>
<?php include './komponen/subheader.php' ?>

<main class="page-section">
    <?php if (empty($koleksiBuku)): ?>
        <div class="jumbotron">
            <p>Tidak ada buku yang sedang dipinjam</p>
        </div>
    <?php else: ?>
        <div class="page-section__content">
            <?php foreach ($koleksiBuku as $buku): ?>
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

                        <p class="book-overview__buttons">
                            <a href="./detailbuku.php?id=<?= $buku->getId() ?>" class="btn btn--blue">
                                <strong>Detail Buku</strong>
                            </a>
                            <a href="./review.php?id=<?= $buku->getId() ?>#reviewForm" class="btn btn--yellow">
                                <strong>Tulis Ulasan</strong>
                            </a>
                            <a href="./kembalikan_buku.php?id=<?= $buku->getId() ?>" class="btn btn--red">
                                <strong>Kembalikan Buku</strong>
                            </a>
                        </p>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</main>

<?php include './komponen/close.php' ?>
