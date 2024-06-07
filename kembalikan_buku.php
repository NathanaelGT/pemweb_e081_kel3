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
    echo "Anda harus login untuk mengembalikan buku";
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

// Memeriksa apakah pengguna sedang meminjam buku ini
$stokBuku = StokBuku::query(['id_buku', '=', $idBuku], ['dipinjam_oleh_id_pengguna', '=', $idPengguna]);
if (empty($stokBuku)) {
    // Tampilkan pesan jika buku tidak sedang dipinjam oleh pengguna
    echo "Anda tidak sedang meminjam buku ini";
    exit;
}

// Lakukan pengembalian buku
foreach ($stokBuku as $stok) {
    if ($stok->getDipinjamOlehIdPengguna() === $idPengguna) {
        // Update catatan pengembalian
        $stok->setDipinjamOlehIdPengguna(null)->simpan();
        // Tampilkan pesan sukses
        echo "Buku berhasil dikembalikan";
        exit;
    }
}

// Jika tidak ada buku yang sesuai untuk dikembalikan
echo "Maaf, terjadi kesalahan saat mengembalikan buku.";
?>
