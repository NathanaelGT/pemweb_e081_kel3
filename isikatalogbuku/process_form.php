<?php

include '../core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST["judul"];
    $kategori = $_POST["kategori"];
    $penulis = $_POST["penulis"];
    $sinopsis = $_POST["sinopsis"];
    $terbit = $_POST["terbit"];
    $penerbit = $_POST["penerbit"];
    $isbn = (int) $_POST["isbn"];

    try {
        $buku = (new Buku)
            ->setJudul($judul)
            ->setKategori($kategori)
            ->setPenulis($penulis)
            ->setSinopsis($sinopsis)
            ->setTerbit($terbit)
            ->setPenerbit($penerbit)
            ->setIsbn($isbn);

        if ($buku->simpan()) {
            header('Location: formbuku.php?status=ok');
            die;
        }
    } catch (Throwable) {
        //
    }

    header('Location: formbuku.php?status=err');
}
?>
