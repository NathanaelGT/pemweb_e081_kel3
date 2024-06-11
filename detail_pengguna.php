<?php
include './core/core.php';

$id = $_GET['id'];
$pengguna = Pengguna::cari($id);

if (!$pengguna) {
    echo "Pengguna tidak ditemukan.";
    exit;
}

$view = $_GET['view'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna</title>
    <link rel="stylesheet" href="assets/detail_pengguna.css">
</head>
<body>
    <h1><?php echo $pengguna->getNama(); ?></h1>

    <button onclick="window.location.href='daftar_pengguna.php'">Back</button>

    <form method="get" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <select name="view" onchange="this.form.submit()">
            <option value="">Tampilkan</option>
            <option value="buku" <?php if ($view == 'buku') echo 'selected'; ?>>Buku yang Dipinjam</option>
            <option value="penilaian" <?php if ($view == 'penilaian') echo 'selected'; ?>>Penilaian</option>
            <option value="ulasan" <?php if ($view == 'ulasan') echo 'selected'; ?>>Ulasan</option>
        </select>
    </form>

    <?php
    switch ($view) {
        case 'buku':
            $bukuDipinjam = Database::query("
                SELECT b.judul, b.kategori, b.penerbit, b.terbit, b.cover, b.isbn 
                FROM stok_buku sb
                JOIN buku b ON sb.id_buku = b.id
                WHERE sb.dipinjam_oleh_id_pengguna = " . Database::escape($id)
            );
            echo "<h2>Buku yang Dipinjam</h2>";
            if ($bukuDipinjam) {
                echo "<table border='1'>";
                echo "<tr><th>Judul</th></tr>";
                foreach ($bukuDipinjam as $buku) {
                    echo "<tr><td>" . $buku['judul'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Tidak ada buku yang dipinjam</p>";
            }
            break;     
        case 'penilaian':
            $bukuDinilai = Database::query("
                SELECT b.judul, b.kategori, b.penerbit, b.terbit, b.cover, b.isbn, p.penilaian
                FROM penilaian p
                JOIN buku b ON p.id_buku = b.id
                WHERE p.id_pengguna = " . Database::escape($id)
            );
            echo "<h2>Buku yang Diniliai</h2>";
            if ($bukuDinilai) {
                echo "<table border='1'>";
                echo "<tr><th>Judul</th><th>Penilaian</th></tr>";
                foreach ($bukuDinilai as $buku) {
                    echo "<tr><td>" . $buku['judul'] . "</td><td>" . $buku['penilaian'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Tidak ada buku yang dinilai</p>";
            }
            break;
        case 'ulasan':
            $bukuDiulas = Database::query("
                SELECT b.judul, b.kategori, b.penerbit, b.terbit, b.cover, b.isbn, u.ulasan
                FROM ulasan u
                JOIN buku b ON u.id_buku = b.id
                WHERE u.id_pengguna = " . Database::escape($id)
            );
            echo "<h2>Buku yang Diulas</h2>";
            if ($bukuDiulas) {
                echo "<table border='1'>";
                echo "<tr><th>Judul</th><th>Ulasan</th></tr>";
                foreach ($bukuDiulas as $buku) {
                    echo "<tr><td>" . $buku['judul'] . "</td><td>" . $buku['ulasan'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Tidak ada buku yang diulas</p>";
            }
            break;
    }
    ?>
</body>
</html>
