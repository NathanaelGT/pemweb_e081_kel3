<section class="page-title">
    <h1 class="page-title__title"><?= $judulHalaman ?></h1>

    <?php if (isset($daftarKategori)): ?>
        <form method="GET" <?= isset($action) ? "action=\"$action\"" : '' ?> class="page-title__content">
            <select name="kategori" class="input">
                <?php if (isset($_GET['kategori']) && $_GET['kategori']): ?>
                    <option value>Semua</option>
                    <?php foreach ($daftarKategori as $kategori): ?>
                        <option <?= $_GET['kategori'] === $kategori ? 'selected' : '' ?>>
                            <?= $kategori ?>
                        </option>
                    <?php endforeach ?>
                <?php else: ?>
                    <option selected hidden value class="select__placeholder">Kategori</option>
                    <option value>Semua</option>
                    <?php foreach ($daftarKategori as $kategori): ?>
                        <option><?= $kategori ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            </select>

            <div class="input">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="input__icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>

                <input type="text" name="kueri" value="<?= $_GET['kueri'] ?? '' ?>" placeholder="Cari" />
            </div>
        </form>
    <?php endif ?>
</section>
