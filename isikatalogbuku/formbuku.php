<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="form.css">
    <title>Insert Data Buku</title>
</head>
<body>

    <h1>Form Data Buku</h1>
    
    <div class="kanan">
        <a href="index.php">Lihat Data</a>
    </div>
    
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
    
    <br>
    <form method="POST" action="process_form.php">
        <table>
            <tr>
                <td>Judul</td>
                <td><input type="text" name="judul" required></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td><input type="text" name="kategori" required></td>
            </tr>
            <tr>
                <td>Penulis</td>
                <td><input type="text" name="penulis" required></td>
            </tr>
            <tr>
                <td>Sinopsis</td>
                <td><textarea name="sinopsis" cols="50" rows="10" required></textarea></td>
            </tr>
            <tr>
                <td>Terbit</td>
                <td><input type="datetime-local" name="terbit" required></td>
            </tr>
            <tr>
                <td>Penerbit</td>
                <td><input type="text" name="penerbit" required></td>
            </tr>
            <tr>
                <td>ISBN</td>
                <td><input type="number" name="isbn" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="SUBMIT"></td>
            </tr>
        </table>
    </form>
</body>
</html>
