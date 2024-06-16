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

$tab = $_GET['tab'] ?? 'buku_yang_sedang_dipinjam';
$data = match ($tab) {
    'buku_yang_sedang_dipinjam' => Peminjaman::query(['id_pengguna', '=', pengguna()], ['tanggal_dikembalikan', 'is', null]),

    'penilaian' => Penilaian::query(['id_pengguna', '=', $pengguna]),

    'ulasan' => Ulasan::query(['id_pengguna', '=', $pengguna]),

    default => header('Location: detail_pengguna.php') and die,
};

$daftarBuku = Buku::query(['id', 'IN', $data]);

$judulHalaman = 'Detail Pengguna';
?>

<?php include '../komponen/open.php' ?>
<?php include '../komponen/header.php' ?>

<main>
    <div class="detail__wrapper">
        <div class="detail">
            <div>
                <span>Nama</span>
                <span><?= $pengguna->getNama() ?></span>
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
                <span><?= $pengguna->getTanggalLahir()->format('d-m-Y') ?></span>
            </div>

            <div>
                <span>Admin</span>
                <span><?= $pengguna->getAdmin() ? 'Ya' : 'Tidak' ?></span>
            </div>
        </div>
    </div>

    <div class="table__tab">
        <?php foreach (['buku_yang_sedang_dipinjam', 'penilaian', 'ulasan'] as $urlTab): ?>
            <a
                href="detail_pengguna.php?id=<?= $pengguna->getId() ?>&tab=<?= $urlTab ?>"
                <?= $urlTab === $tab ? 'class="active"' : '' ?>
            >
                <?= implode(' ', array_map(ucfirst(...), explode('_', $urlTab))) ?>
            </a>
        <?php endforeach ?>
    </div>
    <div class="table__wrapper">
        <div class="table__header">
            <h1><?= implode(' ', array_map(ucfirst(...), explode('_', $tab))) ?></h1>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Judul</th>
                    <?php switch ($tab): case 'buku_yang_sedang_dipinjam': ?>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Diambil</th>
                        <th>Tanggal Dikembalikan</th>
                    <?php break; case 'penilaian': ?>
                        <th>Penilaian</th>
                    <?php break; case 'ulasan': ?>
                        <th>Ulasan</th>
                    <?php break; endswitch ?>
                </tr>
            </thead>
            <tbody class="list">
                <?php if (empty($daftarBuku)): ?>
                    <tr>
                        <td colspan="<?= 2 + ($tab === 'buku_yang_sedang_dipinjam' ? 4 : 1) ?>">
                            Tidak ada <?= implode(' ', explode('_', $tab)) ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarBuku as $index => $buku): ?>
                        <tr>
                            <td>
                                <img
                                    src="<?= $buku->getCover() ?>"
                                    alt="Cover buku <?= $buku->getJudul() ?>"
                                    class="thumbnail"
                                />
                            </td>
                            <td><?= $buku->getJudul() ?></td>
                            <?php switch ($tab): case 'buku_yang_sedang_dipinjam': ?>
                                <td><?= $data[$index]->getTanggalPinjam()->format('d-m-Y H:i') ?></td>
                                <td><?= $data[$index]->getTanggalKembali()->format('d-m-Y H:i') ?></td>
                                <td><?= $data[$index]->getTanggalDiambil()->format('d-m-Y H:i') ?></td>
                                <td><?= $data[$index]->getTanggalDikembalikan()->format('d-m-Y H:i') ?></td>
                            <?php break; case 'penilaian': ?>
                                <td><?= $data[$index]->getPenilaian() ?></td>
                            <?php break; case 'ulasan': ?>
                                <td><?= $data[$index]->getUlasan() ?></td>
                            <?php break; endswitch ?>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../komponen/close.php' ?>
