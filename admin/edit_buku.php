<?php
include '../core/core.php';

$buku = Buku::cari($_GET['id'] ?? null);
if ($buku === null) {
    header('Location: buku.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $buku->setJudul($_POST['judul'])
            ->setKategori($_POST['kategori'])
            ->setPenulis($_POST['penulis'])
            ->setSinopsis($_POST['sinopsis'])
            ->setTerbit($_POST['terbit'])
            ->setPenerbit($_POST['penerbit'])
            ->setIsbn($_POST['isbn'])
            ->simpan();

        $_SESSION['info'] = "Buku \"{$buku->getJudul()}\" berhasil diedit";
        $_SESSION['jenis_info'] = 'success';

        header('Location: buku.php');
    } catch (Throwable $e) {
        $_SESSION['info'] = $e instanceof RuntimeException ? $e->getMessage() : 'Data tidak valid';
        $_SESSION['jenis_info'] = 'error';

        header('Location: ' . $_SERVER['REQUEST_URI']);
    } finally {
        die;
    }
}

$basePath = '../';
$bodyClass = 'bookshelf-background';

$head = <<<HTML
<link href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.1/air-datepicker.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.1/air-datepicker.min.js" defer></script>
<title>Edit Buku</title>
HTML ?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1>Edit Buku <?= $buku->getJudul() ?></h1>

        <?php include '../komponen/info.php' ?>

        <form method="POST" class="form">
            <label class="label">
                <span>Judul</span>
                <input type="text" name="judul" required value="<?= $buku->getJudul() ?>" class="input">
            </label>

            <label class="label">
                <span>Kategori</span>
                <input type="text" name="kategori" required value="<?= $buku->getKategori() ?>" class="input">
            </label>

            <label class="label">
                <span>Penulis</span>
                <input type="text" name="penulis" required value="<?= $buku->getPenulis() ?>" class="input">
            </label>

            <label class="label">
                <span>Sinopsis</span>
                <textarea name="sinopsis" required class="input textarea"><?= $buku->getSinopsis() ?></textarea>
            </label>

            <label class="label">
                <span>Tanggal Terbit</span>
                <input type="text" name="terbit" required value="<?= $buku->getTerbit()->format('Y-m-d') ?>" class="input">
            </label>

            <label class="label">
                <span>Penerbit</span>
                <input type="text" name="penerbit" required value="<?= $buku->getPenerbit() ?>" class="input">
            </label>

            <label class="label">
                <span>ISBN</span>
                <input type="number" min="1" name="isbn" required value="<?= $buku->getIsbn() ?>" class="input">
            </label>

            <button type="submit" class="btn btn--green">Edit Buku</button>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        new AirDatepicker('input[name="terbit"]', { locale: airDatepickerLocale })
    })
</script>

<?php include '../komponen/close.php' ?>
