<?php
include '../core/core.php'; 

$basePath = '../';

if (!pengguna()?->getAdmin()) {
    header("Location: $basePath");
    die;
}

$pengguna = Pengguna::cari(@$_GET['id']);
if ($pengguna === null) {
    header('Location: pengguna.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengguna
        ->setNama($_POST['nama'])
        ->setTelepon($_POST['telepon'])
        ->setTanggalLahir($_POST['tanggal_lahir'])
        ->setEmail($_POST['email'])
        ->setAdmin(isset($_POST['admin']) ? 1 : 0)
        ->simpan();

    header('Location: pengguna.php');
    die;
}

$basePath = '../';
$bodyClass = 'bookshelf-background';

$head = <<<HTML
<link href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.1/air-datepicker.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.1/air-datepicker.min.js" defer></script>
<title>Edit Pengguna</title>
HTML ?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1>Edit Pengguna</h1>

        <?php include '../komponen/info.php' ?>

        <form method="POST" class="form">
            <label class="label">
                <span>Nama</span>
                <input type="text" name="nama" required value="<?= $pengguna->getNama() ?>" class="input">
            </label>

            <label class="label">
                <span>Email</span>
                <input type="email" name="email" required value="<?= $pengguna->getEmail() ?>" class="input">
            </label>

            <label class="label">
                <span>Telepon</span>
                <input type="tel" name="telepon" required value="<?= $pengguna->getTelepon() ?>" class="input">
            </label>

            <label class="label">
                <span>Tanggal Lahir</span>
                <input type="text" name="tanggal_lahir" required value="<?= $pengguna->getTanggalLahir()->format('Y-m-d') ?>" class="input">
            </label>

            <label class="label">
                <span>Admin</span>
                <div>
                    <input type="checkbox" name="admin" <?= $pengguna->getAdmin() ? 'checked' : '' ?>>
                </div>
            </label>

            <button type="submit" class="btn btn--green">Edit Pengguna</button>
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

<?php include '../komponen/close.php' ?>
