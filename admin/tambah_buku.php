<?php
include '../core/core.php';

$basePath = '../';

if (!pengguna()?->getAdmin()) {
    header("Location: $basePath");
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process(function () {
        $buku = new Buku();
        $buku->setJudul($_POST['judul'])
            ->setKategori($_POST['kategori'])
            ->setPenulis($_POST['penulis'])
            ->setSinopsis($_POST['sinopsis'])
            ->setTerbit($_POST['terbit'])
            ->setPenerbit($_POST['penerbit'])
            ->setIsbn($_POST['isbn'])
            ->setCover(handle_upload($_FILES['cover'], $_POST['isbn']))
            ->simpan();

        $_SESSION['info'] = 'Buku berhasil ditambahkan';
        $_SESSION['jenis_info'] = 'success';

        header('Location: buku.php');
    });
}

$bodyClass = 'bookshelf-background';
$judulHalaman = 'Tambah Buku';
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1 style="view-transition-name: tambah_buku-form-judul">Tambah Buku</h1>

        <?php include '../komponen/info.php' ?>

        <form method="POST" style="view-transition-name: tambah_buku-form" class="form">
            <label class="label">
                <span>Judul</span>
                <?= input(name: 'judul', required: true, class: 'input') ?>
                <input type="text" name="judul" required class="input">
            </label>

            <label class="label">
                <span>Kategori</span>
                <?= input(name: 'kategori', required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>Penulis</span>
                <?= input(name: 'penulis', required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>Sinopsis</span>
                <textarea name="sinopsis" required class="input textarea"><?=
                    $_SESSION['old']['sinopsis'] ?? ''
                ?></textarea>
            </label>

            <label class="label">
                <span>Tanggal Terbit</span>
                <?= input(name: 'terbit', required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>Penerbit</span>
                <?= input(name: 'penerbit', required: true, class: 'input') ?>
                <input type="text" name="penerbit" required class="input">
            </label>

            <label class="label">
                <span>ISBN</span>
                <?= input(name: 'isbn', required: true, class: 'input', type: 'number', min: 1) ?>
            </label>

            <label class="label">
                <span>Cover</span>
                <input type="file" name="cover" accept=".jpg, .jpeg, .png, .webp" required class="input">
            </label>

            <button type="submit" class="btn btn--green">Tambah Buku</button>
        </form>
    </div>
</main>

<script>
    scripts.add(function () {
        new AirDatepicker('input[name="terbit"]', { locale: airDatepickerLocale })
    })
</script>

<?php include '../komponen/close.php' ?>
