<?php

php_sapi_name() === 'cli' or die;

include __DIR__ . '/Database.php';

$sql = explode(';', file_get_contents(__DIR__ . '/perpustakaan.sql'));
foreach ($sql as $q) {
    if ($q = trim($q)) {
        Database::query($q);
    }
}
