<?php
include './core/core.php';

if (is_null($pengguna = pengguna())) {
    $_SESSION['info'] = 'Anda harus login untuk meminjam buku';
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
if (!empty($peminjaman)) {
    $_SESSION['info'] = 'Anda sudah meminjam buku ini';
    $_SESSION['jenis_info'] = 'error';

    header("Location: $redirectKe");
    die;
}

$stokBuku = StokBuku::query(['id_buku', '=', $buku]);
if (empty($stokBuku)) {
    $_SESSION['info'] = 'Buku tidak tersedia saat ini';
    $_SESSION['jenis_info'] = 'error';

    header("Location: $redirectKe");
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process(function () use ($stokBuku, $buku, $pengguna, $redirectKe) {
        foreach ($stokBuku as $stok) {
            if ($stok->getIdPeminjaman() === null) {
                $peminjaman = new Peminjaman();
                $peminjaman
                    ->setIdBuku($buku->getId())
                    ->setIdPengguna($pengguna->getId())
                    ->setTanggalPinjam($_POST['tanggal_pinjam'])
                    ->setTanggalKembali($_POST['tanggal_kembali'])
                    ->simpan();

                $stok->setIdPeminjaman($peminjaman->getId())->simpan();

                $_SESSION['info'] = 'Buku berhasil dipinjam';
                $_SESSION['jenis_info'] = 'success';

                header("Location: $redirectKe");
                die;
            }
        }

        $_SESSION['info'] = 'Maaf, buku tidak tersedia untuk dipinjam saat ini';
        $_SESSION['jenis_info'] = 'error';

        header("Location: $redirectKe");
    });
}

$bodyClass = 'bookshelf-background';
$judulHalaman = 'Pinjam Buku';
?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<main class="form__wrapper form__wrapper--split">
    <div>
        <section style="view-transition-name: pinjam_buku-detail" class="text-left">
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
            <h2 style="view-transition-name: pinjam_buku-form-judul" class="text-left mb-1">
                Informasi Peminjaman
            </h2>

            <?php include './komponen/info.php' ?>

            <form method="POST" style="view-transition-name: pinjam_buku-form" class="form">
                <label class="label">
                    <span>Tanggal pinjam</span>
                    <input type="text" name="tanggal_pinjam" class="input" />
                </label>

                <label class="label">
                    <span>Tanggal kembali</span>
                    <input type="text" name="tanggal_kembali" class="input" />
                </label>

                <button class="btn btn--blue mx-auto">Reservasi Peminjaman</button>
            </form>
        </section>
    </div>
</main>

<script>
    scripts.add(function () {
        const config = {
            locale: airDatepickerLocale,
            timepicker: true,
            minHours: 8,
            maxHours: 17,
            minDate: new Date(),
        }

        new AirDatepicker('input[name="tanggal_pinjam"]', { ...config, position: 'bottom left', selectedDates: [new Date()] })
        new AirDatepicker('input[name="tanggal_kembali"]', { ...config, position: 'top left' })
    })
</script>

<?php include './komponen/close.php' ?>
