<?php
include 'core/core.php';

$buku_id = $_GET['id']; //mendapat ID buku dari URL
$reviews = Ulasan::query(['id_buku', '=', $buku_id]);
$ratings = Penilaian::query(['id_buku', '=', $buku_id]);
$buku = Buku::cari($buku_id); //memunculkan info detail buku

$pengguna = pengguna();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan</title>
    <script>
        function toggleReviewForm() {
            var form = document.getElementById('reviewForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <h1>Rating dan Ulasan</h1>
    <h2>judul buku : <?= $buku->getJudul() ?></h2>
    <br>
    <?php if ($pengguna): ?>
        <button onclick="toggleReviewForm()">Add Review</button>
        <form id="reviewForm" action="submit_review.php" method="post" style="display: none;">
            <input type="hidden" name="id_buku" value="<?php echo $buku_id; ?>">
            <textarea name="ulasan" placeholder="Write your review here" required></textarea>
            <label for="penilaian">Rating:</label>
            <select name="penilaian" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <button type="submit">Submit Review</button>
        </form>
    <?php else: ?>
        <p>Please log in to add a review.</p>
    <?php endif; ?>

    <?php foreach ($reviews as $review): ?>
        <?php 
            $user = Pengguna::cari($review->getIdPengguna()); 
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
                <p>Rating: <?php echo $rating->getPenilaian(); ?>/5</p>
            <?php endif; ?>
            <p><?php echo htmlspecialchars($review->getUlasan()); ?></p>
        </div>
    <?php endforeach; ?>

</body>
</html>
