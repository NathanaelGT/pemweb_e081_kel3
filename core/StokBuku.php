<?php

class StokBuku extends Model
{
    const TABLE = 'stok_buku';

    protected int $id_buku;

    protected ?int $dipinjam_oleh_id_pengguna = null;

    public function getIdBuku(): int
    {
        return $this->id_buku;
    }

    public function setIdBuku(int $idBuku): static
    {
        $this->id_buku = $idBuku;

        return $this;
    }

    public function getDipinjamOlehIdPengguna(): ?int
    {
        return $this->dipinjam_oleh_id_pengguna;
    }

    public function setDipinjamOlehIdPengguna(?int $dipinjamOlehIdPengguna): static
    {
        $this->dipinjam_oleh_id_pengguna = $dipinjamOlehIdPengguna;

        return $this;
    }

    public function getForeignKey(string $tabel): ?int
    {
        return match ($tabel) {
            'buku' => $this->id_buku,
            'pengguna' => $this->dipinjam_oleh_id_pengguna,
            default => null,
        };
    }
}
