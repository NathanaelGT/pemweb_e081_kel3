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
