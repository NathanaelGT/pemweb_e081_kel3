SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `penilaian`;
DROP TABLE IF EXISTS `komentar`;
DROP TABLE IF EXISTS `ulasan`;
DROP TABLE IF EXISTS `stok_buku`;
DROP TABLE IF EXISTS `peminjaman`;
DROP TABLE IF EXISTS `buku`;
DROP TABLE IF EXISTS `pengguna`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `pengguna` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(255) NOT NULL,
    `telepon` VARCHAR(20) NOT NULL,
    `tanggal_lahir` DATE NOT NULL,
    `foto` VARCHAR(255) DEFAULT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `admin` BOOLEAN NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`email`)
);

CREATE TABLE `buku` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `judul` VARCHAR(255) NOT NULL,
    `kategori` VARCHAR(255) NOT NULL,
    `penulis` VARCHAR(255) NOT NULL,
    `sinopsis` TEXT NOT NULL,
    `terbit` DateTime NOT NULL,
    `penerbit` VARCHAR(255) NOT NULL,
    `cover` VARCHAR(255) NULL DEFAULT NULL,
    `isbn` int NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`isbn`)
);

CREATE TABLE `peminjaman` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_buku` INT UNSIGNED NOT NULL,
    `id_pengguna` INT UNSIGNED NOT NULL,
    `tanggal_pinjam` DateTime NOT NULL,
    `tanggal_kembali` DateTime NOT NULL,
    `tanggal_diambil` DateTime NULL DEFAULT NULL,
    `tanggal_dikembalikan` DateTime NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_buku`) REFERENCES `buku`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna`(`id`) ON DELETE CASCADE
);

CREATE TABLE `stok_buku` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_buku` INT UNSIGNED NOT NULL,
    `id_peminjaman` INT UNSIGNED NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_buku`) REFERENCES `buku`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman`(`id`) ON DELETE CASCADE
);

CREATE TABLE `ulasan` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_buku` INT UNSIGNED NOT NULL,
    `id_pengguna` INT UNSIGNED NOT NULL,
    `ulasan` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_buku`) REFERENCES `buku`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna`(`id`) ON DELETE CASCADE
);

CREATE TABLE `komentar` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_ulasan` INT UNSIGNED NOT NULL,
    `id_pengguna` INT UNSIGNED NOT NULL,
    `komentar` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_ulasan`) REFERENCES `ulasan`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna`(`id`) ON DELETE CASCADE
);

