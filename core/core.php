<?php

include __DIR__ . '/Database.php';
include __DIR__ . '/Model.php';
include __DIR__ . '/Pengguna.php';
include __DIR__ . '/Buku.php';
include __DIR__ . '/StokBuku.php';
include __DIR__ . '/Ulasan.php';
include __DIR__ . '/Penilaian.php';

session_start();

$basePath = './';

function pengguna(): ?Pengguna
{
    static $pengguna = false;

    if ($pengguna === false) {
        $pengguna = isset($_SESSION['pengguna'])
            ? Pengguna::cari($_SESSION['pengguna'])
            : null;
    }

    return $pengguna;
}

/**
 * @template TValue
 * 
 * @param TValue  $value
 * @param mixed  ...$moreValues
 * @return TValue
 */
function dump(mixed $value, mixed ...$moreValues): mixed
{
    $backtrace = debug_backtrace()[0];
    echo '<div style="margin: 1rem; z-index: 999; text-shadow: 0 0 1px #000">';
    echo '<pre style="padding: 0.5rem 1rem; font-size: 1.3rem; border: 2px solid red">';
    echo $backtrace['file'] . ':' . $backtrace['line'];
    echo '</pre>';

    foreach ([$value, ...$moreValues] as $value) {
        echo '<pre style="padding: 0.5rem 1rem; font-size: 1rem; border: 2px solid red; border-top: none">';
        var_dump($value);
        echo '</pre>';
    }

    echo '<div style="height: 1rem"></div>';
    echo '</div>';

    return $value;
}

function dd(mixed ...$values): never
{
    dump(...$values);

    die;
}
