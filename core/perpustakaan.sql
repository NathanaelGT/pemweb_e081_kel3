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
