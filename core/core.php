<?php

include __DIR__ . '/Database.php';
include __DIR__ . '/Model.php';
include __DIR__ . '/Pengguna.php';
include __DIR__ . '/Buku.php';
include __DIR__ . '/StokBuku.php';
include __DIR__ . '/Ulasan.php';
include __DIR__ . '/Penilaian.php';

session_start();

function pengguna(): ?Pengguna
{
    static $pengguna = false;

    if ($pengguna === false) {
        $pengguna = isset($_SESSION['pengguna'])
            ? Pengguna::cari($_SESSION['pengguna'])
            : null;
    }

    return $pengguna;
}
