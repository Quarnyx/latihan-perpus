/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : 127.0.0.1:3306
 Source Schema         : perpustakaan

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 08/04/2026 22:38:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for anggota
-- ----------------------------
DROP TABLE IF EXISTS `anggota`;
CREATE TABLE `anggota`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nis` bigint NOT NULL,
  `nama_anggota` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `no_telp` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tempat_lahir` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('aktif','nonaktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'nonaktif',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for buku
-- ----------------------------
DROP TABLE IF EXISTS `buku`;
CREATE TABLE `buku`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `halaman` int NOT NULL,
  `nama_buku` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stok` int NOT NULL,
  `rak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dimensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `penerbit_id` bigint NOT NULL,
  `penulis_id` bigint NOT NULL,
  `supplier_id` bigint NOT NULL,
  `tahun` bigint NOT NULL,
  `kategori_id` bigint NOT NULL,
  `petugas_id` bigint NOT NULL,
  `barcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `buku_penerbit_index`(`penerbit_id` ASC, `penulis_id` ASC, `supplier_id` ASC, `kategori_id` ASC, `petugas_id` ASC) USING BTREE,
  INDEX `fk_buku_kategori_1`(`kategori_id` ASC) USING BTREE,
  INDEX `fk_buku_penulis_1`(`penulis_id` ASC) USING BTREE,
  INDEX `fk_buku_petugas_1`(`petugas_id` ASC) USING BTREE,
  INDEX `fk_buku_supplier_1`(`supplier_id` ASC) USING BTREE,
  CONSTRAINT `fk_buku_kategori_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_buku_penerbit_1` FOREIGN KEY (`penerbit_id`) REFERENCES `penerbit` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_buku_penulis_1` FOREIGN KEY (`penulis_id`) REFERENCES `penulis` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_buku_petugas_1` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_buku_supplier_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_kategori` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_kategori` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for peminjaman
-- ----------------------------
DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE `peminjaman`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `kode_pinjam` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `anggota_id` bigint NOT NULL,
  `petugas_id` bigint NOT NULL,
  `buku_id` bigint NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `peminjaman_id_index`(`anggota_id` ASC, `petugas_id` ASC, `buku_id` ASC) USING BTREE,
  INDEX `fk_peminjaman_buku_1`(`buku_id` ASC) USING BTREE,
  INDEX `fk_peminjaman_petugas_1`(`petugas_id` ASC) USING BTREE,
  CONSTRAINT `fk_peminjaman_anggota_1` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_peminjaman_buku_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_peminjaman_petugas_1` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penerbit
-- ----------------------------
DROP TABLE IF EXISTS `penerbit`;
CREATE TABLE `penerbit`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_penerbit` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_penerbit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengembalian
-- ----------------------------
DROP TABLE IF EXISTS `pengembalian`;
CREATE TABLE `pengembalian`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `peminjaman_id` bigint NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `denda` int NOT NULL,
  `petugas_id` bigint NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pengembalian_index`(`peminjaman_id` ASC, `petugas_id` ASC) USING BTREE,
  INDEX `fk_pengembalian_petugas_1`(`petugas_id` ASC) USING BTREE,
  CONSTRAINT `fk_pengembalian_peminjaman_1` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_pengembalian_petugas_1` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penulis
-- ----------------------------
DROP TABLE IF EXISTS `penulis`;
CREATE TABLE `penulis`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_penulis` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_penulis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for petugas
-- ----------------------------
DROP TABLE IF EXISTS `petugas`;
CREATE TABLE `petugas`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `level` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'nonaktif',
  `foto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_supplier` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_supplier` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- View structure for v_buku
-- ----------------------------
DROP VIEW IF EXISTS `v_buku`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_buku` AS select `buku`.`id` AS `id`,`buku`.`kode_buku` AS `kode_buku`,`buku`.`halaman` AS `halaman`,`buku`.`nama_buku` AS `nama_buku`,`buku`.`stok` AS `stok`,`buku`.`cover` AS `cover`,`buku`.`rak` AS `rak`,`buku`.`dimensi` AS `dimensi`,`buku`.`penerbit_id` AS `penerbit_id`,`buku`.`penulis_id` AS `penulis_id`,`buku`.`supplier_id` AS `supplier_id`,`buku`.`tahun` AS `tahun`,`buku`.`kategori_id` AS `kategori_id`,`buku`.`petugas_id` AS `petugas_id`,`petugas`.`nama_petugas` AS `nama_petugas`,`supplier`.`nama_supplier` AS `nama_supplier`,`penulis`.`nama_penulis` AS `nama_penulis`,`penerbit`.`nama_penerbit` AS `nama_penerbit`,`kategori`.`nama_kategori` AS `nama_kategori`,`buku`.`barcode` AS `barcode`,`buku`.`tanggal_masuk` AS `tanggal_masuk` from (((((`buku` join `petugas` on((`buku`.`petugas_id` = `petugas`.`id`))) join `supplier` on((`buku`.`supplier_id` = `supplier`.`id`))) join `penulis` on((`buku`.`penulis_id` = `penulis`.`id`))) join `penerbit` on((`buku`.`penerbit_id` = `penerbit`.`id`))) join `kategori` on((`buku`.`kategori_id` = `kategori`.`id`)));

-- ----------------------------
-- View structure for v_buku_full
-- ----------------------------
DROP VIEW IF EXISTS `v_buku_full`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_buku_full` AS select `buku`.`id` AS `id`,`buku`.`kode_buku` AS `kode_buku`,`buku`.`nama_buku` AS `nama_buku`,`penulis`.`nama_penulis` AS `nama_penulis`,`penerbit`.`nama_penerbit` AS `nama_penerbit`,`kategori`.`nama_kategori` AS `nama_kategori`,`supplier`.`nama_supplier` AS `nama_supplier` from ((((`buku` join `kategori` on((`buku`.`kategori_id` = `kategori`.`id`))) join `penerbit` on((`buku`.`penerbit_id` = `penerbit`.`id`))) join `penulis` on((`buku`.`penulis_id` = `penulis`.`id`))) join `supplier` on((`buku`.`supplier_id` = `supplier`.`id`)));

-- ----------------------------
-- View structure for v_bukukeluar
-- ----------------------------
DROP VIEW IF EXISTS `v_bukukeluar`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_bukukeluar` AS select `peminjaman`.`tanggal_pinjam` AS `tanggal_pinjam`,`buku`.`kode_buku` AS `kode_buku`,`buku`.`nama_buku` AS `nama_buku`,`penerbit`.`nama_penerbit` AS `nama_penerbit`,`penulis`.`nama_penulis` AS `nama_penulis`,`supplier`.`nama_supplier` AS `nama_supplier` from ((((`peminjaman` join `buku` on((`peminjaman`.`buku_id` = `buku`.`id`))) join `penerbit` on((`buku`.`penerbit_id` = `penerbit`.`id`))) join `penulis` on((`buku`.`penulis_id` = `penulis`.`id`))) join `supplier` on((`buku`.`supplier_id` = `supplier`.`id`)));

-- ----------------------------
-- View structure for v_denda
-- ----------------------------
DROP VIEW IF EXISTS `v_denda`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_denda` AS select `pengembalian`.`id` AS `id`,`pengembalian`.`peminjaman_id` AS `peminjaman_id`,`pengembalian`.`tanggal_pengembalian` AS `tanggal_pengembalian`,`pengembalian`.`denda` AS `denda`,`pengembalian`.`petugas_id` AS `petugas_id`,`peminjaman`.`buku_id` AS `buku_id`,`anggota`.`nama_anggota` AS `nama_anggota`,`petugas`.`nama_petugas` AS `nama_petugas` from ((((`pengembalian` join `peminjaman` on((`pengembalian`.`peminjaman_id` = `peminjaman`.`id`))) join `petugas` on(((`pengembalian`.`petugas_id` = `petugas`.`id`) and (`peminjaman`.`petugas_id` = `petugas`.`id`)))) join `anggota` on((`peminjaman`.`anggota_id` = `anggota`.`id`))) join `buku` on(((`buku`.`petugas_id` = `petugas`.`id`) and (`peminjaman`.`buku_id` = `buku`.`id`)))) where (`pengembalian`.`denda` > 0);

-- ----------------------------
-- View structure for v_pengembalian
-- ----------------------------
DROP VIEW IF EXISTS `v_pengembalian`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_pengembalian` AS select `peminjaman`.`kode_pinjam` AS `kode_pinjam`,`pengembalian`.`id` AS `id`,`pengembalian`.`peminjaman_id` AS `peminjaman_id`,`pengembalian`.`tanggal_pengembalian` AS `tanggal_pengembalian`,`pengembalian`.`denda` AS `denda`,`pengembalian`.`petugas_id` AS `petugas_id`,`petugas`.`nama_petugas` AS `nama_petugas`,`buku`.`nama_buku` AS `nama_buku`,`anggota`.`nama_anggota` AS `nama_anggota`,`peminjaman`.`buku_id` AS `buku_id` from ((((`pengembalian` join `peminjaman` on((`pengembalian`.`peminjaman_id` = `peminjaman`.`id`))) join `petugas` on(((`pengembalian`.`petugas_id` = `petugas`.`id`) and (`peminjaman`.`petugas_id` = `petugas`.`id`)))) join `buku` on(((`buku`.`petugas_id` = `petugas`.`id`) and (`peminjaman`.`buku_id` = `buku`.`id`)))) join `anggota` on((`peminjaman`.`anggota_id` = `anggota`.`id`)));

-- ----------------------------
-- View structure for v_pinjambuku
-- ----------------------------
DROP VIEW IF EXISTS `v_pinjambuku`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_pinjambuku` AS select `peminjaman`.`id` AS `id`,`peminjaman`.`tanggal_pinjam` AS `tanggal_pinjam`,`peminjaman`.`tanggal_kembali` AS `tanggal_kembali`,`peminjaman`.`kode_pinjam` AS `kode_pinjam`,`peminjaman`.`anggota_id` AS `anggota_id`,`peminjaman`.`petugas_id` AS `petugas_id`,`peminjaman`.`buku_id` AS `buku_id`,`peminjaman`.`status` AS `status`,`buku`.`nama_buku` AS `nama_buku`,`anggota`.`nama_anggota` AS `nama_anggota` from ((`peminjaman` join `buku` on((`peminjaman`.`buku_id` = `buku`.`id`))) join `anggota` on((`peminjaman`.`anggota_id` = `anggota`.`id`)));

SET FOREIGN_KEY_CHECKS = 1;
