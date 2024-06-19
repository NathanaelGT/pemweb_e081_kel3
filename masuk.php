<?php
include './core/core.php';

if (pengguna() !== null) {
    header('Location: ./');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process(function () {
        $pengguna = array_first(Pengguna::query(['email', '=', $_POST['email']]));
        if ($pengguna === null) {
            throw new RuntimeException('Email tidak ditemukan');
        }

        if ($pengguna->cekPassword($_POST['password'])) {
            session_regenerate_id(true);

            $_SESSION['pengguna'] = $pengguna->getId();
            header('Location: ./');
        } else {
            throw new RuntimeException('Password salah');
        }
    });
}

$bodyClass = 'bookshelf-background';

$head = <<<HTML
<title>Masuk</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1 style="view-transition-name: masuk-form-judul">Masuk</h1>

        <?php include './komponen/info.php' ?>

        <form method="POST" style="view-transition-name: masuk-form" class="form">
            <?= input(name: 'email', placeholder: 'Masukkan email yang terdaftar', class: 'input', type: 'email') ?>
            <?= input(name: 'password', placeholder: 'Password', class: 'input', type: 'password', restoreValue: false) ?>

            <button class="btn btn--yellow">Masuk</button>

            <p>Tidak punya akun? <a href="./daftar.php">Daftar di sini</a></p>
        </form>
    </div>
</main>

<?php include './komponen/close.php' ?>