CREATE TABLE `penilaian` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_buku` INT UNSIGNED NOT NULL,
    `id_pengguna` INT UNSIGNED NOT NULL,
    `penilaian` TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_buku`) REFERENCES `buku`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna`(`id`) ON DELETE CASCADE
);

-- password: password
INSERT INTO `pengguna` (`nama`, `telepon`, `tanggal_lahir`, `email`, `password`, `admin`) VALUES
('Admin', '081234567890', '1980-01-01', 'admin@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', TRUE),
('Pengguna', '081234567891', '1990-01-01', 'pengguna@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Budi Santoso', '081234567892', '1991-01-01', 'budi.santoso@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Siti Aminah', '081234567893', '1992-01-01', 'siti.aminah@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Agus Setiawan', '081234567894', '1993-01-01', 'agus.setiawan@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Dewi Sartika', '081234567895', '1994-01-01', 'dewi.sartika@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Rahmat Hidayat', '081234567896', '1995-01-01', 'rahmat.hidayat@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Yuniarti Rahayu', '081234567897', '1996-01-01', 'yuniarti.rahayu@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Hari Prasetyo', '081234567898', '1997-01-01', 'hari.prasetyo@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Indah Permatasari', '081234567899', '1998-01-01', 'indah.permatasari@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Andi Wijaya', '081234567800', '1999-01-01', 'andi.wijaya@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Rina Maulida', '081234567801', '2000-01-01', 'rina.maulida@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Wawan Kurniawan', '081234567802', '2001-01-01', 'wawan.kurniawan@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Sari Kusuma', '081234567803', '2002-01-01', 'sari.kusuma@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Dedi Susanto', '081234567804', '2003-01-01', 'dedi.susanto@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Lestari Anindya', '081234567805', '2004-01-01', 'lestari.anindya@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Taufik Ramdhan', '081234567806', '2005-01-01', 'taufik.ramdhan@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Desi Oktaviani', '081234567807', '2006-01-01', 'desi.oktaviani@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Bayu Saputra', '081234567808', '2007-01-01', 'bayu.saputra@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Dina Fitria', '081234567809', '2008-01-01', 'dina.fitria@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Adi Putra', '081234567810', '2009-01-01', 'adi.putra@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE),
('Maya Puspita', '081234567811', '2010-01-01', 'maya.puspita@example.com', '$2y$10$S7c7CNC2Wwgwhia77SuhTeXWMmW21RUepTeuaAJEv.mTUjGtecEIS', FALSE);

INSERT INTO `buku` (`judul`, `kategori`, `penulis`, `sinopsis`, `terbit`, `penerbit`, `cover`, `isbn`) VALUES
('Laskar Pelangi', 'Fiksi', 'Andrea Hirata', 'Laskar Pelangi menceritakan kisah inspiratif tentang anak-anak di sebuah desa kecil di Belitung yang berjuang mendapatkan pendidikan.', '2020-01-01 00:00:00', 'Bentang Pustaka', 'https://cdn.gramedia.com/uploads/items/9789793062792_New-Edition-Laskar-Pelangi.jpg', 123456789),
('Bumi Manusia', 'Sejarah Fiksi', 'Pramoedya Ananta Toer', 'Bumi Manusia mengisahkan perjalanan hidup Minke, seorang pemuda pribumi yang menentang ketidakadilan kolonial.', '2020-02-01 00:00:00', 'Hasta Mitra', 'https://bukukita.com/babacms/displaybuku/98759_f.jpg', 223456789),
('Sang Pemimpi', 'Fiksi', 'Andrea Hirata', 'Sang Pemimpi melanjutkan kisah Laskar Pelangi, menyoroti perjalanan hidup Ikal dan Arai yang penuh perjuangan dan impian.', '2020-03-01 00:00:00', 'Bentang Pustaka', 'https://cdn.gramedia.com/uploads/items/Sang_Pemimpi_ofLeeOG.jpg', 323456789),
('Negeri 5 Menara', 'Fiksi', 'A. Fuadi', 'Negeri 5 Menara bercerita tentang pengalaman hidup Alif di pondok pesantren yang penuh dengan pelajaran hidup dan persahabatan.', '2020-04-01 00:00:00', 'Gramedia Pustaka Utama', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1249749162i/6688121.jpg', 423456789),
('Supernova', 'Fiksi Ilmiah', 'Dee Lestari', 'Supernova adalah novel fiksi ilmiah yang menggabungkan elemen ilmu pengetahuan, filsafat, dan romantika.', '2020-05-01 00:00:00', 'Bentang Pustaka', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1410249029i/1300350.jpg', 523456789),
('Ayat-Ayat Cinta', 'Romantis', 'Habiburrahman El Shirazy', 'Ayat-Ayat Cinta mengisahkan perjalanan cinta dan kehidupan Fahri, seorang mahasiswa Indonesia di Mesir.', '2020-06-01 00:00:00', 'Republika', 'https://upload.wikimedia.org/wikipedia/id/b/b4/Ayatayatcinta.jpg', 623456789),
('Cantik Itu Luka', 'Sejarah Fiksi', 'Eka Kurniawan', 'Cantik Itu Luka adalah novel epik yang menggabungkan sejarah Indonesia dengan cerita fiksi yang kaya akan karakter dan peristiwa.', '2020-07-01 00:00:00', 'Gramedia Pustaka Utama', 'https://cdn.gramedia.com/uploads/items/9786020366517_Cantik-Itu-Luka-Hard-Cover---Limited-Edition.jpg', 723456789),
('Perahu Kertas', 'Romantis', 'Dee Lestari', 'Perahu Kertas bercerita tentang perjalanan cinta Kugy dan Keenan yang penuh lika-liku dan pencarian jati diri.', '2020-08-01 00:00:00', 'Bentang Pustaka', 'https://deelestari.com/wp-content/uploads/2014/09/Perahukertas-1.jpg', 823456789),
('Pulang', 'Fiksi', 'Leila S. Chudori', 'Pulang mengisahkan tentang kerinduan seorang anak akan kampung halamannya setelah bertahun-tahun hidup di pengasingan politik.', '2020-09-01 00:00:00', 'Kepustakaan Populer Gramedia', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1465061573i/16174176.jpg', 923456789),
('Ronggeng Dukuh Paruk', 'Sejarah Fiksi', 'Ahmad Tohari', 'Ronggeng Dukuh Paruk adalah kisah tentang kehidupan Srintil, seorang penari ronggeng, dan perjuangannya melawan takdir.', '2020-10-01 00:00:00', 'Gramedia Pustaka Utama', 'https://s3-ap-southeast-1.amazonaws.com/ebook-previews/53333/200748/1.jpg', 102345678),
('Gadis Pantai', 'Sejarah Fiksi', 'Pramoedya Ananta Toer', 'Gadis Pantai bercerita tentang kehidupan seorang gadis pesisir yang menikah dengan seorang priyayi dan menghadapi banyak tantangan.', '2020-11-01 00:00:00', 'Hasta Mitra', 'https://cdn.gramedia.com/uploads/items/98752_f.jpg', 112345678),
('Dilan: Dia adalah Dilanku Tahun 1990', 'Romantis', 'Pidi Baiq', 'Dilan: Dia adalah Dilanku Tahun 1990 adalah kisah romantis tentang Dilan dan Milea yang berlatar belakang kehidupan remaja di Bandung.', '2020-12-01 00:00:00', 'Pastel Books', 'https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1529766227/dilan1_rgsiyd.jpg', 122345678);


INSERT INTO `peminjaman` (`id_buku`, `id_pengguna`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_diambil`, `tanggal_dikembalikan`)
VALUES 
(1, 3, '2024-06-01 10:00:00', '2024-06-15 10:00:00', '2024-06-01 10:30:00', '2024-06-14 15:30:00'),
(1, 4, '2024-06-02 11:00:00', '2024-06-16 11:00:00', '2024-06-02 11:30:00', NULL),
(2, 5, '2024-06-03 12:00:00', '2024-06-17 12:00:00', '2024-06-03 12:30:00', NULL),
(2, 6, '2024-06-04 13:00:00', '2024-06-18 13:00:00', '2024-06-04 13:30:00', NULL),
(3, 7, '2024-06-05 14:00:00', '2024-06-19 14:00:00', '2024-06-05 14:30:00', NULL),
(3, 8, '2024-06-06 15:00:00', '2024-06-20 15:00:00', '2024-06-06 15:30:00', NULL),
(4, 9, '2024-06-07 16:00:00', '2024-06-21 16:00:00', '2024-06-07 16:30:00', NULL),
(4, 10, '2024-06-08 17:00:00', '2024-06-22 17:00:00', '2024-06-08 17:30:00', NULL),
(5, 11, '2024-06-09 18:00:00', '2024-06-23 18:00:00', '2024-06-09 18:30:00', NULL),
(5, 12, '2024-06-10 19:00:00', '2024-06-24 19:00:00', '2024-06-10 19:30:00', NULL),
(6, 13, '2024-06-11 20:00:00', '2024-06-25 20:00:00', '2024-06-11 20:30:00', NULL),
(6, 14, '2024-06-12 21:00:00', '2024-06-26 21:00:00', '2024-06-12 21:30:00', NULL),
(7, 15, '2024-06-13 22:00:00', '2024-06-27 22:00:00', '2024-06-13 22:30:00', NULL),
(7, 16, '2024-06-14 23:00:00', '2024-06-28 23:00:00', '2024-06-14 23:30:00', NULL),
(8, 17, '2024-06-15 10:00:00', '2024-06-29 10:00:00', '2024-06-15 10:30:00', NULL),
(8, 18, '2024-06-16 11:00:00', '2024-06-30 11:00:00', '2024-06-16 11:30:00', NULL),
(9, 19, '2024-06-17 12:00:00', '2024-07-01 12:00:00', '2024-06-17 12:30:00', NULL),
(9, 20, '2024-06-18 13:00:00', '2024-07-02 13:00:00', '2024-06-18 13:30:00', NULL),
(10, 1, '2024-06-19 14:00:00', '2024-07-03 14:00:00', '2024-06-19 14:30:00', NULL),
(10, 2, '2024-06-20 15:00:00', '2024-07-04 15:00:00', '2024-06-20 15:30:00', NULL),
(11, 3, '2024-06-21 16:00:00', '2024-07-05 16:00:00', '2024-06-21 16:30:00', NULL),
(11, 4, '2024-06-22 17:00:00', '2024-07-06 17:00:00', '2024-06-22 17:30:00', NULL),
(12, 5, '2024-06-23 18:00:00', '2024-07-07 18:00:00', '2024-06-23 18:30:00', NULL),
(12, 6, '2024-06-24 19:00:00', '2024-07-08 19:00:00', '2024-06-24 19:30:00', NULL);


