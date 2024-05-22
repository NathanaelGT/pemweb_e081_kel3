<?php if (isset($_SESSION['info'])): ?>
    <div class="info info-<?= $_SESSION['jenis_info'] ?>">
        <?= $_SESSION['info'] ?>
    </div>
    <?php /*unset($_SESSION['info'], $_SESSION['jenis_info'])*/ ?>
<?php endif ?>
