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


$head = <<<HTML
<title>Home</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<section class="page-title">
    <h1 class="page-title__title">Katalog Buku Perpustakaan</h1>

    <form method="GET" class="page-title__content">
        <select name="kategori" class="input">
            <?php if (isset($_GET['kategori']) && $_GET['kategori']): ?>
                <option value>Semua</option>
                <?php foreach ($daftarKategori as $kategori): ?>
                    <option <?= $_GET['kategori'] === $kategori ? 'selected' : '' ?>>
                        <?= $kategori ?>
                    </option>
                <?php endforeach ?>
            <?php else: ?>
                <option selected hidden value class="select__placeholder">Kategori</option>
                <option value>Semua</option>
                <?php foreach ($daftarKategori as $kategori): ?>
                    <option><?= $kategori ?></option>
                <?php endforeach ?>
            <?php endif ?>
        </select>

        <div class="input">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="input__icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>

            <input type="text" name="kueri" value="<?= $_GET['kueri'] ?? '' ?>" placeholder="Cari" />
        </div>
    </form>
</section>

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
                                src="https://via.placeholder.com/234x342"
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
                                <?php $intRating = (int) $rating ?>

                                <div class="book-overview__rating__star__wrapper">
                                    <?php for ($i = 0; $i < $intRating; $i++): ?>
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="book-overview__rating__star">
                                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                        </svg>
                                    <?php endfor ?>
                                    <?php for ($i = $intRating; $i < 5; $i++): ?>
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="book-overview__rating__star">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                        </svg>
                                    <?php endfor ?>
                                </div>

                                <span class="book-overview__rating__text">
                                    <?= $rating ? number_format($rating, 1) : 'Belum ada' ?>
                                </span>

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
