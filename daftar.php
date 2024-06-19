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

    process(function () {
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
    });
}

$bodyClass = 'bookshelf-background';
$judulHalaman = 'Daftar';
?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1>Daftar</h1>

        <?php include './komponen/info.php' ?>

        <form method="POST" class="form">
            <input type="text" name="email" placeholder="Alamat email" class="input" />
            <input type="tel" name="telepon" placeholder="Nomor telepon" class="input" />
            <input type="text" name="name" placeholder="Nama lengkap" class="input" />
            <input type="text" name="tanggal_lahir" placeholder="Tanggal lahir" class="input" />
            <input type="password" name="password" placeholder="Password" class="input" />
            <input type="password" name="konfirmasi_password" placeholder="Konfirmasi password" class="input" />

            <button class="btn btn--yellow">Daftar</button>

            <p>Sudah punya akun? <a href="./masuk.php">Masuk di sini</a></p>
        </form>
    </div>
</main>

<script>
    scripts.add(function () {
        new AirDatepicker('input[name="tanggal_lahir"]', { locale: airDatepickerLocale })
    })
</script>

<?php include './komponen/close.php' ?>
