<?php

class Penilaian extends Model
{
    const TABLE = 'penilaian';

    protected int $id_buku;

    protected int $id_pengguna;

    protected int $penilaian;

    public function getIdBuku(): int
    {
        return $this->id_buku;
    }

    public function setIdBuku(int $idBuku): static
    {
        $this->id_buku = $idBuku;

        return $this;
    }

    public function getIdPengguna(): int
    {
        return $this->id_pengguna;
    }

    public function setIdPengguna(int $idPengguna): static
    {
        $this->id_pengguna = $idPengguna;

        return $this;
    }

    public function getPenilaian(): int
    {
        return $this->penilaian;
    }

    public function setPenilaian(int $penilaian): static
    {
        $this->penilaian = $penilaian;

        return $this;
    }

    public function getForeignKey(string $tabel): ?int
    {
        return match ($tabel) {
            'buku' => $this->id_buku,
            'pengguna' => $this->id_pengguna,
            default => null,
        };
    }
}
