-- PostgreSQL conversion from Oracle dump
-- Schemas renamed:
--   PGN_SHARE   -> NR_CSR
--   PGN_PAYMENT -> NR_PAYMENT

create schema if not exists nr_csr;
create schema if not exists nr_payment;

-- ----------------------------
-- Table structure for NO_AGENDA
-- ----------------------------
drop table if exists nr_csr.no_agenda cascade;
create table nr_csr.no_agenda (
  tahun integer not null,
  last_no numeric not null
);

-- ----------------------------
-- Table structure for TBL_ALOKASI
-- ----------------------------
drop table if exists nr_csr.tbl_alokasi cascade;
create table nr_csr.tbl_alokasi (
  id_alokasi numeric,
  id_relokasi numeric,
  proker varchar(200),
  provinsi varchar(100),
  tahun varchar(4),
  nominal_alokasi numeric,
  sektor_bantuan varchar(100)
);

-- ----------------------------
-- Table structure for TBL_ANGGARAN
-- ----------------------------
drop table if exists nr_csr.tbl_anggaran cascade;
create table nr_csr.tbl_anggaran (
  id_anggaran numeric not null,
  nominal numeric,
  tahun varchar(4),
  perusahaan_old varchar(255),
  id_perusahaan numeric,
  perusahaan varchar(255)
);

-- ----------------------------
-- Table structure for TBL_ANGGOTA
-- ----------------------------
drop table if exists nr_csr.tbl_anggota cascade;
create table nr_csr.tbl_anggota (
  id_anggota numeric not null,
  nama_anggota varchar(100),
  fraksi varchar(150),
  komisi varchar(10),
  jabatan varchar(100),
  staf_ahli varchar(100),
  no_telp varchar(20),
  foto_profile varchar(255),
  status varchar(10)
);

-- ----------------------------
-- Table structure for TBL_AREA
-- ----------------------------
drop table if exists nr_csr.tbl_area cascade;
create table nr_csr.tbl_area (
  id_area bigint not null,
  area_kerja varchar(50),
  created_at timestamp,
  updated_at timestamp
);

-- ----------------------------
-- Table structure for TBL_ASSESSMENT_VENDOR
-- ----------------------------
drop table if exists nr_csr.tbl_assessment_vendor cascade;
create table nr_csr.tbl_assessment_vendor (
  assessment_id numeric not null,
  tanggal varchar(255),
  id_vendor varchar(255),
  tahun varchar(255),
  created_by varchar(255),
  created_date timestamp
);

-- ----------------------------
-- Table structure for TBL_BAKN
-- ----------------------------
drop table if exists nr_csr.tbl_bakn cascade;
create table nr_csr.tbl_bakn (
  bakn_id numeric not null,
  nomor varchar(255),
  tanggal varchar(255),
  pekerjaan_id numeric,
  status varchar(255),
  catatan varchar(255),
  created_by varchar(255),
  created_date timestamp,
  id_vendor varchar(255),
  file_bakn varchar(255),
  nilai_kesepakatan numeric,
  sph_id numeric,
  response_date timestamp,
  response_by varchar(255)
);

-- ----------------------------
-- Table structure for TBL_BANK
-- ----------------------------
drop table if exists nr_csr.tbl_bank cascade;
create table nr_csr.tbl_bank (
  bank_id numeric not null,
  nama_bank varchar(255)
);

-- ----------------------------
-- Table structure for TBL_BAST_DANA
-- ----------------------------
drop table if exists nr_csr.tbl_bast_dana cascade;
create table nr_csr.tbl_bast_dana (
  id_bast_dana numeric not null,
  no_agenda varchar(50),
  pilar varchar(100),
  bantuan_untuk varchar(300),
  proposal_dari varchar(100),
  alamat varchar(500),
  provinsi varchar(50),
  kabupaten varchar(50),
  penanggung_jawab varchar(50),
  bertindak_sebagai varchar(100),
  no_surat varchar(50),
  tgl_surat timestamp,
  perihal varchar(100),
  nama_bank varchar(50),
  no_rekening varchar(50),
  atas_nama varchar(100),
  no_bast_dana varchar(50),
  created_by varchar(50),
  created_date timestamp,
  no_bast_pihak_kedua varchar(100),
  tgl_bast timestamp,
  nama_pejabat varchar(100),
  jabatan_pejabat varchar(100),
  nama_barang varchar(100),
  jumlah_barang numeric,
  satuan_barang varchar(20),
  no_pelimpahan varchar(100),
  tgl_pelimpahan timestamp,
  pihak_kedua varchar(500),
  status varchar(50),
  approved_by varchar(50),
  approved_date timestamp,
  deskripsi varchar(500),
  id_kelayakan numeric,
  approver_id numeric
);

-- ----------------------------
-- Table structure for TBL_CITY
-- ----------------------------
drop table if exists nr_csr.tbl_city cascade;
create table nr_csr.tbl_city (
  id_city bigint not null,
  city_name varchar(255)
);

-- ----------------------------
-- Table structure for TBL_DETAIL_APPROVAL
-- ----------------------------
drop table if exists nr_csr.tbl_detail_approval cascade;
create table nr_csr.tbl_detail_approval (
  id numeric not null,
  id_kelayakan numeric,
  id_hirarki numeric,
  id_user numeric,
  catatan varchar(255),
  status varchar(255),
  status_date timestamp,
  task_date timestamp,
  action_date timestamp,
  phase varchar(255),
  created_by numeric,
  pesan varchar(255)
);

-- ----------------------------
-- Table structure for TBL_DETAIL_KRITERIA
-- ----------------------------
drop table if exists nr_csr.tbl_detail_kriteria cascade;
create table nr_csr.tbl_detail_kriteria (
  id_detail_kriteria bigint not null,
  no_agenda varchar(50),
  kriteria varchar(50),
  created_at timestamp,
  updated_at timestamp,
  id_kelayakan numeric
);

-- ----------------------------
-- Table structure for TBL_DETAIL_SPK
-- ----------------------------
drop table if exists nr_csr.tbl_detail_spk cascade;
create table nr_csr.tbl_detail_spk (
  id_detail_spk numeric not null,
  no_agenda varchar(50),
  column1 varchar(200),
  column2 varchar(200),
  column3 varchar(200)
);

-- ----------------------------
-- Table structure for TBL_DOKUMEN
-- ----------------------------
drop table if exists nr_csr.tbl_dokumen cascade;
create table nr_csr.tbl_dokumen (
  id numeric not null,
  nama_dokumen varchar(255),
  mandatori varchar(10)
);

-- ----------------------------
-- Table structure for TBL_DOKUMEN_MANDATORI_PROYEK
-- ----------------------------
drop table if exists nr_csr.tbl_dokumen_mandatori_proyek cascade;
create table nr_csr.tbl_dokumen_mandatori_proyek (
  dokumen_id numeric not null,
  nama_dokumen varchar(255)
);

-- ----------------------------
-- Table structure for TBL_DOKUMEN_MANDATORI_VENDOR
-- ----------------------------
drop table if exists nr_csr.tbl_dokumen_mandatori_vendor cascade;
create table nr_csr.tbl_dokumen_mandatori_vendor (
  dokumen_id numeric not null,
  nama_dokumen varchar(255)
);

-- ----------------------------
-- Table structure for TBL_DOKUMEN_VENDOR
-- ----------------------------
drop table if exists nr_csr.tbl_dokumen_vendor cascade;
create table nr_csr.tbl_dokumen_vendor (
  dokumen_id numeric not null,
  id_vendor numeric,
  nama_dokumen varchar(255),
  nomor varchar(255),
  tanggal varchar(255),
  masa_berlaku varchar(255),
  keterangan varchar(255),
  catatan varchar(255),
  file varchar(255),
  parameter1 varchar(255),
  parameter2 varchar(255),
  parameter3 varchar(255),
  parameter4 varchar(255),
  parameter5 varchar(255),
  status varchar(255),
  status_date timestamp,
  created_date timestamp,
  created_by varchar(255),
  verifikasi_date timestamp,
  verifikasi_by varchar(255)
);

-- ----------------------------
-- Table structure for TBL_EVALUASI
-- ----------------------------
drop table if exists nr_csr.tbl_evaluasi cascade;
create table nr_csr.tbl_evaluasi (
  id_evaluasi bigint not null,
  no_agenda varchar(50),
  rencana_anggaran varchar(20),
  dokumen varchar(20),
  denah varchar(20),
  syarat varchar(100),
  evaluator1 varchar(50),
  catatan1 text,
  evaluator2 varchar(50),
  catatan2 text,
  kadep varchar(50),
  kadiv varchar(50),
  status varchar(50),
  approve_date timestamp,
  ket_kadiv varchar(150),
  ket_kadin1 varchar(150),
  ket_kadin2 varchar(150),
  keterangan varchar(200),
  approve_kadep timestamp,
  approve_kadiv timestamp,
  revisi_by varchar(50),
  revisi_date timestamp,
  reject_by varchar(50),
  reject_date timestamp,
  create_by varchar(50),
  create_date timestamp,
  created_at timestamp,
  updated_at timestamp,
  catatan1_new varchar(200),
  catatan2_new varchar(200),
  id_kelayakan numeric,
  created_by numeric,
  sekper varchar(255),
  dirut varchar(255),
  ket_sekper varchar(255),
  ket_dirut varchar(255),
  approve_sekper timestamp,
  approve_dirut timestamp
);

-- ----------------------------
-- Table structure for TBL_EXCEPTION
-- ----------------------------
drop table if exists nr_csr.tbl_exception cascade;
create table nr_csr.tbl_exception (
  error_id numeric not null,
  exception long,
  error_date timestamp,
  error_by varchar(255),
  status varchar(255),
  remark varchar(255)
);

-- ----------------------------
-- Table structure for TBL_HIRARKI
-- ----------------------------
drop table if exists nr_csr.tbl_hirarki cascade;
create table nr_csr.tbl_hirarki (
  id numeric not null,
  id_user numeric,
  id_level numeric,
  status varchar(10)
);

-- ----------------------------
-- Table structure for TBL_IZIN_USAHA
-- ----------------------------
drop table if exists nr_csr.tbl_izin_usaha cascade;
create table nr_csr.tbl_izin_usaha (
  izin_usaha_id numeric not null,
  id_vendor varchar(255),
  nib varchar(255),
  jenis_kbli varchar(255),
  kode_kbli varchar(255),
  alamat varchar(255),
  file varchar(255),
  created_date timestamp,
  created_by varchar(255)
);

-- ----------------------------
-- Table structure for TBL_KEBIJAKAN
-- ----------------------------
drop table if exists nr_csr.tbl_kebijakan cascade;
create table nr_csr.tbl_kebijakan (
  id_kebijakan numeric not null,
  kebijakan varchar(200)
);

-- ----------------------------
-- Table structure for TBL_KELAYAKAN
-- ----------------------------
drop table if exists nr_csr.tbl_kelayakan cascade;
create table nr_csr.tbl_kelayakan (
  no_agenda varchar(50),
  tgl_terima timestamp,
  no_surat varchar(100),
  tgl_surat timestamp,
  sebagai varchar(100) default '',
  provinsi varchar(100),
  kabupaten varchar(100),
  kelurahan varchar(100),
  kodepos varchar(10),
  bantuan_untuk varchar(200),
  contact_person varchar(100),
  nilai_pengajuan numeric(38,0),
  sektor_bantuan varchar(100),
  nama_bank varchar(50),
  atas_nama varchar(150),
  no_rekening varchar(50),
  nilai_bantuan numeric(38,0),
  nama_anggota varchar(50),
  fraksi varchar(255),
  jabatan varchar(200),
  pic varchar(255),
  asal_surat varchar(100),
  komisi varchar(100),
  sifat varchar(20),
  status varchar(50),
  email_pengaju varchar(50),
  nama_person varchar(50),
  mata_uang_pengajuan varchar(20),
  mata_uang_bantuan varchar(20),
  proposal varchar(255),
  create_by varchar(50),
  create_date timestamp,
  pengirim varchar(200),
  perihal varchar(200),
  pengaju_proposal varchar(200),
  alamat varchar(400),
  cabang_bank varchar(150),
  jenis varchar(255),
  hewan_kurban varchar(255),
  jumlah_hewan bigint,
  kode_bank varchar(255),
  kode_kota varchar(255),
  kota_bank varchar(255),
  cabang varchar(255),
  deskripsi varchar(500),
  pilar varchar(255),
  tpb varchar(255),
  kode_indikator varchar(255),
  keterangan_indikator varchar(1000),
  proker varchar(255),
  indikator varchar(255),
  smap varchar(255),
  ykpp varchar(255),
  checklist_by varchar(255),
  checklist_date timestamp,
  nominal_approved bigint,
  nominal_fee bigint,
  total_ykpp bigint,
  status_ykpp varchar(255),
  approved_ykpp_by varchar(255),
  approved_ykpp_date timestamp,
  submited_ykpp_by varchar(255),
  submited_ykpp_date timestamp,
  no_surat_ykpp varchar(255),
  tgl_surat_ykpp varchar(255),
  penyaluran_ke_old bigint,
  id_kelayakan numeric not null,
  surat_ykpp varchar(255),
  tahun_ykpp varchar(4),
  penyaluran_ke varchar(255),
  id_lembaga numeric,
  id_pengirim numeric,
  created_by numeric,
  created_date timestamp,
  id_proker numeric,
  kecamatan varchar(100)  default ''
);

-- ----------------------------
-- Table structure for TBL_KODE
-- ----------------------------
drop table if exists nr_csr.tbl_kode cascade;
create table nr_csr.tbl_kode (
  kode varchar(20),
  provinsi varchar(100)
);

-- ----------------------------
-- Table structure for TBL_KTP_PENGURUS
-- ----------------------------
drop table if exists nr_csr.tbl_ktp_pengurus cascade;
create table nr_csr.tbl_ktp_pengurus (
  ktp_id numeric not null,
  id_vendor varchar(255),
  nomor varchar(255),
  nama varchar(255),
  jabatan varchar(255),
  no_telp varchar(255),
  email varchar(255),
  file varchar(255),
  created_date timestamp,
  created_by varchar(255)
);

-- ----------------------------
-- Table structure for TBL_LAMPIRAN
-- ----------------------------
drop table if exists nr_csr.tbl_lampiran cascade;
create table nr_csr.tbl_lampiran (
  id_lampiran bigint not null,
  no_agenda varchar(50),
  nama varchar(255),
  lampiran varchar(500),
  upload_by varchar(50),
  upload_date timestamp,
  created_at timestamp,
  updated_at timestamp,
  id_kelayakan numeric,
  created_by numeric
);

-- ----------------------------
-- Table structure for TBL_LAMPIRAN_AP
-- ----------------------------
drop table if exists nr_csr.tbl_lampiran_ap cascade;
create table nr_csr.tbl_lampiran_ap (
  id_lampiran bigint not null,
  id_realisasi bigint,
  nama varchar(255),
  lampiran varchar(255),
  upload_by varchar(255),
  upload_date timestamp
);

-- ----------------------------
-- Table structure for TBL_LAMPIRAN_PEKERJAAN
-- ----------------------------
drop table if exists nr_csr.tbl_lampiran_pekerjaan cascade;
create table nr_csr.tbl_lampiran_pekerjaan (
  lampiran_id numeric not null,
  id_vendor numeric,
  nomor varchar(255),
  nama_file varchar(255),
  file varchar(255),
  type varchar(255),
  size numeric,
  status varchar(255),
  catatan varchar(255),
  upload_by varchar(255),
  upload_date timestamp,
  nama_dokumen varchar(255),
  pekerjaan_id numeric
);

-- ----------------------------
-- Table structure for TBL_LAMPIRAN_VENDOR
-- ----------------------------
drop table if exists nr_csr.tbl_lampiran_vendor cascade;
create table nr_csr.tbl_lampiran_vendor (
  lampiran_id numeric not null,
  id_vendor numeric,
  nomor varchar(255),
  nama_file varchar(255),
  file varchar(255),
  type varchar(255),
  size numeric,
  status varchar(255),
  catatan varchar(255),
  upload_by varchar(255),
  upload_date timestamp,
  nama_dokumen varchar(255)
);

-- ----------------------------
-- Table structure for TBL_LEMBAGA
-- ----------------------------
drop table if exists nr_csr.tbl_lembaga cascade;
create table nr_csr.tbl_lembaga (
  id_lembaga numeric not null,
  nama_lembaga varchar(255),
  nama_pic varchar(255),
  alamat varchar(255),
  no_telp varchar(255),
  jabatan varchar(255),
  no_rekening varchar(255),
  atas_nama varchar(255),
  nama_bank varchar(255),
  cabang varchar(255),
  kota_bank varchar(255),
  kode_bank varchar(255),
  kode_kota varchar(255),
  perusahaan varchar(255),
  id_perusahaan numeric
);