INSERT INTO `stok_buku` (`id_buku`, `id_peminjaman`)
VALUES 
(1, NULL), (1, NULL), (1, NULL), (1, NULL), (1, NULL), (1, NULL), (1, NULL), (1, NULL), (1, 1), (1, 2),
(2, NULL), (2, NULL), (2, NULL), (2, NULL), (2, NULL), (2, NULL), (2, NULL), (2, NULL), (2, 3), (2, 4),
(3, NULL), (3, NULL), (3, NULL), (3, NULL), (3, NULL), (3, NULL), (3, NULL), (3, NULL), (3, 5), (3, 6),
(4, NULL), (4, NULL), (4, NULL), (4, NULL), (4, NULL), (4, NULL), (4, NULL), (4, NULL), (4, 7), (4, 8),
(5, NULL), (5, NULL), (5, NULL), (5, NULL), (5, NULL), (5, NULL), (5, NULL), (5, NULL), (5, 9), (5, 10),
(6, NULL), (6, NULL), (6, NULL), (6, NULL), (6, NULL), (6, NULL), (6, NULL), (6, NULL), (6, 11), (6, 12),
(7, NULL), (7, NULL), (7, NULL), (7, NULL), (7, NULL), (7, NULL), (7, NULL), (7, NULL), (7, 13), (7, 14),
(8, NULL), (8, NULL), (8, NULL), (8, NULL), (8, NULL), (8, NULL), (8, NULL), (8, NULL), (8, 15), (8, 16),
(9, NULL), (9, NULL), (9, NULL), (9, NULL), (9, NULL), (9, NULL), (9, NULL), (9, NULL), (9, 17), (9, 18),
(10, NULL), (10, NULL), (10, NULL), (10, NULL), (10, NULL), (10, NULL), (10, NULL), (10, NULL), (10, 19), (10, 20),
(11, NULL), (11, NULL), (11, NULL), (11, NULL), (11, NULL), (11, NULL), (11, NULL), (11, NULL), (11, 21), (11, 22),
(12, NULL), (12, NULL), (12, NULL), (12, NULL), (12, NULL), (12, NULL), (12, NULL), (12, NULL), (12, 23), (12, 24);


