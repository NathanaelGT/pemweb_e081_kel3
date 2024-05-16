<?php
include('../core/Database.php');
include('../core/Buku.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST["judul"];
    $kategori = $_POST["kategori"];
    $penulis = $_POST["penulis"];
    $sinopsis = $_POST["sinopsis"];
    $terbit = $_POST["terbit"];
    $penerbit = $_POST["penerbit"];
    $isbn = (int) $_POST["isbn"];

    $buku = new Buku();
    $buku->setJudul($judul)
         ->setKategori($kategori)
         ->setPenulis($penulis)
         ->setSinopsis($sinopsis)
         ->setTerbit($terbit)
         ->setPenerbit($penerbit)
         ->setIsbn($isbn);

    if (Database::query(sprintf(
        "INSERT INTO %s (judul, kategori, penulis, sinopsis, terbit, penerbit, isbn) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%d')",
        Buku::TABLE,
        $buku->getJudul(),
        $buku->getKategori(),
        $buku->getPenulis(),
        $buku->getSinopsis(),
        $buku->getTerbit()->format('Y-m-d H:i:s'),
        $buku->getPenerbit(),
        $buku->getIsbn()
    ))) {
        header('Location: formbuku.php?status=ok');
    } else {
        header('Location: formbuku.php?status=err');
    }
}
?>
