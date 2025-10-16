SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `desa` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(255) NOT NULL,
  `slogan` TEXT,
  `deskripsi` TEXT,
  `alamat` TEXT,
  `telepon` VARCHAR(50),
  `email` VARCHAR(255),
  `situs_web` VARCHAR(255),
  `latitude` DECIMAL(10,6),
  `longitude` DECIMAL(10,6),
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `kategori_berita` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_berita_slug_unik` (`desa_id`,`slug`),
  CONSTRAINT `kategori_berita_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `berita` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `kategori_id` BIGINT UNSIGNED DEFAULT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `ringkasan` TEXT,
  `isi` LONGTEXT,
  `gambar_sampul` VARCHAR(255),
  `nama_penulis` VARCHAR(255),
  `status` ENUM('draf','dijadwalkan','diterbitkan') NOT NULL DEFAULT 'draf',
  `unggulan` TINYINT(1) NOT NULL DEFAULT 0,
  `dipublikasikan_pada` TIMESTAMP NULL DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_slug_unik` (`desa_id`,`slug`),
  KEY `berita_kategori_idx` (`kategori_id`),
  KEY `berita_published_at_idx` (`dipublikasikan_pada`),
  CONSTRAINT `berita_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE,
  CONSTRAINT `berita_kategori_fk` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_berita`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pengumuman` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `isi` LONGTEXT,
  `prioritas` ENUM('rendah','sedang','tinggi') NOT NULL DEFAULT 'sedang',
  `status` ENUM('draf','dijadwalkan','diterbitkan','kedaluwarsa') NOT NULL DEFAULT 'dijadwalkan',
  `dipublikasikan_pada` TIMESTAMP NULL DEFAULT NULL,
  `berakhir_pada` TIMESTAMP NULL DEFAULT NULL,
  `lokasi` VARCHAR(255),
  `kontak_nama` VARCHAR(255),
  `kontak_telepon` VARCHAR(50),
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengumuman_slug_unik` (`desa_id`,`slug`),
  KEY `pengumuman_published_at_idx` (`dipublikasikan_pada`),
  CONSTRAINT `pengumuman_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `acara` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `kategori` VARCHAR(100) NOT NULL,
  `status` ENUM('draf','dijadwalkan','berlangsung','selesai','dibatalkan') NOT NULL DEFAULT 'dijadwalkan',
  `deskripsi` LONGTEXT,
  `penyelenggara` VARCHAR(255),
  `sasaran` VARCHAR(255),
  `lokasi` VARCHAR(255),
  `dimulai_pada` TIMESTAMP NULL DEFAULT NULL,
  `berakhir_pada` TIMESTAMP NULL DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acara_slug_unik` (`desa_id`,`slug`),
  KEY `acara_dimulai_idx` (`dimulai_pada`),
  KEY `acara_kategori_idx` (`kategori`),
  CONSTRAINT `acara_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `layanan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `deskripsi` LONGTEXT,
  `waktu_proses` VARCHAR(255),
  `jam_layanan` VARCHAR(255),
  `biaya` DECIMAL(12,2),
  `keterangan_biaya` LONGTEXT,
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `layanan_slug_unik` (`desa_id`,`slug`),
  CONSTRAINT `layanan_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `persyaratan_layanan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `layanan_id` BIGINT UNSIGNED NOT NULL,
  `urutan` INT NOT NULL DEFAULT 1,
  `deskripsi` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persyaratan_layanan_urutan_unik` (`layanan_id`,`urutan`),
  CONSTRAINT `persyaratan_layanan_fk` FOREIGN KEY (`layanan_id`) REFERENCES `layanan`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `kategori_umkm` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_umkm_slug_unik` (`desa_id`,`slug`),
  CONSTRAINT `kategori_umkm_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `produk_umkm` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `kategori_id` BIGINT UNSIGNED DEFAULT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `deskripsi` LONGTEXT,
  `harga` DECIMAL(12,2),
  `satuan` VARCHAR(50),
  `nama_penjual` VARCHAR(255),
  `telepon_penjual` VARCHAR(50),
  `email_penjual` VARCHAR(255),
  `alamat_penjual` VARCHAR(255),
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  `unggulan` TINYINT(1) NOT NULL DEFAULT 0,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produk_umkm_slug_unik` (`desa_id`,`slug`),
  KEY `produk_umkm_kategori_idx` (`kategori_id`),
  KEY `produk_umkm_harga_idx` (`harga`),
  CONSTRAINT `produk_umkm_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE,
  CONSTRAINT `produk_umkm_kategori_fk` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_umkm`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `album_galeri` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `gambar_sampul` VARCHAR(255),
  `deskripsi` LONGTEXT,
  `unggulan` TINYINT(1) NOT NULL DEFAULT 0,
  `dipublikasikan_pada` TIMESTAMP NULL DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `album_galeri_slug_unik` (`desa_id`,`slug`),
  CONSTRAINT `album_galeri_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `foto_galeri` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `album_id` BIGINT UNSIGNED NOT NULL,
  `judul` VARCHAR(255),
  `deskripsi` LONGTEXT,
  `gambar` VARCHAR(255) NOT NULL,
  `urutan` INT NOT NULL DEFAULT 1,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `foto_galeri_urutan_unik` (`album_id`,`urutan`),
  CONSTRAINT `foto_galeri_album_fk` FOREIGN KEY (`album_id`) REFERENCES `album_galeri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `transparansi_tahun` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `tahun_anggaran` INT NOT NULL,
  `total_pendapatan` DECIMAL(15,2),
  `total_belanja` DECIMAL(15,2),
  `surplus` DECIMAL(15,2),
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transparansi_tahun_unik` (`desa_id`,`tahun_anggaran`),
  CONSTRAINT `transparansi_tahun_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `transparansi_pendapatan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `transparansi_tahun_id` BIGINT UNSIGNED NOT NULL,
  `nama_sumber` VARCHAR(255) NOT NULL,
  `jumlah` DECIMAL(15,2) NOT NULL,
  `persentase` DECIMAL(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `transparansi_pendapatan_fk` FOREIGN KEY (`transparansi_tahun_id`) REFERENCES `transparansi_tahun`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `transparansi_belanja` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `transparansi_tahun_id` BIGINT UNSIGNED NOT NULL,
  `nama_bidang` VARCHAR(255) NOT NULL,
  `jumlah` DECIMAL(15,2) NOT NULL,
  `persentase` DECIMAL(6,2) DEFAULT NULL,
  `catatan` LONGTEXT,
  PRIMARY KEY (`id`),
  CONSTRAINT `transparansi_belanja_fk` FOREIGN KEY (`transparansi_tahun_id`) REFERENCES `transparansi_tahun`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `program_prioritas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `transparansi_tahun_id` BIGINT UNSIGNED DEFAULT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `deskripsi` LONGTEXT,
  `anggaran` DECIMAL(15,2),
  `persentase_realisasi` DECIMAL(5,2),
  `status` ENUM('direncanakan','berlangsung','selesai','ditangguhkan') NOT NULL DEFAULT 'direncanakan',
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `program_prioritas_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE,
  CONSTRAINT `program_prioritas_transparansi_fk` FOREIGN KEY (`transparansi_tahun_id`) REFERENCES `transparansi_tahun`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `laporan_keuangan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `transparansi_tahun_id` BIGINT UNSIGNED DEFAULT NULL,
  `periode` VARCHAR(100) NOT NULL,
  `berkas` VARCHAR(255) NOT NULL,
  `dipublikasikan_pada` TIMESTAMP NULL DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `laporan_keuangan_periode_unik` (`desa_id`,`periode`),
  CONSTRAINT `laporan_keuangan_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE,
  CONSTRAINT `laporan_keuangan_transparansi_fk` FOREIGN KEY (`transparansi_tahun_id`) REFERENCES `transparansi_tahun`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `snapshot_statistik` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `periode` VARCHAR(100) NOT NULL,
  `tahun` INT,
  `total_penduduk` INT,
  `jumlah_kk` INT,
  `penduduk_laki` INT,
  `penduduk_perempuan` INT,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `snapshot_statistik_periode_unik` (`desa_id`,`periode`),
  CONSTRAINT `snapshot_statistik_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `statistik_kelompok_usia` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `snapshot_id` BIGINT UNSIGNED NOT NULL,
  `label` VARCHAR(255) NOT NULL,
  `jumlah` INT NOT NULL,
  `urutan` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `statistik_kelompok_usia_label_unik` (`snapshot_id`,`label`),
  CONSTRAINT `statistik_kelompok_usia_fk` FOREIGN KEY (`snapshot_id`) REFERENCES `snapshot_statistik`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `statistik_pendidikan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `snapshot_id` BIGINT UNSIGNED NOT NULL,
  `jenjang` VARCHAR(255) NOT NULL,
  `jumlah` INT NOT NULL,
  `urutan` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `statistik_pendidikan_jenjang_unik` (`snapshot_id`,`jenjang`),
  CONSTRAINT `statistik_pendidikan_fk` FOREIGN KEY (`snapshot_id`) REFERENCES `snapshot_statistik`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `statistik_pekerjaan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `snapshot_id` BIGINT UNSIGNED NOT NULL,
  `nama_pekerjaan` VARCHAR(255) NOT NULL,
  `jumlah` INT DEFAULT NULL,
  `persentase` DECIMAL(5,2) DEFAULT NULL,
  `urutan` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `statistik_pekerjaan_nama_unik` (`snapshot_id`,`nama_pekerjaan`),
  CONSTRAINT `statistik_pekerjaan_fk` FOREIGN KEY (`snapshot_id`) REFERENCES `snapshot_statistik`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pesan_kontak` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `nama_lengkap` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255),
  `telepon` VARCHAR(50),
  `subjek` VARCHAR(255),
  `isi` LONGTEXT NOT NULL,
  `status` ENUM('baru','diproses','selesai','arsip') NOT NULL DEFAULT 'baru',
  `ditangani_oleh` VARCHAR(255),
  `ditangani_pada` TIMESTAMP NULL DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `pesan_kontak_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `dokumen_unduhan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `berkas` VARCHAR(255) NOT NULL,
  `tipe_berkas` VARCHAR(100),
  `deskripsi` LONGTEXT,
  `dipublikasikan_pada` TIMESTAMP NULL DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dokumen_unduhan_judul_unik` (`desa_id`,`judul`),
  CONSTRAINT `dokumen_unduhan_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `auth_user_id` CHAR(36) DEFAULT NULL,
  `desa_id` BIGINT UNSIGNED DEFAULT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255),
  `telepon` VARCHAR(50),
  `foto_profil` VARCHAR(255),
  `status` ENUM('aktif','nonaktif','diblokir') NOT NULL DEFAULT 'aktif',
  `terakhir_masuk` TIMESTAMP NULL DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengguna_email_unik` (`email`),
  CONSTRAINT `pengguna_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `peran` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `desa_id` BIGINT UNSIGNED DEFAULT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `deskripsi` LONGTEXT,
  `prioritas` INT NOT NULL DEFAULT 10,
  `bawaan` TINYINT(1) NOT NULL DEFAULT 0,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peran_slug_unik` (`slug`),
  CONSTRAINT `peran_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pengguna_peran` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pengguna_id` BIGINT UNSIGNED NOT NULL,
  `peran_id` BIGINT UNSIGNED NOT NULL,
  `desa_id` BIGINT UNSIGNED DEFAULT NULL,
  `status` ENUM('aktif','dicabut') NOT NULL DEFAULT 'aktif',
  `ditetapkan_oleh` BIGINT UNSIGNED DEFAULT NULL,
  `ditetapkan_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengguna_peran_unik` (`pengguna_id`,`peran_id`,`desa_id`),
  CONSTRAINT `pengguna_peran_pengguna_fk` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna`(`id`) ON DELETE CASCADE,
  CONSTRAINT `pengguna_peran_peran_fk` FOREIGN KEY (`peran_id`) REFERENCES `peran`(`id`) ON DELETE CASCADE,
  CONSTRAINT `pengguna_peran_desa_fk` FOREIGN KEY (`desa_id`) REFERENCES `desa`(`id`) ON DELETE CASCADE,
  CONSTRAINT `pengguna_peran_penetu_fk` FOREIGN KEY (`ditetapkan_oleh`) REFERENCES `pengguna`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `peran_hak_akses` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `peran_id` BIGINT UNSIGNED NOT NULL,
  `modul` ENUM('profil_desa','berita','pengumuman','agenda','layanan','umkm','galeri','transparansi','statistik','dokumen','pesan','pengguna') NOT NULL,
  `boleh_lihat` TINYINT(1) NOT NULL DEFAULT 0,
  `boleh_kelola` TINYINT(1) NOT NULL DEFAULT 0,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peran_hak_akses_unik` (`peran_id`,`modul`),
  CONSTRAINT `peran_hak_akses_peran_fk` FOREIGN KEY (`peran_id`) REFERENCES `peran`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `desa` (`id`, `nama`, `slogan`, `deskripsi`, `alamat`, `telepon`, `email`, `situs_web`, `latitude`, `longitude`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 'Desa Juara', 'Bersama Maju', 'Desa Juara adalah desa yang aktif membangun.', 'Jl. Merdeka No.1', '0215551234', 'info@desajuara.id', 'https://desajuara.id', -6.200000, 106.816667, '2025-01-01 08:00:00', '2025-01-01 08:00:00');

