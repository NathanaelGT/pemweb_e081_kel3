<?php
include './core/core.php';

// Memvalidasi input
$idBuku = $_GET['id'] ?? null;
if ($idBuku === null || !is_numeric($idBuku)) {
    // Tampilkan pesan kesalahan jika ID buku tidak valid
    echo "ID buku tidak valid";
    exit;
}

// Mendapatkan pengguna yang sedang login
$pengguna = pengguna();
if ($pengguna === null) {
    // Tampilkan pesan jika pengguna tidak login
    echo "Anda harus login untuk meminjam buku";
    exit;
}

// Mendapatkan ID pengguna
$idPengguna = $pengguna->getId();

// Cari buku berdasarkan ID
$buku = Buku::cari($idBuku);
if ($buku === null) {
    // Tampilkan pesan jika buku tidak ditemukan
    echo "Buku tidak ditemukan";
    exit;
}

// Memeriksa ketersediaan stok buku
$stokBuku = StokBuku::query(['id_buku', '=', $idBuku]);
if (empty($stokBuku)) {
    // Tampilkan pesan jika buku tidak tersedia
    echo "Buku tidak tersedia saat ini";
    exit;
}

// Memeriksa apakah pengguna sudah meminjam buku ini
foreach ($stokBuku as $stok) {
    if ($stok->getDipinjamOlehIdPengguna() === $idPengguna) {
        // Jika pengguna sudah meminjam buku ini
        echo "Anda sudah meminjam buku ini.";
        exit;
    }
}

// Lakukan peminjaman jika buku tersedia
foreach ($stokBuku as $stok) {
    if ($stok->getDipinjamOlehIdPengguna() === null) {
        // Update catatan peminjaman
        $stok->setDipinjamOlehIdPengguna($idPengguna)->simpan();
        // Tampilkan pesan sukses
        echo "Buku berhasil dipinjam";
        exit;
    }
}

// Jika tidak ada stok buku yang tersedia untuk dipinjam
echo "Maaf, buku tidak tersedia untuk dipinjam saat ini.";
?>
