<?php
include 'core/core.php';

$buku = Buku::cari(@$_GET['id']);
if ($buku === null) {
    header('Location: ./');
    die;
}

$reviews = Ulasan::query(['id_buku', '=', $buku]);
$ratings = Penilaian::query(['id_buku', '=', $buku]);

$pengguna = pengguna();

$bodyClass = 'review-body';
$head = <<<HTML
<title>Ulasan</title>
<link rel="stylesheet" href="assets/review.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<main class="layout">
    <div class="topnav">
        <h1> <a href="javascript:history.back()">
                <i class="bi bi-arrow-left" style="font-size: 2rem; color: white;"></i>
            </a> Rating dan Ulasan</h1>
    </div>
    <br>
    <div class="cover">
        <img
            src="<?= $buku->getCover() ?>"
            alt="Cover <?= $buku->getJudul() ?>"
            style="view-transition-name: buku-cover-<?= $buku->getId() ?>"
        />
    </div>

    <div class="judul">
        <h1 style="view-transition-name: buku-judul-<?= $buku->getId() ?>"><?= $buku->getJudul() ?></h1>
    </div>

    <div class="tulisreview">
        <?php if ($pengguna): ?>
            <form id="reviewForm" action="submit_review.php" method="post" style="background-color: #121212; padding: 20px; border-radius: 8px; margin-top: 20px;">
                <input type="hidden" name="id_buku" value="<?= $buku->getId() ?>">
                <input type="hidden" name="penilaian" id="rating-input" value="">
                <p>Berikan ulasan Anda :</p>
                <div class="star-rating">
                    <i class="bi bi-star text-secondary" data-rating="1"></i>
                    <i class="bi bi-star text-secondary" data-rating="2"></i>
                    <i class="bi bi-star text-secondary" data-rating="3"></i>
                    <i class="bi bi-star text-secondary" data-rating="4"></i>
                    <i class="bi bi-star text-secondary" data-rating="5"></i>
                </div>
                <div class="mb-3">
                    <textarea name="ulasan" class="form-control" placeholder="Tulis Ulasan Anda di sini" required></textarea>
                </div>
                <br>
                <button type="submit" class="btn btn--green">Kirim</button>
            </form>
        <?php else: ?>
            <p>Tolong masuk untuk menambahkan ulasan</p>
        <?php endif; ?>
    </div>

    <div class="ulasanuser">
        <table>
            <tbody id="tabelreview">
                
            </tbody>
            <tr>
            <?php $users = dict(Pengguna::query(['id', 'IN', $reviews])) ?>
            <?php $komentars = array_group(fn(Komentar $k) => [
                $k->getIdUlasan() => $k,
            ], Komentar::query(['id_ulasan', 'IN', $reviews])) ?>
            <?php foreach ($reviews as $review): ?>
                <?php 
                    $user = $users[$review->getIdPengguna()];
                    $rating = null;
                    foreach ($ratings as $r) {
                        if ($r->getIdPengguna() == $review->getIdPengguna()) {
                            $rating = $r;
                            break;
                        }
                    }
                ?>
                <div>
                    <strong><?php echo htmlspecialchars($user->getNama()); ?></strong>
                    <?php if ($rating): ?>
                        <p><?php 
                            $stars = $rating->getPenilaian();
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < $stars) {
                                    echo '<i class="bi bi-star-fill"></i>';
                                } else {
                                    echo '<i class="bi bi-star"></i>';
                                }
                            }
                        ?></p>
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($review->getUlasan()); ?></p>

                    <!-- ikon comment -->
                    <i class="bi bi-chat-left-text comment-icon" data-review-id="<?php echo $review->getId(); ?>" style="cursor: pointer;"></i>

                    <!-- Comment section -->
                    <div id="comment-section-<?php echo $review->getId(); ?>" class="komentar" style="display: none; margin-top: 10px;">
                        <input type="hidden" name="id_buku" value="<?= $buku->getId() ?>">
                        <?php foreach ($komentars[$review->getId()] ?? [] as $komentar): ?>
                            <?php $komentarUser = Pengguna::cari($komentar->getIdPengguna()); ?>
                            <div class="komentar-item" style="margin-bottom: 10px;">
                                <strong><?php echo htmlspecialchars($komentarUser->getNama()); ?></strong>
                                <p><?php echo htmlspecialchars($komentar->getKomentar()); ?></p>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($pengguna): ?>
                            <form action="submit_komentar.php" method="post" class="komentar-form">
                                <input type="hidden" name="id_ulasan" value="<?php echo $review->getId(); ?>">
                                <textarea name="komentar" class="form-control" placeholder="Tulis komentar Anda di sini" required></textarea>
                                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Kirim</button>
                            </form>
                        <?php else: ?>
                            <p>Harap masuk untuk menambahkan komentar</p>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <br>
                </div>
            <?php endforeach ?>

            </tr>
        </table>
    </div>
</main>


<script>
$(document).ready(function() {
    $('.star-rating .bi').on('click', function() {
        var rating = $(this).data('rating');
        $('#rating-input').val(rating); // Menetapkan nilai rating ke elemen input
        $(this).prevAll().addBack().removeClass('text-secondary').addClass('text-warning'); // Mengubah warna bintang yang diklik dan sebelumnya
        $(this).nextAll().removeClass('text-warning').addClass('text-secondary'); // Mengubah warna bintang setelahnya
    });

    $('.comment-icon').on('click', function() {
        var reviewId = $(this).data('review-id');
        $('#comment-section-' + reviewId).toggle();
    });
});

</script>

<?php include './komponen/close.php' ?>