INSERT IGNORE INTO `kategori_berita` (`id`, `desa_id`, `nama`, `slug`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Pemerintahan', 'pemerintahan', '2025-01-02 09:00:00', '2025-01-02 09:00:00');

INSERT IGNORE INTO `berita` (`id`, `desa_id`, `kategori_id`, `judul`, `slug`, `ringkasan`, `isi`, `gambar_sampul`, `nama_penulis`, `status`, `unggulan`, `dipublikasikan_pada`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 1, 'Musrenbang Desa 2025', 'musrenbang-desa-2025', 'Rangkuman musyawarah perencanaan pembangunan desa.', 'Isi lengkap berita Musrenbang 2025.', 'musrenbang.jpg', 'Tim Redaksi', 'diterbitkan', 1, '2025-01-05 10:00:00', '2025-01-04 08:30:00', '2025-01-05 10:00:00');

INSERT IGNORE INTO `pengumuman` (`id`, `desa_id`, `judul`, `slug`, `isi`, `prioritas`, `status`, `dipublikasikan_pada`, `berakhir_pada`, `lokasi`, `kontak_nama`, `kontak_telepon`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Penutupan Layanan Sementara', 'penutupan-layanan-sementara', 'Pelayanan administrasi ditutup sementara karena pemeliharaan sistem.', 'tinggi', 'diterbitkan', '2025-01-06 08:00:00', '2025-01-10 16:00:00', 'Kantor Desa Juara', 'Sekretariat Desa', '081234567890', '2025-01-05 09:00:00', '2025-01-06 08:00:00');

INSERT IGNORE INTO `acara` (`id`, `desa_id`, `judul`, `slug`, `kategori`, `status`, `deskripsi`, `penyelenggara`, `sasaran`, `lokasi`, `dimulai_pada`, `berakhir_pada`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Festival Panen Raya', 'festival-panen-raya', 'Kebudayaan', 'berlangsung', 'Festival panen raya dengan berbagai lomba dan bazar UMKM.', 'BUMDes Juara', 'Warga Desa Juara', 'Lapangan Desa Juara', '2025-02-15 09:00:00', '2025-02-15 21:00:00', '2025-01-20 14:00:00', '2025-02-10 08:00:00');

INSERT IGNORE INTO `layanan` (`id`, `desa_id`, `nama`, `slug`, `deskripsi`, `waktu_proses`, `jam_layanan`, `biaya`, `keterangan_biaya`, `aktif`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Surat Keterangan Domisili', 'surat-keterangan-domisili', 'Pelayanan penerbitan surat keterangan domisili warga.', '2 Hari Kerja', '08:00-14:00 WIB', 0.00, 'Gratis', 1, '2025-01-03 08:30:00', '2025-01-03 08:30:00');

INSERT IGNORE INTO `persyaratan_layanan` (`id`, `layanan_id`, `urutan`, `deskripsi`) VALUES
(1, 1, 1, 'Fotokopi KTP pemohon'),
(2, 1, 2, 'Fotokopi Kartu Keluarga');

INSERT IGNORE INTO `kategori_umkm` (`id`, `desa_id`, `nama`, `slug`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Kuliner', 'kuliner', '2025-01-07 11:00:00', '2025-01-07 11:00:00');

INSERT IGNORE INTO `produk_umkm` (`id`, `desa_id`, `kategori_id`, `nama`, `slug`, `deskripsi`, `harga`, `satuan`, `nama_penjual`, `telepon_penjual`, `email_penjual`, `alamat_penjual`, `aktif`, `unggulan`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 1, 'Keripik Singkong Pedas', 'keripik-singkong-pedas', 'Keripik singkong pedas buatan kelompok wanita tani.', 15000.00, 'Pack', 'Kelompok Wanita Tani Mekar', '081355512345', 'kwtmekar@desajuara.id', 'RT 02 RW 03', 1, 1, '2025-01-10 09:15:00', '2025-01-10 09:15:00');

INSERT IGNORE INTO `album_galeri` (`id`, `desa_id`, `judul`, `slug`, `gambar_sampul`, `deskripsi`, `unggulan`, `dipublikasikan_pada`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Galeri Festival Panen', 'galeri-festival-panen', 'festival-cover.jpg', 'Dokumentasi festival panen raya Desa Juara.', 1, '2025-02-16 08:00:00', '2025-02-16 08:00:00', '2025-02-16 08:00:00');

INSERT IGNORE INTO `foto_galeri` (`id`, `album_id`, `judul`, `deskripsi`, `gambar`, `urutan`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Pembukaan Festival', 'Pembukaan oleh Kepala Desa.', 'festival-1.jpg', 1, '2025-02-16 08:30:00', '2025-02-16 08:30:00'),
(2, 1, 'Stan UMKM', 'Produk unggulan UMKM desa.', 'festival-2.jpg', 2, '2025-02-16 08:35:00', '2025-02-16 08:35:00');

INSERT IGNORE INTO `transparansi_tahun` (`id`, `desa_id`, `tahun_anggaran`, `total_pendapatan`, `total_belanja`, `surplus`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 2024, 1250000000.00, 1185000000.00, 65000000.00, '2025-01-12 10:00:00', '2025-01-12 10:00:00');

INSERT IGNORE INTO `transparansi_pendapatan` (`id`, `transparansi_tahun_id`, `nama_sumber`, `jumlah`, `persentase`) VALUES
(1, 1, 'Dana Desa', 750000000.00, 60.00),
(2, 1, 'Pendapatan Asli Desa', 250000000.00, 20.00),
(3, 1, 'Bantuan Provinsi', 250000000.00, 20.00);

INSERT IGNORE INTO `transparansi_belanja` (`id`, `transparansi_tahun_id`, `nama_bidang`, `jumlah`, `persentase`, `catatan`) VALUES
(1, 1, 'Pembangunan Infrastruktur', 550000000.00, 46.40, 'Pembangunan jalan lingkungan'),
(2, 1, 'Pemberdayaan Masyarakat', 300000000.00, 25.30, 'Pelatihan UMKM dan kelompok tani'),
(3, 1, 'Belanja Rutin', 335000000.00, 28.30, 'Operasional kantor desa');

INSERT IGNORE INTO `program_prioritas` (`id`, `desa_id`, `transparansi_tahun_id`, `nama`, `deskripsi`, `anggaran`, `persentase_realisasi`, `status`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 1, 'Pembangunan Jalan Utama', 'Pengecoran jalan utama desa sepanjang 1 km.', 450000000.00, 55.00, 'berlangsung', '2025-01-18 09:00:00', '2025-02-01 09:00:00');

INSERT IGNORE INTO `laporan_keuangan` (`id`, `desa_id`, `transparansi_tahun_id`, `periode`, `berkas`, `dipublikasikan_pada`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 1, 'Triwulan IV 2024', 'laporan-triwulan-iv-2024.pdf', '2025-01-25 08:00:00', '2025-01-25 08:00:00', '2025-01-25 08:00:00');

INSERT IGNORE INTO `snapshot_statistik` (`id`, `desa_id`, `periode`, `tahun`, `total_penduduk`, `jumlah_kk`, `penduduk_laki`, `penduduk_perempuan`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Triwulan I', 2025, 8450, 2150, 4200, 4250, '2025-03-01 08:00:00', '2025-03-01 08:00:00');

INSERT IGNORE INTO `statistik_kelompok_usia` (`id`, `snapshot_id`, `label`, `jumlah`, `urutan`) VALUES
(1, 1, '0-5 Tahun', 950, 1),
(2, 1, '6-18 Tahun', 2200, 2),
(3, 1, '19-59 Tahun', 4200, 3),
(4, 1, '60+ Tahun', 1100, 4);

INSERT IGNORE INTO `statistik_pendidikan` (`id`, `snapshot_id`, `jenjang`, `jumlah`, `urutan`) VALUES
(1, 1, 'Tidak Sekolah', 800, 1),
(2, 1, 'SD/Sederajat', 2200, 2),
(3, 1, 'SMP/Sederajat', 1800, 3),
(4, 1, 'SMA/Sederajat', 2400, 4),
(5, 1, 'Diploma', 550, 5),
(6, 1, 'Sarjana', 600, 6);

INSERT IGNORE INTO `statistik_pekerjaan` (`id`, `snapshot_id`, `nama_pekerjaan`, `jumlah`, `persentase`, `urutan`) VALUES
(1, 1, 'Petani', 1800, 21.30, 1),
(2, 1, 'Pedagang', 950, 11.20, 2),
(3, 1, 'Pegawai Negeri', 420, 5.00, 3),
(4, 1, 'Wirausaha', 1200, 14.20, 4),
(5, 1, 'Pelajar/Mahasiswa', 2100, 24.90, 5),
(6, 1, 'Pekerja Lepas', 980, 11.60, 6);

INSERT IGNORE INTO `pesan_kontak` (`id`, `desa_id`, `nama_lengkap`, `email`, `telepon`, `subjek`, `isi`, `status`, `ditangani_oleh`, `ditangani_pada`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Rahma Sari', 'rahma@contoh.id', '082233445566', 'Permohonan Informasi', 'Mohon informasi jadwal pelayanan akta kelahiran.', 'diproses', 'Petugas Pelayanan', '2025-03-02 09:00:00', '2025-03-01 14:30:00', '2025-03-02 09:00:00');

INSERT IGNORE INTO `dokumen_unduhan` (`id`, `desa_id`, `judul`, `berkas`, `tipe_berkas`, `deskripsi`, `dipublikasikan_pada`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Perdes RPJM Desa 2024-2030', 'perdes-rpjm-2024-2030.pdf', 'pdf', 'Peraturan desa tentang RPJM Desa Juara.', '2025-02-05 10:00:00', '2025-02-05 10:00:00', '2025-02-05 10:00:00');

INSERT IGNORE INTO `pengguna` (`id`, `auth_user_id`, `desa_id`, `nama`, `email`, `telepon`, `foto_profil`, `status`, `terakhir_masuk`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, NULL, 1, 'Admin Desa Juara', 'admin@desajuara.id', '081234567890', NULL, 'aktif', '2025-03-01 07:45:00', '2025-01-02 08:00:00', '2025-03-01 07:45:00');

INSERT IGNORE INTO `peran` (`id`, `desa_id`, `nama`, `slug`, `deskripsi`, `prioritas`, `bawaan`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'Administrator', 'administrator', 'Memiliki akses penuh terhadap seluruh modul.', 1, 1, '2025-01-02 08:30:00', '2025-01-02 08:30:00');

INSERT IGNORE INTO `pengguna_peran` (`id`, `pengguna_id`, `peran_id`, `desa_id`, `status`, `ditetapkan_oleh`, `ditetapkan_pada`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 1, 1, 'aktif', 1, '2025-01-02 09:00:00', '2025-01-02 09:00:00', '2025-01-02 09:00:00');

INSERT IGNORE INTO `peran_hak_akses` (`id`, `peran_id`, `modul`, `boleh_lihat`, `boleh_kelola`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 1, 'profil_desa', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(2, 1, 'berita', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(3, 1, 'pengumuman', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(4, 1, 'agenda', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(5, 1, 'layanan', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(6, 1, 'umkm', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(7, 1, 'galeri', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(8, 1, 'transparansi', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(9, 1, 'statistik', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(10, 1, 'dokumen', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(11, 1, 'pesan', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00'),
(12, 1, 'pengguna', 1, 1, '2025-01-02 09:05:00', '2025-01-02 09:05:00');

SET FOREIGN_KEY_CHECKS = 1;
