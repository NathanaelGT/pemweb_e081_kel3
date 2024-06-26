<?php
include '../core/core.php';

$basePath = '../';

if (!pengguna()?->getAdmin()) {
    header("Location: $basePath");
    die;
}

$buku = Buku::cari(@$_GET['id']);
if ($buku === null) {
    header('Location: buku.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process(function () use ($buku) {
        $semuaStokBuku = StokBuku::query(['id_buku', '=', $buku]);
        $jumlahStokBuku = count($semuaStokBuku);
        $stokBuku = array_group(fn (StokBuku $stok) => [
            $stok->getIdPeminjaman() === null ? 'tersedia' : 'dipinjam' => $stok
        ], $semuaStokBuku);

        if ($_POST['jumlah_stok'] > $jumlahStokBuku) {
            for ($i = 0; $i < $_POST['jumlah_stok'] - $jumlahStokBuku; $i++) {
                (new StokBuku)
                    ->setIdBuku($buku->getId())
                    ->simpan();
            }
        } elseif ($_POST['jumlah_stok'] < $jumlahStokBuku) {
            $stokTersedia = $stokBuku['tersedia'] ?? [];

            if (count($stokTersedia) < $jumlahStokBuku - $_POST['jumlah_stok']) {
                throw new RuntimeException(
                    'Jumlah stok yang tersedia tidak boleh kurang dari jumlah stok yang sedang dipinjam'
                );
            }

            foreach (array_slice($stokTersedia, 0, $jumlahStokBuku - $_POST['jumlah_stok']) as $stok) {
                $stok->hapus();
            }
        }

        $buku->setJudul($_POST['judul'])
            ->setKategori($_POST['kategori'])
            ->setPenulis($_POST['penulis'])
            ->setSinopsis($_POST['sinopsis'])
            ->setTerbit($_POST['terbit'])
            ->setPenerbit($_POST['penerbit'])
            ->setIsbn($_POST['isbn']);

        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $buku->setCover(handle_upload($_FILES['cover'], $_POST['isbn']));
        }

        $buku->simpan();

        $_SESSION['info'] = "Buku \"{$buku->getJudul()}\" berhasil diedit";
        $_SESSION['jenis_info'] = 'success';

        header('Location: buku.php');
    });
}

$bodyClass = 'bookshelf-background';
$judulHalaman = 'Edit Buku';
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1 style="view-transition-name: edit_buku-<?= $buku->getId() ?>-form-judul">
            Edit Buku
            <span style="view-transition-name: buku-judul-<?= $buku->getId() ?>">
                <?= $buku->getJudul() ?>
            </span>
        </h1>

        <?php include '../komponen/info.php' ?>

        <form
            method="POST"
            enctype="multipart/form-data"
            style="view-transition-name: edit_buku-<?= $buku->getId() ?>-form"
            class="form"
        >
            <label class="label">
                <span>Judul</span>
                <?= input(name: 'judul', value: $buku->getJudul(), required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>Kategori</span>
                <?= input(name: 'kategori', value: $buku->getKategori(), required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>Penulis</span>
                <?= input(name: 'penulis', value: $buku->getPenulis(), required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>Sinopsis</span>
                <textarea name="sinopsis" required class="input textarea"><?=
                    $_SESSION['old']['sinopsis'] ?? $buku->getSinopsis()
                ?></textarea>
            </label>

            <label class="label">
                <span>Tanggal Terbit</span>
                <?= input(name: 'terbit', value: $buku->getTerbit()->format('Y-m-d'), required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>Penerbit</span>
                <?= input(name: 'penerbit', value: $buku->getPenerbit(), required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>ISBN</span>
                <?= input(name: 'isbn', value: $buku->getIsbn(), required: true, class: 'input', type: 'number', min: 1) ?>
            </label>

            <label class="label">
                <span>Cover</span>
                <input type="file" name="cover" accept=".jpg, .jpeg, .png, .webp" class="input">
            </label>

            <label class="label">
                <span>Jumlah Buku</span>
                <?= input(
                    name: 'jumlah_stok',
                    value: fn() => count(StokBuku::query(['id_buku', '=', $buku])),
                    required: true,
                    class: 'input',
                    type: 'number',
                    min: 1
                ) ?>
            </label>

            <button type="submit" class="btn btn--green">Edit Buku</button>
        </form>
    </div>
</main>

<script>
    scripts.add(function () {
        new AirDatepicker('input[name="terbit"]', { locale: airDatepickerLocale })
    })
</script>

<?php include '../komponen/close.php' ?>