-- ----------------------------
-- Table structure for TBL_LEVEL_HIRARKI
-- ----------------------------
drop table if exists nr_csr.tbl_level_hirarki cascade;
create table nr_csr.tbl_level_hirarki (
  id numeric not null,
  level numeric,
  nama_level varchar(20)
);

-- ----------------------------
-- Table structure for TBL_LOG
-- ----------------------------
drop table if exists nr_csr.tbl_log cascade;
create table nr_csr.tbl_log (
  id numeric not null,
  id_kelayakan numeric,
  keterangan varchar(200),
  created_by numeric,
  created_date timestamp
);

-- ----------------------------
-- Table structure for TBL_LOG_PEKERJAAN
-- ----------------------------
drop table if exists nr_csr.tbl_log_pekerjaan cascade;
create table nr_csr.tbl_log_pekerjaan (
  log_id numeric not null,
  pekerjaan_id varchar(255),
  update_by varchar(255),
  update_date timestamp,
  action varchar(255),
  keterangan varchar(255)
);

-- ----------------------------
-- Table structure for TBL_LOG_RELOKASI
-- ----------------------------
drop table if exists nr_csr.tbl_log_relokasi cascade;
create table nr_csr.tbl_log_relokasi (
  id_log numeric not null,
  id_proker varchar(255),
  keterangan varchar(255),
  status varchar(255),
  status_date timestamp
);

-- ----------------------------
-- Table structure for TBL_LOG_VENDOR
-- ----------------------------
drop table if exists nr_csr.tbl_log_vendor cascade;
create table nr_csr.tbl_log_vendor (
  log_id numeric not null,
  id_vendor varchar(255),
  update_by varchar(255),
  update_date timestamp,
  action varchar(255),
  keterangan varchar(255)
);

-- ----------------------------
-- Table structure for TBL_PEJABAT
-- ----------------------------
drop table if exists nr_csr.tbl_pejabat cascade;
create table nr_csr.tbl_pejabat (
  id numeric not null,
  nama varchar(255),
  jabatan varchar(255),
  sk varchar(255),
  tanggal timestamp
);

-- ----------------------------
-- Table structure for TBL_PEKERJAAN
-- ----------------------------
drop table if exists nr_csr.tbl_pekerjaan cascade;
create table nr_csr.tbl_pekerjaan (
  pekerjaan_id numeric not null,
  nama_pekerjaan varchar(255),
  tahun varchar(255),
  proker_id numeric,
  nilai_perkiraan numeric,
  status varchar(255),
  created_by varchar(255),
  created_date timestamp,
  ringkasan long,
  kak varchar(255),
  id_vendor varchar(255),
  nilai_penawaran numeric,
  nilai_kesepakatan numeric
);

-- ----------------------------
-- Table structure for TBL_PEMBAYARAN
-- ----------------------------
drop table if exists nr_csr.tbl_pembayaran cascade;
create table nr_csr.tbl_pembayaran (
  id_pembayaran bigint not null,
  no_agenda varchar(50),
  no_bast varchar(50),
  no_ba varchar(50),
  termin varchar(2),
  nilai_approved numeric,
  persen varchar(3),
  status varchar(50),
  pr_id varchar(50) default null,
  create_date timestamp,
  create_by varchar(50),
  export_date timestamp,
  export_by varchar(100),
  id_kelayakan bigint,
  deskripsi varchar(500),
  fee numeric,
  jumlah_pembayaran numeric,
  subtotal numeric,
  fee_persen numeric,
  status_ykpp varchar(255),
  approved_ykpp_by varchar(255),
  approved_ykpp_date timestamp,
  submited_ykpp_by varchar(255),
  submited_ykpp_date timestamp,
  no_surat_ykpp varchar(255),
  tgl_surat_ykpp varchar(255),
  surat_ykpp varchar(255),
  tahun_ykpp varchar(4),
  penyaluran_ke varchar(255),
  metode varchar(255)
);

-- ----------------------------
-- Table structure for TBL_PEMBAYARAN_VENDOR
-- ----------------------------
drop table if exists nr_csr.tbl_pembayaran_vendor cascade;
create table nr_csr.tbl_pembayaran_vendor (
  id_pembayaran bigint not null,
  pekerjaan_id varchar(50),
  no_bast varchar(50),
  no_ba varchar(50),
  termin varchar(2),
  nilai_kesepakatan numeric,
  persen varchar(3),
  jumlah_pembayaran varchar(255),
  status varchar(50),
  pr_id varchar(50),
  create_date timestamp,
  create_by varchar(50),
  export_date timestamp,
  export_by varchar(100),
  id_vendor varchar(255)
);

-- ----------------------------
-- Table structure for TBL_PEMBAYARAN_copy1
-- ----------------------------
drop table if exists nr_csr.tbl_pembayaran_copy1 cascade;
create table nr_csr.tbl_pembayaran_copy1 (
  id_pembayaran bigint not null,
  no_agenda varchar(50),
  no_bast varchar(50),
  no_ba varchar(50),
  termin varchar(2),
  nilai_approved numeric,
  persen varchar(3),
  status varchar(50),
  pr_id varchar(50) default null,
  create_date timestamp,
  create_by varchar(50),
  export_date timestamp,
  export_by varchar(100),
  id_kelayakan bigint,
  deskripsi varchar(500),
  fee numeric,
  jumlah_pembayaran numeric,
  subtotal numeric,
  fee_persen numeric,
  status_ykpp varchar(255),
  approved_ykpp_by varchar(255),
  approved_ykpp_date timestamp,
  submited_ykpp_by varchar(255),
  submited_ykpp_date timestamp,
  no_surat_ykpp varchar(255),
  tgl_surat_ykpp varchar(255),
  surat_ykpp varchar(255),
  tahun_ykpp varchar(4),
  penyaluran_ke varchar(255),
  metode varchar(255)
);

-- ----------------------------
-- Table structure for TBL_PENGALAMAN_KERJA
-- ----------------------------
drop table if exists nr_csr.tbl_pengalaman_kerja cascade;
create table nr_csr.tbl_pengalaman_kerja (
  pengalaman_id numeric not null,
  id_vendor varchar(255),
  no_kontrak varchar(255),
  tgl_kontrak varchar(255),
  pekerjaan varchar(255),
  pemberi_kerja varchar(255),
  lokasi varchar(255),
  file varchar(255),
  created_by varchar(255),
  created_date timestamp,
  nilai numeric
);

-- ----------------------------
-- Table structure for TBL_PENGEMBALIAN_ANGGARAN
-- ----------------------------
drop table if exists nr_csr.tbl_pengembalian_anggaran cascade;
create table nr_csr.tbl_pengembalian_anggaran (
  id numeric not null,
  anggaran_id numeric,
  pengembalian varchar(255),
  created_by varchar(255),
  created_date timestamp
);

-- ----------------------------
-- Table structure for TBL_PENGIRIM
-- ----------------------------
drop table if exists nr_csr.tbl_pengirim cascade;
create table nr_csr.tbl_pengirim (
  id_pengirim numeric not null,
  pengirim varchar(50),
  created_at timestamp,
  updated_at timestamp,
  perusahaan varchar(100),
  id_perusahaan numeric,
  status varchar(10)
);

-- ----------------------------
-- Table structure for TBL_PERUSAHAAN
-- ----------------------------
drop table if exists nr_csr.tbl_perusahaan cascade;
create table nr_csr.tbl_perusahaan (
  id_perusahaan numeric not null,
  nama_perusahaan varchar(100),
  kategori varchar(20),
  kode varchar(10),
  foto_profile varchar(255),
  alamat varchar(500),
  no_telp varchar(15),
  pic numeric,
  status varchar(20)
);

-- ----------------------------
-- Table structure for TBL_PILAR
-- ----------------------------
drop table if exists nr_csr.tbl_pilar cascade;
create table nr_csr.tbl_pilar (
  id_pilar bigint not null,
  kode varchar(255),
  nama varchar(255)
);

-- ----------------------------
-- Table structure for TBL_PROKER
-- ----------------------------
drop table if exists nr_csr.tbl_proker cascade;
create table nr_csr.tbl_proker (
  id_proker numeric not null,
  proker varchar(1000),
  id_indikator varchar(100),
  tahun varchar(4),
  anggaran numeric,
  prioritas varchar(255),
  eb varchar(255),
  pilar varchar(255),
  gols varchar(255),
  perusahaan varchar(255),
  id_perusahaan numeric,
  kode_tpb varchar(255)
);

-- ----------------------------
-- Table structure for TBL_PROVINSI
-- ----------------------------
drop table if exists nr_csr.tbl_provinsi cascade;
create table nr_csr.tbl_provinsi (
  id_provinsi bigint not null,
  kode_provinsi varchar(10),
  provinsi varchar(100)
);

-- ----------------------------
-- Table structure for TBL_REALISASI_AP
-- ----------------------------
drop table if exists nr_csr.tbl_realisasi_ap cascade;
create table nr_csr.tbl_realisasi_ap (
  id_realisasi bigint not null,
  no_proposal varchar(255),
  tgl_proposal timestamp,
  pengirim varchar(255),
  tgl_realisasi timestamp,
  sifat varchar(255),
  perihal varchar(255),
  besar_permohonan bigint,
  kategori varchar(255),
  nilai_bantuan bigint,
  status varchar(255),
  provinsi varchar(255),
  kabupaten varchar(255),
  deskripsi varchar(255),
  id_proker bigint,
  proker varchar(255),
  pilar varchar(255),
  gols varchar(255),
  nama_yayasan varchar(255),
  alamat varchar(255),
  pic varchar(255),
  jabatan varchar(255),
  no_telp varchar(255),
  no_rekening varchar(255),
  atas_nama varchar(255),
  nama_bank varchar(255),
  kota_bank varchar(255),
  cabang_bank varchar(255),
  created_by varchar(255),
  created_date timestamp,
  jenis varchar(255),
  perusahaan varchar(255),
  tahun varchar(4),
  status_date timestamp,
  prioritas varchar(255),
  id_perusahaan bigint,
  kecamatan varchar(255),
  kelurahan varchar(255)
);

-- ----------------------------
-- Table structure for TBL_RELOKASI
-- ----------------------------
drop table if exists nr_csr.tbl_relokasi cascade;
create table nr_csr.tbl_relokasi (
  id_relokasi numeric not null,
  proker_asal varchar(255),
  nominal_asal numeric,
  proker_tujuan varchar(255),
  nominal_tujuan numeric,
  request_by varchar(255),
  request_date timestamp,
  status varchar(255),
  approver varchar(255),
  tahun varchar(4),
  perusahaan varchar(255),
  status_date timestamp,
  nominal_relokasi numeric,
  id_perusahaan numeric
);

-- ----------------------------
-- Table structure for TBL_ROLE
-- ----------------------------
drop table if exists nr_csr.tbl_role cascade;
create table nr_csr.tbl_role (
  id_role bigint not null,
  role varchar(2) not null,
  role_name varchar(30)
);

-- ----------------------------
-- Table structure for TBL_SDG
-- ----------------------------
drop table if exists nr_csr.tbl_sdg cascade;
create table nr_csr.tbl_sdg (
  id_sdg bigint not null,
  nama varchar(255),
  kode varchar(255),
  pilar varchar(255)
);

-- ----------------------------
-- Table structure for TBL_SEKTOR
-- ----------------------------
drop table if exists nr_csr.tbl_sektor cascade;
create table nr_csr.tbl_sektor (
  id_sektor bigint not null,
  kode_sektor varchar(10),
  sektor_bantuan varchar(100)
);

-- ----------------------------
-- Table structure for TBL_SPH
-- ----------------------------
drop table if exists nr_csr.tbl_sph cascade;
create table nr_csr.tbl_sph (
  sph_id numeric not null,
  nomor varchar(255),
  tanggal varchar(255),
  pekerjaan_id numeric,
  status varchar(255),
  catatan varchar(255),
  created_by varchar(255),
  created_date timestamp,
  id_vendor varchar(255),
  file_sph varchar(255),
  nilai_penawaran numeric,
  spph_id numeric
);

-- ----------------------------
-- Table structure for TBL_SPK
-- ----------------------------
drop table if exists nr_csr.tbl_spk cascade;
create table nr_csr.tbl_spk (
  spk_id numeric not null,
  nomor varchar(255),
  tanggal varchar(255),
  pekerjaan_id numeric,
  status varchar(255),
  catatan varchar(255),
  created_by varchar(255),
  created_date timestamp,
  id_vendor varchar(255),
  file_spk varchar(255),
  nilai_kesepakatan numeric,
  sph_id numeric,
  bakn_id numeric,
  start_date timestamp,
  due_date timestamp,
  durasi numeric,
  response_date timestamp,
  response_by varchar(255)
);

-- ----------------------------
-- Table structure for TBL_SPPH
-- ----------------------------
drop table if exists nr_csr.tbl_spph cascade;
create table nr_csr.tbl_spph (
  spph_id numeric not null,
  nomor varchar(255),
  tanggal timestamp,
  pekerjaan_id numeric,
  status varchar(255),
  catatan varchar(255),
  created_by varchar(255),
  created_date timestamp,
  id_vendor varchar(255),
  file_spph varchar(255),
  response_date timestamp
);

-- ----------------------------
-- Table structure for TBL_SUB_PILAR
-- ----------------------------
drop table if exists nr_csr.tbl_sub_pilar cascade;
create table nr_csr.tbl_sub_pilar (
  id_sub_pilar bigint not null,
  tpb varchar(255),
  kode_indikator varchar(255),
  keterangan varchar(1000),
  pilar varchar(255)
);

-- ----------------------------
-- Table structure for TBL_SUB_PROPOSAL
-- ----------------------------
drop table if exists nr_csr.tbl_sub_proposal cascade;
create table nr_csr.tbl_sub_proposal (
  id_sub_proposal numeric not null,
  no_agenda varchar(50),
  no_sub_agenda varchar(255),
  nama_ketua varchar(255),
  nama_lembaga varchar(255),
  kambing bigint,
  sapi bigint,
  total bigint,
  harga_kambing bigint,
  harga_sapi bigint,
  provinsi varchar(255),
  kabupaten varchar(255),
  alamat varchar(255),
  fee bigint,
  subtotal bigint,
  ppn bigint
);

-- ----------------------------
-- Table structure for TBL_SURVEI
-- ----------------------------
drop table if exists nr_csr.tbl_survei cascade;
create table nr_csr.tbl_survei (
  id_survei bigint not null,
  no_agenda varchar(50),
  hasil_konfirmasi text,
  hasil_survei text,
  usulan varchar(50),
  bantuan_berupa varchar(50),
  nilai_bantuan numeric(38,0),
  nilai_approved numeric(38,0),
  termin varchar(20),
  rupiah1 numeric(38,0),
  rupiah2 numeric(38,0),
  rupiah3 numeric(38,0),
  rupiah4 numeric(38,0),
  survei1 varchar(50),
  survei2 varchar(50),
  status varchar(20),
  kadep varchar(50),
  kadiv varchar(50),
  ket_kadin1 text,
  ket_kadin2 text,
  ket_kadiv text,
  keterangan text,
  approve_date timestamp,
  approve_kadep timestamp,
  approve_kadiv timestamp,
  create_by varchar(50),
  create_date timestamp,
  revisi_by varchar(50),
  revisi_date timestamp,
  created_at timestamp,
  updated_at timestamp,
  bast varchar(20),
  spk varchar(20),
  pks varchar(20),
  vendor_id numeric,
  id_kelayakan numeric,
  created_by numeric,
  sekper varchar(255),
  dirut varchar(255),
  ket_sekper varchar(255),
  ket_dirut varchar(255),
  approve_sekper timestamp,
  approve_dirut timestamp,
  persen1 numeric(10,2),
  persen2 numeric(10,2),
  persen3 numeric(10,2),
  persen4 numeric(10,2)
);

-- ----------------------------
-- Table structure for TBL_USER
-- ----------------------------
drop table if exists nr_csr.tbl_user cascade;
create table nr_csr.tbl_user (
  id_user numeric not null,
  username varchar(100) not null,
  email varchar(100) not null,
  nama varchar(100) not null,
  jabatan varchar(100) not null,
  password varchar(200) not null,
  role varchar(100) not null,
  area_kerja varchar(100),
  status varchar(100),
  foto_profile varchar(255),
  remember_token varchar(100),
  jk varchar(100),
  old_email varchar(255),
  perusahaan varchar(255),
  vendor_id varchar(255),
  id_perusahaan numeric,
  no_sk varchar(255),
  tgl_sk timestamp
);

-- ----------------------------
-- Table structure for TBL_VENDOR
-- ----------------------------
drop table if exists nr_csr.tbl_vendor cascade;
create table nr_csr.tbl_vendor (
  vendor_id numeric not null,
  nama_perusahaan varchar(200),
  alamat varchar(500),
  no_telp varchar(20),
  email varchar(100),
  website varchar(50),
  no_ktp varchar(50),
  nama_pic varchar(100),
  jabatan varchar(100),
  email_pic varchar(100),
  no_hp varchar(20),
  file_ktp varchar(200),
  created_at timestamp,
  updated_at timestamp,
  status varchar(255),
  approve_by varchar(255),
  approve_date timestamp
);

