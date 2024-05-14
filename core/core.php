<?php

include 'Database.php';
include 'Model.php';
include 'Pengguna.php';
include 'Buku.php';
include 'StokBuku.php';
include 'Ulasan.php';
include 'Penilaian.php';

session_start();

function pengguna(): ?Pengguna
{
    static $pengguna = isset($_SESSION['pengguna'])
        ? Pengguna::cari($_SESSION['pengguna'])
        : null;

    return $pengguna;
}
