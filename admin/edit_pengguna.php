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
    process(function () use ($pengguna) {
        if (!empty(Pengguna::query(['email', '=', $_POST['email']], ['id', '!=', $pengguna]))) {
            throw new RuntimeException('Email sudah terdaftar');
        }

        $pengguna
            ->setNama($_POST['nama'])
            ->setTelepon($_POST['telepon'])
            ->setTanggalLahir($_POST['tanggal_lahir'])
            ->setEmail($_POST['email'])
            ->setAdmin(isset($_POST['admin']) ? 1 : 0)
            ->simpan();

        $_SESSION['info'] = "Data \"{$pengguna->getNama()}\" berhasil diedit";
        $_SESSION['jenis_info'] = 'success';

        header('Location: pengguna.php');
    });
}

$bodyClass = 'bookshelf-background';
$judulHalaman = 'Edit Pengguna';
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1 style="view-transition-name: edit_pengguna-<?= $pengguna->getId() ?>-form-judul">
            Edit Pengguna
        </h1>

        <?php include '../komponen/info.php' ?>

        <form method="POST" style="view-transition-name: edit_pengguna-<?= $pengguna->getId() ?>-form" class="form">
            <label class="label">
                <span>Nama</span>
                <?= input(name: 'nama', value: $pengguna->getNama(), required: true, class: 'input') ?>
            </label>

            <label class="label">
                <span>Email</span>
                <?= input(name: 'email', value: $pengguna->getEmail(), required: true, class: 'input', type: 'email') ?>
            </label>

            <label class="label">
                <span>Telepon</span>
                <?= input(name: 'telepon', value: $pengguna->getTelepon(), required: true, class: 'input', type: 'tel') ?>
            </label>

            <label class="label">
                <span>Tanggal Lahir</span>
                <?= input(name: 'tanggal_lahir', value: $pengguna->getTanggalLahir()->format('Y-m-d'), required: true, class: 'input') ?>
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
    scripts.add(function () {
        new AirDatepicker('input[name="tanggal_lahir"]', { locale: airDatepickerLocale })
    })
</script>

<?php include '../komponen/close.php' ?>