-- ----------------------------
-- Table structure for TBL_WILAYAH
-- ----------------------------
drop table if exists nr_csr.tbl_wilayah cascade;
create table nr_csr.tbl_wilayah (
  id_wilayah numeric not null,
  province varchar(50),
  city varchar(50),
  city_name varchar(50),
  sub_district varchar(50),
  village varchar(50),
  postal_code varchar(5)
);

-- ----------------------------
-- View structure for V_ANGGARAN
-- ----------------------------
create or replace view nr_csr.v_anggaran as select
	tbl_anggaran.id_anggaran, 
	tbl_anggaran.nominal, 
	tbl_anggaran.tahun, 
	tbl_anggaran.id_perusahaan, 
	tbl_perusahaan.nama_perusahaan, 
	tbl_perusahaan.kode
from
	tbl_anggaran
	inner join
	tbl_perusahaan
	on 
		tbl_anggaran.id_perusahaan = tbl_perusahaan.id_perusahaan;

-- ----------------------------
-- View structure for V_BAST
-- ----------------------------
create or replace view nr_csr.v_bast as select
    bast.id_bast_dana, 
    sur.bantuan_berupa, 
    kel.id_kelayakan, 
    kel.pilar, 
    kel.deskripsi, 
    kel.provinsi, 
    kel.kabupaten, 
    lem.nama_lembaga, 
    bast.no_bast_dana, 
    bast.no_bast_pihak_kedua, 
    bast.tgl_bast, 
    sur.nilai_approved, 
    lem.nama_pic, 
    lem.jabatan, 
    kel.no_surat, 
    kel.bantuan_untuk, 
    kel.tgl_surat, 
    sur.termin, 
    sur.persen1, 
    sur.persen2, 
    sur.persen3, 
    sur.persen4, 
    sur.rupiah1, 
    sur.rupiah2, 
    sur.rupiah3, 
    sur.rupiah4, 
    sur.survei1, 
    kel.nama_bank, 
    kel.atas_nama, 
    kel.no_rekening, 
    bast.jumlah_barang, 
    bast.no_pelimpahan,
    bast.approver_id, 
    lem.alamat
from
    tbl_bast_dana bast
    inner join tbl_kelayakan kel on bast.id_kelayakan = kel.id_kelayakan
    inner join tbl_survei sur on kel.id_kelayakan = sur.id_kelayakan
    inner join tbl_lembaga lem on kel.id_lembaga = lem.id_lembaga;

-- ----------------------------
-- View structure for V_BAST_DANA
-- ----------------------------
create or replace view nr_csr.v_bast_dana as select
tbl_bast_dana.no_agenda,
tbl_bast_dana.id_bast_dana,
tbl_kelayakan.id_kelayakan,
tbl_kelayakan.sektor_bantuan,
tbl_kelayakan.pilar,
tbl_kelayakan.tpb,
tbl_bast_dana.bantuan_untuk,
tbl_kelayakan.deskripsi,
tbl_bast_dana.proposal_dari,
tbl_bast_dana.alamat,
tbl_bast_dana.provinsi,
tbl_bast_dana.kabupaten,
tbl_bast_dana.penanggung_jawab,
tbl_bast_dana.bertindak_sebagai,
tbl_bast_dana.no_surat,
tbl_bast_dana.tgl_surat,
tbl_bast_dana.perihal,
tbl_bast_dana.pihak_kedua,
tbl_bast_dana.nama_bank,
tbl_bast_dana.no_rekening,
tbl_bast_dana.atas_nama,
tbl_bast_dana.no_bast_dana,
tbl_bast_dana.no_bast_pihak_kedua,
tbl_bast_dana.tgl_bast,
tbl_bast_dana.nama_barang,
tbl_bast_dana.jumlah_barang,
tbl_bast_dana.satuan_barang,
tbl_bast_dana.nama_pejabat,
tbl_bast_dana.jabatan_pejabat,
tbl_bast_dana.created_by,
tbl_bast_dana.created_date,
tbl_bast_dana.no_pelimpahan,
tbl_bast_dana.tgl_pelimpahan,
tbl_bast_dana.status,
tbl_bast_dana.approved_by,
tbl_bast_dana.approved_date,
tbl_survei.nilai_approved,
tbl_survei.termin,
tbl_survei.persen1,
tbl_survei.persen2,
tbl_survei.persen3,
tbl_survei.persen4,
tbl_survei.rupiah1,
tbl_survei.rupiah2,
tbl_survei.rupiah3,
tbl_survei.rupiah4,
tbl_survei.survei1,
tbl_survei.bantuan_berupa
from
tbl_bast_dana
join tbl_kelayakan
on tbl_bast_dana.no_agenda = tbl_kelayakan.no_agenda 
join tbl_survei
on tbl_bast_dana.no_agenda = tbl_survei.no_agenda;

-- ----------------------------
-- View structure for V_BULAN
-- ----------------------------
create or replace view nr_csr.v_bulan as select 
sum(pr.invoice_amount) jumlah,
to_char(pr.invoice_date, 'MM') as bulan,
to_char(pr.invoice_date, 'YYYY') as tahun
from nr_payment.t_invoice_line inv, nr_payment.t_payment_request pr
 where inv.id_payment_request = pr.id 
 and pr.type = 'CSR 517/518' 
 and pr.receiver_type = 'EXTERNAL' 
 and inv.account_eb in ('517','518')
group by pr.id, pr.invoice_date;

-- ----------------------------
-- View structure for V_DETAIL_APPROVAL
-- ----------------------------
create or replace view nr_csr.v_detail_approval as select
nr_csr.tbl_detail_approval.id,
nr_csr.tbl_detail_approval.id_kelayakan,
nr_csr.tbl_detail_approval.id_hirarki,
nr_csr.tbl_detail_approval.phase,
nr_csr.tbl_hirarki.id_level,
nr_csr.tbl_level_hirarki.level,
nr_csr.tbl_level_hirarki.nama_level,
nr_csr.tbl_detail_approval.id_user,
nr_csr.tbl_detail_approval.catatan,
nr_csr.tbl_detail_approval.status,
nr_csr.tbl_detail_approval.status_date,
nr_csr.tbl_detail_approval.task_date,
nr_csr.tbl_detail_approval.action_date
from
nr_csr.tbl_detail_approval
inner join nr_csr.tbl_hirarki on nr_csr.tbl_detail_approval.id_hirarki = nr_csr.tbl_hirarki.id
inner join nr_csr.tbl_level_hirarki on nr_csr.tbl_hirarki.id_level = nr_csr.tbl_level_hirarki.id;

-- ----------------------------
-- View structure for V_EVALUASI
-- ----------------------------
create or replace view nr_csr.v_evaluasi as select
    e.id_evaluasi                                         as id_evaluasi,
    k.no_agenda                                           as no_agenda,
    k.pengirim                                            as pengirim,
    k.tgl_terima                                          as tgl_terima,
    k.no_surat                                            as no_surat,
    k.tgl_surat                                           as tgl_surat,
    k.perihal                                             as perihal,
    k.pengaju_proposal                                    as pengaju_proposal,
    k.sebagai                                             as sebagai,
    k.alamat                                              as alamat,
    k.provinsi                                            as provinsi,
    k.kabupaten                                           as kabupaten,
    k.bantuan_untuk                                       as bantuan_untuk,
    k.deskripsi                                           as deskripsi,
    k.jenis                                               as jenis,
    k.atas_nama                                           as atas_nama,
    k.nama_person                                         as nama_person,
    k.contact_person                                      as contact_person,
    k.nilai_pengajuan                                     as nilai_pengajuan,
    k.sektor_bantuan                                      as sektor_bantuan,
    k.nilai_bantuan                                       as nilai_bantuan,
    k.nama_anggota                                        as nama_anggota,
    k.fraksi                                              as fraksi,
    k.jabatan                                             as jabatan,
    k.pic                                                 as pic,
    k.asal_surat                                          as asal_surat,
    k.komisi                                              as komisi,
    k.sifat                                               as sifat,
    k.email_pengaju                                       as email_pengaju,
    k.mata_uang_pengajuan                                 as mata_uang_pengajuan,
    k.mata_uang_bantuan                                   as mata_uang_bantuan,
    e.rencana_anggaran                                    as rencana_anggaran,
    k.proposal                                            as proposal,
    e.dokumen                                             as dokumen,
    e.denah                                               as denah,
    e.syarat                                              as syarat,
    e.evaluator1                                          as evaluator1,
    e.catatan1                                            as catatan1,
    e.evaluator2                                          as evaluator2,
    e.catatan2                                            as catatan2,
    e.kadep                                               as kadep,
    e.kadiv                                               as kadiv,
    e.status                                              as status,
    e.approve_date                                        as approve_date,
    e.approve_kadep                                       as approve_kadep,
    e.approve_kadiv                                       as approve_kadiv,
    e.ket_kadin1                                          as ket_kadin1,
    e.ket_kadiv                                           as ket_kadiv,
    e.revisi_by                                           as revisi_by,
    e.revisi_date                                         as revisi_date,
    e.reject_by                                           as reject_by,
    e.reject_date                                         as reject_date,
    e.create_by                                           as create_by,
    e.create_date                                         as create_date,
    k.id_kelayakan                                        as id_kelayakan,
    e.sekper,
    e.dirut,
    e.ket_sekper,
    e.ket_dirut,
    e.approve_sekper,
    e.approve_dirut
from tbl_kelayakan k
join tbl_evaluasi  e
  on e.id_kelayakan = k.id_kelayakan;

-- ----------------------------
-- View structure for V_HIRARKI
-- ----------------------------
create or replace view nr_csr.v_hirarki as select
nr_csr.tbl_hirarki.id,
nr_csr.tbl_hirarki.id_user,
nr_csr.tbl_user.nama,
nr_csr.tbl_user.username,
nr_csr.tbl_user.email,
nr_csr.tbl_user.jabatan,
nr_csr.tbl_user.foto_profile,
nr_csr.tbl_hirarki.id_level,
nr_csr.tbl_level_hirarki.level,
nr_csr.tbl_level_hirarki.nama_level,
nr_csr.tbl_hirarki.status
from
nr_csr.tbl_hirarki
inner join nr_csr.tbl_user on nr_csr.tbl_hirarki.id_user = nr_csr.tbl_user.id_user
inner join nr_csr.tbl_level_hirarki on nr_csr.tbl_hirarki.id_level = nr_csr.tbl_level_hirarki.id;

-- ----------------------------
-- View structure for V_INFO_BANK
-- ----------------------------
create or replace view nr_csr.v_info_bank as select
no_agenda, atas_nama, nama_bank, kode_bank, kota_bank, kode_kota, cabang_bank
from
tbl_kelayakan;

-- ----------------------------
-- View structure for V_INV_PAYREQUEST
-- ----------------------------
create or replace view nr_csr.v_inv_payrequest as select pr.invoice_number, 
pr.invoice_date, 
pr.description, 
pr.long_description, 
pr.invoice_amount, 
pr.payment_termin, 
pr.budget_year, 
pr.status, pr.id, 
inv.account_eb, 
inv.account_cad1, 
inv.account_cad2 
from nr_payment.t_invoice_line inv, nr_payment.t_payment_request pr
 where inv.id_payment_request = pr.id 
 and pr.type = 'CSR 517/518' 
 and pr.status = 'PAID'
 and pr.receiver_type = 'EXTERNAL' 
 and inv.account_eb in ('517','518');

-- ----------------------------
-- View structure for V_JENIS
-- ----------------------------
create or replace view nr_csr.v_jenis as select jenis, count(jenis) as jumlah, to_char(tgl_terima, 'YYYY') as tahun from tbl_kelayakan group by tgl_terima, jenis;

-- ----------------------------
-- View structure for V_KABUPATEN_KAMBING
-- ----------------------------
create or replace view nr_csr.v_kabupaten_kambing as select kabupaten from tbl_sub_proposal where kambing > 0 group by kabupaten;

-- ----------------------------
-- View structure for V_KABUPATEN_SAPI
-- ----------------------------
create or replace view nr_csr.v_kabupaten_sapi as select kabupaten from tbl_sub_proposal where sapi > 0 group by kabupaten;

-- ----------------------------
-- View structure for V_KELAYAKAN
-- ----------------------------
create or replace view nr_csr.v_kelayakan as select
nr_csr.tbl_kelayakan.tgl_terima,
nr_csr.tbl_kelayakan.deskripsi,
nr_csr.tbl_kelayakan.pengaju_proposal,
nr_csr.tbl_survei.nilai_bantuan,
nr_csr.tbl_kelayakan.pilar
from
nr_csr.tbl_kelayakan
inner join nr_csr.tbl_survei on nr_csr.tbl_kelayakan.no_agenda = nr_csr.tbl_survei.no_agenda
where to_char(tbl_kelayakan.tgl_terima, 'YYYY') = '2022' and tbl_kelayakan.status = 'Approved';

-- ----------------------------
-- View structure for V_NILAI_REALISASI_PROVINSI
-- ----------------------------
create or replace view nr_csr.v_nilai_realisasi_provinsi as select account_eb, account_cad1, account_cad2, invoice_amount, to_char(invoice_date, 'YYYY') as tahun from v_inv_payrequest;

-- ----------------------------
-- View structure for V_PEKERJAAN
-- ----------------------------
create or replace view nr_csr.v_pekerjaan as select
nr_csr.tbl_pekerjaan.pekerjaan_id,
nr_csr.tbl_pekerjaan.nama_pekerjaan,
nr_csr.tbl_pekerjaan.ringkasan,
nr_csr.tbl_pekerjaan.nilai_perkiraan,
nr_csr.tbl_pekerjaan.nilai_penawaran,
nr_csr.tbl_pekerjaan.nilai_kesepakatan,
nr_csr.tbl_pekerjaan.tahun,
nr_csr.tbl_pekerjaan.proker_id,
nr_csr.tbl_pekerjaan.kak,
nr_csr.tbl_pekerjaan.id_vendor,
nr_csr.tbl_proker.proker,
nr_csr.tbl_proker.prioritas,
nr_csr.tbl_proker.pilar,
nr_csr.tbl_proker.gols,
nr_csr.tbl_pekerjaan.status,
nr_csr.tbl_pekerjaan.created_by,
nr_csr.tbl_pekerjaan.created_date
from
nr_csr.tbl_pekerjaan
inner join nr_csr.tbl_proker on nr_csr.tbl_pekerjaan.proker_id = nr_csr.tbl_proker.id_proker;

-- ----------------------------
-- View structure for V_PEMBAYARAN
-- ----------------------------
create or replace view nr_csr.v_pembayaran as select
	p.id_pembayaran, 
	p.termin, 
	p.nilai_approved, 
	p.status, 
	p.pr_id, 
	p.create_date, 
	p.create_by, 
	p.export_date, 
	p.export_by, 
	p.id_kelayakan, 
	p.deskripsi deskripsi_pembayaran, 
	p.fee, 
	p.jumlah_pembayaran, 
	p.subtotal, 
	k.no_agenda, 
	k.tgl_terima, 
	k.provinsi, 
	k.kabupaten, 
	k.kecamatan, 
	k.kelurahan, 
	k.bantuan_untuk, 
	k.nama_bank, 
	k.atas_nama, 
	k.no_rekening, 
	k.perihal, 
	k.jenis, 
	k.deskripsi, 
	k.id_lembaga, 
	l.nama_lembaga, 
	k.id_proker, 
	pr.proker, 
	pr.tahun, 
	pr.pilar, 
	pr.kode_tpb, 
	pr.gols, 
	pr.prioritas, 
	s.approve_kadiv approve_date, 
	p.metode
from
	tbl_pembayaran p
	left join
	tbl_kelayakan k
	on 
		p.id_kelayakan = k.id_kelayakan
	left join
	tbl_lembaga l
	on 
		k.id_lembaga = l.id_lembaga
	left join
	tbl_proker pr
	on 
		k.id_proker = pr.id_proker
	left join
	tbl_survei s
	on 
		s.id_kelayakan = k.id_kelayakan;

-- ----------------------------
-- View structure for V_PRIORITAS
-- ----------------------------
create or replace view nr_csr.v_prioritas as select
	nr_csr.tbl_kelayakan.no_agenda,
	nr_csr.tbl_kelayakan.id_proker,
	nr_csr.tbl_proker.prioritas,
	nr_csr.tbl_proker.tahun,
	nr_csr.tbl_survei.nilai_approved 
from
	nr_csr.tbl_kelayakan
	inner join nr_csr.tbl_proker on nr_csr.tbl_kelayakan.id_proker = nr_csr.tbl_proker.id_proker
	inner join nr_csr.tbl_survei on nr_csr.tbl_kelayakan.no_agenda = nr_csr.tbl_survei.no_agenda 
where
	nr_csr.tbl_kelayakan.id_proker is not null 
	and nr_csr.tbl_proker.prioritas is not null 
	and nr_csr.tbl_kelayakan.status = 'Approved';

