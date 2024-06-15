<?php
include './core/core.php';

if (pengguna() !== null) {
    header('Location: ./');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pengguna = Pengguna::query(['email', '=', $_POST['email']]);
        if (empty($pengguna)) {
            $_SESSION['info'] = 'Email tidak ditemukan';
            $_SESSION['jenis_info'] = 'error';
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }

        $pengguna = $pengguna[0];

        if ($pengguna->cekPassword($_POST['password'])) {
            session_regenerate_id(true);

            $_SESSION['pengguna'] = $pengguna->getId();
            header('Location: ./');
        } else {
            $_SESSION['info'] = 'Password salah';
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

$bodyClass = 'bookshelf-background';

$head = <<<HTML
<title>Masuk</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1>Masuk</h1>

        <?php include './komponen/info.php' ?>

        <form method="POST" class="form">
            <input type="text" name="email" placeholder="Masukkan email yang terdaftar" class="input" />
            <input type="password" name="password" placeholder="Password" class="input" />

            <button class="btn btn--yellow">Masuk</button>

            <p>Tidak punya akun? <a href="./daftar.php">Daftar di sini</a></p>
        </form>
    </div>
</main>

<?php include './komponen/close.php' ?>
