<?php
include './core/core.php';

if (pengguna() !== null) {
    header('Location: ./');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process(function () {
        if ($_POST['password'] !== $_POST['konfirmasi_password']) {
            throw new RuntimeException('Konfirmasi password tidak sama');
        }

        if (!empty(Pengguna::query(['email', '=', $_POST['email']]))) {
            throw new RuntimeException('Email sudah terdaftar');
        }

        $pengguna = (new Pengguna)
            ->setEmail($_POST['email'])
            ->setTelepon($_POST['telepon'])
            ->setNama($_POST['nama'])
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
        <h1 style="view-transition-name: daftar-form-judul">Daftar</h1>

        <?php include './komponen/info.php' ?>

        <form method="POST" style="view-transition-name: daftar-form" class="form">
            <?= input(name: 'email', placeholder: 'Alamat email', class: 'input', type: 'email') ?>
            <?= input(name: 'telepon', placeholder: 'Nomor telepon', class: 'input', type: 'tel') ?>
            <?= input(name: 'nama', placeholder: 'Nama lengkap', class: 'input') ?>
            <?= input(name: 'tanggal_lahir', placeholder: 'Tanggal lahir', class: 'input') ?>
            <?= input(name: 'password', placeholder: 'Password', class: 'input', type: 'password', restoreValue: false) ?>
            <?= input(name: 'konfirmasi_password', placeholder: 'Konfirmasi password', class: 'input', type: 'password', restoreValue: false) ?>

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
