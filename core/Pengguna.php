<?php

class Pengguna extends Model
{
    const TABLE = 'pengguna';

    protected string $nama;

    protected string $telepon;

    protected DateTime $tanggal_lahir;

    protected string $email;

    protected string $password;

    protected bool $admin = false;

    protected ?string $foto = null;

    public function getNama(): string
    {
        return $this->nama;
    }

    public function setNama(string $nama): static
    {
        $this->nama = $nama;

        return $this;
    }

    public function getTelepon(): string
    {
        return $this->telepon;
    }

    public function setTelepon(string $telepon): static
    {
        $this->telepon = $telepon;

        return $this;
    }

    public function getTanggalLahir(): DateTime
    {
        return $this->tanggal_lahir;
    }

    public function setTanggalLahir(string $tanggal_lahir): static
    {
        $this->tanggal_lahir = new DateTime($tanggal_lahir);

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function cekPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function setPassword(string $password): static
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    public function getAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): static
    {
        $this->admin = $admin;

        return $this;
    }

    public function getFotoProfil(): string
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&color=FFFFFF&background=09090b';
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): static
    {
        $this->foto = $foto;
        return $this;
    }
}
