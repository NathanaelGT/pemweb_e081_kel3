<?php
include 'core/core.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_ulasan']) && isset($_POST['komentar'])) {
        $id_ulasan = $_POST['id_ulasan'];
        $komentar_text = $_POST['komentar'];
        $pengguna = pengguna();

        if ($pengguna) {
            // menyimpan komentar ke db
            $komentar = new Komentar();
            $komentar->setIdUlasan($id_ulasan);
            $komentar->setIdPengguna($pengguna->getId());
            $komentar->setKomentar($komentar_text);
            $komentar->simpan();

            // Memperoleh id_buku dari id_ulasan setelah komentar disimpan
            $ulasan = Ulasan::cari($id_ulasan);
            $id_buku = $ulasan->getIdBuku();

            header('Location: review.php?id=' . $id_buku);
            exit();
        } else {
            echo "Error: User is not logged in.";
        }
    } else {
        echo "Error: Required data not received.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
