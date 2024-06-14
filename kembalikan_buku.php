<?php
include './core/core.php';

$redirectKe = './detailbuku.php?id=' . ($_GET['id'] ?? '');

if (is_null($pengguna = pengguna())) {
    $_SESSION['info'] = 'Anda harus login untuk mengembalikan buku';
    $_SESSION['jenis_info'] = 'error';

    header("Location: $redirectKe");
    die;
}

$buku = Buku::cari($_GET['id'] ?? null);
if ($buku === null) {
    $_SESSION['info'] = 'Buku tidak ditemukan';
    $_SESSION['jenis_info'] = 'error';

    header("Location: $redirectKe");
    die;
}

$stokBuku = StokBuku::query(['id_buku', '=', $buku], ['dipinjam_oleh_id_pengguna', '=', $pengguna->getId()]);
if (empty($stokBuku)) {
    $_SESSION['info'] = 'Anda tidak sedang meminjam buku ini';
    $_SESSION['jenis_info'] = 'error';

    header("Location: $redirectKe");
    die;
}

foreach ($stokBuku as $stok) {
    if ($stok->getDipinjamOlehIdPengguna() === $pengguna->getId()) {
        $stok->setDipinjamOlehIdPengguna(null)->simpan();

        $_SESSION['info'] = 'Buku berhasil dikembalikan';
        $_SESSION['jenis_info'] = 'success';

        header("Location: $redirectKe");
        die;
    }
}

$_SESSION['info'] = 'Maaf, terjadi kesalahan saat mengembalikan buku';
$_SESSION['jenis_info'] = 'error';

header("Location: $redirectKe");
