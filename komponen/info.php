<?php if (isset($_SESSION['info'])): ?>
    <div>
        <?= $_SESSION['info'] ?>
    </div>
    <?php unset($_SESSION['info'], $_SESSION['jenis_info']) ?>
<?php endif ?>
