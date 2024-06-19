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

$tab = $_GET['tab'] ?? 'koleksi';
$data = match ($tab) {
    'koleksi' => Peminjaman::query(['id_pengguna', '=', $pengguna]),

    'penilaian' => Penilaian::query(['id_pengguna', '=', $pengguna]),

    'ulasan' => Ulasan::query(['id_pengguna', '=', $pengguna]),

    default => header("Location: detail_pengguna.php?id={$pengguna->getId()}") and die,
};

$daftarBuku = dict(Buku::query(['id', 'IN', $data]));

$judulHalaman = 'Detail Pengguna';
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main>
    <div class="detail__wrapper">
        <div class="detail">
            <div>
                <span>Nama</span>
                <span style="view-transition-name: pengguna-nama-<?= $pengguna->getId() ?>"><?= $pengguna->getNama() ?></span>
            </div>

            <div>
                <span>Email</span>
                <span><?= $pengguna->getEmail() ?></span>
            </div>

            <div>
                <span>Telepon</span>
                <span><?= $pengguna->getTelepon() ?></span>
            </div>

            <div>
                <span>Tanggal Lahir</span>
                <span><?= $pengguna->getTanggalLahir()->format('d/m/Y') ?></span>
            </div>

            <div>
                <span>Admin</span>
                <span><?= $pengguna->getAdmin() ? 'Ya' : 'Tidak' ?></span>
            </div>
        </div>
    </div>

    <div class="table__tab">
        <?php foreach (['koleksi', 'penilaian', 'ulasan'] as $index => $urlTab): ?>
            <a
                href="detail_pengguna.php?id=<?= $pengguna->getId() ?>&tab=<?= $urlTab ?>"
                style="view-transition-name: pengguna-tab-<?= $pengguna->getId() ?>-<?= $index ?>"
                <?= $urlTab === $tab ? 'class="active"' : '' ?>
            >
                <?= ucfirst($urlTab) ?>
            </a>
        <?php endforeach ?>
    </div>
    <div style="view-transition-name: pengguna-table-<?= $pengguna->getId() ?>" class="table__wrapper">
        <div class="table__header">
            <h1><?= ucfirst($tab) ?></h1>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>
                        <span style="view-transition-name: tbl-pengguna-cover">Cover</span>
                    </th>
                    <th>
                        <span style="view-transition-name: tbl-pengguna-judul">Judul</span>
                    </th>
                    <?php switch ($tab): case 'koleksi': ?>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <!-- <th>Tanggal Diambil</th> -->
                        <th>Tanggal Dikembalikan</th>
                    <?php break; case 'penilaian': ?>
                        <th>Penilaian</th>
                    <?php break; case 'ulasan': ?>
                        <th>Ulasan</th>
                    <?php break; endswitch ?>
                </tr>
            </thead>
            <tbody class="list">
                <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="<?= 2 + ($tab === 'koleksi' ? 4 : 1) ?>">
                            Tidak ada <?= $tab ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data as $d): ?>
                        <?php $buku = $daftarBuku[$d->getIdBuku()] ?>
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
                            <?php switch ($tab): case 'koleksi': ?>
                                <td><?= $d->getTanggalPinjam()->format('d/m/Y H:i') ?></td>
                                <td><?= $d->getTanggalKembali()->format('d/m/Y H:i') ?></td>
                                <!-- <td><?= $d->getTanggalDiambil()?->format('d/m/Y H:i') ?? '-' ?></td> -->
                                <td><?= $d->getTanggalDikembalikan()?->format('d/m/Y H:i') ?? '-' ?></td>
                            <?php break; case 'penilaian': ?>
                                <td><?= $d->getPenilaian() ?></td>
                            <?php break; case 'ulasan': ?>
                                <td><?= $d->getUlasan() ?></td>
                            <?php break; endswitch ?>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../komponen/close.php' ?>
