<?php
include './core/core.php';

$pengguna = Pengguna::semua();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pengguna</title>
    <link rel="stylesheet" href="assets/daftar_pengguna.css">

</head>
<body>

<h2>Tabel Pengguna</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Tanggal Lahir</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Edit</th>
            <th>Detail Pengguna</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pengguna as $user): ?>
            <tr>
                <td><?php echo $user->getId(); ?></td>
                <td><?php echo $user->getNama(); ?></td>
                <td><?php echo $user->getTelepon(); ?></td>
                <td><?php echo $user->getTanggalLahir()->format('Y-m-d'); ?></td>
                <td><?php echo $user->getEmail(); ?></td>
                <td><?php echo $user->getAdmin() ? 'Ya' : 'Tidak'; ?></td>
                <td><a href="edit_pengguna.php?id=<?php echo $user->getId(); ?>"><button>Edit</button></a></td>
                <td><a href="detail_pengguna.php?id=<?php echo $user->getId(); ?>"><button>Detail Pengguna</button></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
