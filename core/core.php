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

if (
    @$_SESSION['old_url'] !== @$_SERVER['REQUEST_URI'] || // ganti halaman
    in_array(@$_SERVER['HTTP_CACHE_CONTROL'], ['max-age=0', 'no-cache']) // refresh
) {
    unset($_SESSION['old'], $_SESSION['old_url']);
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

/**
 * @template TValue
 * @template TDefault
 * 
 * @param TValue[] $array
 * @param TDefault $default
 * @return TValue|TDefault
 */
function array_first(array $array, mixed $default = null): mixed
{
    foreach ($array as $value) {
        return $value;
    }

    return $default;
}

function parse_datetime(DateTime | string | null $dateTime): ?DateTime
{
    if (is_string($dateTime)) {
        if ($dateTime === 'now') {
            return new DateTime();
        }

        $separator = str_contains($dateTime, '/') ? '/' : '-';
        $dateFormat = strpos($dateTime, $separator) === 2
            ? "d{$separator}m{$separator}Y"
            : "Y{$separator}m{$separator}d";

        $dateFormat = str_contains($dateTime, ':')
            ? "$dateFormat h:i a"
            : $dateFormat;

        $dateTime = DateTime::createFromFormat($dateFormat, $dateTime);
        if ($dateTime === false) {
            throw new RuntimeException('Format tanggal tidak diketahui.');
        }
    }

    return $dateTime;
}

function input(
    string $name,
    string $class,
    ?string $placeholder = null,
    string $type = 'text',
    bool $required = false,
    bool $disabled = false,
    ?string $value = null,
    ?int $min = null,
    ?int $max = null,
    bool $restoreValue = true,
    ?string $style = null,
): string
{
    $value = $restoreValue ? $_SESSION['old'][$name] ?? $value : $value;
    $value = $value ? " value=\"$value\"" : '';

    $name = " name=\"$name\"";
    $class = " class=\"$class\"";
    $placeholder = $placeholder ? " placeholder=\"$placeholder\"" : '';
    $type = " type=\"$type\"";
    $required = $required ? ' required' : '';
    $disabled = $disabled ? ' disabled' : '';
    $min = $min ? " min=\"$min\"" : '';
    $max = $max ? " max=\"$max\"" : '';
    $style = $style ? " style=\"$style\"" : '';

    return "<input$type$name$placeholder$required$value$min$max$style$class>";
}

function process(Closure $callback, ?string $redirectOnError = null): never
{
    try {
        $callback();
    } catch (Throwable $e) {
        $_SESSION['info'] = $e instanceof RuntimeException ? $e->getMessage() : 'Data tidak valid';
        $_SESSION['jenis_info'] = 'error';
        $_SESSION['old'] = $_POST;
        $_SESSION['old_url'] = $_SERVER['REQUEST_URI'];

        global $basePath;

        header('Location: ' . ($redirectOnError ?: $_SERVER['REQUEST_URI'] ?: $basePath));
    } finally {
        die;
    }
}

function handle_upload(array $file, string $fileName): string
{
    $path = realpath(__DIR__ . '/../') . '/uploads';
    $name = $fileName . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    move_uploaded_file($file['tmp_name'], "$path/$name");

    return "uploads/$name";
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
