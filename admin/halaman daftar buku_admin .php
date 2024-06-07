<?php
session_start();
include './core/core.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$bukuList = Buku::semua();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku (Admin)</title>
    <link rel="stylesheet" href="assets/daftarbuku.css">
</head>
<body>
    <?php include './komponen/open.php' ?>
    <?php include './komponen/header.php' ?>

    <div class="container">
        <h1>Daftar Buku (Admin)</h1>
        <div class="button">
            <a href="tambah_buku.php">Tambah Buku</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bukuList as $buku): ?>
                <tr>
                    <td><?= $buku->getJudul() ?></td>
                    <td><?= $buku->getPenulis() ?></td>
                    <td><?= $buku->getPenerbit() ?></td>
                    <td><?= $buku->getTerbit()->format('Y') ?></td>
                    <td><?= $buku->getKategori() ?></td>
                    <td>
                        <a href="edit_buku.php?id=<?= $buku->getId() ?>">Edit</a> |
                        <a href="hapus_buku.php?id=<?= $buku->getId() ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>
