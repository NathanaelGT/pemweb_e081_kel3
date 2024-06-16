<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="turbo-prefetch" content="false">
    <meta name="view-transition" content="same-origin">
    <link href="https://fonts.cdnfonts.com/css/metropolis-2" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <?php if (isset($head)): ?>
        <?= $head ?>
    <?php else: ?>
        <title><?= $judulHalaman ?></title>
    <?php endif ?>

    <link rel="stylesheet" href="<?= $basePath ?>assets/main.css">
    <script src="https://unpkg.com/@hotwired/turbo@8.0.4/dist/turbo.es2017-umd.js"></script>
    <script src="<?= $basePath ?>assets/main.js" defer></script>
</head>
<body <?= isset($bodyClass) ? "class=\"$bodyClass\"" : '' ?>>
