<?php
include 'core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengguna = pengguna();

    if ($pengguna) {
        $id_buku = $_POST['id_buku'];
        $ulasan = @$_POST['ulasan'];
        $penilaian = @$_POST['penilaian'];

        // Tulis dan simpan ulasan
        if ($ulasan) {
            $review = new Ulasan([
                'id_buku' => $id_buku,
                'id_pengguna' => $pengguna->getId(),
                'ulasan' => $ulasan,
            ]);

            $review->simpan();
        }

        // Tulis dan menyimpan rating/penilaian jika nilainya tidak null
        if ($penilaian) {
            $rating = array_first(Penilaian::query(['id_buku', '=', $id_buku], ['id_pengguna', '=', $pengguna]));

            if ($rating === null) {
                $rating = new Penilaian([
                    'id_buku' => $id_buku,
                    'id_pengguna' => $pengguna->getId(),
                    'penilaian' => $penilaian,
                ]);

                $rating->simpan();
            } elseif ($rating->getPenilaian() !== $penilaian) {
                $rating->setPenilaian($penilaian);

                $rating->simpan();
            }
        }

        // mengarahkan ke laman ulasan lagi
        header('Location: review.php?id=' . $id_buku);
        exit;
    } else {
        echo 'You must be logged in to submit a review.';
    }
}
?>