-- ----------------------------
-- View structure for V_PROKER
-- ----------------------------
create or replace view nr_csr.v_proker as select
nr_csr.tbl_proker.id_proker,
nr_csr.tbl_proker.proker,
nr_csr.tbl_sub_pilar.pilar,
nr_csr.tbl_sub_pilar.tpb,
nr_csr.tbl_proker.id_indikator,
nr_csr.tbl_sub_pilar.kode_indikator,
nr_csr.tbl_sub_pilar.keterangan,
nr_csr.tbl_proker.tahun,
nr_csr.tbl_proker.anggaran,
nr_csr.tbl_proker.prioritas,
nr_csr.tbl_proker.eb
from
nr_csr.tbl_proker
inner join nr_csr.tbl_sub_pilar on nr_csr.tbl_proker.id_indikator = nr_csr.tbl_sub_pilar.id_sub_pilar;

-- ----------------------------
-- View structure for V_PROPOSAL
-- ----------------------------
create or replace view nr_csr.v_proposal as select
k.id_kelayakan,
k.no_agenda,
k.tgl_terima,
k.no_surat,
k.tgl_surat,
k.id_pengirim,
p.pengirim,
k.sifat,
k.jenis,
k.id_proker,
pr.proker,
pr.pilar,
pr.kode_tpb,
pr.gols,
pr.prioritas,
k.perihal,
k.bantuan_untuk,
k.id_lembaga,
l.nama_lembaga,
l.nama_pic,
l.alamat,
l.no_telp,
l.jabatan,
k.no_rekening,
k.atas_nama,
k.nama_bank,
k.nilai_pengajuan,
k.nilai_bantuan,
k.provinsi,
k.kabupaten,
k.kecamatan,
k.kelurahan,
k.deskripsi,
k.ykpp,
k.status_ykpp,
k.smap,
k.status,
k.email_pengaju,
k.created_date,
k.created_by,
u.nama as nama_maker,
u.email as email_maker,
u.jabatan as jabatan_maker,
u.foto_profile,
k.checklist_by,
k.checklist_date,
k.nominal_approved,
k.nominal_fee,
k.total_ykpp,
k.approved_ykpp_by,
k.approved_ykpp_date,
k.submited_ykpp_by,
k.submited_ykpp_date,
k.no_surat_ykpp,
k.tgl_surat_ykpp,
k.surat_ykpp,
k.tahun_ykpp,
k.penyaluran_ke
from
nr_csr.tbl_kelayakan k
left join nr_csr.tbl_pengirim p on k.id_pengirim = p.id_pengirim
left join nr_csr.tbl_lembaga l on k.id_lembaga = l.id_lembaga
left join nr_csr.tbl_user u on k.created_by = u.id_user
left join nr_csr.tbl_proker pr on k.id_proker = pr.id_proker;

-- ----------------------------
-- View structure for V_PROVINSI_KAMBING
-- ----------------------------
create or replace view nr_csr.v_provinsi_kambing as select provinsi from tbl_sub_proposal where kambing > 0 group by provinsi;

-- ----------------------------
-- View structure for V_PROVINSI_SAPI
-- ----------------------------
create or replace view nr_csr.v_provinsi_sapi as select provinsi from tbl_sub_proposal where sapi > 0 group by provinsi;

-- ----------------------------
-- View structure for V_REALISASI_AP
-- ----------------------------
create or replace view nr_csr.v_realisasi_ap as select
nr_csr.tbl_realisasi_ap.id_realisasi,
nr_csr.tbl_realisasi_ap.no_proposal,
nr_csr.tbl_realisasi_ap.tgl_proposal,
nr_csr.tbl_realisasi_ap.pengirim,
nr_csr.tbl_realisasi_ap.tgl_realisasi,
nr_csr.tbl_realisasi_ap.sifat,
nr_csr.tbl_realisasi_ap.perihal,
nr_csr.tbl_realisasi_ap.besar_permohonan,
nr_csr.tbl_realisasi_ap.kategori,
nr_csr.tbl_realisasi_ap.nilai_bantuan,
nr_csr.tbl_realisasi_ap.status,
nr_csr.tbl_realisasi_ap.provinsi,
nr_csr.tbl_realisasi_ap.kabupaten,
nr_csr.tbl_realisasi_ap.deskripsi,
nr_csr.tbl_realisasi_ap.id_proker,
nr_csr.tbl_realisasi_ap.proker,
nr_csr.tbl_realisasi_ap.pilar,
nr_csr.tbl_realisasi_ap.gols,
nr_csr.tbl_realisasi_ap.nama_yayasan,
nr_csr.tbl_realisasi_ap.alamat,
nr_csr.tbl_realisasi_ap.pic,
nr_csr.tbl_realisasi_ap.jabatan,
nr_csr.tbl_realisasi_ap.no_telp,
nr_csr.tbl_realisasi_ap.no_rekening,
nr_csr.tbl_realisasi_ap.atas_nama,
nr_csr.tbl_realisasi_ap.nama_bank,
nr_csr.tbl_realisasi_ap.kota_bank,
nr_csr.tbl_realisasi_ap.cabang_bank,
nr_csr.tbl_realisasi_ap.created_by,
nr_csr.tbl_realisasi_ap.created_date,
nr_csr.tbl_realisasi_ap.jenis,
nr_csr.tbl_realisasi_ap.perusahaan,
to_char(tgl_realisasi, 'MM') as bulan,
nr_csr.tbl_realisasi_ap.tahun,
nr_csr.tbl_realisasi_ap.status_date
from
nr_csr.tbl_realisasi_ap;

-- ----------------------------
-- View structure for V_REALISASI_PROVINSI
-- ----------------------------
create or replace view nr_csr.v_realisasi_provinsi as select account_cad2 from v_inv_payrequest group by account_cad2 order by account_cad2 asc;

-- ----------------------------
-- View structure for V_SEKTOR
-- ----------------------------
create or replace view nr_csr.v_sektor as select sektor_bantuan, count(sektor_bantuan) as jumlah, to_char(tgl_terima, 'YYYY') as tahun from tbl_kelayakan group by tgl_terima, sektor_bantuan;

-- ----------------------------
-- View structure for V_SPK
-- ----------------------------
create or replace view nr_csr.v_spk as select
tbl_spk.id_spk,
tbl_kelayakan.id_kelayakan,
tbl_spk.no_agenda,
tbl_spk.no_spk,
tbl_spk.tgl_spk,
tbl_spk.kegiatan,
tbl_spk.jabatan,
tbl_spk.perusahaan,
tbl_spk.alamat,
tbl_spk.no_penawaran,
tbl_spk.tgl_penawaran,
tbl_spk.no_berita_acara,
tbl_spk.tgl_berita_acara,
tbl_spk.nominal,
tbl_spk.termin,
tbl_spk.rupiah1,
tbl_spk.rupiah2,
tbl_spk.rupiah3,
tbl_spk.rupiah4,
tbl_spk.nama_bank,
tbl_spk.cabang,
tbl_spk.no_rekening,
tbl_spk.atas_nama,
tbl_spk.due_date,
tbl_spk.nama_pengadilan,
tbl_spk.nama_pejabat,
tbl_spk.jabatan_pejabat,
tbl_spk.status,
tbl_spk.nama,
tbl_spk.header1,
tbl_spk.header2,
tbl_spk.header3,
tbl_spk.created_by,
tbl_spk.created_date
from
tbl_spk
join tbl_kelayakan
on tbl_spk.no_agenda = tbl_kelayakan.no_agenda;

-- ----------------------------
-- View structure for V_SPPH
-- ----------------------------
create or replace view nr_csr.v_spph as select
nr_csr.tbl_spph.spph_id,
nr_csr.tbl_spph.nomor,
nr_csr.tbl_spph.tanggal,
to_char(tbl_spph.tanggal, 'MM') as bulan,
to_char(tbl_spph.tanggal, 'YYYY') as tahun,
nr_csr.tbl_spph.pekerjaan_id,
nr_csr.tbl_pekerjaan.nama_pekerjaan,
nr_csr.tbl_spph.status,
nr_csr.tbl_spph.catatan,
nr_csr.tbl_spph.created_by,
nr_csr.tbl_spph.created_date,
nr_csr.tbl_spph.id_vendor,
nr_csr.tbl_spph.file_spph,
nr_csr.tbl_spph.response_date,
nr_csr.tbl_vendor.nama_perusahaan,
nr_csr.tbl_pekerjaan.kak,
nr_csr.tbl_pekerjaan.ringkasan
from
nr_csr.tbl_spph
inner join nr_csr.tbl_pekerjaan on nr_csr.tbl_spph.pekerjaan_id = nr_csr.tbl_pekerjaan.pekerjaan_id
inner join nr_csr.tbl_vendor on nr_csr.tbl_spph.id_vendor = nr_csr.tbl_vendor.vendor_id;

-- ----------------------------
-- View structure for V_SUM_SEKTOR
-- ----------------------------
create or replace view nr_csr.v_sum_sektor as select v_survei.sektor_bantuan as sektor_bantuan,sum(v_survei.nilai_approved) as jumlah, to_char(tgl_terima, 'YYYY') as tahun from nr_csr.v_survei where (v_survei.status = 'Approved 3') group by v_survei.sektor_bantuan, v_survei.tgl_terima;

-- ----------------------------
-- View structure for V_SUM_SEKTOR2
-- ----------------------------
create or replace view nr_csr.v_sum_sektor2 as select 
max(pr.invoice_amount) jumlah,
inv.account_cad1 as sektor_bantuan, pr.budget_year as tahun, pr.status as status
from nr_payment.t_invoice_line inv, nr_payment.t_payment_request pr
 where inv.id_payment_request = pr.id 
 and pr.type = 'CSR 517/518' 
 and pr.receiver_type = 'EXTERNAL' 
 and inv.account_eb in ('517','518')
group by pr.id, pr.budget_year,
inv.account_cad1, pr.status;

-- ----------------------------
-- View structure for V_SUM_STATUS
-- ----------------------------
create or replace view nr_csr.v_sum_status as select 
sum(pr.invoice_amount) jumlah,
pr.status as status, pr.budget_year as tahun
from nr_payment.t_invoice_line inv, nr_payment.t_payment_request pr
 where inv.id_payment_request = pr.id 
 and pr.type = 'CSR 517/518' 
 and pr.receiver_type = 'EXTERNAL' 
 and inv.account_eb in ('517','518')
group by pr.id, pr.budget_year, pr.status;

-- ----------------------------
-- View structure for V_SURVEI
-- ----------------------------
create or replace view nr_csr.v_survei as select
    s.id_survei                             as id_survei,
    k.pengirim                              as pengirim,
    k.jenis                                 as jenis,
    k.tgl_terima                            as tgl_terima,
    k.no_surat                              as no_surat,
    k.tgl_surat                             as tgl_surat,
    k.perihal                               as perihal,
    k.pilar                                 as pilar,
    k.tpb                                   as tpb,
    k.pengaju_proposal                      as pengaju_proposal,
    k.sebagai                               as sebagai,
    k.alamat                                as alamat,
    k.provinsi                              as provinsi,
    k.kabupaten                             as kabupaten,
    k.bantuan_untuk                         as bantuan_untuk,
    k.contact_person                        as contact_person,
    k.nilai_pengajuan                       as nilai_pengajuan,
    k.sektor_bantuan                        as sektor_bantuan,
    k.nama_bank                             as nama_bank,
    k.atas_nama                             as atas_nama,
    k.no_rekening                           as no_rekening,
    k.nama_anggota                          as nama_anggota,
    k.fraksi                                as fraksi,
    k.jabatan                               as jabatan,
    k.pic                                   as pic,
    k.asal_surat                            as asal_surat,
    k.komisi                                as komisi,
    k.sifat                                 as sifat,
    k.email_pengaju                         as email_pengaju,
    k.nama_person                           as nama_person,
    k.mata_uang_pengajuan                   as mata_uang_pengajuan,
    k.mata_uang_bantuan                     as mata_uang_bantuan,
    s.hasil_konfirmasi                      as hasil_konfirmasi,
    s.hasil_survei                          as hasil_survei,
    s.usulan                                as usulan,
    s.bantuan_berupa                        as bantuan_berupa,
    s.nilai_bantuan                         as nilai_bantuan,
    s.termin                                as termin,
    s.survei1                               as survei1,
    s.survei2                               as survei2,
    s.status                                as status,
    s.kadep                                 as kadep,
    s.kadiv                                 as kadiv,
    s.ket_kadin1                            as ket_kadin1,
    s.ket_kadin2                            as ket_kadin2,
    s.ket_kadiv                             as ket_kadiv,
    s.keterangan                            as keterangan,
    k.deskripsi                             as deskripsi,
    s.approve_date                          as approve_date,
    s.approve_kadep                         as approve_kadep,
    s.approve_kadiv                         as approve_kadiv,
    s.create_by                             as create_by,
    s.create_date                           as create_date,
    e.rencana_anggaran                      as rencana_anggaran,
    k.proposal                              as proposal,
    s.persen1                               as persen1,
    s.persen2                               as persen2,
    s.persen3                               as persen3,
    s.persen4                               as persen4,
    s.rupiah1                               as rupiah1,
    s.rupiah2                               as rupiah2,
    s.rupiah3                               as rupiah3,
    s.rupiah4                               as rupiah4,
    s.bast                                  as bast,
    s.spk                                   as spk,
    s.pks                                   as pks,
    s.revisi_by                             as revisi_by,
    s.revisi_date                           as revisi_date,
    s.nilai_approved                        as nilai_approved,
    k.id_kelayakan                          as id_kelayakan,
    s.sekper,
    s.dirut,
    s.ket_sekper,
    s.ket_dirut,
    s.approve_sekper,
    s.approve_dirut,
    k.no_agenda                             as no_agenda
from tbl_kelayakan k
join tbl_evaluasi  e on e.id_kelayakan = k.id_kelayakan
join tbl_survei    s on s.id_kelayakan = k.id_kelayakan;

-- ----------------------------
-- View structure for V_USER
-- ----------------------------
create or replace view nr_csr.v_user as select nr_csr.tbl_user.id_user as id_user,nr_csr.tbl_user.username as username,nr_csr.tbl_user.email as email,nr_csr.tbl_user.nama as nama,nr_csr.tbl_user.jabatan as jabatan,nr_csr.tbl_user.password as password,nr_csr.tbl_user.role as role,nr_csr.tbl_role.role_name as role_name,nr_csr.tbl_user.area_kerja as area_kerja,nr_csr.tbl_user.status as status,nr_csr.tbl_user.foto as foto,nr_csr.tbl_user.remember_token as remember_token from (nr_csr.tbl_user join nr_csr.tbl_role on((nr_csr.tbl_user.role = nr_csr.tbl_role.role)));

-- ----------------------------
-- View structure for V_YKPP
-- ----------------------------
create or replace view nr_csr.v_ykpp as select
	p.id_pembayaran, 
	p.id_kelayakan, 
	k.no_agenda, 
	k.tgl_terima, 
	k.deskripsi, 
	k.id_lembaga, 
	l.nama_lembaga, 
	l.nama_pic, 
	l.alamat, 
	k.id_proker, 
	pr.proker, 
	pr.anggaran, 
	pr.prioritas, 
	pr.pilar, 
	pr.gols, 
	pr.kode_tpb, 
	p.jumlah_pembayaran, 
	p.fee, 
	p.subtotal, 
	p.fee_persen, 
	p.status_ykpp, 
	p.penyaluran_ke, 
	p.tahun_ykpp, 
	p.no_surat_ykpp, 
	p.tgl_surat_ykpp, 
	p.surat_ykpp, 
	p.submited_ykpp_by, 
	p.submited_ykpp_date, 
	p.approved_ykpp_by, 
	p.approved_ykpp_date, 
	p.metode, 
	p.create_date, 
	p.create_by, 
	k.provinsi, 
	k.kabupaten, 
	k.kecamatan, 
	k.kelurahan, 
	k.nama_bank, 
	k.atas_nama, 
	k.no_rekening, 
	p.termin
from
	tbl_pembayaran p
	left join
	tbl_kelayakan k
	on 
		p.id_kelayakan = k.id_kelayakan
	left join
	tbl_lembaga l
	on 
		k.id_lembaga = l.id_lembaga
	left join
	tbl_proker pr
	on 
		k.id_proker = pr.id_proker
where
	p.metode = 'YKPP';

