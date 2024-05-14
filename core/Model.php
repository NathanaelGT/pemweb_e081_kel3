<?php

abstract class Model
{
    protected ?int $id = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $kolom => $nilai) {
            $reflection = new ReflectionProperty($this, $kolom);

            $this->$kolom = ctype_upper(($class = $reflection->getType()?->getName() ?? 'a')[0])
                ? new $class($nilai)
                : $nilai;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return static[] */
    public static function semua(): array
    {
        $data = Database::query('SELECT * FROM ' . static::table());

        return array_map(fn($d) => new static($d), $data);
    }

    public static function cari(int|string $id): ?static
    {
        if ($id !== null) {
            foreach (Database::query('SELECT * FROM ' . static::table() . " WHERE id = $id LIMIT 1") as $data) {
                return new static($data);
            }
        }

        return null;
    }

    public function simpan(): bool
    {
        $data = get_object_vars($this);
        unset($data['id']);

        foreach ($data as $k => $n) {
            if (is_null($n)) {
                unset($data[$k]);
                continue;
            }

            $data[$k] = match (true) {
                is_string($n) => $n ? "'$n'" : throw new RuntimeException("Kolom $k tidak boleh kosong"),
                is_bool($n) => $n ? 'TRUE' : 'FALSE',
                $n instanceof DateTime => "'" . $n->format('Y-m-d H:i:s') . "'",
                default => $n,
            };
        }

        if ($this->id === null) {
            $kolom = implode(', ', array_keys($data));
            $nilai = implode(', ', array_values($data));

            if ($id = Database::query('INSERT INTO ' . static::table() . " ($kolom) VALUES ($nilai)")) {
                $this->id = $id;
                return true;
            }

            return false;
        }

        $set = [];
        foreach ($data as $k => $n) {
            $set[] = "$k = $n";
        }
        $set = implode(', ', $set);

        return Database::query('UPDATE ' . static::table() . " SET $set WHERE id = $this->id");
    }

    public function hapus(): bool
    {
        return Database::query('DELETE FROM ' . static::table() . " WHERE `id` = '$this->id'");
    }

    protected static function table(): string
    {
        if (defined('static::TABLE')) {
            return constant('static::TABLE');
        }

        throw new RuntimeException('Nama tabel belum diatur');
    }
}
