BEGIN;

CREATE TABLE IF NOT EXISTS public.desa (
  id bigserial PRIMARY KEY,
  nama text NOT NULL,
  slogan text,
  deskripsi text,
  alamat text,
  telepon text,
  email text,
  situs_web text,
  latitude numeric(10,6),
  longitude numeric(10,6),
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now()
);

CREATE TABLE IF NOT EXISTS public.kategori_berita (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  nama text NOT NULL,
  slug text NOT NULL,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT kategori_berita_slug_unik UNIQUE (desa_id, slug)
);

CREATE TABLE IF NOT EXISTS public.berita (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  kategori_id bigint REFERENCES public.kategori_berita(id) ON DELETE SET NULL,
  judul text NOT NULL,
  slug text NOT NULL,
  ringkasan text,
  isi text,
  url_gambar_sampul text,
  nama_penulis text,
  status text NOT NULL DEFAULT 'draf',
  unggulan boolean NOT NULL DEFAULT false,
  dipublikasikan_pada timestamptz,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT berita_status_check CHECK (status IN ('draf','dijadwalkan','diterbitkan')),
  CONSTRAINT berita_slug_unik UNIQUE (desa_id, slug)
);

CREATE INDEX IF NOT EXISTS berita_published_at_idx ON public.berita (dipublikasikan_pada DESC);
CREATE INDEX IF NOT EXISTS berita_kategori_idx ON public.berita (kategori_id);

CREATE TABLE IF NOT EXISTS public.pengumuman (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  judul text NOT NULL,
  slug text NOT NULL,
  isi text,
  prioritas text NOT NULL DEFAULT 'sedang',
  status text NOT NULL DEFAULT 'dijadwalkan',
  dipublikasikan_pada timestamptz,
  berakhir_pada timestamptz,
  lokasi text,
  kontak_nama text,
  kontak_telepon text,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT pengumuman_prioritas_check CHECK (prioritas IN ('rendah','sedang','tinggi')),
  CONSTRAINT pengumuman_status_check CHECK (status IN ('draf','dijadwalkan','diterbitkan','kedaluwarsa')),
  CONSTRAINT pengumuman_slug_unik UNIQUE (desa_id, slug)
);

CREATE INDEX IF NOT EXISTS pengumuman_published_at_idx ON public.pengumuman (dipublikasikan_pada DESC);

CREATE TABLE IF NOT EXISTS public.acara (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  judul text NOT NULL,
  slug text NOT NULL,
  kategori text NOT NULL,
  status text NOT NULL DEFAULT 'dijadwalkan',
  deskripsi text,
  penyelenggara text,
  sasaran text,
  lokasi text,
  dimulai_pada timestamptz,
  berakhir_pada timestamptz,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT acara_status_check CHECK (status IN ('draf','dijadwalkan','berlangsung','selesai','dibatalkan')),
  CONSTRAINT acara_slug_unik UNIQUE (desa_id, slug)
);

CREATE INDEX IF NOT EXISTS acara_dimulai_idx ON public.acara (dimulai_pada DESC);
CREATE INDEX IF NOT EXISTS acara_kategori_idx ON public.acara (kategori);

CREATE TABLE IF NOT EXISTS public.layanan (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  nama text NOT NULL,
  slug text NOT NULL,
  deskripsi text,
  waktu_proses text,
  jam_layanan text,
  biaya numeric(12,2),
  keterangan_biaya text,
  aktif boolean NOT NULL DEFAULT true,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT layanan_slug_unik UNIQUE (desa_id, slug)
);

CREATE TABLE IF NOT EXISTS public.persyaratan_layanan (
  id bigserial PRIMARY KEY,
  layanan_id bigint NOT NULL REFERENCES public.layanan(id) ON DELETE CASCADE,
  urutan integer NOT NULL DEFAULT 1,
  deskripsi text NOT NULL,
  CONSTRAINT persyaratan_layanan_urutan_unik UNIQUE (layanan_id, urutan)
);

CREATE TABLE IF NOT EXISTS public.kategori_umkm (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  nama text NOT NULL,
  slug text NOT NULL,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT kategori_umkm_slug_unik UNIQUE (desa_id, slug)
);

