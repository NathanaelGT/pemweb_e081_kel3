<?php
include './core/core.php';

if (($pengguna = pengguna()) === null) {
    header('Location: ./masuk.php');
    die;
}

$pengguna = Pengguna::cari($pengguna->getId());

if ($pengguna === null) {
    $_SESSION['info'] = 'Pengguna tidak ditemukan';
    $_SESSION['jenis_info'] = 'error';
    header('Location: ./masuk.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengguna->setNama($_POST['nama'])
        ->setEmail($_POST['email'])
        ->setTelepon($_POST['telepon'])
        ->setTanggalLahir($_POST['tanggal_lahir']);

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $fileSize = $_FILES['foto']['size'];
        $fileType = $_FILES['foto']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $pengguna->getId() . '.' . $fileExtension;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $pengguna->setFoto($dest_path);
            }
        }
    }

    if ($pengguna->simpan()) {
        $_SESSION['info'] = 'Data berhasil diperbarui';
        $_SESSION['jenis_info'] = 'success';
    } else {
        $_SESSION['info'] = 'Data gagal diperbarui';
        $_SESSION['jenis_info'] = 'error';
    }

    header('Location: ./akun_pengguna.php');
    die;
}

$head = <<<HTML
<title>Profile</title>
HTML;
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/akunpengguna.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include './komponen/open.php' ?>
    <?php include './komponen/header.php' ?>
</head>
<body class="bookshelf-background">
<main class="profile">

    <div class="title">
        <h1>Profile</h1>
    </div>
        
    <div class="content">
        
        <div id="view-mode">
            <table>
                <tr>
                    <td>
                        <div class="profile-picture">
                        <img src="<?= htmlspecialchars($pengguna->getFoto() ?? 'default_profile.png'); ?>" alt="Profile Picture">
                         </div>
                    </td>
                    <td><h1><?= htmlspecialchars($pengguna->getNama()); ?></h1>
                        <p><?= htmlspecialchars($pengguna->getEmail()); ?></p>
                        <p><?= htmlspecialchars($pengguna->getTelepon()); ?></p>
                        <p><?= htmlspecialchars($pengguna->getTanggalLahir()->format('d/m/Y')); ?></p>
                    </td>
                </tr>
            </table>
            <br>
            <button class="btn btn-primary" onclick="toggleEditMode()">Edit Biodata</button>
        </div>

        <div id="edit-mode" style="display:none;">
            <form method="post" enctype="multipart/form-data" class="text-white">
                <table class="table">
                    <tr>
                        <td><input type="text" name="nama" value="<?= htmlspecialchars($pengguna->getNama()); ?>" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><input type="email" name="email" value="<?= htmlspecialchars($pengguna->getEmail()); ?>" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="telepon" value="<?= htmlspecialchars($pengguna->getTelepon()); ?>" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($pengguna->getTanggalLahir()->format('Y-m-d')); ?>" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><input type="file" name="foto" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Batal</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</main>

<?php include './komponen/close.php'; ?>
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
</script>
</body>
</html>
