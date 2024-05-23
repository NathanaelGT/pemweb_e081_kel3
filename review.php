<?php
include 'core/core.php';

$buku_id = $_GET['id']; //mendapat ID buku dari URL
$reviews = Ulasan::query(['id_buku', '=', $buku_id]);
$ratings = Penilaian::query(['id_buku', '=', $buku_id]);
$buku = Buku::cari($buku_id); //memunculkan info detail buku

$pengguna = pengguna();
?>

<?php $head = <<<HTML
<title>Home</title>
HTML ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan</title>
    <link rel="stylesheet" href="assets/review.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <?php include './komponen/open.php' ?>
    <?php include './komponen/open.php' ?>
    <?php include './komponen/header.php' ?>
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
    
    <div class="topnav">
        <!-- Belum ditambah tombol backspace -->
        <h1>Rating dan Ulasan</h1>
    </div>

    <div class="cover">
        <img src="cover.jpg" alt="<?= $buku->getJudul() ?>"> 
        <!-- diganti upload foto cover buku -->
    </div>

    <div class="judul">
        <h1> <?= $buku->getJudul() ?></h1>
    </div>

    <div class="tulisreview">
        <?php if ($pengguna): ?>
            <button onclick="toggleReviewForm()">Add Review</button>
            <form id="reviewForm" action="submit_review.php" method="post" style="display: none;">
                <input type="hidden" name="id_buku" value="<?php echo $buku_id; ?>">
                <textarea name="ulasan" placeholder="Write your review here" required></textarea>
                <br>
                <label for="penilaian">Rating:</label>
                <select name="penilaian" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <br>
                <button type="submit">Submit Review</button>
            </form>
        <?php else: ?>
            <p>Please log in to add a review.</p>
        <?php endif; ?>
    </div>

    <div class="ulasanuser">
        <table class="tabelreview">
            <tr>
                <td>
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
                    </div>
                <?php endforeach; ?>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
