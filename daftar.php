<?php
include './core/core.php';

if (pengguna() !== null) {
    header('Location: ./');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['password'] !== $_POST['konfirmasi_password']) {
        $_SESSION['info'] = 'Konfirmasi password tidak sama';
        $_SESSION['jenis_info'] = 'error';

        header('Location: ' . $_SERVER['REQUEST_URI']);
        die;
    }

    if (!empty(Pengguna::query(['email', '=', $_POST['email']]))) {
        $_SESSION['info'] = 'Email sudah terdaftar';
        $_SESSION['jenis_info'] = 'error';

        header('Location: ' . $_SERVER['REQUEST_URI']);
        die;
    }

    try {
        $pengguna = (new Pengguna)
            ->setEmail($_POST['email'])
            ->setTelepon($_POST['telepon'])
            ->setNama($_POST['name'])
            ->setTanggalLahir($_POST['tanggal_lahir'])
            ->setPassword($_POST['password']);

        if ($pengguna->simpan()) {
            session_regenerate_id(true);

            $_SESSION['pengguna'] = $pengguna->getId();
            $_SESSION['info'] = 'Berhasil mendaftar';
            $_SESSION['jenis_info'] = 'success';
            header('Location: ./');
        } else {
            $_SESSION['info'] = 'Gagal mendaftar. Harap coba lagi nanti';
            $_SESSION['jenis_info'] = 'error';
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } catch (Throwable $e) {
        $_SESSION['info'] = $e instanceof RuntimeException ? $e->getMessage() : 'Data tidak valid';
        $_SESSION['jenis_info'] = 'error';

        header('Location: ' . $_SERVER['REQUEST_URI']);
    } finally {
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
</head>
<body>
    <h1>Daftar</h1>

    <?php include './komponen/info.php' ?>

    <form method="POST">
        <input type="text" name="email" placeholder="Alamat dmail" />
        <input type="tel" name="telepon" placeholder="Nomor telepon" />
        <input type="text" name="name" placeholder="Nama lengkap" />
        <input type="date" name="tanggal_lahir" placeholder="Tanggal lahir" />
        <input type="password" name="password" placeholder="Password" />
        <input type="password" name="konfirmasi_password" placeholder="Konfirmasi password" />

        <button>Daftar</button>

        <p>Sudah punya akun? <a href="./masuk.php">Masuk di sini</a></p>
    </form>
</body>
</html>