INSERT INTO `ulasan` (`id_buku`, `id_pengguna`, `ulasan`) VALUES 
(1, 3, 'Buku yang sangat menginspirasi, cerita yang luar biasa tentang perjuangan anak-anak di Belitung.'),
(1, 4, 'Menyentuh dan penuh dengan pesan moral. Sangat direkomendasikan.'),
(1, 5, 'Cerita yang menggugah hati tentang pendidikan dan persahabatan.'),
(1, 6, 'Laskar Pelangi membawa saya kembali ke masa kecil dengan semua kenangan indahnya.'),
(1, 7, 'Buku ini sangat memotivasi dan memberikan banyak pelajaran hidup.'),

(2, 8, 'Pramoedya benar-benar jenius dalam menggambarkan ketidakadilan kolonial. Buku yang sangat kuat.'),
(2, 9, 'Cerita yang sangat mendalam dan menyentuh tentang perjuangan seorang pemuda.'),
(2, 10, 'Bumi Manusia adalah karya sastra yang luar biasa dengan narasi yang sangat baik.'),
(2, 11, 'Saya sangat terkesan dengan karakter Minke dan perjuangannya melawan ketidakadilan.'),
(2, 12, 'Novel ini membuka mata saya tentang sejarah Indonesia. Sangat direkomendasikan.'),

