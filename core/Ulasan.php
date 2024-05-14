<?php

class Ulasan extends Model
{
    const TABLE = 'ulasan';

    protected int $id_buku;

    protected int $id_pengguna;

    protected string $ulasan;

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

    public function getUlasan(): string
    {
        return $this->ulasan;
    }

    public function setUlasan(string $ulasan): static
    {
        $this->ulasan = $ulasan;

        return $this;
    }
}
