<?php

class Buku extends Model
{
    const TABLE = 'buku';

    protected string $judul;

    protected string $kategori;

    protected string $penulis;

    protected string $sinopsis;

    protected DateTime $terbit;

    protected string $penerbit;

    protected int $isbn;

    public function getJudul(): string
    {
        return $this->judul;
    }

    public function setJudul(string $judul): static
    {
        $this->judul = $judul;

        return $this;
    }

    public function getKategori(): string
    {
        return $this->kategori;
    }

    public function setKategori(string $kategori): static
    {
        $this->kategori = $kategori;

        return $this;
    }

    public function getPenulis(): string
    {
        return $this->penulis;
    }

    public function setPenulis(string $penulis): static
    {
        $this->penulis = $penulis;

        return $this;
    }

    public function getSinopsis(): string
    {
        return $this->sinopsis;
    }

    public function setSinopsis(string $sinopsis): static
    {
        $this->sinopsis = $sinopsis;

        return $this;
    }

    public function getTerbit(): DateTime
    {
        return $this->terbit;
    }

    public function setTerbit(string $terbit): static
    {
        $this->terbit = new DateTime($terbit);

        return $this;
    }

    public function getPenerbit(): string
    {
        return $this->penerbit;
    }

    public function setPenerbit(string $penerbit): static
    {
        $this->penerbit = $penerbit;

        return $this;
    }

    public function getIsbn(): int
    {
        return $this->isbn;
    }

    public function setIsbn(int $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }
}
