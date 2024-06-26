<?php
include '../core/core.php';

$basePath = '../';

if (!pengguna()?->getAdmin()) {
    header("Location: $basePath");
    die;
}

$judulHalaman = 'Daftar Buku';
$daftarBuku = Buku::semua();
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main>
    <div class="table__info">
        <?php include '../komponen/info.php' ?>
    </div>

    <div class="table__wrapper">
        <div class="table__header">
            <h1>Daftar Buku</h1>
            <div class="table__header__button">
                <a href="tambah_buku.php" class="btn btn--green">Tambah Buku</a>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="list">
                <?php foreach ($daftarBuku as $buku): ?>
                    <tr>
                        <td>
                            <img
                                src="<?= $buku->getCover() ?>"
                                alt="Cover buku <?= $buku->getJudul() ?>"
                                style="view-transition-name: buku-cover-<?= $buku->getId() ?>"
                                class="thumbnail"
                            />
                        </td>
                        <td>
                            <span style="view-transition-name: buku-judul-<?= $buku->getId() ?>">
                                <?= $buku->getJudul() ?>
                            </span>
                        </td>
                        <td><?= $buku->getPenulis() ?></td>
                        <td><?= $buku->getPenerbit() ?></td>
                        <td><?= $buku->getTerbit()->format('d/m/Y') ?></td>
                        <td><?= $buku->getKategori() ?></td>
                        <td>
                            <div class="table__actions table__actions--vertical">
                                <a href="detail_buku.php?id=<?= $buku->getId() ?>" class="btn btn--blue">Detail</a>
                                <a href="edit_buku.php?id=<?= $buku->getId() ?>" class="btn btn--yellow">Edit</a>
                                <a href="hapus_buku.php?id=<?= $buku->getId() ?>" class="btn btn--red">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../komponen/close.php' ?>