CREATE TABLE IF NOT EXISTS public.produk_umkm (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  kategori_id bigint REFERENCES public.kategori_umkm(id) ON DELETE SET NULL,
  nama text NOT NULL,
  slug text NOT NULL,
  deskripsi text,
  harga numeric(12,2),
  satuan text,
  nama_penjual text,
  telepon_penjual text,
  email_penjual text,
  alamat_penjual text,
  aktif boolean NOT NULL DEFAULT true,
  unggulan boolean NOT NULL DEFAULT false,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT produk_umkm_slug_unik UNIQUE (desa_id, slug)
);

CREATE INDEX IF NOT EXISTS produk_umkm_kategori_idx ON public.produk_umkm (kategori_id);
CREATE INDEX IF NOT EXISTS produk_umkm_harga_idx ON public.produk_umkm (harga);

CREATE TABLE IF NOT EXISTS public.album_galeri (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  judul text NOT NULL,
  slug text NOT NULL,
  gambar_sampul text,
  deskripsi text,
  unggulan boolean NOT NULL DEFAULT false,
  dipublikasikan_pada timestamptz,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT album_galeri_slug_unik UNIQUE (desa_id, slug)
);

CREATE TABLE IF NOT EXISTS public.foto_galeri (
  id bigserial PRIMARY KEY,
  album_id bigint NOT NULL REFERENCES public.album_galeri(id) ON DELETE CASCADE,
  judul text,
  deskripsi text,
  gambar text NOT NULL,
  urutan integer NOT NULL DEFAULT 1,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT foto_galeri_urutan_unik UNIQUE (album_id, urutan)
);

CREATE TABLE IF NOT EXISTS public.transparansi_tahun (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  tahun_anggaran integer NOT NULL,
  total_pendapatan numeric(15,2),
  total_belanja numeric(15,2),
  surplus numeric(15,2),
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT transparansi_tahun_unik UNIQUE (desa_id, tahun_anggaran)
);

CREATE TABLE IF NOT EXISTS public.transparansi_pendapatan (
  id bigserial PRIMARY KEY,
  transparansi_tahun_id bigint NOT NULL REFERENCES public.transparansi_tahun(id) ON DELETE CASCADE,
  nama_sumber text NOT NULL,
  jumlah numeric(15,2) NOT NULL,
  persentase numeric(6,2)
);

CREATE TABLE IF NOT EXISTS public.transparansi_belanja (
  id bigserial PRIMARY KEY,
  transparansi_tahun_id bigint NOT NULL REFERENCES public.transparansi_tahun(id) ON DELETE CASCADE,
  nama_bidang text NOT NULL,
  jumlah numeric(15,2) NOT NULL,
  persentase numeric(6,2),
  catatan text
);

CREATE TABLE IF NOT EXISTS public.program_prioritas (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  transparansi_tahun_id bigint REFERENCES public.transparansi_tahun(id) ON DELETE SET NULL,
  nama text NOT NULL,
  deskripsi text,
  anggaran numeric(15,2),
  persentase_realisasi numeric(5,2),
  status text NOT NULL DEFAULT 'direncanakan',
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT program_prioritas_status_check CHECK (status IN ('direncanakan','berlangsung','selesai','ditangguhkan'))
);

CREATE TABLE IF NOT EXISTS public.laporan_keuangan (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  transparansi_tahun_id bigint REFERENCES public.transparansi_tahun(id) ON DELETE SET NULL,
  periode text NOT NULL,
  berkas text NOT NULL,
  dipublikasikan_pada timestamptz,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT laporan_keuangan_periode_unik UNIQUE (desa_id, periode)
);

CREATE TABLE IF NOT EXISTS public.snapshot_statistik (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  periode text NOT NULL,
  tahun integer,
  total_penduduk integer,
  jumlah_kk integer,
  penduduk_laki integer,
  penduduk_perempuan integer,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT snapshot_statistik_periode_unik UNIQUE (desa_id, periode)
);

CREATE TABLE IF NOT EXISTS public.statistik_kelompok_usia (
  id bigserial PRIMARY KEY,
  snapshot_id bigint NOT NULL REFERENCES public.snapshot_statistik(id) ON DELETE CASCADE,
  label text NOT NULL,
  jumlah integer NOT NULL,
  urutan integer NOT NULL DEFAULT 1,
  CONSTRAINT statistik_kelompok_usia_label_unik UNIQUE (snapshot_id, label)
);

