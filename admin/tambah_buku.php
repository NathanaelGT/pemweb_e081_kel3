<?php
include '../core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $buku = new Buku();
        $buku->setJudul($_POST['judul'])
            ->setKategori($_POST['kategori'])
            ->setPenulis($_POST['penulis'])
            ->setSinopsis($_POST['sinopsis'])
            ->setTerbit($_POST['terbit'])
            ->setPenerbit($_POST['penerbit'])
            ->setIsbn($_POST['isbn'])
            ->simpan();

        $_SESSION['info'] = 'Buku berhasil ditambahkan';
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
$judulHalaman = 'Tambah Buku';
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1>Tambah Buku</h1>

        <?php include '../komponen/info.php' ?>

        <form method="POST" class="form">
            <label class="label">
                <span>Judul</span>
                <input type="text" name="judul" required class="input">
            </label>

            <label class="label">
                <span>Kategori</span>
                <input type="text" name="kategori" required class="input">
            </label>

            <label class="label">
                <span>Penulis</span>
                <input type="text" name="penulis" required class="input">
            </label>

            <label class="label">
                <span>Sinopsis</span>
                <textarea name="sinopsis" required class="input textarea"></textarea>
            </label>

            <label class="label">
                <span>Tanggal Terbit</span>
                <input type="text" name="terbit" required class="input">
            </label>

            <label class="label">
                <span>Penerbit</span>
                <input type="text" name="penerbit" required class="input">
            </label>

            <label class="label">
                <span>ISBN</span>
                <input type="number" min="1" name="isbn" required class="input">
            </label>

            <button type="submit" class="btn btn--green">Tambah Buku</button>
        </form>
    </div>
</main>

<script>
    $(document).ready(function () {
        new AirDatepicker('input[name="terbit"]', { locale: airDatepickerLocale })
    })
</script>

<?php include '../komponen/close.php' ?>
