<?php

class Database
{
    protected static $hostname = 'localhost';

    protected static $username = 'root';

    protected static $password = '';

    protected static $database = 'pemweb_e081_kel3';

    protected static function mysqli(): mysqli
    {
        static $mysqli = null;
        if ($mysqli !== null) {
            return $mysqli;
        }

        try {
            $mysqli = new mysqli(static::$hostname, static::$username, static::$password, static::$database);
        } catch (mysqli_sql_exception $e) {
            switch ($e->getCode()) {
                case 1049:
                    $mysqli = new mysqli(static::$hostname, static::$username, static::$password);
                    $mysqli->query('CREATE DATABASE ' . static::$database);
                    $mysqli->select_db(static::$database);
                    break;

                case 1045:
                    echo 'Gagal terhubung ke database: username atau password salah. Harap ubah pada file core/Database.php';
                    die;

                default:
                    echo 'Gagal terhubung ke database: ' . $e->getMessage();
                    die;
            }
        }

        register_shutdown_function(function () use ($mysqli) {
            $mysqli->close();
        });

        return $mysqli;
    }

    public static function query($query): mixed
    {
        $mysqli = static::mysqli();

        try {
            $hasil = $mysqli->query($query);

            if ($mysqli->insert_id) {
                return $mysqli->insert_id;
            } elseif (is_bool($hasil)) {
                return $hasil;
            }

            return $hasil->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            if ($e instanceof mysqli_sql_exception && $e->getCode() === 1146) {
                $sql = explode(';', file_get_contents(__DIR__ . '/perpustakaan.sql'));
                foreach ($sql as $q) {
                    if ($q = trim($q)) {
                        $mysqli->query($q);
                    }
                }

                return static::query($query);
            }

            dump($query, $e->getMessage());

            throw $e;
        }
    }

    public static function escape(mixed $nilai, ?string $tabelRelasi = null): mixed
    {
        return match (true) {
            is_string($nilai) => "'$nilai'",
            is_numeric($nilai) => $nilai,
            is_bool($nilai) => $nilai ? 'TRUE' : 'FALSE',
            is_null($nilai) => 'NULL',
            is_array($nilai) => '(' . implode(', ', array_map(fn($n) => static::escape($n, $tabelRelasi), $nilai)) . ')',
            $nilai instanceof Model => ($tabelRelasi ? $nilai->getForeignKey($tabelRelasi) : null) ?? $nilai->getId(),
            $nilai instanceof DateTime => "'" . $nilai->format('Y-m-d H:i:s') . "'",
            default => dd($nilai, 'Tipe data tidak diketahui'),
        };
    }
}