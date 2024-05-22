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
?>

<?php $head = <<<HTML
<title>Masuk</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<main class="auth">
    <div>
        <h1>Masuk</h1>

        <?php include './komponen/info.php' ?>

        <form method="POST">
            <input type="text" name="email" placeholder="Masukkan email yang terdaftar" />
            <input type="password" name="password" placeholder="Password" />

            <button>Masuk</button>

            <p>Tidak punya akun? <a href="./daftar.php">Daftar di sini</a></p>
        </form>
    </div>
</main>

<?php include './komponen/close.php' ?>
