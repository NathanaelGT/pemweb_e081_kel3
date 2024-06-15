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

$bodyClass = 'bookshelf-background';

$head = <<<HTML
<link href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.1/air-datepicker.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.1/air-datepicker.min.js" defer></script>
<title>Daftar</title>
HTML ?>

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
    document.addEventListener('DOMContentLoaded', () => {
        new AirDatepicker('input[name="tanggal_lahir"]', {
            locale: {
                days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                daysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                daysMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                today: 'Hari ini',
                clear: 'Hapus',
                dateFormat: 'dd/MM/yyyy',
                timeFormat: 'hh:mm aa',
                firstDay: 1
            }
        })
    })
</script>

<?php include './komponen/close.php' ?>