-- ----------------------------
-- View structure for V_YKPP_ASPIRASI
-- ----------------------------
create or replace view nr_csr.v_ykpp_aspirasi as select no_agenda,tgl_terima,no_surat,tgl_surat,sebagai,provinsi,kabupaten,kecamatan,kelurahan,kodepos,bantuan_untuk,contact_person,nilai_pengajuan,sektor_bantuan,nama_bank,atas_nama,no_rekening,nilai_bantuan,nama_anggota,fraksi,jabatan,pic,asal_surat,komisi,sifat,status,email_pengaju,nama_person,mata_uang_pengajuan,mata_uang_bantuan,proposal,create_by,create_date,pengirim,perihal,pengaju_proposal,alamat,cabang_bank,jenis,hewan_kurban,jumlah_hewan,kode_bank,kode_kota,kota_bank,cabang,deskripsi,pilar,tpb,kode_indikator,keterangan_indikator,proker,indikator,id_proker,smap,ykpp,checklist_by,checklist_date,nominal_approved,nominal_fee,total_ykpp,status_ykpp,approved_ykpp_by,approved_ykpp_date,submited_ykpp_by,submited_ykpp_date,no_surat_ykpp,tgl_surat_ykpp,penyaluran_ke_old,id_kelayakan,surat_ykpp,tahun_ykpp,penyaluran_ke from tbl_kelayakan where ykpp = 'Yes' and tahun_ykpp in ('2023','2024') and jenis = 'Aspirasi';

-- ----------------------------
-- View structure for V_YKPP_SUBMIT
-- ----------------------------
create or replace view nr_csr.v_ykpp_submit as select
nr_csr.tbl_kelayakan.no_agenda,
nr_csr.tbl_kelayakan.tgl_terima,
nr_csr.tbl_kelayakan.no_surat,
nr_csr.tbl_kelayakan.tgl_surat,
nr_csr.tbl_kelayakan.sebagai,
nr_csr.tbl_kelayakan.provinsi,
nr_csr.tbl_kelayakan.kabupaten,
nr_csr.tbl_kelayakan.kecamatan,
nr_csr.tbl_kelayakan.kelurahan,
nr_csr.tbl_kelayakan.kodepos,
nr_csr.tbl_kelayakan.bantuan_untuk,
nr_csr.tbl_kelayakan.contact_person,
nr_csr.tbl_kelayakan.nilai_pengajuan,
nr_csr.tbl_kelayakan.sektor_bantuan,
nr_csr.tbl_kelayakan.nama_bank,
nr_csr.tbl_kelayakan.atas_nama,
nr_csr.tbl_kelayakan.no_rekening,
nr_csr.tbl_kelayakan.nilai_bantuan,
nr_csr.tbl_kelayakan.nama_anggota,
nr_csr.tbl_kelayakan.fraksi,
nr_csr.tbl_kelayakan.jabatan,
nr_csr.tbl_kelayakan.pic,
nr_csr.tbl_kelayakan.asal_surat,
nr_csr.tbl_kelayakan.komisi,
nr_csr.tbl_kelayakan.sifat,
nr_csr.tbl_kelayakan.status,
nr_csr.tbl_kelayakan.email_pengaju,
nr_csr.tbl_kelayakan.nama_person,
nr_csr.tbl_kelayakan.mata_uang_pengajuan,
nr_csr.tbl_kelayakan.mata_uang_bantuan,
nr_csr.tbl_kelayakan.proposal,
nr_csr.tbl_kelayakan.create_by,
nr_csr.tbl_kelayakan.create_date,
nr_csr.tbl_kelayakan.pengirim,
nr_csr.tbl_kelayakan.perihal,
nr_csr.tbl_kelayakan.pengaju_proposal,
nr_csr.tbl_kelayakan.alamat,
nr_csr.tbl_kelayakan.cabang_bank,
nr_csr.tbl_kelayakan.jenis,
nr_csr.tbl_kelayakan.hewan_kurban,
nr_csr.tbl_kelayakan.jumlah_hewan,
nr_csr.tbl_kelayakan.kode_bank,
nr_csr.tbl_kelayakan.kode_kota,
nr_csr.tbl_kelayakan.kota_bank,
nr_csr.tbl_kelayakan.cabang,
nr_csr.tbl_kelayakan.deskripsi,
nr_csr.tbl_kelayakan.id_proker,
nr_csr.tbl_proker.proker,
nr_csr.tbl_proker.prioritas,
nr_csr.tbl_proker.pilar,
nr_csr.tbl_proker.gols,
nr_csr.tbl_kelayakan.smap,
nr_csr.tbl_kelayakan.ykpp,
nr_csr.tbl_kelayakan.checklist_by,
nr_csr.tbl_kelayakan.checklist_date,
nr_csr.tbl_kelayakan.nominal_approved,
nr_csr.tbl_kelayakan.nominal_fee,
nr_csr.tbl_kelayakan.total_ykpp,
nr_csr.tbl_kelayakan.status_ykpp,
nr_csr.tbl_kelayakan.approved_ykpp_by,
nr_csr.tbl_kelayakan.approved_ykpp_date,
nr_csr.tbl_kelayakan.submited_ykpp_by,
nr_csr.tbl_kelayakan.submited_ykpp_date,
nr_csr.tbl_kelayakan.no_surat_ykpp,
nr_csr.tbl_kelayakan.tgl_surat_ykpp,
nr_csr.tbl_kelayakan.penyaluran_ke,
nr_csr.tbl_kelayakan.id_kelayakan,
nr_csr.tbl_kelayakan.surat_ykpp,
nr_csr.tbl_kelayakan.tahun_ykpp
from
nr_csr.tbl_kelayakan
inner join nr_csr.tbl_proker on nr_csr.tbl_kelayakan.id_proker = nr_csr.tbl_proker.id_proker
where
nr_csr.tbl_kelayakan.ykpp = 'Yes' and
nr_csr.tbl_kelayakan.status_ykpp in ('Submited');

-- ----------------------------
-- Sequence structure for AREA_SEQ
-- ----------------------------
drop sequence if exists nr_csr.area_seq cascade;
create sequence if not exists nr_csr.area_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ASSESSMENT_VENDOR_SEQ
-- ----------------------------
drop sequence if exists nr_csr.assessment_vendor_seq cascade;
create sequence if not exists nr_csr.assessment_vendor_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for BAKN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.bakn_seq cascade;
create sequence if not exists nr_csr.bakn_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for BANK_SEQ
-- ----------------------------
drop sequence if exists nr_csr.bank_seq cascade;
create sequence if not exists nr_csr.bank_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for COMPANY_SEQ
-- ----------------------------
drop sequence if exists nr_csr.company_seq cascade;
create sequence if not exists nr_csr.company_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for DETAIL_DOKUMEN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.detail_dokumen_seq cascade;
create sequence if not exists nr_csr.detail_dokumen_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for DETAIL_KRITERIA_SECQ
-- ----------------------------
drop sequence if exists nr_csr.detail_kriteria_secq cascade;
create sequence if not exists nr_csr.detail_kriteria_secq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for DETAIL_RUANG_LINGKUP_SEQ
-- ----------------------------
drop sequence if exists nr_csr.detail_ruang_lingkup_seq cascade;
create sequence if not exists nr_csr.detail_ruang_lingkup_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for DOKUMEN_MANDATORI_PROYEK_SEQ
-- ----------------------------
drop sequence if exists nr_csr.dokumen_mandatori_proyek_seq cascade;
create sequence if not exists nr_csr.dokumen_mandatori_proyek_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for DOKUMEN_MANDATORI_SEQ
-- ----------------------------
drop sequence if exists nr_csr.dokumen_mandatori_seq cascade;
create sequence if not exists nr_csr.dokumen_mandatori_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for EVALUASI_SEQ
-- ----------------------------
drop sequence if exists nr_csr.evaluasi_seq cascade;
create sequence if not exists nr_csr.evaluasi_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_ALOKASI_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_alokasi_seq cascade;
create sequence if not exists nr_csr.id_alokasi_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_ANGGARAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_anggaran_seq cascade;
create sequence if not exists nr_csr.id_anggaran_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_ANGGOTA_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_anggota_seq cascade;
create sequence if not exists nr_csr.id_anggota_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_BAST_DANA_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_bast_dana_seq cascade;
create sequence if not exists nr_csr.id_bast_dana_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_CO_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_co_seq cascade;
create sequence if not exists nr_csr.id_co_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_DETAIL_SPK
-- ----------------------------
drop sequence if exists nr_csr.id_detail_spk cascade;
create sequence if not exists nr_csr.id_detail_spk 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_DOK_VENDOR
-- ----------------------------
drop sequence if exists nr_csr.id_dok_vendor cascade;
create sequence if not exists nr_csr.id_dok_vendor 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_ERROR
-- ----------------------------
drop sequence if exists nr_csr.id_error cascade;
create sequence if not exists nr_csr.id_error 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_KEBIJAKAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_kebijakan_seq cascade;
create sequence if not exists nr_csr.id_kebijakan_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_LAMPIRAN_AP
-- ----------------------------
drop sequence if exists nr_csr.id_lampiran_ap cascade;
create sequence if not exists nr_csr.id_lampiran_ap 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_LAMPIRAN_VENDOR_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_lampiran_vendor_seq cascade;
create sequence if not exists nr_csr.id_lampiran_vendor_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_LEMBAGA_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_lembaga_seq cascade;
create sequence if not exists nr_csr.id_lembaga_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_LOG_RELOKASI_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_log_relokasi_seq cascade;
create sequence if not exists nr_csr.id_log_relokasi_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_LOG_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_log_seq cascade;
create sequence if not exists nr_csr.id_log_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_PERUSAHAAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_perusahaan_seq cascade;
create sequence if not exists nr_csr.id_perusahaan_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_PILAR_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_pilar_seq cascade;
create sequence if not exists nr_csr.id_pilar_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_PROKER_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_proker_seq cascade;
create sequence if not exists nr_csr.id_proker_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_REALISASI_AP
-- ----------------------------
drop sequence if exists nr_csr.id_realisasi_ap cascade;
create sequence if not exists nr_csr.id_realisasi_ap 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_RELOKASI_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_relokasi_seq cascade;
create sequence if not exists nr_csr.id_relokasi_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_SDG_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_sdg_seq cascade;
create sequence if not exists nr_csr.id_sdg_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_SPK_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_spk_seq cascade;
create sequence if not exists nr_csr.id_spk_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_SPPH_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_spph_seq cascade;
create sequence if not exists nr_csr.id_spph_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_SUB_PILAR_SDG
-- ----------------------------
drop sequence if exists nr_csr.id_sub_pilar_sdg cascade;
create sequence if not exists nr_csr.id_sub_pilar_sdg 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_SUB_PROPOSAL
-- ----------------------------
drop sequence if exists nr_csr.id_sub_proposal cascade;
create sequence if not exists nr_csr.id_sub_proposal 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for ID_VENDOR_SEQ
-- ----------------------------
drop sequence if exists nr_csr.id_vendor_seq cascade;
create sequence if not exists nr_csr.id_vendor_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for IZIN_USAHA_SEQ
-- ----------------------------
drop sequence if exists nr_csr.izin_usaha_seq cascade;
create sequence if not exists nr_csr.izin_usaha_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for KEGIATAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.kegiatan_seq cascade;
create sequence if not exists nr_csr.kegiatan_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for KELAYAKAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.kelayakan_seq cascade;
create sequence if not exists nr_csr.kelayakan_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for KTP_PENGURUS_SEQ
-- ----------------------------
drop sequence if exists nr_csr.ktp_pengurus_seq cascade;
create sequence if not exists nr_csr.ktp_pengurus_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for LAMPIRAN_PEKERJAAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.lampiran_pekerjaan_seq cascade;
create sequence if not exists nr_csr.lampiran_pekerjaan_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for LOG_PEKERJAAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.log_pekerjaan_seq cascade;
create sequence if not exists nr_csr.log_pekerjaan_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for LOG_VENDOR_SEQ
-- ----------------------------
drop sequence if exists nr_csr.log_vendor_seq cascade;
create sequence if not exists nr_csr.log_vendor_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for M_WILAYAH_ID_WILAYAH_1SEQ
-- ----------------------------
drop sequence if exists nr_csr.m_wilayah_id_wilayah_1seq cascade;
create sequence if not exists nr_csr.m_wilayah_id_wilayah_1seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for PEKERJAAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.pekerjaan_seq cascade;
create sequence if not exists nr_csr.pekerjaan_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for PEMBAYARAN_VENDOR_SEQ
-- ----------------------------
drop sequence if exists nr_csr.pembayaran_vendor_seq cascade;
create sequence if not exists nr_csr.pembayaran_vendor_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for PENGALAMAN_KERJA_SEQ
-- ----------------------------
drop sequence if exists nr_csr.pengalaman_kerja_seq cascade;
create sequence if not exists nr_csr.pengalaman_kerja_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for PHOTO_SEQ
-- ----------------------------
drop sequence if exists nr_csr.photo_seq cascade;
create sequence if not exists nr_csr.photo_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for SEQ_DETAIL_APPROVAL_ID
-- ----------------------------
drop sequence if exists nr_csr.seq_detail_approval_id cascade;
create sequence nr_csr.seq_detail_approval_id minvalue 1 maxvalue 9999999999999999999999999999 increment by 1 nocache;

-- ----------------------------
-- Sequence structure for SEQ_DOKUMEN_ID
-- ----------------------------
drop sequence if exists nr_csr.seq_dokumen_id cascade;
create sequence nr_csr.seq_dokumen_id minvalue 1 maxvalue 9999999999999999999999999999 increment by 1 nocache;

-- ----------------------------
-- Sequence structure for SEQ_HIRARKI_ID
-- ----------------------------
drop sequence if exists nr_csr.seq_hirarki_id cascade;
create sequence nr_csr.seq_hirarki_id minvalue 1 maxvalue 9999999999999999999999999999 increment by 1 nocache;

-- ----------------------------
-- Sequence structure for SEQ_LEVEL_HIRARKI_ID
-- ----------------------------
drop sequence if exists nr_csr.seq_level_hirarki_id cascade;
create sequence nr_csr.seq_level_hirarki_id minvalue 1 maxvalue 9999999999999999999999999999 increment by 1 nocache;

-- ----------------------------
-- Sequence structure for SEQ_PEJABAT_ID
-- ----------------------------
drop sequence if exists nr_csr.seq_pejabat_id cascade;
create sequence nr_csr.seq_pejabat_id minvalue 1 maxvalue 9999999999999999999999999999 increment by 1 nocache;

-- ----------------------------
-- Sequence structure for SPH_SEQ
-- ----------------------------
drop sequence if exists nr_csr.sph_seq cascade;
create sequence if not exists nr_csr.sph_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for SURVEY_SEQ
-- ----------------------------
drop sequence if exists nr_csr.survey_seq cascade;
create sequence if not exists nr_csr.survey_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_AREA_ID_AREA_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_area_id_area_seq cascade;
create sequence if not exists nr_csr.tbl_area_id_area_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_CITY_ID_CITY_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_city_id_city_seq cascade;
create sequence if not exists nr_csr.tbl_city_id_city_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_DETAIL_KRITERIA_ID_DET_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_detail_kriteria_id_det_seq cascade;
create sequence if not exists nr_csr.tbl_detail_kriteria_id_det_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_EVALUASI_ID_EVALUASI_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_evaluasi_id_evaluasi_seq cascade;
create sequence if not exists nr_csr.tbl_evaluasi_id_evaluasi_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_KELAYAKAN_ID_KELAYAKAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_kelayakan_id_kelayakan_seq cascade;
create sequence if not exists nr_csr.tbl_kelayakan_id_kelayakan_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_LAMPIRAN_ID_LAMPIRAN_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_lampiran_id_lampiran_seq cascade;
create sequence if not exists nr_csr.tbl_lampiran_id_lampiran_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_PEMBAYARAN_ID_PEMBAYAR_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_pembayaran_id_pembayar_seq cascade;
create sequence if not exists nr_csr.tbl_pembayaran_id_pembayar_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_PENGIRIM_ID_PENGIRIM_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_pengirim_id_pengirim_seq cascade;
create sequence if not exists nr_csr.tbl_pengirim_id_pengirim_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_PROVINSI_ID_PROVINSI_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_provinsi_id_provinsi_seq cascade;
create sequence if not exists nr_csr.tbl_provinsi_id_provinsi_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_ROLE_ID_ROLE_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_role_id_role_seq cascade;
create sequence if not exists nr_csr.tbl_role_id_role_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_SEKTOR_ID_SEKTOR_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_sektor_id_sektor_seq cascade;
create sequence if not exists nr_csr.tbl_sektor_id_sektor_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_SURVEI_ID_SURVEI_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_survei_id_survei_seq cascade;
create sequence if not exists nr_csr.tbl_survei_id_survei_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_USER_ID_USER_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_user_id_user_seq cascade;
create sequence if not exists nr_csr.tbl_user_id_user_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for TBL_WILAYAH_ID_WILAYAH_SEQ
-- ----------------------------
drop sequence if exists nr_csr.tbl_wilayah_id_wilayah_seq cascade;
create sequence if not exists nr_csr.tbl_wilayah_id_wilayah_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for T_USER_ID_USER_SEQ
-- ----------------------------
drop sequence if exists nr_csr.t_user_id_user_seq cascade;
create sequence if not exists nr_csr.t_user_id_user_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Sequence structure for USER_SEQ
-- ----------------------------
drop sequence if exists nr_csr.user_seq cascade;
create sequence if not exists nr_csr.user_seq 
    increment by 1 
    minvalue 1 
    start with 1 
    no maxvalue 
    cache 20;

