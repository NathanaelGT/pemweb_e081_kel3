<?php include './core/core.php' ?>

<?php $head = <<<HTML
<title>Home</title>
HTML ?>

<?php include './komponen/open.php' ?>
<?php include './komponen/header.php' ?>

<div style="background-color: var(--white)">
    <?= 'Hello ' . (pengguna()?->getNama() ?? 'world') . '!' ?>
</div>

<?php include './komponen/close.php' ?>
