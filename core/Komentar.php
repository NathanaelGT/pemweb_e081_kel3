<?php

class Komentar extends Model
{
    const TABLE = 'komentar';

    protected int $id_ulasan;
    protected int $id_pengguna;
    protected string $komentar;

    public function getIdUlasan(): int
    {
        return $this->id_ulasan;
    }

    public function setIdUlasan(int $idUlasan): static
    {
        $this->id_ulasan = $idUlasan;
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

    public function getKomentar(): string
    {
        return $this->komentar;
    }

    public function setKomentar(string $komentar): static
    {
        $this->komentar = $komentar;
        return $this;
    }
}
?>
