<?php

class Peminjaman extends Model
{
    const TABLE = 'peminjaman';

    protected int $id_buku;

    protected int $id_pengguna;

    protected DateTime $tanggal_pinjam;

    protected DateTime $tanggal_kembali;

    protected ?DateTime $tanggal_diambil = null;

    protected ?DateTime $tanggal_dikembalikan = null;

    public function getIdBuku(): int
    {
        return $this->id_buku;
    }

    public function setIdBuku(int $idBuku): static
    {
        $this->id_buku = $idBuku;

        return $this;
    }

    public function getIdPengguna(): ?int
    {
        return $this->id_pengguna;
    }

    public function setIdPengguna(?int $idPengguna): static
    {
        $this->id_pengguna = $idPengguna;

        return $this;
    }

    public function getTanggalPinjam(): DateTime
    {
        return $this->tanggal_pinjam;
    }

    public function setTanggalPinjam(DateTime | string $tanggalPinjam): static
    {
        $this->tanggal_pinjam = parse_datetime($tanggalPinjam);

        return $this;
    }

    public function getTanggalKembali(): DateTime
    {
        return $this->tanggal_kembali;
    }

    public function setTanggalKembali(DateTime | string $tanggalKembali): static
    {
        $this->tanggal_kembali = parse_datetime($tanggalKembali);

        return $this;
    }

    public function getTanggalDiambil(): ?DateTime
    {
        return $this->tanggal_diambil;
    }

    public function setTanggalDiambil(DateTime | string | null $tanggalDiambil): static
    {
        $this->tanggal_diambil = parse_datetime($tanggalDiambil);

        return $this;
    }

    public function getTanggalDikembalikan(): ?DateTime
    {
        return $this->tanggal_dikembalikan;
    }

    public function setTanggalDikembalikan(DateTime | string | null $tanggalDikembalikan): static
    {
        $this->tanggal_dikembalikan = parse_datetime($tanggalDikembalikan);

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