-- ----------------------------
-- Checks structure for table NO_AGENDA
-- ----------------------------
alter table nr_csr.no_agenda alter column tahun set not null;
alter table nr_csr.no_agenda alter column last_no set not null;
alter table nr_csr.no_agenda alter column tahun set not null;
alter table nr_csr.no_agenda alter column last_no set not null;
-- ----------------------------
-- Triggers structure for table TBL_ALOKASI
-- ----------------------------
create or replace function nr_csr.id_alokasi_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_alokasi is null then
    new.id_alokasi := nextval('"NR_CSR"."ID_ALOKASI_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_alokasi_trig on nr_csr.tbl_alokasi;
create trigger id_alokasi_trig before insert on nr_csr.tbl_alokasi
for each row execute function nr_csr.id_alokasi_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_ANGGARAN
-- ----------------------------
alter table nr_csr.tbl_anggaran add constraint tbl_anggaran_pk primary key (id_anggaran);

-- ----------------------------
-- Uniques structure for table TBL_ANGGARAN
-- ----------------------------
alter table nr_csr.tbl_anggaran add constraint tahun unique (tahun, id_perusahaan);
-- ----------------------------
-- Checks structure for table TBL_ANGGARAN
-- ----------------------------
alter table nr_csr.tbl_anggaran alter column id_anggaran set not null;
-- ----------------------------
-- Triggers structure for table TBL_ANGGARAN
-- ----------------------------
create or replace function nr_csr.id_anggaran_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_anggaran is null then
    new.id_anggaran := nextval('"NR_CSR"."ID_ANGGARAN_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_anggaran_trig on nr_csr.tbl_anggaran;
create trigger id_anggaran_trig before insert on nr_csr.tbl_anggaran
for each row execute function nr_csr.id_anggaran_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_ANGGOTA
-- ----------------------------
alter table nr_csr.tbl_anggota add constraint tbl_anggota_pk primary key (id_anggota);

-- ----------------------------
-- Checks structure for table TBL_ANGGOTA
-- ----------------------------
alter table nr_csr.tbl_anggota alter column id_anggota set not null;
-- ----------------------------
-- Triggers structure for table TBL_ANGGOTA
-- ----------------------------
create or replace function nr_csr.id_anggota_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_anggota is null then
    new.id_anggota := nextval('"NR_CSR"."ID_ANGGOTA_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_anggota_trig on nr_csr.tbl_anggota;
create trigger id_anggota_trig before insert on nr_csr.tbl_anggota
for each row execute function nr_csr.id_anggota_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_AREA
-- ----------------------------
alter table nr_csr.tbl_area alter column id_area set not null;
-- ----------------------------
-- Triggers structure for table TBL_AREA
-- ----------------------------
create or replace function nr_csr.tbl_area_id_area_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_area is null then
    new.id_area := nextval('"NR_CSR"."TBL_AREA_ID_AREA_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_area_id_area_trig on nr_csr.tbl_area;
create trigger tbl_area_id_area_trig before insert or update on nr_csr.tbl_area
for each row execute function nr_csr.tbl_area_id_area_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_ASSESSMENT_VENDOR
-- ----------------------------
alter table nr_csr.tbl_assessment_vendor add constraint sys_c002141356 primary key (assessment_id);

-- ----------------------------
-- Triggers structure for table TBL_ASSESSMENT_VENDOR
-- ----------------------------
create or replace function nr_csr.assessment_vendor_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.assessment_id is null then
    new.assessment_id := nextval('"NR_CSR"."ASSESSMENT_VENDOR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists assessment_vendor_trig on nr_csr.tbl_assessment_vendor;
create trigger assessment_vendor_trig before insert on nr_csr.tbl_assessment_vendor
for each row execute function nr_csr.assessment_vendor_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_BAKN
-- ----------------------------
alter table nr_csr.tbl_bakn add constraint sys_c002172927 primary key (bakn_id);

-- ----------------------------
-- Checks structure for table TBL_BAKN
-- ----------------------------
alter table nr_csr.tbl_bakn alter column bakn_id set not null;
alter table nr_csr.tbl_bakn alter column bakn_id set not null;
-- ----------------------------
-- Indexes structure for table TBL_BAKN
-- ----------------------------
create unique index nr_csr.no_bakn
  on nr_csr.tbl_bakn (nomor asc);
-- ----------------------------
-- Triggers structure for table TBL_BAKN
-- ----------------------------
create or replace function nr_csr.bakn_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.bakn_id is null then
    new.bakn_id := nextval('"NR_CSR"."BAKN_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists bakn_trig on nr_csr.tbl_bakn;
create trigger bakn_trig before insert on nr_csr.tbl_bakn
for each row execute function nr_csr.bakn_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_BANK
-- ----------------------------
alter table nr_csr.tbl_bank add constraint sys_c002165427 primary key (bank_id);

-- ----------------------------
-- Checks structure for table TBL_BANK
-- ----------------------------
alter table nr_csr.tbl_bank alter column bank_id set not null;
-- ----------------------------
-- Triggers structure for table TBL_BANK
-- ----------------------------
create or replace function nr_csr.bank_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.bank_id is null then
    new.bank_id := nextval('"NR_CSR"."BANK_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists bank_trig on nr_csr.tbl_bank;
create trigger bank_trig before insert on nr_csr.tbl_bank
for each row execute function nr_csr.bank_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_BAST_DANA
-- ----------------------------
alter table nr_csr.tbl_bast_dana add constraint tbl_bast_dana_pk primary key (id_bast_dana);

-- ----------------------------
-- Uniques structure for table TBL_BAST_DANA
-- ----------------------------
alter table nr_csr.tbl_bast_dana add constraint tbl_bast_dana_uk1 unique (no_agenda);
-- ----------------------------
-- Checks structure for table TBL_BAST_DANA
-- ----------------------------
alter table nr_csr.tbl_bast_dana alter column id_bast_dana set not null;
-- ----------------------------
-- Triggers structure for table TBL_BAST_DANA
-- ----------------------------
create or replace function nr_csr.id_bast_dana_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_bast_dana is null then
    new.id_bast_dana := nextval('"NR_CSR"."ID_BAST_DANA_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_bast_dana_trig on nr_csr.tbl_bast_dana;
create trigger id_bast_dana_trig before insert on nr_csr.tbl_bast_dana
for each row execute function nr_csr.id_bast_dana_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_CITY
-- ----------------------------
alter table nr_csr.tbl_city alter column id_city set not null;
-- ----------------------------
-- Triggers structure for table TBL_CITY
-- ----------------------------
create or replace function nr_csr.tbl_city_id_city_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_city is null then
    new.id_city := nextval('"NR_CSR"."TBL_CITY_ID_CITY_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_city_id_city_trig on nr_csr.tbl_city;
create trigger tbl_city_id_city_trig before insert or update on nr_csr.tbl_city
for each row execute function nr_csr.tbl_city_id_city_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_DETAIL_APPROVAL
-- ----------------------------
alter table nr_csr.tbl_detail_approval add constraint sys_c002597877 primary key (id);

-- ----------------------------
-- Triggers structure for table TBL_DETAIL_APPROVAL
-- ----------------------------
create or replace function nr_csr.trg_detail_approval_id__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id is null then
    new.id := nextval('"NR_CSR"."SEQ_DETAIL_APPROVAL_ID"');
  end if;
  return new;
end;
$$;

drop trigger if exists trg_detail_approval_id on nr_csr.tbl_detail_approval;
create trigger trg_detail_approval_id before insert on nr_csr.tbl_detail_approval
for each row execute function nr_csr.trg_detail_approval_id__fn();

-- ----------------------------
-- Primary Key structure for table TBL_DETAIL_KRITERIA
-- ----------------------------
alter table nr_csr.tbl_detail_kriteria add constraint sys_c002597880 primary key (id_detail_kriteria);

-- ----------------------------
-- Checks structure for table TBL_DETAIL_KRITERIA
-- ----------------------------
alter table nr_csr.tbl_detail_kriteria alter column id_detail_kriteria set not null;
-- ----------------------------
-- Triggers structure for table TBL_DETAIL_KRITERIA
-- ----------------------------
create or replace function nr_csr.tbl_detail_kriteria_id_de_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_detail_kriteria is null then
    new.id_detail_kriteria := nextval('"NR_CSR"."TBL_DETAIL_KRITERIA_ID_DET_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_detail_kriteria_id_de_trig on nr_csr.tbl_detail_kriteria;
create trigger tbl_detail_kriteria_id_de_trig before insert or update on nr_csr.tbl_detail_kriteria
for each row execute function nr_csr.tbl_detail_kriteria_id_de_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_DETAIL_SPK
-- ----------------------------
alter table nr_csr.tbl_detail_spk add constraint tbl_detail_spk_pk primary key (id_detail_spk);

-- ----------------------------
-- Checks structure for table TBL_DETAIL_SPK
-- ----------------------------
alter table nr_csr.tbl_detail_spk alter column id_detail_spk set not null;
-- ----------------------------
-- Triggers structure for table TBL_DETAIL_SPK
-- ----------------------------
create or replace function nr_csr.id_detail_spk_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_detail_spk is null then
    new.id_detail_spk := nextval('"NR_CSR"."ID_DETAIL_SPK"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_detail_spk_trig on nr_csr.tbl_detail_spk;
create trigger id_detail_spk_trig before insert on nr_csr.tbl_detail_spk
for each row execute function nr_csr.id_detail_spk_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_DOKUMEN
-- ----------------------------
alter table nr_csr.tbl_dokumen add constraint sys_c002586878 primary key (id);

-- ----------------------------
-- Triggers structure for table TBL_DOKUMEN
-- ----------------------------
create or replace function nr_csr.trg_dokumen_id__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id is null then
    new.id := nextval('"NR_CSR"."SEQ_DOKUMEN_ID"');
  end if;
  return new;
end;
$$;

drop trigger if exists trg_dokumen_id on nr_csr.tbl_dokumen;
create trigger trg_dokumen_id before insert on nr_csr.tbl_dokumen
for each row execute function nr_csr.trg_dokumen_id__fn();

-- ----------------------------
-- Primary Key structure for table TBL_DOKUMEN_MANDATORI_PROYEK
-- ----------------------------
alter table nr_csr.tbl_dokumen_mandatori_proyek add constraint sys_c002172827 primary key (dokumen_id);

-- ----------------------------
-- Triggers structure for table TBL_DOKUMEN_MANDATORI_PROYEK
-- ----------------------------
create or replace function nr_csr.dokumen_mandatori_proyek_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.dokumen_id is null then
    new.dokumen_id := nextval('"NR_CSR"."DOKUMEN_MANDATORI_PROYEK_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists dokumen_mandatori_proyek_trig on nr_csr.tbl_dokumen_mandatori_proyek;
create trigger dokumen_mandatori_proyek_trig before insert on nr_csr.tbl_dokumen_mandatori_proyek
for each row execute function nr_csr.dokumen_mandatori_proyek_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_DOKUMEN_MANDATORI_VENDOR
-- ----------------------------
alter table nr_csr.tbl_dokumen_mandatori_vendor add constraint sys_c002165428 primary key (dokumen_id);

-- ----------------------------
-- Triggers structure for table TBL_DOKUMEN_MANDATORI_VENDOR
-- ----------------------------
create or replace function nr_csr.dokumen_mandatori_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.dokumen_id is null then
    new.dokumen_id := nextval('"NR_CSR"."DOKUMEN_MANDATORI_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists dokumen_mandatori_trig on nr_csr.tbl_dokumen_mandatori_vendor;
create trigger dokumen_mandatori_trig before insert on nr_csr.tbl_dokumen_mandatori_vendor
for each row execute function nr_csr.dokumen_mandatori_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_DOKUMEN_VENDOR
-- ----------------------------
alter table nr_csr.tbl_dokumen_vendor add constraint sys_c002141352 primary key (dokumen_id);

-- ----------------------------
-- Triggers structure for table TBL_DOKUMEN_VENDOR
-- ----------------------------
create or replace function nr_csr.id_dok_vendor__fn()
returns trigger
language plpgsql
as $$
begin
  if new.dokumen_id is null then
    new.dokumen_id := nextval('"NR_CSR"."ID_DOK_VENDOR"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_dok_vendor on nr_csr.tbl_dokumen_vendor;
create trigger id_dok_vendor before insert on nr_csr.tbl_dokumen_vendor
for each row execute function nr_csr.id_dok_vendor__fn();

-- ----------------------------
-- Checks structure for table TBL_EVALUASI
-- ----------------------------
alter table nr_csr.tbl_evaluasi alter column id_evaluasi set not null;
-- ----------------------------
-- Triggers structure for table TBL_EVALUASI
-- ----------------------------
create or replace function nr_csr.tbl_evaluasi_id_evaluasi_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_evaluasi is null then
    new.id_evaluasi := nextval('"NR_CSR"."TBL_EVALUASI_ID_EVALUASI_SEQ"');
  end if;
  new.create_date := now();
  new.approve_date := now();
  return new;
end;
$$;

drop trigger if exists tbl_evaluasi_id_evaluasi_trig on nr_csr.tbl_evaluasi;
create trigger tbl_evaluasi_id_evaluasi_trig before insert or update on nr_csr.tbl_evaluasi
for each row execute function nr_csr.tbl_evaluasi_id_evaluasi_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_EXCEPTION
-- ----------------------------
alter table nr_csr.tbl_exception add constraint sys_c001319167 primary key (error_id);

-- ----------------------------
-- Triggers structure for table TBL_EXCEPTION
-- ----------------------------
create or replace function nr_csr.id_error__fn()
returns trigger
language plpgsql
as $$
begin
  if new.error_id is null then
    new.error_id := nextval('"NR_CSR"."ID_ERROR"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_error on nr_csr.tbl_exception;
create trigger id_error before insert on nr_csr.tbl_exception
for each row execute function nr_csr.id_error__fn();

-- ----------------------------
-- Primary Key structure for table TBL_HIRARKI
-- ----------------------------
alter table nr_csr.tbl_hirarki add constraint sys_c002581243 primary key (id);

-- ----------------------------
-- Triggers structure for table TBL_HIRARKI
-- ----------------------------
create or replace function nr_csr.trg_hirarki_id__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id is null then
    new.id := nextval('"NR_CSR"."SEQ_HIRARKI_ID"');
  end if;
  return new;
end;
$$;

drop trigger if exists trg_hirarki_id on nr_csr.tbl_hirarki;
create trigger trg_hirarki_id before insert on nr_csr.tbl_hirarki
for each row execute function nr_csr.trg_hirarki_id__fn();

-- ----------------------------
-- Primary Key structure for table TBL_IZIN_USAHA
-- ----------------------------
alter table nr_csr.tbl_izin_usaha add constraint sys_c002161794 primary key (izin_usaha_id);

-- ----------------------------
-- Triggers structure for table TBL_IZIN_USAHA
-- ----------------------------
create or replace function nr_csr.izin_usaha_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.izin_usaha_id is null then
    new.izin_usaha_id := nextval('"NR_CSR"."IZIN_USAHA_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists izin_usaha_trig on nr_csr.tbl_izin_usaha;
create trigger izin_usaha_trig before insert on nr_csr.tbl_izin_usaha
for each row execute function nr_csr.izin_usaha_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_KEBIJAKAN
-- ----------------------------
alter table nr_csr.tbl_kebijakan add constraint tbl_kebijakan_pk primary key (id_kebijakan);

-- ----------------------------
-- Checks structure for table TBL_KEBIJAKAN
-- ----------------------------
alter table nr_csr.tbl_kebijakan alter column id_kebijakan set not null;
-- ----------------------------
-- Triggers structure for table TBL_KEBIJAKAN
-- ----------------------------
create or replace function nr_csr.id_kebijakan_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_kebijakan is null then
    new.id_kebijakan := nextval('"NR_CSR"."ID_KEBIJAKAN_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_kebijakan_trig on nr_csr.tbl_kebijakan;
create trigger id_kebijakan_trig before insert on nr_csr.tbl_kebijakan
for each row execute function nr_csr.id_kebijakan_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_KELAYAKAN
-- ----------------------------
alter table nr_csr.tbl_kelayakan add constraint sys_c002001360 primary key (id_kelayakan);

-- ----------------------------
-- Uniques structure for table TBL_KELAYAKAN
-- ----------------------------
alter table nr_csr.tbl_kelayakan add constraint tbl_kelayakan_uk1 unique (no_agenda);
-- ----------------------------
-- Checks structure for table TBL_KELAYAKAN
-- ----------------------------
alter table nr_csr.tbl_kelayakan alter column id_kelayakan set not null;
-- ----------------------------
-- Triggers structure for table TBL_KELAYAKAN
-- ----------------------------
create or replace function nr_csr.tbl_kelayakan_id_kelayaka_trig__fn()
returns trigger
language plpgsql
as $$
begin
  new.create_date := now();
  return new;
end;
$$;

drop trigger if exists tbl_kelayakan_id_kelayaka_trig on nr_csr.tbl_kelayakan;
create trigger tbl_kelayakan_id_kelayaka_trig before insert or update on nr_csr.tbl_kelayakan
for each row execute function nr_csr.tbl_kelayakan_id_kelayaka_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_KTP_PENGURUS
-- ----------------------------
alter table nr_csr.tbl_ktp_pengurus add constraint sys_c002141437 primary key (ktp_id);

-- ----------------------------
-- Triggers structure for table TBL_KTP_PENGURUS
-- ----------------------------
create or replace function nr_csr.ktp_pengurus_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.ktp_id is null then
    new.ktp_id := nextval('"NR_CSR"."KTP_PENGURUS_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists ktp_pengurus_trig on nr_csr.tbl_ktp_pengurus;
create trigger ktp_pengurus_trig before insert on nr_csr.tbl_ktp_pengurus
for each row execute function nr_csr.ktp_pengurus_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_LAMPIRAN
-- ----------------------------
alter table nr_csr.tbl_lampiran alter column id_lampiran set not null;
-- ----------------------------
-- Triggers structure for table TBL_LAMPIRAN
-- ----------------------------
create or replace function nr_csr.tbl_lampiran_id_lampiran_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_lampiran is null then
    new.id_lampiran := nextval('"NR_CSR"."TBL_LAMPIRAN_ID_LAMPIRAN_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_lampiran_id_lampiran_trig on nr_csr.tbl_lampiran;
create trigger tbl_lampiran_id_lampiran_trig before insert or update on nr_csr.tbl_lampiran
for each row execute function nr_csr.tbl_lampiran_id_lampiran_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LAMPIRAN_AP
-- ----------------------------
alter table nr_csr.tbl_lampiran_ap add constraint sys_c001388084 primary key (id_lampiran);

-- ----------------------------
-- Checks structure for table TBL_LAMPIRAN_AP
-- ----------------------------
alter table nr_csr.tbl_lampiran_ap alter column id_lampiran set not null;
-- ----------------------------
-- Triggers structure for table TBL_LAMPIRAN_AP
-- ----------------------------
create or replace function nr_csr.id_lampiran_ap__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_lampiran is null then
    new.id_lampiran := nextval('"NR_CSR"."ID_LAMPIRAN_AP"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_lampiran_ap on nr_csr.tbl_lampiran_ap;
create trigger id_lampiran_ap before insert on nr_csr.tbl_lampiran_ap
for each row execute function nr_csr.id_lampiran_ap__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LAMPIRAN_PEKERJAAN
-- ----------------------------
alter table nr_csr.tbl_lampiran_pekerjaan add constraint sys_c002171003 primary key (lampiran_id);

-- ----------------------------
-- Checks structure for table TBL_LAMPIRAN_PEKERJAAN
-- ----------------------------
alter table nr_csr.tbl_lampiran_pekerjaan alter column lampiran_id set not null;
-- ----------------------------
-- Triggers structure for table TBL_LAMPIRAN_PEKERJAAN
-- ----------------------------
create or replace function nr_csr.lampiran_pekerjaan_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.lampiran_id is null then
    new.lampiran_id := nextval('"NR_CSR"."LAMPIRAN_PEKERJAAN_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists lampiran_pekerjaan_trig on nr_csr.tbl_lampiran_pekerjaan;
create trigger lampiran_pekerjaan_trig before insert on nr_csr.tbl_lampiran_pekerjaan
for each row execute function nr_csr.lampiran_pekerjaan_trig__fn();

create or replace function nr_csr.lampiran_vendor_trig_copy1__fn()
returns trigger
language plpgsql
as $$
begin
  if new.lampiran_id is null then
    new.lampiran_id := nextval('"NR_CSR"."ID_LAMPIRAN_VENDOR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists lampiran_vendor_trig_copy1 on nr_csr.tbl_lampiran_pekerjaan;
create trigger lampiran_vendor_trig_copy1 before insert on nr_csr.tbl_lampiran_pekerjaan
for each row execute function nr_csr.lampiran_vendor_trig_copy1__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LAMPIRAN_VENDOR
-- ----------------------------
alter table nr_csr.tbl_lampiran_vendor add constraint sys_c002141351 primary key (lampiran_id);

-- ----------------------------
-- Triggers structure for table TBL_LAMPIRAN_VENDOR
-- ----------------------------
create or replace function nr_csr.lampiran_vendor_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.lampiran_id is null then
    new.lampiran_id := nextval('"NR_CSR"."ID_LAMPIRAN_VENDOR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists lampiran_vendor_trig on nr_csr.tbl_lampiran_vendor;
create trigger lampiran_vendor_trig before insert on nr_csr.tbl_lampiran_vendor
for each row execute function nr_csr.lampiran_vendor_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LEMBAGA
-- ----------------------------
alter table nr_csr.tbl_lembaga add constraint sys_c001237315 primary key (id_lembaga);

-- ----------------------------
-- Triggers structure for table TBL_LEMBAGA
-- ----------------------------
create or replace function nr_csr.id_lembaga_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_lembaga is null then
    new.id_lembaga := nextval('"NR_CSR"."ID_LEMBAGA_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_lembaga_trig on nr_csr.tbl_lembaga;
create trigger id_lembaga_trig before insert on nr_csr.tbl_lembaga
for each row execute function nr_csr.id_lembaga_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LEVEL_HIRARKI
-- ----------------------------
alter table nr_csr.tbl_level_hirarki add constraint sys_c002581245 primary key (id);

-- ----------------------------
-- Triggers structure for table TBL_LEVEL_HIRARKI
-- ----------------------------
create or replace function nr_csr.trg_level_hirarki_id__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id is null then
    new.id := nextval('"NR_CSR"."SEQ_LEVEL_HIRARKI_ID"');
  end if;
  return new;
end;
$$;

drop trigger if exists trg_level_hirarki_id on nr_csr.tbl_level_hirarki;
create trigger trg_level_hirarki_id before insert on nr_csr.tbl_level_hirarki
for each row execute function nr_csr.trg_level_hirarki_id__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LOG
-- ----------------------------
alter table nr_csr.tbl_log add constraint tbl_log_pk primary key (id);

-- ----------------------------
-- Checks structure for table TBL_LOG
-- ----------------------------
alter table nr_csr.tbl_log alter column id set not null;
-- ----------------------------
-- Triggers structure for table TBL_LOG
-- ----------------------------
create or replace function nr_csr.trg_log_id__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id is null then
    new.id := nextval('"NR_CSR"."ID_LOG_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists trg_log_id on nr_csr.tbl_log;
create trigger trg_log_id before insert on nr_csr.tbl_log
for each row execute function nr_csr.trg_log_id__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LOG_PEKERJAAN
-- ----------------------------
alter table nr_csr.tbl_log_pekerjaan add constraint sys_c002171005 primary key (log_id);

-- ----------------------------
-- Checks structure for table TBL_LOG_PEKERJAAN
-- ----------------------------
alter table nr_csr.tbl_log_pekerjaan alter column log_id set not null;
-- ----------------------------
-- Triggers structure for table TBL_LOG_PEKERJAAN
-- ----------------------------
create or replace function nr_csr.log_pekerjaan_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.log_id is null then
    new.log_id := nextval('"NR_CSR"."LOG_PEKERJAAN_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists log_pekerjaan_trig on nr_csr.tbl_log_pekerjaan;
create trigger log_pekerjaan_trig before insert on nr_csr.tbl_log_pekerjaan
for each row execute function nr_csr.log_pekerjaan_trig__fn();

create or replace function nr_csr.log_vendor_trig_copy1__fn()
returns trigger
language plpgsql
as $$
begin
  if new.log_id is null then
    new.log_id := nextval('"NR_CSR"."LOG_VENDOR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists log_vendor_trig_copy1 on nr_csr.tbl_log_pekerjaan;
create trigger log_vendor_trig_copy1 before insert on nr_csr.tbl_log_pekerjaan
for each row execute function nr_csr.log_vendor_trig_copy1__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LOG_RELOKASI
-- ----------------------------
alter table nr_csr.tbl_log_relokasi add constraint sys_c001356432 primary key (id_log);

-- ----------------------------
-- Checks structure for table TBL_LOG_RELOKASI
-- ----------------------------
alter table nr_csr.tbl_log_relokasi alter column id_log set not null;
-- ----------------------------
-- Triggers structure for table TBL_LOG_RELOKASI
-- ----------------------------
create or replace function nr_csr.id_log_relokasi_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_log is null then
    new.id_log := nextval('"NR_CSR"."ID_LOG_RELOKASI_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_log_relokasi_trig on nr_csr.tbl_log_relokasi;
create trigger id_log_relokasi_trig before insert on nr_csr.tbl_log_relokasi
for each row execute function nr_csr.id_log_relokasi_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_LOG_VENDOR
-- ----------------------------
alter table nr_csr.tbl_log_vendor add constraint sys_c002141355 primary key (log_id);

-- ----------------------------
-- Triggers structure for table TBL_LOG_VENDOR
-- ----------------------------
create or replace function nr_csr.log_vendor_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.log_id is null then
    new.log_id := nextval('"NR_CSR"."LOG_VENDOR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists log_vendor_trig on nr_csr.tbl_log_vendor;
create trigger log_vendor_trig before insert on nr_csr.tbl_log_vendor
for each row execute function nr_csr.log_vendor_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_PEJABAT
-- ----------------------------
alter table nr_csr.tbl_pejabat add constraint sys_c002616462 primary key (id);

-- ----------------------------
-- Triggers structure for table TBL_PEJABAT
-- ----------------------------
create or replace function nr_csr.trg_pejabat_id__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id is null then
    new.id := nextval('"NR_CSR"."SEQ_PEJABAT_ID"');
  end if;
  return new;
end;
$$;

drop trigger if exists trg_pejabat_id on nr_csr.tbl_pejabat;
create trigger trg_pejabat_id before insert on nr_csr.tbl_pejabat
for each row execute function nr_csr.trg_pejabat_id__fn();

-- ----------------------------
-- Primary Key structure for table TBL_PEKERJAAN
-- ----------------------------
alter table nr_csr.tbl_pekerjaan add constraint sys_c002167335 primary key (pekerjaan_id);

-- ----------------------------
-- Triggers structure for table TBL_PEKERJAAN
-- ----------------------------
create or replace function nr_csr.pekerjaan_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.pekerjaan_id is null then
    new.pekerjaan_id := nextval('"NR_CSR"."PEKERJAAN_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists pekerjaan_trig on nr_csr.tbl_pekerjaan;
create trigger pekerjaan_trig before insert on nr_csr.tbl_pekerjaan
for each row execute function nr_csr.pekerjaan_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_PEMBAYARAN
-- ----------------------------
alter table nr_csr.tbl_pembayaran alter column id_pembayaran set not null;
-- ----------------------------
-- Triggers structure for table TBL_PEMBAYARAN
-- ----------------------------
create or replace function nr_csr.tbl_pembayaran_id_pembaya_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_pembayaran is null then
    new.id_pembayaran := nextval('"NR_CSR"."TBL_PEMBAYARAN_ID_PEMBAYAR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_pembayaran_id_pembaya_trig on nr_csr.tbl_pembayaran;
create trigger tbl_pembayaran_id_pembaya_trig before insert or update on nr_csr.tbl_pembayaran
for each row execute function nr_csr.tbl_pembayaran_id_pembaya_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_PEMBAYARAN_VENDOR
-- ----------------------------
alter table nr_csr.tbl_pembayaran_vendor alter column id_pembayaran set not null;
alter table nr_csr.tbl_pembayaran_vendor alter column id_pembayaran set not null;
-- ----------------------------
-- Triggers structure for table TBL_PEMBAYARAN_VENDOR
-- ----------------------------
create or replace function nr_csr.pembayaran_vendor_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_pembayaran is null then
    new.id_pembayaran := nextval('"NR_CSR"."PEMBAYARAN_VENDOR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists pembayaran_vendor_trig on nr_csr.tbl_pembayaran_vendor;
create trigger pembayaran_vendor_trig before insert on nr_csr.tbl_pembayaran_vendor
for each row execute function nr_csr.pembayaran_vendor_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_PEMBAYARAN_copy1
-- ----------------------------
alter table nr_csr.tbl_pembayaran_copy1 alter column id_pembayaran set not null;
alter table nr_csr.tbl_pembayaran_copy1 alter column id_pembayaran set not null;
-- ----------------------------
-- Triggers structure for table TBL_PEMBAYARAN_copy1
-- ----------------------------
create or replace function nr_csr.tbl_pembayaran_id_pembaya_trig_copy1__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_pembayaran is null then
    new.id_pembayaran := nextval('"NR_CSR"."TBL_PEMBAYARAN_ID_PEMBAYAR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_pembayaran_id_pembaya_trig_copy1 on nr_csr.tbl_pembayaran_copy1;
create trigger tbl_pembayaran_id_pembaya_trig_copy1 before insert or update on nr_csr.tbl_pembayaran_copy1
for each row execute function nr_csr.tbl_pembayaran_id_pembaya_trig_copy1__fn();

-- ----------------------------
-- Primary Key structure for table TBL_PENGALAMAN_KERJA
-- ----------------------------
alter table nr_csr.tbl_pengalaman_kerja add constraint sys_c002163610 primary key (pengalaman_id);

-- ----------------------------
-- Triggers structure for table TBL_PENGALAMAN_KERJA
-- ----------------------------
create or replace function nr_csr.pengalaman_kerja_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.pengalaman_id is null then
    new.pengalaman_id := nextval('"NR_CSR"."PENGALAMAN_KERJA_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists pengalaman_kerja_trig on nr_csr.tbl_pengalaman_kerja;
create trigger pengalaman_kerja_trig before insert on nr_csr.tbl_pengalaman_kerja
for each row execute function nr_csr.pengalaman_kerja_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_PENGEMBALIAN_ANGGARAN
-- ----------------------------
alter table nr_csr.tbl_pengembalian_anggaran add constraint sys_c002465143 primary key (id);

-- ----------------------------
-- Triggers structure for table TBL_PENGEMBALIAN_ANGGARAN
-- ----------------------------
create or replace function nr_csr.id_co_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id is null then
    new.id := nextval('"NR_CSR"."ID_CO_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_co_trig on nr_csr.tbl_pengembalian_anggaran;
create trigger id_co_trig before insert on nr_csr.tbl_pengembalian_anggaran
for each row execute function nr_csr.id_co_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_PENGIRIM
-- ----------------------------
alter table nr_csr.tbl_pengirim add constraint sys_c002579424 primary key (id_pengirim);

-- ----------------------------
-- Checks structure for table TBL_PENGIRIM
-- ----------------------------
alter table nr_csr.tbl_pengirim alter column id_pengirim set not null;
-- ----------------------------
-- Triggers structure for table TBL_PENGIRIM
-- ----------------------------
create or replace function nr_csr.tbl_pengirim_id_pengirim_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_pengirim is null then
    new.id_pengirim := nextval('"NR_CSR"."TBL_PENGIRIM_ID_PENGIRIM_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_pengirim_id_pengirim_trig on nr_csr.tbl_pengirim;
create trigger tbl_pengirim_id_pengirim_trig before insert or update on nr_csr.tbl_pengirim
for each row execute function nr_csr.tbl_pengirim_id_pengirim_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_PERUSAHAAN
-- ----------------------------
alter table nr_csr.tbl_perusahaan add constraint sys_c001352957 primary key (id_perusahaan);

-- ----------------------------
-- Triggers structure for table TBL_PERUSAHAAN
-- ----------------------------
create or replace function nr_csr.id_perusahaan_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_perusahaan is null then
    new.id_perusahaan := nextval('"NR_CSR"."ID_PERUSAHAAN_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_perusahaan_trig on nr_csr.tbl_perusahaan;
create trigger id_perusahaan_trig before insert on nr_csr.tbl_perusahaan
for each row execute function nr_csr.id_perusahaan_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_PILAR
-- ----------------------------
alter table nr_csr.tbl_pilar add constraint sys_c0015585991 primary key (id_pilar);

-- ----------------------------
-- Checks structure for table TBL_PILAR
-- ----------------------------
alter table nr_csr.tbl_pilar alter column id_pilar set not null;
alter table nr_csr.tbl_pilar alter column id_pilar set not null;
-- ----------------------------
-- Triggers structure for table TBL_PILAR
-- ----------------------------
create or replace function nr_csr.id_pilar_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_pilar is null then
    new.id_pilar := nextval('"NR_CSR"."ID_PILAR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_pilar_trig on nr_csr.tbl_pilar;
create trigger id_pilar_trig before insert on nr_csr.tbl_pilar
for each row execute function nr_csr.id_pilar_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_PROKER
-- ----------------------------
alter table nr_csr.tbl_proker add constraint tbl_proker_pk primary key (id_proker);

-- ----------------------------
-- Checks structure for table TBL_PROKER
-- ----------------------------
alter table nr_csr.tbl_proker alter column id_proker set not null;
alter table nr_csr.tbl_proker alter column id_proker set not null;
-- ----------------------------
-- Triggers structure for table TBL_PROKER
-- ----------------------------
create or replace function nr_csr.id_proker_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_proker is null then
    new.id_proker := nextval('"NR_CSR"."ID_PROKER_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_proker_trig on nr_csr.tbl_proker;
create trigger id_proker_trig before insert on nr_csr.tbl_proker
for each row execute function nr_csr.id_proker_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_PROVINSI
-- ----------------------------
alter table nr_csr.tbl_provinsi alter column id_provinsi set not null;
-- ----------------------------
-- Triggers structure for table TBL_PROVINSI
-- ----------------------------
create or replace function nr_csr.tbl_provinsi_id_provinsi_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_provinsi is null then
    new.id_provinsi := nextval('"NR_CSR"."TBL_PROVINSI_ID_PROVINSI_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_provinsi_id_provinsi_trig on nr_csr.tbl_provinsi;
create trigger tbl_provinsi_id_provinsi_trig before insert or update on nr_csr.tbl_provinsi
for each row execute function nr_csr.tbl_provinsi_id_provinsi_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_REALISASI_AP
-- ----------------------------
alter table nr_csr.tbl_realisasi_ap add constraint sys_c001386382 primary key (id_realisasi);

-- ----------------------------
-- Triggers structure for table TBL_REALISASI_AP
-- ----------------------------
create or replace function nr_csr.id_realisasi_ap_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_realisasi is null then
    new.id_realisasi := nextval('"NR_CSR"."ID_REALISASI_AP"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_realisasi_ap_trig on nr_csr.tbl_realisasi_ap;
create trigger id_realisasi_ap_trig before insert on nr_csr.tbl_realisasi_ap
for each row execute function nr_csr.id_realisasi_ap_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_RELOKASI
-- ----------------------------
alter table nr_csr.tbl_relokasi add constraint sys_c001356429 primary key (id_relokasi);

-- ----------------------------
-- Triggers structure for table TBL_RELOKASI
-- ----------------------------
create or replace function nr_csr.id_relokasi_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_relokasi is null then
    new.id_relokasi := nextval('"NR_CSR"."ID_RELOKASI_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_relokasi_trig on nr_csr.tbl_relokasi;
create trigger id_relokasi_trig before insert on nr_csr.tbl_relokasi
for each row execute function nr_csr.id_relokasi_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_ROLE
-- ----------------------------
alter table nr_csr.tbl_role alter column id_role set not null;
alter table nr_csr.tbl_role alter column role set not null;
-- ----------------------------
-- Triggers structure for table TBL_ROLE
-- ----------------------------
create or replace function nr_csr.tbl_role_id_role_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_role is null then
    new.id_role := nextval('"NR_CSR"."TBL_ROLE_ID_ROLE_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_role_id_role_trig on nr_csr.tbl_role;
create trigger tbl_role_id_role_trig before insert or update on nr_csr.tbl_role
for each row execute function nr_csr.tbl_role_id_role_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_SDG
-- ----------------------------
alter table nr_csr.tbl_sdg add constraint sys_c0015585989 primary key (id_sdg);

-- ----------------------------
-- Checks structure for table TBL_SDG
-- ----------------------------
alter table nr_csr.tbl_sdg alter column id_sdg set not null;
alter table nr_csr.tbl_sdg alter column id_sdg set not null;
-- ----------------------------
-- Triggers structure for table TBL_SDG
-- ----------------------------
create or replace function nr_csr.id_sdg_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_sdg is null then
    new.id_sdg := nextval('"NR_CSR"."ID_SDG_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_sdg_trig on nr_csr.tbl_sdg;
create trigger id_sdg_trig before insert on nr_csr.tbl_sdg
for each row execute function nr_csr.id_sdg_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_SEKTOR
-- ----------------------------
alter table nr_csr.tbl_sektor add constraint tbl_sektor_pk primary key (id_sektor);

-- ----------------------------
-- Uniques structure for table TBL_SEKTOR
-- ----------------------------
alter table nr_csr.tbl_sektor add constraint tbl_sektor_uk1 unique (kode_sektor);
-- ----------------------------
-- Checks structure for table TBL_SEKTOR
-- ----------------------------
alter table nr_csr.tbl_sektor alter column id_sektor set not null;
alter table nr_csr.tbl_sektor alter column id_sektor set not null;
-- ----------------------------
-- Triggers structure for table TBL_SEKTOR
-- ----------------------------
create or replace function nr_csr.tbl_sektor_id_sektor_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_sektor is null then
    new.id_sektor := nextval('"NR_CSR"."TBL_SEKTOR_ID_SEKTOR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_sektor_id_sektor_trig on nr_csr.tbl_sektor;
create trigger tbl_sektor_id_sektor_trig before insert or update on nr_csr.tbl_sektor
for each row execute function nr_csr.tbl_sektor_id_sektor_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_SPH
-- ----------------------------
alter table nr_csr.tbl_sph add constraint sys_c002172825 primary key (sph_id);

-- ----------------------------
-- Checks structure for table TBL_SPH
-- ----------------------------
alter table nr_csr.tbl_sph alter column sph_id set not null;
-- ----------------------------
-- Indexes structure for table TBL_SPH
-- ----------------------------
create unique index nr_csr.no_sph
  on nr_csr.tbl_sph (nomor asc);
-- ----------------------------
-- Triggers structure for table TBL_SPH
-- ----------------------------
create or replace function nr_csr.sph_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.sph_id is null then
    new.sph_id := nextval('"NR_CSR"."SPH_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists sph_trig on nr_csr.tbl_sph;
create trigger sph_trig before insert on nr_csr.tbl_sph
for each row execute function nr_csr.sph_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_SPK
-- ----------------------------
alter table nr_csr.tbl_spk add constraint sys_c002172822 primary key (spk_id);

-- ----------------------------
-- Checks structure for table TBL_SPK
-- ----------------------------
alter table nr_csr.tbl_spk alter column spk_id set not null;
-- ----------------------------
-- Triggers structure for table TBL_SPK
-- ----------------------------
create or replace function nr_csr.spk_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.spk_id is null then
    new.spk_id := nextval('"NR_CSR"."ID_SPK_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists spk_trig on nr_csr.tbl_spk;
create trigger spk_trig before insert on nr_csr.tbl_spk
for each row execute function nr_csr.spk_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_SPPH
-- ----------------------------
alter table nr_csr.tbl_spph add constraint sys_c002139512 primary key (spph_id);

-- ----------------------------
-- Indexes structure for table TBL_SPPH
-- ----------------------------
create unique index nr_csr.no_spph
  on nr_csr.tbl_spph (nomor asc);
-- ----------------------------
-- Triggers structure for table TBL_SPPH
-- ----------------------------
create or replace function nr_csr.id_spph_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.spph_id is null then
    new.spph_id := nextval('"NR_CSR"."ID_SPPH_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_spph_trig on nr_csr.tbl_spph;
create trigger id_spph_trig before insert on nr_csr.tbl_spph
for each row execute function nr_csr.id_spph_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_SUB_PILAR
-- ----------------------------
alter table nr_csr.tbl_sub_pilar add constraint sys_c0015585993 primary key (id_sub_pilar);

-- ----------------------------
-- Checks structure for table TBL_SUB_PILAR
-- ----------------------------
alter table nr_csr.tbl_sub_pilar alter column id_sub_pilar set not null;
alter table nr_csr.tbl_sub_pilar alter column id_sub_pilar set not null;
-- ----------------------------
-- Triggers structure for table TBL_SUB_PILAR
-- ----------------------------
create or replace function nr_csr.id_sub_pilar_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_sub_pilar is null then
    new.id_sub_pilar := nextval('"NR_CSR"."ID_SUB_PILAR_SDG"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_sub_pilar_trig on nr_csr.tbl_sub_pilar;
create trigger id_sub_pilar_trig before insert on nr_csr.tbl_sub_pilar
for each row execute function nr_csr.id_sub_pilar_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_SUB_PROPOSAL
-- ----------------------------
alter table nr_csr.tbl_sub_proposal add constraint sys_c0015579351 primary key (id_sub_proposal);

-- ----------------------------
-- Checks structure for table TBL_SUB_PROPOSAL
-- ----------------------------
alter table nr_csr.tbl_sub_proposal alter column id_sub_proposal set not null;
-- ----------------------------
-- Triggers structure for table TBL_SUB_PROPOSAL
-- ----------------------------
create or replace function nr_csr.id_sub_proposal_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_sub_proposal is null then
    new.id_sub_proposal := nextval('"NR_CSR"."ID_SUB_PROPOSAL"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_sub_proposal_trig on nr_csr.tbl_sub_proposal;
create trigger id_sub_proposal_trig before insert on nr_csr.tbl_sub_proposal
for each row execute function nr_csr.id_sub_proposal_trig__fn();

-- ----------------------------
-- Checks structure for table TBL_SURVEI
-- ----------------------------
alter table nr_csr.tbl_survei alter column id_survei set not null;
-- ----------------------------
-- Triggers structure for table TBL_SURVEI
-- ----------------------------
create or replace function nr_csr.tbl_survei_id_survei_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_survei is null then
    new.id_survei := nextval('"NR_CSR"."TBL_SURVEI_ID_SURVEI_SEQ"');
  end if;
  new.create_date := now();
  return new;
end;
$$;

drop trigger if exists tbl_survei_id_survei_trig on nr_csr.tbl_survei;
create trigger tbl_survei_id_survei_trig before insert or update on nr_csr.tbl_survei
for each row execute function nr_csr.tbl_survei_id_survei_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_USER
-- ----------------------------
alter table nr_csr.tbl_user add constraint tbl_user_pk primary key (id_user);

-- ----------------------------
-- Uniques structure for table TBL_USER
-- ----------------------------
alter table nr_csr.tbl_user add constraint tbl_user_uk1 unique (username);
alter table nr_csr.tbl_user add constraint tbl_user_uk2 unique (email);
-- ----------------------------
-- Checks structure for table TBL_USER
-- ----------------------------
alter table nr_csr.tbl_user alter column id_user set not null;
alter table nr_csr.tbl_user alter column username set not null;
alter table nr_csr.tbl_user alter column email set not null;
alter table nr_csr.tbl_user alter column nama set not null;
alter table nr_csr.tbl_user alter column jabatan set not null;
alter table nr_csr.tbl_user alter column password set not null;
alter table nr_csr.tbl_user alter column role set not null;
-- ----------------------------
-- Triggers structure for table TBL_USER
-- ----------------------------
create or replace function nr_csr.id_user_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_user is null then
    new.id_user := nextval('"NR_CSR"."T_USER_ID_USER_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_user_trig on nr_csr.tbl_user;
create trigger id_user_trig before insert on nr_csr.tbl_user
for each row execute function nr_csr.id_user_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_VENDOR
-- ----------------------------
alter table nr_csr.tbl_vendor add constraint tbl_vendor_pk primary key (vendor_id);

-- ----------------------------
-- Checks structure for table TBL_VENDOR
-- ----------------------------
alter table nr_csr.tbl_vendor alter column vendor_id set not null;
-- ----------------------------
-- Triggers structure for table TBL_VENDOR
-- ----------------------------
create or replace function nr_csr.id_vendor_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.vendor_id is null then
    new.vendor_id := nextval('"NR_CSR"."ID_VENDOR_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists id_vendor_trig on nr_csr.tbl_vendor;
create trigger id_vendor_trig before insert on nr_csr.tbl_vendor
for each row execute function nr_csr.id_vendor_trig__fn();

-- ----------------------------
-- Primary Key structure for table TBL_WILAYAH
-- ----------------------------
alter table nr_csr.tbl_wilayah add constraint sys_c002583062 primary key (id_wilayah);

-- ----------------------------
-- Checks structure for table TBL_WILAYAH
-- ----------------------------
alter table nr_csr.tbl_wilayah alter column id_wilayah set not null;
-- ----------------------------
-- Triggers structure for table TBL_WILAYAH
-- ----------------------------
create or replace function nr_csr.tbl_wilayah_id_wilayah_trig__fn()
returns trigger
language plpgsql
as $$
begin
  if new.id_wilayah is null then
    new.id_wilayah := nextval('"NR_CSR"."TBL_WILAYAH_ID_WILAYAH_SEQ"');
  end if;
  return new;
end;
$$;

drop trigger if exists tbl_wilayah_id_wilayah_trig on nr_csr.tbl_wilayah;
create trigger tbl_wilayah_id_wilayah_trig before insert or update on nr_csr.tbl_wilayah
for each row execute function nr_csr.tbl_wilayah_id_wilayah_trig__fn();

-- ----------------------------
-- Foreign Keys structure for table TBL_ANGGARAN
-- ----------------------------
alter table nr_csr.tbl_anggaran add constraint fk_id_perusahaan_anggaran foreign key (id_perusahaan);
-- ----------------------------
-- Foreign Keys structure for table TBL_BAST_DANA
-- ----------------------------
alter table nr_csr.tbl_bast_dana add constraint fk_id_approver foreign key (approver_id);
alter table nr_csr.tbl_bast_dana add constraint fk_id_kelayakan_bast foreign key (id_kelayakan);
-- ----------------------------
-- Foreign Keys structure for table TBL_DETAIL_APPROVAL
-- ----------------------------
alter table nr_csr.tbl_detail_approval add constraint fk_id_hirarki foreign key (id_hirarki);
alter table nr_csr.tbl_detail_approval add constraint fk_id_maker_log foreign key (created_by);
alter table nr_csr.tbl_detail_approval add constraint fk_id_user_approval foreign key (id_user);
-- ----------------------------
-- Foreign Keys structure for table TBL_EVALUASI
-- ----------------------------
alter table nr_csr.tbl_evaluasi add constraint fk_id_kelayakan_evaluasi foreign key (id_kelayakan);
alter table nr_csr.tbl_evaluasi add constraint fk_id_user_evaluasi foreign key (created_by);
-- ----------------------------
-- Foreign Keys structure for table TBL_HIRARKI
-- ----------------------------
alter table nr_csr.tbl_hirarki add constraint fk_hirarki_level foreign key (id_level);
alter table nr_csr.tbl_hirarki add constraint fk_hirarki_user foreign key (id_user);
-- ----------------------------
-- Foreign Keys structure for table TBL_KELAYAKAN
-- ----------------------------
alter table nr_csr.tbl_kelayakan add constraint fk_id_lembaga foreign key (id_lembaga);
alter table nr_csr.tbl_kelayakan add constraint fk_id_pengirim foreign key (id_pengirim);
alter table nr_csr.tbl_kelayakan add constraint fk_id_proker foreign key (id_proker);
alter table nr_csr.tbl_kelayakan add constraint fk_id_user foreign key (created_by);
-- ----------------------------
-- Foreign Keys structure for table TBL_LAMPIRAN
-- ----------------------------
alter table nr_csr.tbl_lampiran add constraint fk_lampiran_kelayakan foreign key (id_kelayakan);
alter table nr_csr.tbl_lampiran add constraint fk_maker_id foreign key (created_by);
-- ----------------------------
-- Foreign Keys structure for table TBL_LOG
-- ----------------------------
alter table nr_csr.tbl_log add constraint fk_created_by foreign key (created_by);
alter table nr_csr.tbl_log add constraint fk_id_kelayakan foreign key (id_kelayakan);
-- ----------------------------
-- Foreign Keys structure for table TBL_PEMBAYARAN
-- ----------------------------
alter table nr_csr.tbl_pembayaran add constraint fk_id_kelayakan_pembayaran foreign key (id_kelayakan);
-- ----------------------------
-- Foreign Keys structure for table TBL_PEMBAYARAN_copy1
-- ----------------------------
alter table nr_csr.tbl_pembayaran_copy1 add constraint sys_c002684983 foreign key (id_kelayakan);
-- ----------------------------
-- Foreign Keys structure for table TBL_PENGIRIM
-- ----------------------------
alter table nr_csr.tbl_pengirim add constraint fk_pengirim_perusahaan foreign key (id_perusahaan);
-- ----------------------------
-- Foreign Keys structure for table TBL_PERUSAHAAN
-- ----------------------------
alter table nr_csr.tbl_perusahaan add constraint fk_pic_user foreign key (pic);
-- ----------------------------
-- Foreign Keys structure for table TBL_SURVEI
-- ----------------------------
alter table nr_csr.tbl_survei add constraint fk_id_kelayakan_survei foreign key (id_kelayakan);
alter table nr_csr.tbl_survei add constraint fk_id_user_survei foreign key (created_by);
-- ----------------------------
-- Foreign Keys structure for table TBL_USER
-- ----------------------------
alter table nr_csr.tbl_user add constraint fk_id_perusahaan foreign key (id_perusahaan);
