<?php
include '../core/core.php';

$basePath = '../';

if (!pengguna()?->getAdmin()) {
    header("Location: $basePath");
    die;
}

$judulHalaman = 'Daftar Pengguna';
$daftarPengguna = Pengguna::semua();
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main>
    <div class="table__info">
        <?php include '../komponen/info.php' ?>
    </div>

    <div class="table__wrapper">
        <div class="table__header">
            <h1>Pengguna Buku</h1>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Tanggal Lahir</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daftarPengguna as $pengguna): ?>
                    <tr>
                        <td>
                            <img
                                src="<?= $pengguna->getFotoProfil() ?>"
                                alt="Foto profil <?= $pengguna->getNama() ?>"
                                class="profile-picture profile-picture--large"
                            />
                        </td>
                        <td><?= $pengguna->getNama() ?></td>
                        <td><?= $pengguna->getTelepon() ?></td>
                        <td><?= $pengguna->getTanggalLahir()->format('d-m-Y') ?></td>
                        <td><?= $pengguna->getEmail() ?></td>
                        <td><?= $pengguna->getAdmin() ? 'Ya' : 'Tidak' ?></td>
                        <td>
                            <div class="table__actions">
                                <a href="Detail_pengguna.php?id=<?= $pengguna->getId() ?>" class="btn btn--blue">Detail</a>
                                <a href="edit_pengguna.php?id=<?= $pengguna->getId() ?>" class="btn btn--yellow">Edit</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../komponen/close.php' ?>
