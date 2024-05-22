<?php
include './core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buku = new Buku();
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
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Buku</h1>
        <form method="POST" action="tambah_buku.php">
            <label for="judul">Judul:</label>
            <input type="text" id="judul" name="judul" required>

            <label for="kategori">Kategori:</label>
            <input type="text" id="kategori" name="kategori" required>

            <label for="penulis">Penulis:</label>
            <input type="text" id="penulis" name="penulis" required>

            <label for="sinopsis">Sinopsis:</label>
            <textarea id="sinopsis" name="sinopsis" required></textarea>

            <label for="terbit">Tanggal Terbit:</label>
            <input type="date" id="terbit" name="terbit" required>

            <label for="penerbit">Penerbit:</label>
            <input type="text" id="penerbit" name="penerbit" required>

            <label for="isbn">ISBN:</label>
            <input type="number" id="isbn" name="isbn" required>

            <button type="submit" class="btn">Tambah Buku</button>
        </form>
    </div>
</body>
</html>
