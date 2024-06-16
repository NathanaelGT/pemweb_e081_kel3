<?php
include './core/core.php';

$redirectKe = './detailbuku.php?id=' . ($_GET['id'] ?? '');

if (is_null($pengguna = pengguna())) {
    $_SESSION['info'] = 'Anda harus login untuk meminjam buku';
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

$stokBuku = StokBuku::query(['id_buku', '=', $buku]);
if (empty($stokBuku)) {
    $_SESSION['info'] = 'Buku tidak tersedia saat ini';
    $_SESSION['jenis_info'] = 'error';

    header("Location: $redirectKe");
    die;
}

$peminjaman = Peminjaman::query(['id_buku', '=', $buku], ['id_pengguna', '=', $pengguna], ['tanggal_dikembalikan', 'is', null]);
if (!empty($peminjaman)) {
    $_SESSION['info'] = 'Anda sudah meminjam buku ini';
    $_SESSION['jenis_info'] = 'error';

    header("Location: $redirectKe");
    die;
}

foreach ($stokBuku as $stok) {
    if ($stok->getIdPeminjaman() === null) {
        $peminjaman = new Peminjaman();
        $peminjaman
            ->setIdBuku($buku->getId())
            ->setIdPengguna($pengguna->getId())
            ->setTanggalPinjam(new DateTime('now'))
            ->setTanggalKembali(new DateTime('+7 days'))
            ->simpan();

        $stok->setIdPeminjaman($peminjaman->getId())->simpan();

        $_SESSION['info'] = 'Buku berhasil dipinjam';
        $_SESSION['jenis_info'] = 'success';

        header("Location: $redirectKe");
        die;
    }
}

$_SESSION['info'] = 'Maaf, buku tidak tersedia untuk dipinjam saat ini';
$_SESSION['jenis_info'] = 'error';

header("Location: $redirectKe");
