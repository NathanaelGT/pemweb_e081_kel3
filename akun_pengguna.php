<?php
include './core/core.php';

if (is_null($pengguna = pengguna())) {
    header('Location: ./masuk.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process(function () use ($pengguna) {
        if (isset($_FILES['foto'])) {
            $pengguna->setFoto(handle_upload($_FILES['foto'], 'pengguna-' . $pengguna->getId()));
        }

        $pengguna->setNama($_POST['nama'])
            ->setEmail($_POST['email'])
            ->setTelepon($_POST['telepon'])
            ->setTanggalLahir($_POST['tanggal_lahir']);

        if ($pengguna->simpan()) {
            $_SESSION['info'] = 'Data berhasil diperbarui';
            $_SESSION['jenis_info'] = 'success';
        } else {
            $_SESSION['info'] = 'Data gagal diperbarui';
            $_SESSION['jenis_info'] = 'error';
        }

        header('Location: ./akun_pengguna.php');
    }, './akun_pengguna.php');
}

$editMode = isset($_SESSION['info']);

$bodyClass = 'dark-gray-background';
$head = <<<HTML
<title>Profile</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<main class="form__wrapper">
    <div>
        <h1>Profile</h1>

        <?php include './komponen/info.php' ?>

        <div id="view-mode" <?= $editMode ? 'style="display:none"' : '' ?>>
            <div class="profile__info">
                <div>
                    <img
                        src="<?= htmlspecialchars($pengguna->getFotoProfil()); ?>"
                        alt="Profile Picture"
                        class="profile-picture profile-picture--super-large"
                    />
                </div>

                <div>
                    <p class="book-overview__title"><?= htmlspecialchars($pengguna->getNama()); ?></p>
                    <p><?= htmlspecialchars($pengguna->getEmail()); ?></p>
                    <p><?= htmlspecialchars($pengguna->getTelepon()); ?></p>
                    <p><?= htmlspecialchars($pengguna->getTanggalLahir()->format('d/m/Y')); ?></p>
                </div>
            </div>

            <button class="btn btn--green" onclick="toggleEditMode()">Edit Biodata</button>
        </div>

        <div id="edit-mode" <?= $editMode ? '' : 'style="display:none"' ?>>
            <form method="POST" enctype="multipart/form-data" class="form">
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
                    <input type="text" name="telepon" required value="<?= $pengguna->getTelepon() ?>" class="input">
                </label>

                <label class="label">
                    <span>Tanggal lahir</span>
                    <input type="text" name="tanggal_lahir" required value="<?= $pengguna->getTanggalLahir()->format('Y-m-d') ?>" class="input">
                </label>

                <label class="label">
                    <span>Foto profil</span>
                    <input type="file" name="foto" accept=".jpg, .jpeg, .png, .webp" class="input">
                </label>

                <div class="form__button-groups">
                    <button type="button" class="btn btn--light-gray" onclick="toggleEditMode()">Batal</button>
                    <button class="btn btn--green">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    function toggleEditMode() {
        const viewMode = document.getElementById('view-mode');
        const editMode = document.getElementById('edit-mode');
        if (viewMode.style.display === 'none') {
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
        } else {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
        }
    }

    scripts.add(function () {
        new AirDatepicker('input[name="tanggal_lahir"]', { locale: airDatepickerLocale })
    })
</script>

<?php include './komponen/close.php' ?>
