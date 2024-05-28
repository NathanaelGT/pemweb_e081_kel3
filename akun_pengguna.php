<?php
include './core/core.php';

if (($pengguna = pengguna()) === null) {
    header('Location: ./masuk.php');
    die;
}

$pengguna = Pengguna::cari($pengguna->getId());

if ($pengguna === null) {
    $_SESSION['info'] = 'Pengguna tidak ditemukan';
    $_SESSION['jenis_info'] = 'error';
    header('Location: ./masuk.php');
    die;
}

$head = <<<HTML
<title>Profile</title>
HTML;
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/akunpengguna.css">
        
        <?php include './komponen/open.php' ?>
        <?php include './komponen/header.php' ?>
    </head>

    <body>
        
    </body>
</html>
<main class="profile">

    <div class="topnav">
        <h1>Profile</h1>
    </div>

    <div class="content">
        <table>
            <tr>
                <th>Nama</th>
                <td><?= htmlspecialchars($pengguna->getNama()); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($pengguna->getEmail()); ?></td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td><?= htmlspecialchars($pengguna->getTelepon()); ?></td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td><?= htmlspecialchars($pengguna->getTanggalLahir()->format('d/m/Y')); ?></td>
            </tr>
        </table>
        
    </div>
</main>

<?php include './komponen/close.php'; ?>