CREATE TABLE IF NOT EXISTS public.statistik_pendidikan (
  id bigserial PRIMARY KEY,
  snapshot_id bigint NOT NULL REFERENCES public.snapshot_statistik(id) ON DELETE CASCADE,
  jenjang text NOT NULL,
  jumlah integer NOT NULL,
  urutan integer NOT NULL DEFAULT 1,
  CONSTRAINT statistik_pendidikan_jenjang_unik UNIQUE (snapshot_id, jenjang)
);

CREATE TABLE IF NOT EXISTS public.statistik_pekerjaan (
  id bigserial PRIMARY KEY,
  snapshot_id bigint NOT NULL REFERENCES public.snapshot_statistik(id) ON DELETE CASCADE,
  nama_pekerjaan text NOT NULL,
  jumlah integer,
  persentase numeric(5,2),
  urutan integer NOT NULL DEFAULT 1,
  CONSTRAINT statistik_pekerjaan_nama_unik UNIQUE (snapshot_id, nama_pekerjaan)
);

CREATE TABLE IF NOT EXISTS public.pesan_kontak (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  nama_lengkap text NOT NULL,
  email text,
  telepon text,
  subjek text,
  isi text NOT NULL,
  status text NOT NULL DEFAULT 'baru',
  ditangani_oleh text,
  ditangani_pada timestamptz,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT pesan_kontak_status_check CHECK (status IN ('baru','diproses','selesai','arsip'))
);

CREATE TABLE IF NOT EXISTS public.dokumen_unduhan (
  id bigserial PRIMARY KEY,
  desa_id bigint NOT NULL REFERENCES public.desa(id) ON DELETE CASCADE,
  judul text NOT NULL,
  berkas text NOT NULL,
  tipe_berkas text,
  deskripsi text,
  dipublikasikan_pada timestamptz,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT dokumen_unduhan_judul_unik UNIQUE (desa_id, judul)
);

CREATE TABLE IF NOT EXISTS public.pengguna (
  id bigserial PRIMARY KEY,
  auth_user_id uuid REFERENCES auth.users(id) ON DELETE SET NULL,
  desa_id bigint REFERENCES public.desa(id) ON DELETE SET NULL,
  nama text NOT NULL,
  email text,
  telepon text,
  foto_profil text,
  status text NOT NULL DEFAULT 'aktif',
  terakhir_masuk timestamptz,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT pengguna_status_check CHECK (status IN ('aktif','nonaktif','diblokir')),
  CONSTRAINT pengguna_email_unik UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS public.peran (
  id bigserial PRIMARY KEY,
  desa_id bigint REFERENCES public.desa(id) ON DELETE CASCADE,
  nama text NOT NULL,
  slug text NOT NULL,
  deskripsi text,
  prioritas integer NOT NULL DEFAULT 10,
  bawaan boolean NOT NULL DEFAULT false,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT peran_slug_unik UNIQUE (slug)
);

CREATE TABLE IF NOT EXISTS public.pengguna_peran (
  id bigserial PRIMARY KEY,
  pengguna_id bigint NOT NULL REFERENCES public.pengguna(id) ON DELETE CASCADE,
  peran_id bigint NOT NULL REFERENCES public.peran(id) ON DELETE CASCADE,
  desa_id bigint REFERENCES public.desa(id) ON DELETE CASCADE,
  status text NOT NULL DEFAULT 'aktif',
  ditetapkan_oleh bigint REFERENCES public.pengguna(id) ON DELETE SET NULL,
  ditetapkan_pada timestamptz NOT NULL DEFAULT now(),
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT pengguna_peran_status_check CHECK (status IN ('aktif','dicabut')),
  CONSTRAINT pengguna_peran_unik UNIQUE (pengguna_id, peran_id, desa_id)
);

CREATE TABLE IF NOT EXISTS public.peran_hak_akses (
  id bigserial PRIMARY KEY,
  peran_id bigint NOT NULL REFERENCES public.peran(id) ON DELETE CASCADE,
  modul text NOT NULL,
  boleh_lihat boolean NOT NULL DEFAULT false,
  boleh_kelola boolean NOT NULL DEFAULT false,
  dibuat_pada timestamptz NOT NULL DEFAULT now(),
  diperbarui_pada timestamptz NOT NULL DEFAULT now(),
  CONSTRAINT peran_hak_akses_modul_check CHECK (modul IN ('profil_desa','berita','pengumuman','agenda','layanan','umkm','galeri','transparansi','statistik','dokumen','pesan','pengguna')),
  CONSTRAINT peran_hak_akses_unik UNIQUE (peran_id, modul)
);

COMMIT;
