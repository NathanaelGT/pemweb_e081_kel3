<?php
include './core/core.php'; // Memasukkan core.php untuk koneksi database dan fungsi-fungsi lainnya

// Ambil ID pengguna dari query string
$id = $_GET['id'];

// Ambil data pengguna berdasarkan ID
$pengguna = Pengguna::cari($id);

// Jika form disubmit, proses data yang diinput
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $tanggal_lahir = $_POST['tanggal_lahir']; // Tetap sebagai string
    $email = $_POST['email'];
    $admin = isset($_POST['admin']) ? 1 : 0;

    // Update data pengguna
    $pengguna->setNama($nama);
    $pengguna->setTelepon($telepon);
    $pengguna->setTanggalLahir($tanggal_lahir); // Mengirim string
    $pengguna->setEmail($email);
    $pengguna->setAdmin($admin);

    // Simpan perubahan ke database
    $pengguna->simpan();

    // Redirect kembali ke halaman daftar pengguna
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
    <link rel="stylesheet" href="edit_pengguna.css">
</head>
<body>

<h2>Edit Pengguna</h2>

<form method="post">
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

</body>
</html>
