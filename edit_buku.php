<?php
include './core/core.php';

$buku = Buku::cari($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buku->setJudul($_POST['judul'])
        ->setKategori($_POST['kategori'])
        ->setPenulis($_POST['penulis'])
        ->setSinopsis($_POST['sinopsis'])
        ->setTerbit($_POST['terbit'])
        ->setPenerbit($_POST['penerbit'])
        ->setIsbn($_POST['isbn'])
        ->simpan();

    header('Location: admin_buku.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Buku</h1>
        <form method="POST" action="edit_buku.php?id=<?= $buku->getId() ?>">
            <label for="judul">Judul:</label>
            <input type="text" id="judul" name="judul" value="<?= $buku->getJudul() ?>" required>

            <label for="kategori">Kategori:</label>
            <input type="text" id="kategori" name="kategori" value="<?= $buku->getKategori() ?>" required>

            <label for="penulis">Penulis:</label>
            <input type="text" id="penulis" name="penulis" value="<?= $buku->getPenulis() ?>" required>

            <label for="sinopsis">Sinopsis:</label>
            <textarea id="sinopsis" name="sinopsis" required><?= $buku->getSinopsis() ?></textarea>

            <label for="terbit">Tanggal Terbit:</label>
            <input type="date" id="terbit" name="terbit" value="<?= $buku->getTerbit()->format('Y-m-d') ?>" required>

            <label for="penerbit">Penerbit:</label>
            <input type="text" id="penerbit" name="penerbit" value="<?= $buku->getPenerbit() ?>" required>

            <label for="isbn">ISBN:</label>
            <input type="number" id="isbn" name="isbn" value="<?= $buku->getIsbn() ?>" required>

            <button type="submit" class="btn">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