(3, 13, 'Melanjutkan Laskar Pelangi, buku ini penuh dengan inspirasi dan harapan.'),
(3, 14, 'Sang Pemimpi adalah cerita tentang impian yang sangat memotivasi.'),
(3, 15, 'Cerita yang luar biasa tentang perjuangan hidup dan cita-cita.'),
(3, 16, 'Ikal dan Arai adalah tokoh yang sangat inspiratif. Buku yang hebat.'),
(3, 17, 'Buku ini membuat saya terus bermimpi dan berusaha untuk meraih cita-cita.'),

(4, 18, 'Pengalaman hidup di pondok pesantren yang sangat mendalam dan inspiratif.'),
(4, 19, 'Cerita tentang persahabatan dan perjuangan hidup yang sangat menyentuh.'),
(4, 20, 'Buku ini mengajarkan banyak pelajaran hidup dan nilai-nilai moral.'),
(4, 1, 'Negeri 5 Menara adalah buku yang sangat inspiratif dan memotivasi.'),
(4, 2, 'Saya sangat menikmati kisah Alif dan teman-temannya di pondok pesantren.'),

(5, 3, 'Supernova adalah novel yang sangat unik dengan gabungan ilmu pengetahuan dan filsafat.'),
(5, 4, 'Dee Lestari benar-benar jenius dalam menulis novel ini. Sangat menarik.'),
(5, 5, 'Cerita yang sangat kompleks dan menarik. Buku yang luar biasa.'),
(5, 6, 'Supernova adalah salah satu novel terbaik yang pernah saya baca.'),
(5, 7, 'Novel ini penuh dengan ide-ide cemerlang dan narasi yang sangat baik.'),

(6, 8, 'Ayat-Ayat Cinta adalah kisah romantis yang sangat menyentuh hati.'),
(6, 9, 'Cerita tentang cinta dan kehidupan Fahri sangat menginspirasi.'),
(6, 10, 'Buku ini penuh dengan pesan moral dan nilai-nilai kehidupan.'),
(6, 11, 'Ayat-Ayat Cinta adalah novel yang sangat indah dan menyentuh.'),
(6, 12, 'Saya sangat menikmati perjalanan cinta dan kehidupan Fahri di Mesir.'),

(7, 13, 'Cantik Itu Luka adalah novel epik dengan karakter dan cerita yang sangat kuat.'),
(7, 14, 'Eka Kurniawan berhasil menggambarkan sejarah Indonesia dengan sangat baik.'),
(7, 15, 'Buku ini penuh dengan peristiwa dan karakter yang sangat menarik.'),
(7, 16, 'Cerita yang sangat kompleks dan mendalam. Buku yang luar biasa.'),
(7, 17, 'Cantik Itu Luka adalah salah satu novel terbaik yang pernah saya baca.'),

(8, 18, 'Perahu Kertas adalah cerita cinta yang sangat menyentuh dan inspiratif.'),
(8, 19, 'Dee Lestari berhasil menggambarkan perjalanan cinta Kugy dan Keenan dengan sangat baik.'),
(8, 20, 'Buku ini penuh dengan kisah cinta dan pencarian jati diri yang sangat menarik.'),
(8, 1, 'Saya sangat menikmati cerita cinta dan perjuangan Kugy dan Keenan.'),
(8, 2, 'Perahu Kertas adalah novel yang sangat indah dan penuh dengan makna.'),

(9, 3, 'Pulang adalah cerita tentang kerinduan dan perjuangan hidup yang sangat menyentuh.'),
(9, 4, 'Leila S. Chudori berhasil menggambarkan kehidupan seorang anak yang hidup di pengasingan politik dengan sangat baik.'),
(9, 5, 'Buku ini penuh dengan emosi dan cerita yang sangat mendalam.'),
(9, 6, 'Pulang adalah novel yang sangat kuat dengan narasi yang sangat baik.'),
(9, 7, 'Saya sangat terkesan dengan cerita dan karakter dalam novel ini.'),

(10, 8, 'Ronggeng Dukuh Paruk adalah kisah yang sangat menyentuh tentang kehidupan Srintil.'),
(10, 9, 'Ahmad Tohari berhasil menggambarkan perjuangan Srintil melawan takdir dengan sangat baik.'),
(10, 10, 'Buku ini penuh dengan cerita yang sangat kuat dan karakter yang sangat menarik.'),
(10, 11, 'Ronggeng Dukuh Paruk adalah salah satu novel terbaik yang pernah saya baca.'),
(10, 12, 'Saya sangat menikmati cerita dan karakter dalam novel ini.'),

