<?php

include __DIR__ . '/Database.php';
include __DIR__ . '/Model.php';
include __DIR__ . '/Pengguna.php';
include __DIR__ . '/Buku.php';
include __DIR__ . '/Peminjaman.php';
include __DIR__ . '/StokBuku.php';
include __DIR__ . '/Ulasan.php';
include __DIR__ . '/Penilaian.php';
include __DIR__ . '/Komentar.php';

setlocale(LC_TIME, '');
date_default_timezone_set('Asia/Jakarta');

if (php_sapi_name() !== 'cli') {
    session_start();
}

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

function array_map_with_keys(callable $callback, array $array): array
{
    $hasil = [];

    foreach ($array as $key => $value) {
        foreach ($callback($value, $key) as $mapKey => $mapValue) {
            $hasil[$mapKey] = $mapValue;
        }
    }

    return $hasil;
}

function array_group(callable $callback, array $array): array
{
    $hasil = [];

    foreach ($array as $key => $value) {
        foreach ($callback($value, $key) as $mapKey => $mapValue) {
            $hasil[$mapKey][] = $mapValue;
        }
    }

    return $hasil;
}

function parse_datetime(DateTime | string | null $dateTime): ?DateTime
{
    if (is_string($dateTime)) {
        if ($dateTime === 'now') {
            return new DateTime();
        }

        $format = str_contains($dateTime, ':')
            ? 'd/m/Y h:i a'
            : 'd/m/Y';

        return DateTime::createFromFormat($format, $dateTime);
    }

    return $dateTime;
}

/**
 * @template TModel
 * 
 * @param TModel[] $model
 * @return array<int, TModel>
 */
function dict(array $model): array
{
    return array_map_with_keys(fn(Model $m) => [$m->getId() => $m], $model);
}

if (php_sapi_name() === 'cli') {
    /**
     * @template TValue
     * 
     * @param TValue  $value
     * @param mixed  ...$moreValues
     * @return TValue
     */
    function dump(mixed $value, mixed ...$moreValues): mixed
    {
        foreach ([$value, ...$moreValues] as $value) {
            var_dump($value);
        }

        return $value;
    }
} else {
    /**
     * @template TValue
     * 
     * @param TValue  $value
     * @param mixed  ...$moreValues
     * @return TValue
     */
    function dump(mixed $value, mixed ...$moreValues): mixed
    {
        $backtraces = debug_backtrace();
        $backtrace = $backtraces[0];
        $separator = DIRECTORY_SEPARATOR;
        for ($index = 1; str_contains($backtrace['file'] ?? '', "{$separator}core{$separator}"); $index++) {
            $backtrace = $backtraces[$index];
        }

        echo '<div style="margin: 1rem; z-index: 999; text-shadow: 0 0 1px #000">';
        if (isset($backtrace['file'])) {
            $line = $backtrace['line'] ?? null;

            echo '<pre style="margin: 0; padding: 0.5rem 1rem; font-size: 1.3rem; text-wrap: wrap; border: 2px solid red">';
            echo $backtrace['file'] . ($line !== null ? ":$line" : '');
            echo '</pre>';
        } else {
            echo '<div style="border-top: 2px solid red"></div>';
        }

        foreach ([$value, ...$moreValues] as $value) {
            echo '<pre style="margin: 0; padding: 0.5rem 1rem; font-size: 1rem; text-wrap: wrap; border: 2px solid red; border-top: none">';
            var_dump($value);
            echo '</pre>';
        }

        echo '<div style="height: 1rem"></div>';
        echo '</div>';

        return $value;
    }
}

function dd(mixed ...$values): never
{
    dump(...$values);

    die;
}
