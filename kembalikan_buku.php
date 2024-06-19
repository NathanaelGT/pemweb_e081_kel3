<?php
include './core/core.php';

if (is_null($pengguna = pengguna())) {
    $_SESSION['info'] = 'Anda harus login untuk mengembalikan buku';
    $_SESSION['jenis_info'] = 'error';

    header('Location: masuk.php');
    die;
}

$buku = Buku::cari(@$_GET['id']);
if ($buku === null) {
    $_SESSION['info'] = 'Buku tidak ditemukan';
    $_SESSION['jenis_info'] = 'error';

    header('Location: ./');
    die;
}

$redirectKe = './detailbuku.php?id=' . @$_GET['id'];

$peminjaman = Peminjaman::query(['id_buku', '=', $buku], ['id_pengguna', '=', $pengguna], ['tanggal_dikembalikan', 'is', null]);
if (empty($peminjaman)) {
    $_SESSION['info'] = 'Anda tidak sedang meminjam buku ini';
    $_SESSION['jenis_info'] = 'error';

    header("Location: $redirectKe");
    die;
}
$peminjaman = $peminjaman[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process(function () use ($buku, $peminjaman, $redirectKe) {
        $stokBuku = StokBuku::query(['id_buku', '=', $buku], ['id_peminjaman', '=', $peminjaman]);
        foreach ($stokBuku as $stok) {
            $peminjaman->setTanggalDikembalikan('now')->simpan();
            $stok->setIdPeminjaman(null)->simpan();

            $_SESSION['info'] = 'Buku berhasil dikembalikan';
            $_SESSION['jenis_info'] = 'success';

            header("Location: $redirectKe");
            die;
        }

        $_SESSION['info'] = 'Maaf, terjadi kesalahan saat mengembalikan buku';
        $_SESSION['jenis_info'] = 'error';

        header("Location: $redirectKe");
    });
}

$bodyClass = 'bookshelf-background';
$judulHalaman = 'Kembalikan Buku';
?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<main class="form__wrapper form__wrapper--split">
    <div>
        <section class="text-left">
            <h2 class="mb-1">Informasi Buku</h2>

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
                    <td>: <?= $buku->getTerbit()->format('d/m/Y') ?></td>
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
                    <td>Bisa Dipinjam</td>
                    <td>: <?= count(StokBuku::query(['id_buku', '=', $buku], ['id_peminjaman', 'IS', null])) ?></td>
                </tr>
            </table>
        </section>

        <section>
            <h2 class="text-left mb-1">Informasi Peminjaman</h2>

            <?php include './komponen/info.php' ?>

            <form method="POST" class="form">
                <label class="label">
                    <span>Tanggal pinjam</span>
                    <input type="text" name="tanggal_pinjam" value="<?= $peminjaman->getTanggalPinjam()->format('d/m/Y h:i a') ?>" disabled class="input" />
                </label>

                <label class="label">
                    <span>Tanggal kembali</span>
                    <input type="text" name="tanggal_kembali" value="<?= $peminjaman->getTanggalKembali()->format('d/m/Y h:i a') ?>" disabled class="input" />
                </label>

                <button class="btn btn--red mx-auto">Kembalikan Buku</button>
            </form>
        </section>
    </div>
</main>

<?php include './komponen/close.php' ?>
