CREATE DATABASE IF NOT EXISTS parkirin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE parkirin;
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS tb_log_aktivitas;
DROP TABLE IF EXISTS tb_transaksi;
DROP TABLE IF EXISTS tb_kendaraan;
DROP TABLE IF EXISTS tb_area_parkir;
DROP TABLE IF EXISTS tb_tarif;
DROP TABLE IF EXISTS tb_user;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE tb_user (
  id_user INT(11) NOT NULL AUTO_INCREMENT,
  nama_lengkap VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(100) NOT NULL,
  role ENUM('admin','petugas','owner') NOT NULL,
  status_aktif TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id_user)
) ENGINE=InnoDB;

CREATE TABLE tb_tarif (
  id_tarif INT(11) NOT NULL AUTO_INCREMENT,
  jenis_kendaraan ENUM('motor','mobil','lainnya') NOT NULL,
  tarif_per_jam DECIMAL(10,0) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_tarif),
  UNIQUE KEY uq_tarif_jenis (jenis_kendaraan)
) ENGINE=InnoDB;

CREATE TABLE tb_area_parkir (
  id_area INT(11) NOT NULL AUTO_INCREMENT,
  nama_area VARCHAR(50) NOT NULL,
  kapasitas INT(5) NOT NULL DEFAULT 0,
  terisi INT(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_area),
  UNIQUE KEY uq_area_nama (nama_area)
) ENGINE=InnoDB;

CREATE TABLE tb_kendaraan (
  id_kendaraan INT(11) NOT NULL AUTO_INCREMENT,
  plat_nomor VARCHAR(15) NOT NULL,
  jenis_kendaraan VARCHAR(20) NOT NULL,
  warna VARCHAR(20) DEFAULT NULL,
  pemilik VARCHAR(100) NOT NULL COMMENT 'Nama tamu atau karyawan hotel yang terdaftar',
  id_user INT(11) NOT NULL,
  PRIMARY KEY (id_kendaraan),
  UNIQUE KEY uq_kendaraan_plat (plat_nomor),
  KEY idx_kendaraan_user (id_user),
  CONSTRAINT fk_kendaraan_user FOREIGN KEY (id_user) REFERENCES tb_user(id_user) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE tb_transaksi (
  id_parkir INT(11) NOT NULL AUTO_INCREMENT,
  id_kendaraan INT(11) NOT NULL,
  waktu_masuk DATETIME NOT NULL,
  waktu_keluar DATETIME DEFAULT NULL,
  id_tarif INT(11) NOT NULL,
  durasi_jam INT(5) DEFAULT NULL,
  biaya_total DECIMAL(10,0) NOT NULL DEFAULT 0,
  status ENUM('masuk','keluar') NOT NULL DEFAULT 'masuk',
  id_user INT(11) NOT NULL,
  id_area INT(11) NOT NULL,
  PRIMARY KEY (id_parkir),
  KEY idx_transaksi_waktu (waktu_masuk),
  KEY idx_transaksi_status (status),
  KEY idx_transaksi_kendaraan_status (id_kendaraan,status),
  CONSTRAINT fk_transaksi_kendaraan FOREIGN KEY (id_kendaraan) REFERENCES tb_kendaraan(id_kendaraan) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_transaksi_tarif FOREIGN KEY (id_tarif) REFERENCES tb_tarif(id_tarif) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_transaksi_user FOREIGN KEY (id_user) REFERENCES tb_user(id_user) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_transaksi_area FOREIGN KEY (id_area) REFERENCES tb_area_parkir(id_area) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE tb_log_aktivitas (
  id_log INT(11) NOT NULL AUTO_INCREMENT,
  id_user INT(11) NOT NULL,
  aktivitas VARCHAR(100) NOT NULL,
  waktu_aktivitas DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_log),
  KEY idx_log_waktu (waktu_aktivitas),
  CONSTRAINT fk_log_user FOREIGN KEY (id_user) REFERENCES tb_user(id_user) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Akun contoh untuk pengujian lokal. Ganti password setelah login.
INSERT INTO tb_user (nama_lengkap, username, password, role, status_aktif) VALUES
('Alea Kennedy','alea','alea','admin',1),
('Baskara Santoso','baskara','baskara','petugas',1),
('Camila Putri','camila','camila','owner',1),
('Dayat Jojo','dayat','dayat','petugas',1),
('Emily Yorr','emily','emily','petugas',1),
('Fawas Hidayat','fawas','fawas','petugas',1);
INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES ('motor',3000),('mobil',5000),('lainnya',7000);
INSERT INTO tb_area_parkir (nama_area, kapasitas, terisi) VALUES ('Lobby Hotel',20,0),('Basement',40,0),('Area Karyawan',15,0);
