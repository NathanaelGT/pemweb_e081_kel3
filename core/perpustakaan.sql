DROP TABLE IF EXISTS `pengguna`;

CREATE TABLE `pengguna` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(255) NOT NULL,
    `telepon` VARCHAR(20) NOT NULL,
    `tanggal_lahir` DATE NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `admin` BOOLEAN NOT NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `judul` VARCHAR(255) NOT NULL,
    `kategori` VARCHAR(255) NOT NULL,
    `penulis` VARCHAR(255) NOT NULL,
    `sinopsis` TEXT NOT NULL,
    `terbit` DateTime NOT NULL,
    `penerbit` VARCHAR(255) NOT NULL,
    `isbn` int NOT NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `stok_buku`;

CREATE TABLE `stok_buku` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_buku` INT UNSIGNED NOT NULL,
    `dipinjam_oleh_id_pengguna` INT UNSIGNED NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_buku`) REFERENCES `buku`(`id`),
    FOREIGN KEY (`dipinjam_oleh_id_pengguna`) REFERENCES `pengguna`(`id`)
);
