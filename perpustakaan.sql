-- =====================================================
-- Database: perpustakaan
-- Import via phpMyAdmin atau MySQL CLI
-- Login default: username=admin | password=admin123
-- =====================================================

CREATE DATABASE IF NOT EXISTS perpustakaan
    CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE perpustakaan;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `petugas`;
CREATE TABLE `petugas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(10) NOT NULL DEFAULT 'petugas',
  `status` varchar(10) NOT NULL DEFAULT 'aktif',
  `foto` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `anggota`;
CREATE TABLE `anggota` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nis` bigint NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_kategori` varchar(7) NOT NULL,
  `nama_kategori` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `penerbit`;
CREATE TABLE `penerbit` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_penerbit` varchar(7) NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `penulis`;
CREATE TABLE `penulis` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_penulis` varchar(7) NOT NULL,
  `nama_penulis` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_supplier` varchar(7) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `buku`;
CREATE TABLE `buku` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(7) NOT NULL,
  `halaman` int NOT NULL DEFAULT 0,
  `nama_buku` varchar(100) NOT NULL,
  `stok` int NOT NULL DEFAULT 0,
  `rak` varchar(255) NOT NULL DEFAULT '',
  `dimensi` varchar(255) NOT NULL DEFAULT '',
  `penerbit_id` bigint NOT NULL,
  `penulis_id` bigint NOT NULL,
  `supplier_id` bigint NOT NULL,
  `tahun` bigint NOT NULL,
  `kategori_id` bigint NOT NULL,
  `petugas_id` bigint NOT NULL,
  `barcode` varchar(255) NOT NULL DEFAULT '',
  `cover` varchar(255) NOT NULL DEFAULT '',
  `tanggal_masuk` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_buku_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori`(`id`),
  CONSTRAINT `fk_buku_penerbit` FOREIGN KEY (`penerbit_id`) REFERENCES `penerbit`(`id`),
  CONSTRAINT `fk_buku_penulis`  FOREIGN KEY (`penulis_id`)  REFERENCES `penulis`(`id`),
  CONSTRAINT `fk_buku_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier`(`id`),
  CONSTRAINT `fk_buku_petugas`  FOREIGN KEY (`petugas_id`)  REFERENCES `petugas`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE `peminjaman` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `kode_pinjam` varchar(10) NOT NULL,
  `anggota_id` bigint NOT NULL,
  `petugas_id` bigint NOT NULL,
  `buku_id` bigint NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'dipinjam',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_pinjam_anggota` FOREIGN KEY (`anggota_id`) REFERENCES `anggota`(`id`),
  CONSTRAINT `fk_pinjam_buku`    FOREIGN KEY (`buku_id`)    REFERENCES `buku`(`id`),
  CONSTRAINT `fk_pinjam_petugas` FOREIGN KEY (`petugas_id`) REFERENCES `petugas`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `pengembalian`;
CREATE TABLE `pengembalian` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `peminjaman_id` bigint NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `denda` int NOT NULL DEFAULT 0,
  `petugas_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_kembali_pinjam`  FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman`(`id`),
  CONSTRAINT `fk_kembali_petugas` FOREIGN KEY (`petugas_id`)    REFERENCES `petugas`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- =========================
-- DATA AWAL (SAMPLE DATA)
-- =========================
INSERT INTO `petugas` (nama_petugas,username,password,level,status,foto) VALUES
('Administrator','admin','0192023a7bbd73250516f069df18b500','admin','aktif','');

INSERT INTO `kategori` (kode_kategori,nama_kategori) VALUES
('KAT-001','Fiksi'),('KAT-002','Non-Fiksi'),('KAT-003','Sains'),
('KAT-004','Sejarah'),('KAT-005','Teknologi'),('KAT-006','Pendidikan');

INSERT INTO `penerbit` (kode_penerbit,nama_penerbit) VALUES
('PNR-001','Gramedia Pustaka Utama'),('PNR-002','Erlangga'),
('PNR-003','Mizan'),('PNR-004','Kompas'),('PNR-005','Bumi Aksara');

INSERT INTO `penulis` (kode_penulis,nama_penulis) VALUES
('PNL-001','Andrea Hirata'),('PNL-002','Pramoedya Ananta Toer'),
('PNL-003','Raditya Dika'),('PNL-004','Tere Liye'),('PNL-005','Dewi Lestari');

INSERT INTO `supplier` (kode_supplier,nama_supplier) VALUES
('SUP-001','Toko Buku Gramedia'),('SUP-002','Toko Buku Togamas'),
('SUP-003','Distributor Buku Nasional');

INSERT INTO `buku` (kode_buku,halaman,nama_buku,stok,rak,dimensi,penerbit_id,penulis_id,supplier_id,tahun,kategori_id,petugas_id,barcode,tanggal_masuk) VALUES
('BK-0001',532,'Laskar Pelangi',5,'A-01','20x14 cm',1,1,1,2005,1,1,'9789792207873',CURDATE()),
('BK-0002',380,'Bumi Manusia',3,'A-02','21x14 cm',3,2,1,1980,4,1,'9789793062624',CURDATE()),
('BK-0003',210,'Kambing Jantan',4,'B-01','19x12 cm',1,3,2,2005,1,1,'9789792204025',CURDATE()),
('BK-0004',470,'Hafalan Shalat Delisa',5,'B-02','20x14 cm',3,4,1,2005,1,1,'9789793062556',CURDATE()),
('BK-0005',344,'Supernova',4,'C-01','21x14 cm',3,5,3,2001,1,1,'9789793062501',CURDATE());

INSERT INTO `anggota` (nis,nama_anggota,no_telp,email,tempat_lahir,tanggal_lahir,jenis_kelamin,status,password) VALUES
(12345001,'Budi Santoso','081234567890','budi@email.com','Semarang','2005-03-15','Laki-laki','aktif','0192023a7bbd73250516f069df18b500'),
(12345002,'Siti Rahayu','081234567891','siti@email.com','Solo','2006-07-22','Perempuan','aktif','0192023a7bbd73250516f069df18b500'),
(12345003,'Ahmad Fauzi','081234567892','ahmad@email.com','Yogyakarta','2005-11-10','Laki-laki','aktif','0192023a7bbd73250516f069df18b500');
