<?php
include('../core/Database.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <link rel="stylesheet" href="styleindex.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="index.js"></script>
</head>

<?php
$query = "SELECT * FROM `buku`";
$result = Database::query($query);
?>

<body>
    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 'ok') {
            echo '<div class="success">Sukses!, data berhasil disimpan</div>';
        } elseif ($status == 'err') {
            echo '<div class="error">ERROR!, data gagal disimpan</div>';
        }
    }
    ?>

    <p id="header"><img src="logo.png" alt="logo" style="width: 100px; height: auto;"></p>
    <hr>

    <h1>Data Buku</h1>
    <div class="grid-container">
        <div class="grid-item">
            <div class="kiri">
                <a href="formbuku.php">Tambah Data</a>
            </div>
            
            <div class="kanan">
                <input id="myInput" type="text" placeholder="Search..">
            </div>
        </div>
    </div> 

    <div id="table">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Sinopsis</th>
                    <th>Terbit</th>
                    <th>Penerbit</th>
                    <th>ISBN</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody id="myTable">
                <?php foreach ($result as $data) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['judul']); ?></td>
                        <td><?php echo htmlspecialchars($data['kategori']); ?></td>
                        <td><?php echo htmlspecialchars($data['penulis']); ?></td>
                        <td><?php echo htmlspecialchars($data['sinopsis']); ?></td>
                        <td><?php echo htmlspecialchars($data['terbit']); ?></td>
                        <td><?php echo htmlspecialchars($data['penerbit']); ?></td>
                        <td><?php echo htmlspecialchars($data['isbn']); ?></td>
                        <td>
                            <p><a class="edit" href="<?php echo "update.php?id=" . $data['id']; ?>">UPDATE//blm ada</a></p>
                            <br>
                            <p><a class="edit" href="<?php echo "delete.php?id=" . $data['id']; ?>">DELETE//blm ada</a></p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
