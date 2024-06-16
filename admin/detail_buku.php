<?php
include '../core/core.php';

$basePath = '../';

if (!pengguna()?->getAdmin()) {
    header("Location: $basePath");
    die;
}

$buku = Buku::cari(@$_GET['id']);
if ($buku === null) {
    header('Location: buku.php');
    die;
}

$tab = $_GET['tab'] ?? 'peminjaman';
$data = match ($tab) {
    'peminjaman' => Peminjaman::query(['id_buku', '=', $buku]),

    'ulasan' => Ulasan::query(['id_buku', '=', $buku]),

    'penilaian' => Penilaian::query(['id_buku', '=', $buku]),

    default => header("Location: detail_buku.php?id={$buku->getId()}") and die,
};

$daftarPengguna = dict(Pengguna::query(['id', 'IN', $data]));

$judulHalaman = 'Detail Buku';
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main>
    <div class="detail__wrapper">
        <div class="detail">
            <div>
                <span>ISBN</span>
                <span><?= $buku->getIsbn() ?></span>
            </div>

            <div>
                <span>Judul</span>
                <span style="view-transition-name: buku-judul-<?= $buku->getId() ?>"><?= $buku->getJudul() ?></span>
            </div>

            <div>
                <span>Kategori</span>
                <span><?= $buku->getKategori() ?></span>
            </div>

            <div>
                <span>Penulis</span>
                <span><?= $buku->getPenulis() ?></span>
            </div>

            <div>
                <span>Terbit</span>
                <span><?= $buku->getTerbit()->format('d/m/Y') ?></span>
            </div>

            <div>
                <span>Penerbit</span>
                <span><?= $buku->getPenerbit() ?></span>
            </div>
        </div>
    </div>

    <div class="table__tab">
        <?php foreach (['peminjaman', 'ulasan', 'penilaian'] as $urlTab): ?>
            <a
                href="detail_buku.php?id=<?= $buku->getId() ?>&tab=<?= $urlTab ?>"
                <?= $urlTab === $tab ? 'class="active"' : '' ?>
            >
                <?= ucfirst($urlTab) ?>
            </a>
        <?php endforeach ?>
    </div>
    <div class="table__wrapper">
        <div class="table__header">
            <h1><?= ucfirst($tab) ?></h1>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>
                        <span style="view-transition-name: tbl-buku-foto">Foto</span>
                    </th>
                    <th>
                        <span style="view-transition-name: tbl-buku-nama">Nama</span>
                    </th>
                    <?php switch ($tab): case 'peminjaman': ?>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Dikembalikan</th>
                    <?php break; case 'ulasan': ?>
                        <th>Ulasan</th>
                    <?php break; case 'penilaian': ?>
                        <th>Penilaian</th>
                    <?php break; endswitch ?>
                </tr>
            </thead>
            <tbody class="list">
                <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="<?= 2 + ($tab === 'peminjaman' ? 2 : 1) ?>">
                            Tidak ada <?= $tab ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data as $d): ?>
                        <?php $pengguna = $daftarPengguna[$d->getIdPengguna()] ?>
                        <tr>
                            <td>
                                <img
                                    src="<?= $pengguna->getFotoProfil() ?>"
                                    alt="Foto <?= $pengguna->getNama() ?>"
                                    style="view-transition-name: pengguna-foto-<?= $pengguna->getId() ?>"
                                    class="profile-picture"
                                />
                            </td>
                            <td>
                                <span style="view-transition-name: pengguna-nama-<?= $pengguna->getId() ?>">
                                    <?= $pengguna->getNama() ?>
                                </span>
                            </td>
                            <?php switch ($tab): case 'peminjaman': ?>
                                <td><?= $d->getTanggalPinjam()->format('d/m/Y H:i') ?></td>
                                <td><?= $d->getTanggalDikembalikan()?->format('d/m/Y H:i') ?? 'Belum dikembalikan' ?></td>
                            <?php break; case 'ulasan': ?>
                                <td><?= $d->getUlasan() ?></td>
                            <?php break; case 'penilaian': ?>
                                <td><?= $d->getPenilaian() ?></td>
                            <?php break; endswitch ?>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../komponen/close.php' ?>
