<?php
include '../core/core.php';

$buku = Buku::cari($_GET['id'] ?? null);
if ($buku === null) {
    header('Location: buku.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_FILES['cover'])) {
            $buku->setCover(handle_upload($_FILES['cover'], $_POST['isbn']));
        }

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
$judulHalaman = 'Edit Buku';
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1>
            Edit Buku
            <span style="view-transition-name: buku-judul-<?= $buku->getId() ?>">
                <?= $buku->getJudul() ?>
            </span>
        </h1>

        <?php include '../komponen/info.php' ?>

        <form method="POST" enctype="multipart/form-data" class="form">
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

            <label class="label">
                <span>Cover</span>
                <input type="file" name="cover" accept=".jpg, .jpeg, .png, .webp" class="input">
            </label>

            <button type="submit" class="btn btn--green">Edit Buku</button>
        </form>
    </div>
</main>

<script>
    $(document).ready(function () {
        new AirDatepicker('input[name="terbit"]', { locale: airDatepickerLocale })
    })
</script>

<?php include '../komponen/close.php' ?>
