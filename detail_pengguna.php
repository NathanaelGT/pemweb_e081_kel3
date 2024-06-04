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
<html>
<head>
    <title>Detail Pengguna</title>
    <link rel="stylesheet" href="assets/detail_pengguna.css">
</head>
<body>
    <h1><?php echo $pengguna->getNama(); ?></h1>

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
                echo "<tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penerbit</th>
                <th>Tanggal Terbit</th>
                <th>Cover</th>
                <th>Isbn
                </tr>";
                foreach ($bukuDipinjam as $buku) {
                    echo "<tr>";
                    echo "<td>" . $buku['judul'] . "</td>";
                    echo "<td>" . $buku['kategori'] . "</td>";
                    echo "<td>" . $buku['penerbit'] . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($buku['terbit'])) . "</td>";
                    echo "<td><img src='" . $buku['cover'] . "' alt='" . $buku['judul'] . "' style='max-width: 100px; max-height: 150px;'></td>";
                    echo "<td>" . $buku['isbn'] . "</td>";
                    echo "</tr>";
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
                echo "<tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penerbit</th>
                <th>Tanggal Terbit</th>
                <th>Cover</th>
                <th>Isbn</th>
                <th>Penilaian</th>
                </tr>";
                foreach ($bukuDinilai as $buku) {
                    echo "<tr>";
                    echo "<td>" . $buku['judul'] . "</td>";
                    echo "<td>" . $buku['kategori'] . "</td>";
                    echo "<td>" . $buku['penerbit'] . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($buku['terbit'])) . "</td>";
                    echo "<td><img src='" . $buku['cover'] . "' alt='" . $buku['judul'] . "' style='max-width: 100px; max-height: 150px;'></td>";
                    echo "<td>" . $buku['isbn'] . "</td>";
                    echo "<td>" . $buku['penilaian'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Tidak ada buku yang dipinjam</p>";
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
                echo "<tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penerbit</th>
                <th>Tanggal Terbit</th>
                <th>Cover</th>
                <th>Isbn</th>
                <th>Ulasan</th>
                </tr>";
                foreach ($bukuDiulas as $buku) {
                    echo "<tr>";
                    echo "<td>" . $buku['judul'] . "</td>";
                    echo "<td>" . $buku['kategori'] . "</td>";
                    echo "<td>" . $buku['penerbit'] . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($buku['terbit'])) . "</td>";
                    echo "<td><img src='" . $buku['cover'] . "' alt='" . $buku['judul'] . "' style='max-width: 100px; max-height: 150px;'></td>";
                    echo "<td>" . $buku['isbn'] . "</td>";
                    echo "<td>" . $buku['ulasan'] . "</td>";
                    echo "</tr>";
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