(11, 13, 'Gadis Pantai adalah cerita tentang kehidupan seorang gadis pesisir yang sangat menyentuh.'),
(11, 14, 'Pramoedya Ananta Toer berhasil menggambarkan kehidupan seorang gadis pesisir dengan sangat baik.'),
(11, 15, 'Buku ini penuh dengan emosi dan cerita yang sangat mendalam.'),
(11, 16, 'Gadis Pantai adalah novel yang sangat kuat dengan narasi yang sangat baik.'),
(11, 17, 'Saya sangat terkesan dengan cerita dan karakter dalam novel ini.'),

(12, 18, 'Dilan: Dia adalah Dilanku Tahun 1990 adalah kisah romantis yang sangat menyentuh.'),
(12, 19, 'Pidi Baiq berhasil menggambarkan kehidupan remaja di Bandung dengan sangat baik.'),
(12, 20, 'Buku ini penuh dengan kisah cinta dan kehidupan remaja yang sangat menarik.'),
(12, 1, 'Saya sangat menikmati cerita cinta Dilan dan Milea.'),
(12, 2, 'Dilan: Dia adalah Dilanku Tahun 1990 adalah novel yang sangat indah dan penuh dengan makna.');


INSERT INTO `penilaian` (`id_buku`, `id_pengguna`, `penilaian`) VALUES
(1, 3, 4), (1, 4, 4), (1, 5, 5), (1, 6, 4), (1, 7, 4),
(1, 8, 4), (1, 9, 2), (1, 10, 5), (1, 11, 4), (1, 12, 5),

(2, 8, 5), (2, 9, 4), (2, 10, 3), (2, 11, 4), (2, 12, 5),
(2, 13, 4), (2, 14, 4), (2, 15, 5), (2, 16, 4), (2, 17, 5),

(3, 13, 5), (3, 14, 4), (3, 15, 2), (3, 16, 4), (3, 17, 5),
(3, 18, 4), (3, 19, 4), (3, 20, 5), (3, 1, 4), (3, 2, 5),

(4, 18, 5), (4, 19, 4), (4, 20, 1), (4, 1, 4), (4, 2, 5),
(4, 3, 4), (4, 4, 5), (4, 5, 5), (4, 6, 4), (4, 7, 3),

(5, 8, 5), (5, 9, 4), (5, 10, 5), (5, 11, 4), (5, 12, 5),
(5, 13, 4), (5, 14, 5), (5, 15, 5), (5, 16, 4), (5, 17, 5),

(6, 18, 5), (6, 19, 5), (6, 20, 5), (6, 1, 4), (6, 2, 5),
(6, 3, 4), (6, 4, 5), (6, 5, 3), (6, 6, 4), (6, 7, 5),

(7, 8, 5), (7, 9, 4), (7, 10, 4), (7, 11, 4), (7, 12, 5),
(7, 13, 4), (7, 14, 4), (7, 15, 4), (7, 16, 4), (7, 17, 5),

(8, 18, 3), (8, 19, 4), (8, 20, 5), (8, 1, 4), (8, 2, 5),
(8, 3, 4), (8, 4, 5), (8, 5, 5), (8, 6, 4), (8, 7, 5),

(9, 8, 5), (9, 9, 4), (9, 10, 2), (9, 11, 4), (9, 12, 5),
(9, 13, 4), (9, 14, 5), (9, 15, 5), (9, 16, 4), (9, 17, 5),

(10, 18, 2), (10, 19, 1), (10, 20, 3), (10, 1, 4), (10, 2, 3),
(10, 3, 3), (10, 4, 2), (10, 5, 4), (10, 6, 4), (10, 7, 3),

(11, 8, 5), (11, 9, 4), (11, 10, 5), (11, 11, 4), (11, 12, 5),
(11, 13, 4), (11, 14, 3), (11, 15, 4), (11, 16, 4), (11, 17, 5),

(12, 18, 5), (12, 19, 5), (12, 20, 5), (12, 1, 4), (12, 2, 5),
(12, 3, 4), (12, 4, 5), (12, 5, 5), (12, 6, 5), (12, 7, 5);
