<?php
include './core/core.php'; 

$id = $_GET['id'];

$pengguna = Pengguna::cari($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $email = $_POST['email'];
    $admin = isset($_POST['admin']) ? 1 : 0;

    $pengguna->setNama($nama);
    $pengguna->setTelepon($telepon);
    $pengguna->setTanggalLahir($tanggal_lahir);
    $pengguna->setEmail($email);
    $pengguna->setAdmin($admin);

    $pengguna->simpan();

    header('Location: daftar_pengguna.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="assets/edit_pengguna.css">
</head>
<body>

<div class="header">
    <h2>Edit Pengguna</h2>
</div>

<div class="container">
    <form method="post">
    <a href="daftar_pengguna.php" class="back-button"><span class="arrow">&#65308;</span> Kembali ke daftar pengguna</a>


        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $pengguna->getNama(); ?>" required>

        <label for="telepon">Telepon:</label>
        <input type="text" id="telepon" name="telepon" value="<?php echo $pengguna->getTelepon(); ?>" required>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $pengguna->getTanggalLahir()->format('Y-m-d'); ?>" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $pengguna->getEmail(); ?>" required>

        <label for="admin">Admin:</label>
        <input type="checkbox" id="admin" name="admin" <?php echo $pengguna->getAdmin() ? 'checked' : ''; ?>>

        <button type="submit">Simpan</button>
    </form>
</div>

</body>
</html>
