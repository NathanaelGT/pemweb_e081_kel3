<?php
include '../core/core.php';

$buku = Buku::cari($_GET['id'] ?? null);
if ($buku === null) {
    header('Location: buku.php');
    die;
}

$buku->hapus();

$_SESSION['info'] = "Buku \"{$buku->getJudul()}\" berhasil dihapus";
$_SESSION['jenis_info'] = 'success';

header('Location: buku.php');
