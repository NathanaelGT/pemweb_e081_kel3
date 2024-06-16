<?php

class StokBuku extends Model
{
    const TABLE = 'stok_buku';

    protected int $id_buku;

    protected ?int $id_peminjaman = null;

    public function getIdBuku(): int
    {
        return $this->id_buku;
    }

    public function setIdBuku(int $idBuku): static
    {
        $this->id_buku = $idBuku;

        return $this;
    }

    public function getIdPeminjaman(): ?int
    {
        return $this->id_peminjaman;
    }

    public function setIdPeminjaman(?int $idPeminjaman): static
    {
        $this->id_peminjaman = $idPeminjaman;

        return $this;
    }

    public function getForeignKey(string $tabel): ?int
    {
        return match ($tabel) {
            'buku' => $this->id_buku,
            'peminjaman' => $this->id_peminjaman,
            default => null,
        };
    }
}
