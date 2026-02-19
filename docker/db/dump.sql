--
-- PostgreSQL database dump
--


-- Dumped from database version 16.11
-- Dumped by pg_dump version 16.11

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: NR_CSR; Type: SCHEMA; Schema: -; Owner: nrcsr_user
--

CREATE SCHEMA "NR_CSR";


ALTER SCHEMA "NR_CSR" OWNER TO nrcsr_user;

--
-- Name: NR_PAYMENT; Type: SCHEMA; Schema: -; Owner: nrcsr_user
--

CREATE SCHEMA "NR_PAYMENT";


ALTER SCHEMA "NR_PAYMENT" OWNER TO nrcsr_user;

--
-- Name: nr_csr; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA nr_csr;


ALTER SCHEMA nr_csr OWNER TO nrcsr_user;

--
-- Name: nr_payment; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA nr_payment;


ALTER SCHEMA nr_payment OWNER TO nrcsr_user;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: TBL_PEMBAYARAN_copy1; Type: TABLE; Schema: NR_CSR; Owner: nrcsr_user
--

CREATE TABLE "NR_CSR"."TBL_PEMBAYARAN_copy1" (
    id_pembayaran bigint NOT NULL,
    no_agenda character varying(50),
    no_bast character varying(50),
    no_ba character varying(50),
    termin character varying(2),
    nilai_approved numeric(18,2),
    persen character varying(3),
    status character varying(50),
    pr_id character varying(50),
    create_date timestamp(0) without time zone,
    create_by character varying(50),
    export_date timestamp(0) without time zone,
    export_by character varying(100),
    id_kelayakan bigint,
    deskripsi character varying(500),
    fee numeric(18,2),
    jumlah_pembayaran numeric(18,2),
    subtotal numeric(18,2),
    fee_persen numeric(18,2),
    status_ykpp character varying(255),
    approved_ykpp_by character varying(255),
    approved_ykpp_date timestamp(0) without time zone,
    submited_ykpp_by character varying(255),
    submited_ykpp_date timestamp(0) without time zone,
    no_surat_ykpp character varying(255),
    tgl_surat_ykpp character varying(255),
    surat_ykpp character varying(255),
    tahun_ykpp character varying(4),
    penyaluran_ke character varying(255),
    metode character varying(255)
);


ALTER TABLE "NR_CSR"."TBL_PEMBAYARAN_copy1" OWNER TO nrcsr_user;

--
-- Name: migrations; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE nr_csr.migrations OWNER TO nrcsr_user;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.migrations_id_seq OWNER TO nrcsr_user;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.migrations_id_seq OWNED BY nr_csr.migrations.id;


--
-- Name: no_agenda; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.no_agenda (
    tahun integer NOT NULL,
    last_no numeric(18,2) NOT NULL
);


ALTER TABLE nr_csr.no_agenda OWNER TO nrcsr_user;

--
-- Name: tbl_alokasi; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_alokasi (
    id_alokasi numeric(18,2),
    id_relokasi numeric(18,2),
    proker character varying(200),
    provinsi character varying(100),
    tahun character varying(4),
    nominal_alokasi numeric(18,2),
    sektor_bantuan character varying(100)
);


ALTER TABLE nr_csr.tbl_alokasi OWNER TO nrcsr_user;

--
-- Name: tbl_anggaran; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_anggaran (
    id_anggaran integer NOT NULL,
    nominal numeric(18,2),
    tahun character varying(4),
    perusahaan_old character varying(255),
    id_perusahaan integer,
    perusahaan character varying(255)
);


ALTER TABLE nr_csr.tbl_anggaran OWNER TO nrcsr_user;

--
-- Name: tbl_anggaran_id_anggaran_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_anggaran_id_anggaran_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_anggaran_id_anggaran_seq OWNER TO nrcsr_user;

--
-- Name: tbl_anggaran_id_anggaran_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_anggaran_id_anggaran_seq OWNED BY nr_csr.tbl_anggaran.id_anggaran;


--
-- Name: tbl_anggota; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_anggota (
    id_anggota integer NOT NULL,
    nama_anggota character varying(100),
    fraksi character varying(150),
    komisi character varying(10),
    jabatan character varying(100),
    staf_ahli character varying(100),
    no_telp character varying(20),
    foto_profile character varying(255),
    status character varying(10)
);


ALTER TABLE nr_csr.tbl_anggota OWNER TO nrcsr_user;

--
-- Name: tbl_anggota_id_anggota_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_anggota_id_anggota_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_anggota_id_anggota_seq OWNER TO nrcsr_user;

--
-- Name: tbl_anggota_id_anggota_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_anggota_id_anggota_seq OWNED BY nr_csr.tbl_anggota.id_anggota;


--
-- Name: tbl_area; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_area (
    id_area bigint NOT NULL,
    area_kerja character varying(50),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_area OWNER TO nrcsr_user;

--
-- Name: tbl_assessment_vendor; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_assessment_vendor (
    assessment_id integer NOT NULL,
    tanggal character varying(255),
    id_vendor character varying(255),
    tahun character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_assessment_vendor OWNER TO nrcsr_user;

--
-- Name: tbl_assessment_vendor_assessment_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_assessment_vendor_assessment_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_assessment_vendor_assessment_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_assessment_vendor_assessment_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_assessment_vendor_assessment_id_seq OWNED BY nr_csr.tbl_assessment_vendor.assessment_id;


--
-- Name: tbl_bakn; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_bakn (
    bakn_id integer NOT NULL,
    nomor character varying(255),
    tanggal character varying(255),
    pekerjaan_id numeric(18,2),
    status character varying(255),
    catatan character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone,
    id_vendor character varying(255),
    file_bakn character varying(255),
    nilai_kesepakatan numeric(18,2),
    sph_id numeric(18,2),
    response_date timestamp(0) without time zone,
    response_by character varying(255)
);


ALTER TABLE nr_csr.tbl_bakn OWNER TO nrcsr_user;

--
-- Name: tbl_bakn_bakn_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_bakn_bakn_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_bakn_bakn_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_bakn_bakn_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_bakn_bakn_id_seq OWNED BY nr_csr.tbl_bakn.bakn_id;


--
-- Name: tbl_bank; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_bank (
    bank_id integer NOT NULL,
    nama_bank character varying(255)
);


ALTER TABLE nr_csr.tbl_bank OWNER TO nrcsr_user;

--
-- Name: tbl_bank_bank_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_bank_bank_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_bank_bank_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_bank_bank_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_bank_bank_id_seq OWNED BY nr_csr.tbl_bank.bank_id;


--
-- Name: tbl_bast_dana; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_bast_dana (
    id_bast_dana integer NOT NULL,
    no_agenda character varying(50),
    pilar character varying(100),
    bantuan_untuk character varying(300),
    proposal_dari character varying(100),
    alamat character varying(500),
    provinsi character varying(50),
    kabupaten character varying(50),
    penanggung_jawab character varying(50),
    bertindak_sebagai character varying(100),
    no_surat character varying(50),
    tgl_surat timestamp(0) without time zone,
    perihal character varying(100),
    nama_bank character varying(50),
    no_rekening character varying(50),
    atas_nama character varying(100),
    no_bast_dana character varying(50),
    created_by character varying(50),
    created_date timestamp(0) without time zone,
    no_bast_pihak_kedua character varying(100),
    tgl_bast timestamp(0) without time zone,
    nama_pejabat character varying(100),
    jabatan_pejabat character varying(100),
    nama_barang character varying(100),
    jumlah_barang numeric(18,2),
    satuan_barang character varying(20),
    no_pelimpahan character varying(100),
    tgl_pelimpahan timestamp(0) without time zone,
    pihak_kedua character varying(500),
    status character varying(50),
    approved_by character varying(50),
    approved_date timestamp(0) without time zone,
    deskripsi character varying(500),
    id_kelayakan numeric(18,2),
    approver_id numeric(18,2)
);


ALTER TABLE nr_csr.tbl_bast_dana OWNER TO nrcsr_user;

--
-- Name: tbl_bast_dana_id_bast_dana_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_bast_dana_id_bast_dana_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_bast_dana_id_bast_dana_seq OWNER TO nrcsr_user;

--
-- Name: tbl_bast_dana_id_bast_dana_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_bast_dana_id_bast_dana_seq OWNED BY nr_csr.tbl_bast_dana.id_bast_dana;


--
-- Name: tbl_city; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_city (
    id_city bigint NOT NULL,
    city_name character varying(255)
);


ALTER TABLE nr_csr.tbl_city OWNER TO nrcsr_user;

--
-- Name: tbl_detail_approval; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_detail_approval (
    id integer NOT NULL,
    id_kelayakan numeric(18,2),
    id_hirarki numeric(18,2),
    id_user numeric(18,2),
    catatan character varying(255),
    status character varying(255),
    status_date timestamp(0) without time zone,
    task_date timestamp(0) without time zone,
    action_date timestamp(0) without time zone,
    phase character varying(255),
    created_by numeric(18,2),
    pesan character varying(255)
);


ALTER TABLE nr_csr.tbl_detail_approval OWNER TO nrcsr_user;

--
-- Name: tbl_detail_approval_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_detail_approval_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_detail_approval_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_detail_approval_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_detail_approval_id_seq OWNED BY nr_csr.tbl_detail_approval.id;


--
-- Name: tbl_detail_kriteria; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_detail_kriteria (
    id_detail_kriteria bigint NOT NULL,
    no_agenda character varying(50),
    kriteria character varying(50),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_kelayakan numeric(18,2)
);


ALTER TABLE nr_csr.tbl_detail_kriteria OWNER TO nrcsr_user;

--
-- Name: tbl_detail_kriteria_id_detail_kriteria_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_detail_kriteria_id_detail_kriteria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_detail_kriteria_id_detail_kriteria_seq OWNER TO nrcsr_user;

--
-- Name: tbl_detail_kriteria_id_detail_kriteria_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_detail_kriteria_id_detail_kriteria_seq OWNED BY nr_csr.tbl_detail_kriteria.id_detail_kriteria;


--
-- Name: tbl_detail_spk; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_detail_spk (
    id_detail_spk integer NOT NULL,
    no_agenda character varying(50),
    "COLUMN1" character varying(200),
    "COLUMN2" character varying(200),
    "COLUMN3" character varying(200)
);


ALTER TABLE nr_csr.tbl_detail_spk OWNER TO nrcsr_user;

--
-- Name: tbl_detail_spk_id_detail_spk_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_detail_spk_id_detail_spk_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_detail_spk_id_detail_spk_seq OWNER TO nrcsr_user;

--
-- Name: tbl_detail_spk_id_detail_spk_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_detail_spk_id_detail_spk_seq OWNED BY nr_csr.tbl_detail_spk.id_detail_spk;


--
-- Name: tbl_dokumen; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_dokumen (
    id integer NOT NULL,
    nama_dokumen character varying(255),
    mandatori character varying(10)
);


ALTER TABLE nr_csr.tbl_dokumen OWNER TO nrcsr_user;

--
-- Name: tbl_dokumen_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_dokumen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_dokumen_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_dokumen_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_dokumen_id_seq OWNED BY nr_csr.tbl_dokumen.id;


--
-- Name: tbl_dokumen_mandatori_proyek; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_dokumen_mandatori_proyek (
    dokumen_id integer NOT NULL,
    nama_dokumen character varying(255)
);


ALTER TABLE nr_csr.tbl_dokumen_mandatori_proyek OWNER TO nrcsr_user;

--
-- Name: tbl_dokumen_mandatori_proyek_dokumen_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_dokumen_mandatori_proyek_dokumen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_dokumen_mandatori_proyek_dokumen_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_dokumen_mandatori_proyek_dokumen_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_dokumen_mandatori_proyek_dokumen_id_seq OWNED BY nr_csr.tbl_dokumen_mandatori_proyek.dokumen_id;


--
-- Name: tbl_dokumen_mandatori_vendor; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_dokumen_mandatori_vendor (
    dokumen_id integer NOT NULL,
    nama_dokumen character varying(255)
);


ALTER TABLE nr_csr.tbl_dokumen_mandatori_vendor OWNER TO nrcsr_user;

--
-- Name: tbl_dokumen_mandatori_vendor_dokumen_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_dokumen_mandatori_vendor_dokumen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_dokumen_mandatori_vendor_dokumen_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_dokumen_mandatori_vendor_dokumen_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_dokumen_mandatori_vendor_dokumen_id_seq OWNED BY nr_csr.tbl_dokumen_mandatori_vendor.dokumen_id;


--
-- Name: tbl_dokumen_vendor; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_dokumen_vendor (
    dokumen_id integer NOT NULL,
    id_vendor numeric(18,2),
    nama_dokumen character varying(255),
    nomor character varying(255),
    tanggal character varying(255),
    masa_berlaku character varying(255),
    keterangan character varying(255),
    catatan character varying(255),
    file character varying(255),
    "PARAMETER1" character varying(255),
    "PARAMETER2" character varying(255),
    "PARAMETER3" character varying(255),
    "PARAMETER4" character varying(255),
    "PARAMETER5" character varying(255),
    status character varying(255),
    status_date timestamp(0) without time zone,
    created_date timestamp(0) without time zone,
    created_by character varying(255),
    verifikasi_date timestamp(0) without time zone,
    verifikasi_by character varying(255)
);


ALTER TABLE nr_csr.tbl_dokumen_vendor OWNER TO nrcsr_user;

--
-- Name: tbl_dokumen_vendor_dokumen_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_dokumen_vendor_dokumen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_dokumen_vendor_dokumen_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_dokumen_vendor_dokumen_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_dokumen_vendor_dokumen_id_seq OWNED BY nr_csr.tbl_dokumen_vendor.dokumen_id;


--
-- Name: tbl_evaluasi; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_evaluasi (
    id_evaluasi bigint NOT NULL,
    no_agenda character varying(50),
    rencana_anggaran character varying(20),
    dokumen character varying(20),
    denah character varying(20),
    syarat character varying(100),
    "EVALUATOR1" character varying(50),
    "CATATAN1" text,
    "EVALUATOR2" character varying(50),
    "CATATAN2" text,
    kadep character varying(50),
    kadiv character varying(50),
    status character varying(50),
    approve_date timestamp(0) without time zone,
    ket_kadiv character varying(150),
    "KET_KADIN1" character varying(150),
    "KET_KADIN2" character varying(150),
    keterangan character varying(200),
    approve_kadep timestamp(0) without time zone,
    approve_kadiv timestamp(0) without time zone,
    revisi_by character varying(50),
    revisi_date timestamp(0) without time zone,
    reject_by character varying(50),
    reject_date timestamp(0) without time zone,
    create_by character varying(50),
    create_date timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    "CATATAN1_NEW" character varying(200),
    "CATATAN2_NEW" character varying(200),
    id_kelayakan numeric(18,2),
    created_by numeric(18,2),
    sekper character varying(255),
    dirut character varying(255),
    ket_sekper character varying(255),
    ket_dirut character varying(255),
    approve_sekper timestamp(0) without time zone,
    approve_dirut timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_evaluasi OWNER TO nrcsr_user;

--
-- Name: tbl_exception; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_exception (
    error_id integer NOT NULL,
    exception text,
    error_date timestamp(0) without time zone,
    error_by character varying(255),
    status character varying(255),
    remark character varying(255)
);


ALTER TABLE nr_csr.tbl_exception OWNER TO nrcsr_user;

--
-- Name: tbl_exception_error_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_exception_error_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_exception_error_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_exception_error_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_exception_error_id_seq OWNED BY nr_csr.tbl_exception.error_id;


--
-- Name: tbl_hirarki; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_hirarki (
    id integer NOT NULL,
    id_user numeric(18,2),
    id_level numeric(18,2),
    status character varying(10)
);


ALTER TABLE nr_csr.tbl_hirarki OWNER TO nrcsr_user;

--
-- Name: tbl_hirarki_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_hirarki_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_hirarki_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_hirarki_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_hirarki_id_seq OWNED BY nr_csr.tbl_hirarki.id;


--
-- Name: tbl_izin_usaha; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_izin_usaha (
    izin_usaha_id integer NOT NULL,
    id_vendor character varying(255),
    nib character varying(255),
    jenis_kbli character varying(255),
    kode_kbli character varying(255),
    alamat character varying(255),
    file character varying(255),
    created_date timestamp(0) without time zone,
    created_by character varying(255)
);


ALTER TABLE nr_csr.tbl_izin_usaha OWNER TO nrcsr_user;

--
-- Name: tbl_izin_usaha_izin_usaha_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_izin_usaha_izin_usaha_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_izin_usaha_izin_usaha_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_izin_usaha_izin_usaha_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_izin_usaha_izin_usaha_id_seq OWNED BY nr_csr.tbl_izin_usaha.izin_usaha_id;


--
-- Name: tbl_kebijakan; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_kebijakan (
    id_kebijakan integer NOT NULL,
    kebijakan character varying(200)
);


ALTER TABLE nr_csr.tbl_kebijakan OWNER TO nrcsr_user;

--
-- Name: tbl_kebijakan_id_kebijakan_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_kebijakan_id_kebijakan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_kebijakan_id_kebijakan_seq OWNER TO nrcsr_user;

--
-- Name: tbl_kebijakan_id_kebijakan_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_kebijakan_id_kebijakan_seq OWNED BY nr_csr.tbl_kebijakan.id_kebijakan;


--
-- Name: tbl_kelayakan; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_kelayakan (
    no_agenda character varying(50),
    tgl_terima timestamp(0) without time zone,
    no_surat character varying(100),
    tgl_surat timestamp(0) without time zone,
    sebagai character varying(100) DEFAULT ''::character varying,
    provinsi character varying(100),
    kabupaten character varying(100),
    kelurahan character varying(100),
    kodepos character varying(10),
    bantuan_untuk character varying(200),
    contact_person character varying(100),
    nilai_pengajuan numeric(38,0),
    sektor_bantuan character varying(100),
    nama_bank character varying(50),
    atas_nama character varying(150),
    no_rekening character varying(50),
    nilai_bantuan numeric(38,0),
    nama_anggota character varying(50),
    fraksi character varying(255),
    jabatan character varying(200),
    pic character varying(255),
    asal_surat character varying(100),
    komisi character varying(100),
    sifat character varying(20),
    status character varying(50),
    email_pengaju character varying(50),
    nama_person character varying(50),
    mata_uang_pengajuan character varying(20),
    mata_uang_bantuan character varying(20),
    proposal character varying(255),
    create_by character varying(50),
    create_date timestamp(0) without time zone,
    pengirim character varying(200),
    perihal character varying(200),
    pengaju_proposal character varying(200),
    alamat character varying(400),
    cabang_bank character varying(150),
    jenis character varying(255),
    hewan_kurban character varying(255),
    jumlah_hewan bigint,
    kode_bank character varying(255),
    kode_kota character varying(255),
    kota_bank character varying(255),
    cabang character varying(255),
    deskripsi character varying(500),
    pilar character varying(255),
    tpb character varying(255),
    kode_indikator character varying(255),
    keterangan_indikator character varying(1000),
    proker character varying(255),
    indikator character varying(255),
    smap character varying(255),
    ykpp character varying(255),
    checklist_by character varying(255),
    checklist_date timestamp(0) without time zone,
    nominal_approved bigint,
    nominal_fee bigint,
    total_ykpp bigint,
    status_ykpp character varying(255),
    approved_ykpp_by character varying(255),
    approved_ykpp_date timestamp(0) without time zone,
    submited_ykpp_by character varying(255),
    submited_ykpp_date timestamp(0) without time zone,
    no_surat_ykpp character varying(255),
    tgl_surat_ykpp character varying(255),
    penyaluran_ke_old bigint,
    id_kelayakan integer NOT NULL,
    surat_ykpp character varying(255),
    tahun_ykpp character varying(4),
    penyaluran_ke character varying(255),
    id_lembaga numeric(18,2),
    id_pengirim numeric(18,2),
    created_by numeric(18,2),
    created_date timestamp(0) without time zone,
    id_proker numeric(18,2),
    kecamatan character varying(100) DEFAULT ''::character varying
);


ALTER TABLE nr_csr.tbl_kelayakan OWNER TO nrcsr_user;

--
-- Name: tbl_kelayakan_id_kelayakan_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_kelayakan_id_kelayakan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_kelayakan_id_kelayakan_seq OWNER TO nrcsr_user;

--
-- Name: tbl_kelayakan_id_kelayakan_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_kelayakan_id_kelayakan_seq OWNED BY nr_csr.tbl_kelayakan.id_kelayakan;


--
-- Name: tbl_kode; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_kode (
    kode character varying(20),
    provinsi character varying(100)
);


ALTER TABLE nr_csr.tbl_kode OWNER TO nrcsr_user;

--
-- Name: tbl_ktp_pengurus; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_ktp_pengurus (
    ktp_id integer NOT NULL,
    id_vendor character varying(255),
    nomor character varying(255),
    nama character varying(255),
    jabatan character varying(255),
    no_telp character varying(255),
    email character varying(255),
    file character varying(255),
    created_date timestamp(0) without time zone,
    created_by character varying(255)
);


ALTER TABLE nr_csr.tbl_ktp_pengurus OWNER TO nrcsr_user;

--
-- Name: tbl_ktp_pengurus_ktp_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_ktp_pengurus_ktp_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_ktp_pengurus_ktp_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_ktp_pengurus_ktp_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_ktp_pengurus_ktp_id_seq OWNED BY nr_csr.tbl_ktp_pengurus.ktp_id;


--
-- Name: tbl_lampiran; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_lampiran (
    id_lampiran bigint NOT NULL,
    no_agenda character varying(50),
    nama character varying(255),
    lampiran character varying(500),
    upload_by character varying(50),
    upload_date timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_kelayakan numeric(18,2),
    created_by numeric(18,2)
);


ALTER TABLE nr_csr.tbl_lampiran OWNER TO nrcsr_user;

--
-- Name: tbl_lampiran_ap; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_lampiran_ap (
    id_lampiran bigint NOT NULL,
    id_realisasi bigint,
    nama character varying(255),
    lampiran character varying(255),
    upload_by character varying(255),
    upload_date timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_lampiran_ap OWNER TO nrcsr_user;

--
-- Name: tbl_lampiran_ap_id_lampiran_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_lampiran_ap_id_lampiran_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_lampiran_ap_id_lampiran_seq OWNER TO nrcsr_user;

--
-- Name: tbl_lampiran_ap_id_lampiran_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_lampiran_ap_id_lampiran_seq OWNED BY nr_csr.tbl_lampiran_ap.id_lampiran;


--
-- Name: tbl_lampiran_pekerjaan; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_lampiran_pekerjaan (
    lampiran_id integer NOT NULL,
    id_vendor numeric(18,2),
    nomor character varying(255),
    nama_file character varying(255),
    file character varying(255),
    type character varying(255),
    size numeric(18,2),
    status character varying(255),
    catatan character varying(255),
    upload_by character varying(255),
    upload_date timestamp(0) without time zone,
    nama_dokumen character varying(255),
    pekerjaan_id numeric(18,2)
);


ALTER TABLE nr_csr.tbl_lampiran_pekerjaan OWNER TO nrcsr_user;

--
-- Name: tbl_lampiran_pekerjaan_lampiran_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_lampiran_pekerjaan_lampiran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_lampiran_pekerjaan_lampiran_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_lampiran_pekerjaan_lampiran_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_lampiran_pekerjaan_lampiran_id_seq OWNED BY nr_csr.tbl_lampiran_pekerjaan.lampiran_id;


--
-- Name: tbl_lampiran_vendor; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_lampiran_vendor (
    lampiran_id integer NOT NULL,
    id_vendor numeric(18,2),
    nomor character varying(255),
    nama_file character varying(255),
    file character varying(255),
    type character varying(255),
    size numeric(18,2),
    status character varying(255),
    catatan character varying(255),
    upload_by character varying(255),
    upload_date timestamp(0) without time zone,
    nama_dokumen character varying(255)
);


ALTER TABLE nr_csr.tbl_lampiran_vendor OWNER TO nrcsr_user;

--
-- Name: tbl_lampiran_vendor_lampiran_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_lampiran_vendor_lampiran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_lampiran_vendor_lampiran_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_lampiran_vendor_lampiran_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_lampiran_vendor_lampiran_id_seq OWNED BY nr_csr.tbl_lampiran_vendor.lampiran_id;


--
-- Name: tbl_lembaga; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_lembaga (
    id_lembaga integer NOT NULL,
    nama_lembaga character varying(255),
    nama_pic character varying(255),
    alamat character varying(255),
    no_telp character varying(255),
    jabatan character varying(255),
    no_rekening character varying(255),
    atas_nama character varying(255),
    nama_bank character varying(255),
    cabang character varying(255),
    kota_bank character varying(255),
    kode_bank character varying(255),
    kode_kota character varying(255),
    perusahaan character varying(255),
    id_perusahaan numeric(18,2)
);


ALTER TABLE nr_csr.tbl_lembaga OWNER TO nrcsr_user;

--
-- Name: tbl_lembaga_id_lembaga_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_lembaga_id_lembaga_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_lembaga_id_lembaga_seq OWNER TO nrcsr_user;

--
-- Name: tbl_lembaga_id_lembaga_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_lembaga_id_lembaga_seq OWNED BY nr_csr.tbl_lembaga.id_lembaga;


--
-- Name: tbl_level_hirarki; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_level_hirarki (
    id integer NOT NULL,
    level numeric(18,2),
    nama_level character varying(20)
);


ALTER TABLE nr_csr.tbl_level_hirarki OWNER TO nrcsr_user;

--
-- Name: tbl_level_hirarki_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_level_hirarki_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_level_hirarki_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_level_hirarki_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_level_hirarki_id_seq OWNED BY nr_csr.tbl_level_hirarki.id;


--
-- Name: tbl_log; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_log (
    id integer NOT NULL,
    id_kelayakan numeric(18,2),
    keterangan character varying(200),
    created_by numeric(18,2),
    created_date timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_log OWNER TO nrcsr_user;

--
-- Name: tbl_log_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_log_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_log_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_log_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_log_id_seq OWNED BY nr_csr.tbl_log.id;


--
-- Name: tbl_log_pekerjaan; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_log_pekerjaan (
    log_id integer NOT NULL,
    pekerjaan_id character varying(255),
    update_by character varying(255),
    update_date timestamp(0) without time zone,
    action character varying(255),
    keterangan character varying(255)
);


ALTER TABLE nr_csr.tbl_log_pekerjaan OWNER TO nrcsr_user;

--
-- Name: tbl_log_pekerjaan_log_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_log_pekerjaan_log_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_log_pekerjaan_log_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_log_pekerjaan_log_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_log_pekerjaan_log_id_seq OWNED BY nr_csr.tbl_log_pekerjaan.log_id;


--
-- Name: tbl_log_relokasi; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_log_relokasi (
    id_log integer NOT NULL,
    id_proker character varying(255),
    keterangan character varying(255),
    status character varying(255),
    status_date timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_log_relokasi OWNER TO nrcsr_user;

--
-- Name: tbl_log_relokasi_id_log_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_log_relokasi_id_log_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_log_relokasi_id_log_seq OWNER TO nrcsr_user;

--
-- Name: tbl_log_relokasi_id_log_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_log_relokasi_id_log_seq OWNED BY nr_csr.tbl_log_relokasi.id_log;


--
-- Name: tbl_log_vendor; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_log_vendor (
    log_id integer NOT NULL,
    id_vendor character varying(255),
    update_by character varying(255),
    update_date timestamp(0) without time zone,
    action character varying(255),
    keterangan character varying(255)
);


ALTER TABLE nr_csr.tbl_log_vendor OWNER TO nrcsr_user;

--
-- Name: tbl_log_vendor_log_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_log_vendor_log_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_log_vendor_log_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_log_vendor_log_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_log_vendor_log_id_seq OWNED BY nr_csr.tbl_log_vendor.log_id;


--
-- Name: tbl_pejabat; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_pejabat (
    id integer NOT NULL,
    nama character varying(255),
    jabatan character varying(255),
    sk character varying(255),
    tanggal timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_pejabat OWNER TO nrcsr_user;

--
-- Name: tbl_pejabat_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_pejabat_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_pejabat_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_pejabat_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_pejabat_id_seq OWNED BY nr_csr.tbl_pejabat.id;


--
-- Name: tbl_pekerjaan; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_pekerjaan (
    pekerjaan_id integer NOT NULL,
    nama_pekerjaan character varying(255),
    tahun character varying(255),
    proker_id numeric(18,2),
    nilai_perkiraan numeric(18,2),
    status character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone,
    ringkasan text,
    kak character varying(255),
    id_vendor character varying(255),
    nilai_penawaran numeric(18,2),
    nilai_kesepakatan numeric(18,2)
);


ALTER TABLE nr_csr.tbl_pekerjaan OWNER TO nrcsr_user;

--
-- Name: tbl_pekerjaan_pekerjaan_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_pekerjaan_pekerjaan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_pekerjaan_pekerjaan_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_pekerjaan_pekerjaan_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_pekerjaan_pekerjaan_id_seq OWNED BY nr_csr.tbl_pekerjaan.pekerjaan_id;


--
-- Name: tbl_pembayaran; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_pembayaran (
    id_pembayaran bigint NOT NULL,
    no_agenda character varying(50),
    no_bast character varying(50),
    no_ba character varying(50),
    termin character varying(2),
    nilai_approved numeric(18,2),
    persen character varying(3),
    status character varying(50),
    pr_id character varying(50),
    create_date timestamp(0) without time zone,
    create_by character varying(50),
    export_date timestamp(0) without time zone,
    export_by character varying(100),
    id_kelayakan bigint,
    deskripsi character varying(500),
    fee numeric(18,2),
    jumlah_pembayaran numeric(18,2),
    subtotal numeric(18,2),
    fee_persen numeric(18,2),
    status_ykpp character varying(255),
    approved_ykpp_by character varying(255),
    approved_ykpp_date timestamp(0) without time zone,
    submited_ykpp_by character varying(255),
    submited_ykpp_date timestamp(0) without time zone,
    no_surat_ykpp character varying(255),
    tgl_surat_ykpp character varying(255),
    surat_ykpp character varying(255),
    tahun_ykpp character varying(4),
    penyaluran_ke character varying(255),
    metode character varying(255)
);


ALTER TABLE nr_csr.tbl_pembayaran OWNER TO nrcsr_user;

--
-- Name: tbl_pembayaran_vendor; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_pembayaran_vendor (
    id_pembayaran bigint NOT NULL,
    pekerjaan_id character varying(50),
    no_bast character varying(50),
    no_ba character varying(50),
    termin character varying(2),
    nilai_kesepakatan numeric(18,2),
    persen character varying(3),
    jumlah_pembayaran character varying(255),
    status character varying(50),
    pr_id character varying(50),
    create_date timestamp(0) without time zone,
    create_by character varying(50),
    export_date timestamp(0) without time zone,
    export_by character varying(100),
    id_vendor character varying(255)
);


ALTER TABLE nr_csr.tbl_pembayaran_vendor OWNER TO nrcsr_user;

--
-- Name: tbl_pengalaman_kerja; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_pengalaman_kerja (
    pengalaman_id integer NOT NULL,
    id_vendor character varying(255),
    no_kontrak character varying(255),
    tgl_kontrak character varying(255),
    pekerjaan character varying(255),
    pemberi_kerja character varying(255),
    lokasi character varying(255),
    file character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone,
    nilai numeric(18,2)
);


ALTER TABLE nr_csr.tbl_pengalaman_kerja OWNER TO nrcsr_user;

--
-- Name: tbl_pengalaman_kerja_pengalaman_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_pengalaman_kerja_pengalaman_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_pengalaman_kerja_pengalaman_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_pengalaman_kerja_pengalaman_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_pengalaman_kerja_pengalaman_id_seq OWNED BY nr_csr.tbl_pengalaman_kerja.pengalaman_id;


--
-- Name: tbl_pengembalian_anggaran; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_pengembalian_anggaran (
    id integer NOT NULL,
    anggaran_id numeric(18,2),
    pengembalian character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_pengembalian_anggaran OWNER TO nrcsr_user;

--
-- Name: tbl_pengembalian_anggaran_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_pengembalian_anggaran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_pengembalian_anggaran_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_pengembalian_anggaran_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_pengembalian_anggaran_id_seq OWNED BY nr_csr.tbl_pengembalian_anggaran.id;


--
-- Name: tbl_pengirim; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_pengirim (
    id_pengirim integer NOT NULL,
    pengirim character varying(50),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    perusahaan character varying(100),
    id_perusahaan numeric(18,2),
    status character varying(10)
);


ALTER TABLE nr_csr.tbl_pengirim OWNER TO nrcsr_user;

--
-- Name: tbl_pengirim_id_pengirim_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_pengirim_id_pengirim_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_pengirim_id_pengirim_seq OWNER TO nrcsr_user;

--
-- Name: tbl_pengirim_id_pengirim_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_pengirim_id_pengirim_seq OWNED BY nr_csr.tbl_pengirim.id_pengirim;


--
-- Name: tbl_perusahaan; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_perusahaan (
    id_perusahaan integer NOT NULL,
    nama_perusahaan character varying(100),
    kategori character varying(20),
    kode character varying(10),
    foto_profile character varying(255),
    alamat character varying(500),
    no_telp character varying(15),
    pic numeric(18,2),
    status character varying(20)
);


ALTER TABLE nr_csr.tbl_perusahaan OWNER TO nrcsr_user;

--
-- Name: tbl_perusahaan_id_perusahaan_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_perusahaan_id_perusahaan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_perusahaan_id_perusahaan_seq OWNER TO nrcsr_user;

--
-- Name: tbl_perusahaan_id_perusahaan_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_perusahaan_id_perusahaan_seq OWNED BY nr_csr.tbl_perusahaan.id_perusahaan;


--
-- Name: tbl_pilar; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_pilar (
    id_pilar bigint NOT NULL,
    kode character varying(255),
    nama character varying(255)
);


ALTER TABLE nr_csr.tbl_pilar OWNER TO nrcsr_user;

--
-- Name: tbl_pilar_id_pilar_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_pilar_id_pilar_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_pilar_id_pilar_seq OWNER TO nrcsr_user;

--
-- Name: tbl_pilar_id_pilar_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_pilar_id_pilar_seq OWNED BY nr_csr.tbl_pilar.id_pilar;


--
-- Name: tbl_proker; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_proker (
    id_proker integer NOT NULL,
    proker character varying(1000),
    id_indikator character varying(100),
    tahun character varying(4),
    anggaran numeric(18,2),
    prioritas character varying(255),
    eb character varying(255),
    pilar character varying(255),
    gols character varying(255),
    perusahaan character varying(255),
    id_perusahaan integer,
    kode_tpb character varying(255)
);


ALTER TABLE nr_csr.tbl_proker OWNER TO nrcsr_user;

--
-- Name: tbl_proker_id_proker_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_proker_id_proker_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_proker_id_proker_seq OWNER TO nrcsr_user;

--
-- Name: tbl_proker_id_proker_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_proker_id_proker_seq OWNED BY nr_csr.tbl_proker.id_proker;


--
-- Name: tbl_provinsi; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_provinsi (
    id_provinsi bigint NOT NULL,
    kode_provinsi character varying(10),
    provinsi character varying(100)
);


ALTER TABLE nr_csr.tbl_provinsi OWNER TO nrcsr_user;

--
-- Name: tbl_realisasi_ap; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_realisasi_ap (
    id_realisasi bigint NOT NULL,
    no_proposal character varying(255),
    tgl_proposal timestamp(0) without time zone,
    pengirim character varying(255),
    tgl_realisasi timestamp(0) without time zone,
    sifat character varying(255),
    perihal character varying(255),
    besar_permohonan bigint,
    kategori character varying(255),
    nilai_bantuan bigint,
    status character varying(255),
    provinsi character varying(255),
    kabupaten character varying(255),
    deskripsi character varying(255),
    id_proker bigint,
    proker character varying(255),
    pilar character varying(255),
    gols character varying(255),
    nama_yayasan character varying(255),
    alamat character varying(255),
    pic character varying(255),
    jabatan character varying(255),
    no_telp character varying(255),
    no_rekening character varying(255),
    atas_nama character varying(255),
    nama_bank character varying(255),
    kota_bank character varying(255),
    cabang_bank character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone,
    jenis character varying(255),
    perusahaan character varying(255),
    tahun character varying(4),
    status_date timestamp(0) without time zone,
    prioritas character varying(255),
    id_perusahaan bigint,
    kecamatan character varying(255),
    kelurahan character varying(255)
);


ALTER TABLE nr_csr.tbl_realisasi_ap OWNER TO nrcsr_user;

--
-- Name: tbl_realisasi_ap_id_realisasi_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_realisasi_ap_id_realisasi_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_realisasi_ap_id_realisasi_seq OWNER TO nrcsr_user;

--
-- Name: tbl_realisasi_ap_id_realisasi_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_realisasi_ap_id_realisasi_seq OWNED BY nr_csr.tbl_realisasi_ap.id_realisasi;


--
-- Name: tbl_relokasi; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_relokasi (
    id_relokasi integer NOT NULL,
    proker_asal character varying(255),
    nominal_asal numeric(18,2),
    proker_tujuan character varying(255),
    nominal_tujuan numeric(18,2),
    request_by character varying(255),
    request_date timestamp(0) without time zone,
    status character varying(255),
    approver character varying(255),
    tahun character varying(4),
    perusahaan character varying(255),
    status_date timestamp(0) without time zone,
    nominal_relokasi numeric(18,2),
    id_perusahaan numeric(18,2)
);


ALTER TABLE nr_csr.tbl_relokasi OWNER TO nrcsr_user;

--
-- Name: tbl_relokasi_id_relokasi_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_relokasi_id_relokasi_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_relokasi_id_relokasi_seq OWNER TO nrcsr_user;

--
-- Name: tbl_relokasi_id_relokasi_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_relokasi_id_relokasi_seq OWNED BY nr_csr.tbl_relokasi.id_relokasi;


--
-- Name: tbl_role; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_role (
    id_role bigint NOT NULL,
    role character varying(2) NOT NULL,
    role_name character varying(30)
);


ALTER TABLE nr_csr.tbl_role OWNER TO nrcsr_user;

--
-- Name: tbl_sdg; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_sdg (
    id_sdg bigint NOT NULL,
    nama character varying(255),
    kode character varying(255),
    pilar character varying(255)
);


ALTER TABLE nr_csr.tbl_sdg OWNER TO nrcsr_user;

--
-- Name: tbl_sdg_id_sdg_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_sdg_id_sdg_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_sdg_id_sdg_seq OWNER TO nrcsr_user;

--
-- Name: tbl_sdg_id_sdg_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_sdg_id_sdg_seq OWNED BY nr_csr.tbl_sdg.id_sdg;


--
-- Name: tbl_sektor; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_sektor (
    id_sektor bigint NOT NULL,
    kode_sektor character varying(10),
    sektor_bantuan character varying(100)
);


ALTER TABLE nr_csr.tbl_sektor OWNER TO nrcsr_user;

--
-- Name: tbl_sektor_id_sektor_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_sektor_id_sektor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_sektor_id_sektor_seq OWNER TO nrcsr_user;

--
-- Name: tbl_sektor_id_sektor_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_sektor_id_sektor_seq OWNED BY nr_csr.tbl_sektor.id_sektor;


--
-- Name: tbl_sph; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_sph (
    sph_id integer NOT NULL,
    nomor character varying(255),
    tanggal character varying(255),
    pekerjaan_id numeric(18,2),
    status character varying(255),
    catatan character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone,
    id_vendor character varying(255),
    file_sph character varying(255),
    nilai_penawaran numeric(18,2),
    spph_id numeric(18,2)
);


ALTER TABLE nr_csr.tbl_sph OWNER TO nrcsr_user;

--
-- Name: tbl_sph_sph_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_sph_sph_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_sph_sph_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_sph_sph_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_sph_sph_id_seq OWNED BY nr_csr.tbl_sph.sph_id;


--
-- Name: tbl_spk; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_spk (
    spk_id integer NOT NULL,
    nomor character varying(255),
    tanggal character varying(255),
    pekerjaan_id numeric(18,2),
    status character varying(255),
    catatan character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone,
    id_vendor character varying(255),
    file_spk character varying(255),
    nilai_kesepakatan numeric(18,2),
    sph_id numeric(18,2),
    bakn_id numeric(18,2),
    start_date timestamp(0) without time zone,
    due_date timestamp(0) without time zone,
    durasi numeric(18,2),
    response_date timestamp(0) without time zone,
    response_by character varying(255)
);


ALTER TABLE nr_csr.tbl_spk OWNER TO nrcsr_user;

--
-- Name: tbl_spk_spk_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_spk_spk_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_spk_spk_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_spk_spk_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_spk_spk_id_seq OWNED BY nr_csr.tbl_spk.spk_id;


--
-- Name: tbl_spph; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_spph (
    spph_id integer NOT NULL,
    nomor character varying(255),
    tanggal timestamp(0) without time zone,
    pekerjaan_id numeric(18,2),
    status character varying(255),
    catatan character varying(255),
    created_by character varying(255),
    created_date timestamp(0) without time zone,
    id_vendor character varying(255),
    file_spph character varying(255),
    response_date timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_spph OWNER TO nrcsr_user;

--
-- Name: tbl_spph_spph_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_spph_spph_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_spph_spph_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_spph_spph_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_spph_spph_id_seq OWNED BY nr_csr.tbl_spph.spph_id;


--
-- Name: tbl_sub_pilar; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_sub_pilar (
    id_sub_pilar bigint NOT NULL,
    tpb character varying(255),
    kode_indikator character varying(255),
    keterangan character varying(1000),
    pilar character varying(255)
);


ALTER TABLE nr_csr.tbl_sub_pilar OWNER TO nrcsr_user;

--
-- Name: tbl_sub_pilar_id_sub_pilar_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_sub_pilar_id_sub_pilar_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_sub_pilar_id_sub_pilar_seq OWNER TO nrcsr_user;

--
-- Name: tbl_sub_pilar_id_sub_pilar_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_sub_pilar_id_sub_pilar_seq OWNED BY nr_csr.tbl_sub_pilar.id_sub_pilar;


--
-- Name: tbl_sub_proposal; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_sub_proposal (
    id_sub_proposal integer NOT NULL,
    no_agenda character varying(50),
    no_sub_agenda character varying(255),
    nama_ketua character varying(255),
    nama_lembaga character varying(255),
    kambing bigint,
    sapi bigint,
    total bigint,
    harga_kambing bigint,
    harga_sapi bigint,
    provinsi character varying(255),
    kabupaten character varying(255),
    alamat character varying(255),
    fee bigint,
    subtotal bigint,
    ppn bigint
);


ALTER TABLE nr_csr.tbl_sub_proposal OWNER TO nrcsr_user;

--
-- Name: tbl_sub_proposal_id_sub_proposal_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_sub_proposal_id_sub_proposal_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_sub_proposal_id_sub_proposal_seq OWNER TO nrcsr_user;

--
-- Name: tbl_sub_proposal_id_sub_proposal_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_sub_proposal_id_sub_proposal_seq OWNED BY nr_csr.tbl_sub_proposal.id_sub_proposal;


--
-- Name: tbl_survei; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_survei (
    id_survei bigint NOT NULL,
    no_agenda character varying(50),
    hasil_konfirmasi text,
    hasil_survei text,
    usulan character varying(50),
    bantuan_berupa character varying(50),
    nilai_bantuan numeric(38,0),
    nilai_approved numeric(38,0),
    termin character varying(20),
    "RUPIAH1" numeric(38,0),
    "RUPIAH2" numeric(38,0),
    "RUPIAH3" numeric(38,0),
    "RUPIAH4" numeric(38,0),
    "SURVEI1" character varying(50),
    "SURVEI2" character varying(50),
    status character varying(20),
    kadep character varying(50),
    kadiv character varying(50),
    "KET_KADIN1" text,
    "KET_KADIN2" text,
    ket_kadiv text,
    keterangan text,
    approve_date timestamp(0) without time zone,
    approve_kadep timestamp(0) without time zone,
    approve_kadiv timestamp(0) without time zone,
    create_by character varying(50),
    create_date timestamp(0) without time zone,
    revisi_by character varying(50),
    revisi_date timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    bast character varying(20),
    spk character varying(20),
    pks character varying(20),
    vendor_id numeric(18,2),
    id_kelayakan numeric(18,2),
    created_by numeric(18,2),
    sekper character varying(255),
    dirut character varying(255),
    ket_sekper character varying(255),
    ket_dirut character varying(255),
    approve_sekper timestamp(0) without time zone,
    approve_dirut timestamp(0) without time zone,
    "PERSEN1" numeric(10,2),
    "PERSEN2" numeric(10,2),
    "PERSEN3" numeric(10,2),
    "PERSEN4" numeric(10,2)
);


ALTER TABLE nr_csr.tbl_survei OWNER TO nrcsr_user;

--
-- Name: tbl_user; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_user (
    id_user integer NOT NULL,
    username character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    nama character varying(100) NOT NULL,
    jabatan character varying(100) NOT NULL,
    password character varying(200) NOT NULL,
    role character varying(100) NOT NULL,
    area_kerja character varying(100),
    status character varying(100),
    foto_profile character varying(255),
    remember_token character varying(100),
    jk character varying(100),
    old_email character varying(255),
    perusahaan character varying(255),
    vendor_id character varying(255),
    id_perusahaan integer,
    no_sk character varying(255),
    tgl_sk timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_user OWNER TO nrcsr_user;

--
-- Name: tbl_user_id_user_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_user_id_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_user_id_user_seq OWNER TO nrcsr_user;

--
-- Name: tbl_user_id_user_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_user_id_user_seq OWNED BY nr_csr.tbl_user.id_user;


--
-- Name: tbl_vendor; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_vendor (
    vendor_id integer NOT NULL,
    nama_perusahaan character varying(200),
    alamat character varying(500),
    no_telp character varying(20),
    email character varying(100),
    website character varying(50),
    no_ktp character varying(50),
    nama_pic character varying(100),
    jabatan character varying(100),
    email_pic character varying(100),
    no_hp character varying(20),
    file_ktp character varying(200),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    status character varying(255),
    approve_by character varying(255),
    approve_date timestamp(0) without time zone
);


ALTER TABLE nr_csr.tbl_vendor OWNER TO nrcsr_user;

--
-- Name: tbl_vendor_vendor_id_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_vendor_vendor_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_vendor_vendor_id_seq OWNER TO nrcsr_user;

--
-- Name: tbl_vendor_vendor_id_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_vendor_vendor_id_seq OWNED BY nr_csr.tbl_vendor.vendor_id;


--
-- Name: tbl_wilayah; Type: TABLE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE TABLE nr_csr.tbl_wilayah (
    id_wilayah integer NOT NULL,
    province character varying(50),
    city character varying(50),
    city_name character varying(50),
    sub_district character varying(50),
    village character varying(50),
    postal_code character varying(5)
);


ALTER TABLE nr_csr.tbl_wilayah OWNER TO nrcsr_user;

--
-- Name: tbl_wilayah_id_wilayah_seq; Type: SEQUENCE; Schema: nr_csr; Owner: nrcsr_user
--

CREATE SEQUENCE nr_csr.tbl_wilayah_id_wilayah_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE nr_csr.tbl_wilayah_id_wilayah_seq OWNER TO nrcsr_user;

--
-- Name: tbl_wilayah_id_wilayah_seq; Type: SEQUENCE OWNED BY; Schema: nr_csr; Owner: nrcsr_user
--

ALTER SEQUENCE nr_csr.tbl_wilayah_id_wilayah_seq OWNED BY nr_csr.tbl_wilayah.id_wilayah;


--
-- Name: v_bast; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_bast AS
 SELECT bast.id_bast_dana,
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
    sur."PERSEN1",
    sur."PERSEN2",
    sur."PERSEN3",
    sur."PERSEN4",
    sur."RUPIAH1",
    sur."RUPIAH2",
    sur."RUPIAH3",
    sur."RUPIAH4",
    sur."SURVEI1",
    kel.nama_bank,
    kel.atas_nama,
    kel.no_rekening,
    bast.jumlah_barang,
    bast.no_pelimpahan,
    bast.approver_id,
    lem.alamat
   FROM (((nr_csr.tbl_bast_dana bast
     JOIN nr_csr.tbl_kelayakan kel ON ((bast.id_kelayakan = (kel.id_kelayakan)::numeric)))
     JOIN nr_csr.tbl_survei sur ON (((kel.id_kelayakan)::numeric = sur.id_kelayakan)))
     JOIN nr_csr.tbl_lembaga lem ON ((kel.id_lembaga = (lem.id_lembaga)::numeric)));


ALTER VIEW nr_csr.v_bast OWNER TO nrcsr_user;

--
-- Name: v_bast_dana; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_bast_dana AS
 SELECT tbl_bast_dana.no_agenda,
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
    tbl_survei."PERSEN1",
    tbl_survei."PERSEN2",
    tbl_survei."PERSEN3",
    tbl_survei."PERSEN4",
    tbl_survei."RUPIAH1",
    tbl_survei."RUPIAH2",
    tbl_survei."RUPIAH3",
    tbl_survei."RUPIAH4",
    tbl_survei."SURVEI1",
    tbl_survei.bantuan_berupa
   FROM ((nr_csr.tbl_bast_dana
     JOIN nr_csr.tbl_kelayakan ON (((tbl_bast_dana.no_agenda)::text = (tbl_kelayakan.no_agenda)::text)))
     JOIN nr_csr.tbl_survei ON (((tbl_bast_dana.no_agenda)::text = (tbl_survei.no_agenda)::text)));


ALTER VIEW nr_csr.v_bast_dana OWNER TO nrcsr_user;

--
-- Name: v_detail_approval; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_detail_approval AS
 SELECT tbl_detail_approval.id,
    tbl_detail_approval.id_kelayakan,
    tbl_detail_approval.id_hirarki,
    tbl_detail_approval.phase,
    tbl_hirarki.id_level,
    tbl_level_hirarki.level,
    tbl_level_hirarki.nama_level,
    tbl_detail_approval.id_user,
    tbl_detail_approval.catatan,
    tbl_detail_approval.status,
    tbl_detail_approval.status_date,
    tbl_detail_approval.task_date,
    tbl_detail_approval.action_date
   FROM ((nr_csr.tbl_detail_approval
     JOIN nr_csr.tbl_hirarki ON ((tbl_detail_approval.id_hirarki = (tbl_hirarki.id)::numeric)))
     JOIN nr_csr.tbl_level_hirarki ON ((tbl_hirarki.id_level = (tbl_level_hirarki.id)::numeric)));


ALTER VIEW nr_csr.v_detail_approval OWNER TO nrcsr_user;

--
-- Name: v_evaluasi; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_evaluasi AS
 SELECT e.id_evaluasi,
    k.no_agenda,
    k.pengirim,
    k.tgl_terima,
    k.no_surat,
    k.tgl_surat,
    k.perihal,
    k.pengaju_proposal,
    k.sebagai,
    k.alamat,
    k.provinsi,
    k.kabupaten,
    k.bantuan_untuk,
    k.deskripsi,
    k.jenis,
    k.atas_nama,
    k.nama_person,
    k.contact_person,
    k.nilai_pengajuan,
    k.sektor_bantuan,
    k.nilai_bantuan,
    k.nama_anggota,
    k.fraksi,
    k.jabatan,
    k.pic,
    k.asal_surat,
    k.komisi,
    k.sifat,
    k.email_pengaju,
    k.mata_uang_pengajuan,
    k.mata_uang_bantuan,
    e.rencana_anggaran,
    k.proposal,
    e.dokumen,
    e.denah,
    e.syarat,
    e."EVALUATOR1" AS evaluator1,
    e."CATATAN1" AS catatan1,
    e."EVALUATOR2" AS evaluator2,
    e."CATATAN2" AS catatan2,
    e.kadep,
    e.kadiv,
    e.status,
    e.approve_date,
    e.approve_kadep,
    e.approve_kadiv,
    e."KET_KADIN1" AS ket_kadin1,
    e.ket_kadiv,
    e.revisi_by,
    e.revisi_date,
    e.reject_by,
    e.reject_date,
    e.create_by,
    e.create_date,
    k.id_kelayakan,
    e.sekper,
    e.dirut,
    e.ket_sekper,
    e.ket_dirut,
    e.approve_sekper,
    e.approve_dirut
   FROM (nr_csr.tbl_kelayakan k
     JOIN nr_csr.tbl_evaluasi e ON ((e.id_kelayakan = (k.id_kelayakan)::numeric)));


ALTER VIEW nr_csr.v_evaluasi OWNER TO nrcsr_user;

--
-- Name: v_hirarki; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_hirarki AS
 SELECT tbl_hirarki.id,
    tbl_hirarki.id_user,
    tbl_user.nama,
    tbl_user.username,
    tbl_user.email,
    tbl_user.jabatan,
    tbl_user.foto_profile,
    tbl_hirarki.id_level,
    tbl_level_hirarki.level,
    tbl_level_hirarki.nama_level,
    tbl_hirarki.status
   FROM ((nr_csr.tbl_hirarki
     JOIN nr_csr.tbl_user ON ((tbl_hirarki.id_user = (tbl_user.id_user)::numeric)))
     JOIN nr_csr.tbl_level_hirarki ON ((tbl_hirarki.id_level = (tbl_level_hirarki.id)::numeric)));


ALTER VIEW nr_csr.v_hirarki OWNER TO nrcsr_user;

--
-- Name: v_info_bank; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_info_bank AS
 SELECT no_agenda,
    atas_nama,
    nama_bank,
    kode_bank,
    kota_bank,
    kode_kota,
    cabang_bank
   FROM nr_csr.tbl_kelayakan;


ALTER VIEW nr_csr.v_info_bank OWNER TO nrcsr_user;

--
-- Name: v_jenis; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_jenis AS
 SELECT jenis,
    count(jenis) AS jumlah,
    to_char(tgl_terima, 'YYYY'::text) AS tahun
   FROM nr_csr.tbl_kelayakan
  GROUP BY tgl_terima, jenis;


ALTER VIEW nr_csr.v_jenis OWNER TO nrcsr_user;

--
-- Name: v_kabupaten_kambing; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_kabupaten_kambing AS
 SELECT kabupaten
   FROM nr_csr.tbl_sub_proposal
  WHERE (kambing > 0)
  GROUP BY kabupaten;


ALTER VIEW nr_csr.v_kabupaten_kambing OWNER TO nrcsr_user;

--
-- Name: v_kabupaten_sapi; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_kabupaten_sapi AS
 SELECT kabupaten
   FROM nr_csr.tbl_sub_proposal
  WHERE (sapi > 0)
  GROUP BY kabupaten;


ALTER VIEW nr_csr.v_kabupaten_sapi OWNER TO nrcsr_user;

--
-- Name: v_kelayakan; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_kelayakan AS
 SELECT tbl_kelayakan.tgl_terima,
    tbl_kelayakan.deskripsi,
    tbl_kelayakan.pengaju_proposal,
    tbl_survei.nilai_bantuan,
    tbl_kelayakan.pilar
   FROM (nr_csr.tbl_kelayakan
     JOIN nr_csr.tbl_survei ON (((tbl_kelayakan.no_agenda)::text = (tbl_survei.no_agenda)::text)))
  WHERE ((to_char(tbl_kelayakan.tgl_terima, 'YYYY'::text) = '2022'::text) AND ((tbl_kelayakan.status)::text = 'Approved'::text));


ALTER VIEW nr_csr.v_kelayakan OWNER TO nrcsr_user;

--
-- Name: v_pembayaran; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_pembayaran AS
 SELECT p.id_pembayaran,
    p.termin,
    p.nilai_approved,
    p.status,
    p.pr_id,
    p.create_date,
    p.create_by,
    p.export_date,
    p.export_by,
    p.id_kelayakan,
    p.deskripsi AS deskripsi_pembayaran,
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
    s.approve_kadiv AS approve_date,
    p.metode
   FROM ((((nr_csr.tbl_pembayaran p
     LEFT JOIN nr_csr.tbl_kelayakan k ON ((p.id_kelayakan = k.id_kelayakan)))
     LEFT JOIN nr_csr.tbl_lembaga l ON ((k.id_lembaga = (l.id_lembaga)::numeric)))
     LEFT JOIN nr_csr.tbl_proker pr ON ((k.id_proker = (pr.id_proker)::numeric)))
     LEFT JOIN nr_csr.tbl_survei s ON ((s.id_kelayakan = (k.id_kelayakan)::numeric)));


ALTER VIEW nr_csr.v_pembayaran OWNER TO nrcsr_user;

--
-- Name: v_prioritas; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_prioritas AS
 SELECT tbl_kelayakan.no_agenda,
    tbl_kelayakan.id_proker,
    tbl_proker.prioritas,
    tbl_proker.tahun,
    tbl_survei.nilai_approved
   FROM ((nr_csr.tbl_kelayakan
     JOIN nr_csr.tbl_proker ON ((tbl_kelayakan.id_proker = (tbl_proker.id_proker)::numeric)))
     JOIN nr_csr.tbl_survei ON (((tbl_kelayakan.no_agenda)::text = (tbl_survei.no_agenda)::text)))
  WHERE ((tbl_kelayakan.id_proker IS NOT NULL) AND (tbl_proker.prioritas IS NOT NULL) AND ((tbl_kelayakan.status)::text = 'Approved'::text));


ALTER VIEW nr_csr.v_prioritas OWNER TO nrcsr_user;

--
-- Name: v_proposal; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_proposal AS
 SELECT k.id_kelayakan,
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
    u.nama AS nama_maker,
    u.email AS email_maker,
    u.jabatan AS jabatan_maker,
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
   FROM ((((nr_csr.tbl_kelayakan k
     LEFT JOIN nr_csr.tbl_pengirim p ON ((k.id_pengirim = (p.id_pengirim)::numeric)))
     LEFT JOIN nr_csr.tbl_lembaga l ON ((k.id_lembaga = (l.id_lembaga)::numeric)))
     LEFT JOIN nr_csr.tbl_user u ON ((k.created_by = (u.id_user)::numeric)))
     LEFT JOIN nr_csr.tbl_proker pr ON ((k.id_proker = (pr.id_proker)::numeric)));


ALTER VIEW nr_csr.v_proposal OWNER TO nrcsr_user;

--
-- Name: v_provinsi_kambing; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_provinsi_kambing AS
 SELECT provinsi
   FROM nr_csr.tbl_sub_proposal
  WHERE (kambing > 0)
  GROUP BY provinsi;


ALTER VIEW nr_csr.v_provinsi_kambing OWNER TO nrcsr_user;

--
-- Name: v_provinsi_sapi; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_provinsi_sapi AS
 SELECT provinsi
   FROM nr_csr.tbl_sub_proposal
  WHERE (sapi > 0)
  GROUP BY provinsi;


ALTER VIEW nr_csr.v_provinsi_sapi OWNER TO nrcsr_user;

--
-- Name: v_realisasi_ap; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_realisasi_ap AS
 SELECT id_realisasi,
    no_proposal,
    tgl_proposal,
    pengirim,
    tgl_realisasi,
    sifat,
    perihal,
    besar_permohonan,
    kategori,
    nilai_bantuan,
    status,
    provinsi,
    kabupaten,
    deskripsi,
    id_proker,
    proker,
    pilar,
    gols,
    nama_yayasan,
    alamat,
    pic,
    jabatan,
    no_telp,
    no_rekening,
    atas_nama,
    nama_bank,
    kota_bank,
    cabang_bank,
    created_by,
    created_date,
    jenis,
    perusahaan,
    to_char(tgl_realisasi, 'MM'::text) AS bulan,
    tahun,
    status_date
   FROM nr_csr.tbl_realisasi_ap;


ALTER VIEW nr_csr.v_realisasi_ap OWNER TO nrcsr_user;

--
-- Name: v_sektor; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_sektor AS
 SELECT sektor_bantuan,
    count(sektor_bantuan) AS jumlah,
    to_char(tgl_terima, 'YYYY'::text) AS tahun
   FROM nr_csr.tbl_kelayakan
  GROUP BY tgl_terima, sektor_bantuan;


ALTER VIEW nr_csr.v_sektor OWNER TO nrcsr_user;

--
-- Name: v_spk; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_spk AS
 SELECT spk_id,
    nomor,
    tanggal,
    pekerjaan_id,
    status,
    catatan,
    created_by,
    created_date,
    id_vendor,
    file_spk,
    nilai_kesepakatan,
    sph_id,
    bakn_id,
    start_date,
    due_date,
    durasi,
    response_date,
    response_by
   FROM nr_csr.tbl_spk;


ALTER VIEW nr_csr.v_spk OWNER TO nrcsr_user;

--
-- Name: v_spph; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_spph AS
 SELECT tbl_spph.spph_id,
    tbl_spph.nomor,
    tbl_spph.tanggal,
    to_char((tbl_spph.tanggal)::timestamp without time zone, 'MM'::text) AS bulan,
    to_char((tbl_spph.tanggal)::timestamp without time zone, 'YYYY'::text) AS tahun,
    tbl_spph.pekerjaan_id,
    tbl_pekerjaan.nama_pekerjaan,
    tbl_spph.status,
    tbl_spph.catatan,
    tbl_spph.created_by,
    tbl_spph.created_date,
    tbl_spph.id_vendor,
    tbl_spph.file_spph,
    tbl_spph.response_date,
    tbl_vendor.nama_perusahaan,
    tbl_pekerjaan.kak,
    tbl_pekerjaan.ringkasan
   FROM ((nr_csr.tbl_spph
     JOIN nr_csr.tbl_pekerjaan ON (((tbl_spph.pekerjaan_id)::integer = tbl_pekerjaan.pekerjaan_id)))
     JOIN nr_csr.tbl_vendor ON (((tbl_spph.id_vendor)::integer = tbl_vendor.vendor_id)));


ALTER VIEW nr_csr.v_spph OWNER TO nrcsr_user;

--
-- Name: v_ykpp; Type: VIEW; Schema: nr_csr; Owner: nrcsr_user
--

CREATE VIEW nr_csr.v_ykpp AS
 SELECT k.id_kelayakan,
    k.no_agenda,
    k.tgl_terima,
    k.no_surat,
    k.tgl_surat,
    k.sebagai,
    k.provinsi,
    k.kabupaten,
    k.kelurahan,
    k.kodepos,
    k.bantuan_untuk,
    k.contact_person,
    k.nilai_pengajuan,
    k.sektor_bantuan,
    k.nama_bank,
    k.atas_nama,
    k.no_rekening,
    k.nilai_bantuan,
    k.nama_anggota,
    k.fraksi,
    k.jabatan,
    k.pic,
    k.asal_surat,
    k.komisi,
    k.sifat,
    k.status,
    k.email_pengaju,
    k.nama_person,
    k.mata_uang_pengajuan,
    k.mata_uang_bantuan,
    k.proposal,
    k.create_by,
    k.create_date,
    k.pengirim,
    k.perihal,
    k.pengaju_proposal,
    k.alamat,
    k.cabang_bank,
    k.jenis,
    k.hewan_kurban,
    k.jumlah_hewan,
    k.kode_bank,
    k.kode_kota,
    k.kota_bank,
    k.cabang,
    k.deskripsi,
    k.pilar,
    k.tpb,
    k.kode_indikator,
    k.keterangan_indikator,
    k.proker,
    k.indikator,
    k.smap,
    k.ykpp,
    k.checklist_by,
    k.checklist_date,
    k.nominal_approved AS jumlah_pembayaran,
    k.nominal_fee AS fee,
    k.total_ykpp AS subtotal,
    k.status_ykpp,
    k.approved_ykpp_by,
    k.approved_ykpp_date,
    k.submited_ykpp_by,
    k.submited_ykpp_date,
    k.no_surat_ykpp,
    k.tgl_surat_ykpp,
    k.penyaluran_ke,
    k.id_lembaga,
    k.id_pengirim,
    k.created_by,
    k.created_date,
    k.id_proker,
    k.surat_ykpp,
    k.tahun_ykpp,
    p.prioritas,
    p.gols
   FROM (nr_csr.tbl_kelayakan k
     LEFT JOIN nr_csr.tbl_proker p ON ((k.id_proker = (p.id_proker)::numeric)))
  WHERE ((k.ykpp)::text = 'Yes'::text);


ALTER VIEW nr_csr.v_ykpp OWNER TO nrcsr_user;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: nrcsr_user
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO nrcsr_user;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: nrcsr_user
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO nrcsr_user;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nrcsr_user
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: nrcsr_user
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO nrcsr_user;

--
-- Name: users; Type: TABLE; Schema: public; Owner: nrcsr_user
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO nrcsr_user;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: nrcsr_user
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO nrcsr_user;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nrcsr_user
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: migrations id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.migrations ALTER COLUMN id SET DEFAULT nextval('nr_csr.migrations_id_seq'::regclass);


--
-- Name: tbl_anggaran id_anggaran; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_anggaran ALTER COLUMN id_anggaran SET DEFAULT nextval('nr_csr.tbl_anggaran_id_anggaran_seq'::regclass);


--
-- Name: tbl_anggota id_anggota; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_anggota ALTER COLUMN id_anggota SET DEFAULT nextval('nr_csr.tbl_anggota_id_anggota_seq'::regclass);


--
-- Name: tbl_assessment_vendor assessment_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_assessment_vendor ALTER COLUMN assessment_id SET DEFAULT nextval('nr_csr.tbl_assessment_vendor_assessment_id_seq'::regclass);


--
-- Name: tbl_bakn bakn_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_bakn ALTER COLUMN bakn_id SET DEFAULT nextval('nr_csr.tbl_bakn_bakn_id_seq'::regclass);


--
-- Name: tbl_bank bank_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_bank ALTER COLUMN bank_id SET DEFAULT nextval('nr_csr.tbl_bank_bank_id_seq'::regclass);


--
-- Name: tbl_bast_dana id_bast_dana; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_bast_dana ALTER COLUMN id_bast_dana SET DEFAULT nextval('nr_csr.tbl_bast_dana_id_bast_dana_seq'::regclass);


--
-- Name: tbl_detail_approval id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_detail_approval ALTER COLUMN id SET DEFAULT nextval('nr_csr.tbl_detail_approval_id_seq'::regclass);


--
-- Name: tbl_detail_kriteria id_detail_kriteria; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_detail_kriteria ALTER COLUMN id_detail_kriteria SET DEFAULT nextval('nr_csr.tbl_detail_kriteria_id_detail_kriteria_seq'::regclass);


--
-- Name: tbl_detail_spk id_detail_spk; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_detail_spk ALTER COLUMN id_detail_spk SET DEFAULT nextval('nr_csr.tbl_detail_spk_id_detail_spk_seq'::regclass);


--
-- Name: tbl_dokumen id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_dokumen ALTER COLUMN id SET DEFAULT nextval('nr_csr.tbl_dokumen_id_seq'::regclass);


--
-- Name: tbl_dokumen_mandatori_proyek dokumen_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_dokumen_mandatori_proyek ALTER COLUMN dokumen_id SET DEFAULT nextval('nr_csr.tbl_dokumen_mandatori_proyek_dokumen_id_seq'::regclass);


--
-- Name: tbl_dokumen_mandatori_vendor dokumen_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_dokumen_mandatori_vendor ALTER COLUMN dokumen_id SET DEFAULT nextval('nr_csr.tbl_dokumen_mandatori_vendor_dokumen_id_seq'::regclass);


--
-- Name: tbl_dokumen_vendor dokumen_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_dokumen_vendor ALTER COLUMN dokumen_id SET DEFAULT nextval('nr_csr.tbl_dokumen_vendor_dokumen_id_seq'::regclass);


--
-- Name: tbl_exception error_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_exception ALTER COLUMN error_id SET DEFAULT nextval('nr_csr.tbl_exception_error_id_seq'::regclass);


--
-- Name: tbl_hirarki id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_hirarki ALTER COLUMN id SET DEFAULT nextval('nr_csr.tbl_hirarki_id_seq'::regclass);


--
-- Name: tbl_izin_usaha izin_usaha_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_izin_usaha ALTER COLUMN izin_usaha_id SET DEFAULT nextval('nr_csr.tbl_izin_usaha_izin_usaha_id_seq'::regclass);


--
-- Name: tbl_kebijakan id_kebijakan; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_kebijakan ALTER COLUMN id_kebijakan SET DEFAULT nextval('nr_csr.tbl_kebijakan_id_kebijakan_seq'::regclass);


--
-- Name: tbl_kelayakan id_kelayakan; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_kelayakan ALTER COLUMN id_kelayakan SET DEFAULT nextval('nr_csr.tbl_kelayakan_id_kelayakan_seq'::regclass);


--
-- Name: tbl_ktp_pengurus ktp_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_ktp_pengurus ALTER COLUMN ktp_id SET DEFAULT nextval('nr_csr.tbl_ktp_pengurus_ktp_id_seq'::regclass);


--
-- Name: tbl_lampiran_ap id_lampiran; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_lampiran_ap ALTER COLUMN id_lampiran SET DEFAULT nextval('nr_csr.tbl_lampiran_ap_id_lampiran_seq'::regclass);


--
-- Name: tbl_lampiran_pekerjaan lampiran_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_lampiran_pekerjaan ALTER COLUMN lampiran_id SET DEFAULT nextval('nr_csr.tbl_lampiran_pekerjaan_lampiran_id_seq'::regclass);


--
-- Name: tbl_lampiran_vendor lampiran_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_lampiran_vendor ALTER COLUMN lampiran_id SET DEFAULT nextval('nr_csr.tbl_lampiran_vendor_lampiran_id_seq'::regclass);


--
-- Name: tbl_lembaga id_lembaga; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_lembaga ALTER COLUMN id_lembaga SET DEFAULT nextval('nr_csr.tbl_lembaga_id_lembaga_seq'::regclass);


--
-- Name: tbl_level_hirarki id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_level_hirarki ALTER COLUMN id SET DEFAULT nextval('nr_csr.tbl_level_hirarki_id_seq'::regclass);


--
-- Name: tbl_log id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_log ALTER COLUMN id SET DEFAULT nextval('nr_csr.tbl_log_id_seq'::regclass);


--
-- Name: tbl_log_pekerjaan log_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_log_pekerjaan ALTER COLUMN log_id SET DEFAULT nextval('nr_csr.tbl_log_pekerjaan_log_id_seq'::regclass);


--
-- Name: tbl_log_relokasi id_log; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_log_relokasi ALTER COLUMN id_log SET DEFAULT nextval('nr_csr.tbl_log_relokasi_id_log_seq'::regclass);


--
-- Name: tbl_log_vendor log_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_log_vendor ALTER COLUMN log_id SET DEFAULT nextval('nr_csr.tbl_log_vendor_log_id_seq'::regclass);


--
-- Name: tbl_pejabat id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pejabat ALTER COLUMN id SET DEFAULT nextval('nr_csr.tbl_pejabat_id_seq'::regclass);


--
-- Name: tbl_pekerjaan pekerjaan_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pekerjaan ALTER COLUMN pekerjaan_id SET DEFAULT nextval('nr_csr.tbl_pekerjaan_pekerjaan_id_seq'::regclass);


--
-- Name: tbl_pengalaman_kerja pengalaman_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pengalaman_kerja ALTER COLUMN pengalaman_id SET DEFAULT nextval('nr_csr.tbl_pengalaman_kerja_pengalaman_id_seq'::regclass);


--
-- Name: tbl_pengembalian_anggaran id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pengembalian_anggaran ALTER COLUMN id SET DEFAULT nextval('nr_csr.tbl_pengembalian_anggaran_id_seq'::regclass);


--
-- Name: tbl_pengirim id_pengirim; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pengirim ALTER COLUMN id_pengirim SET DEFAULT nextval('nr_csr.tbl_pengirim_id_pengirim_seq'::regclass);


--
-- Name: tbl_perusahaan id_perusahaan; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_perusahaan ALTER COLUMN id_perusahaan SET DEFAULT nextval('nr_csr.tbl_perusahaan_id_perusahaan_seq'::regclass);


--
-- Name: tbl_pilar id_pilar; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pilar ALTER COLUMN id_pilar SET DEFAULT nextval('nr_csr.tbl_pilar_id_pilar_seq'::regclass);


--
-- Name: tbl_proker id_proker; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_proker ALTER COLUMN id_proker SET DEFAULT nextval('nr_csr.tbl_proker_id_proker_seq'::regclass);


--
-- Name: tbl_realisasi_ap id_realisasi; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_realisasi_ap ALTER COLUMN id_realisasi SET DEFAULT nextval('nr_csr.tbl_realisasi_ap_id_realisasi_seq'::regclass);


--
-- Name: tbl_relokasi id_relokasi; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_relokasi ALTER COLUMN id_relokasi SET DEFAULT nextval('nr_csr.tbl_relokasi_id_relokasi_seq'::regclass);


--
-- Name: tbl_sdg id_sdg; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sdg ALTER COLUMN id_sdg SET DEFAULT nextval('nr_csr.tbl_sdg_id_sdg_seq'::regclass);


--
-- Name: tbl_sektor id_sektor; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sektor ALTER COLUMN id_sektor SET DEFAULT nextval('nr_csr.tbl_sektor_id_sektor_seq'::regclass);


--
-- Name: tbl_sph sph_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sph ALTER COLUMN sph_id SET DEFAULT nextval('nr_csr.tbl_sph_sph_id_seq'::regclass);


--
-- Name: tbl_spk spk_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_spk ALTER COLUMN spk_id SET DEFAULT nextval('nr_csr.tbl_spk_spk_id_seq'::regclass);


--
-- Name: tbl_spph spph_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_spph ALTER COLUMN spph_id SET DEFAULT nextval('nr_csr.tbl_spph_spph_id_seq'::regclass);


--
-- Name: tbl_sub_pilar id_sub_pilar; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sub_pilar ALTER COLUMN id_sub_pilar SET DEFAULT nextval('nr_csr.tbl_sub_pilar_id_sub_pilar_seq'::regclass);


--
-- Name: tbl_sub_proposal id_sub_proposal; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sub_proposal ALTER COLUMN id_sub_proposal SET DEFAULT nextval('nr_csr.tbl_sub_proposal_id_sub_proposal_seq'::regclass);


--
-- Name: tbl_user id_user; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_user ALTER COLUMN id_user SET DEFAULT nextval('nr_csr.tbl_user_id_user_seq'::regclass);


--
-- Name: tbl_vendor vendor_id; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_vendor ALTER COLUMN vendor_id SET DEFAULT nextval('nr_csr.tbl_vendor_vendor_id_seq'::regclass);


--
-- Name: tbl_wilayah id_wilayah; Type: DEFAULT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_wilayah ALTER COLUMN id_wilayah SET DEFAULT nextval('nr_csr.tbl_wilayah_id_wilayah_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: nrcsr_user
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: nrcsr_user
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: TBL_PEMBAYARAN_copy1; Type: TABLE DATA; Schema: NR_CSR; Owner: nrcsr_user
--

COPY "NR_CSR"."TBL_PEMBAYARAN_copy1" (id_pembayaran, no_agenda, no_bast, no_ba, termin, nilai_approved, persen, status, pr_id, create_date, create_by, export_date, export_by, id_kelayakan, deskripsi, fee, jumlah_pembayaran, subtotal, fee_persen, status_ykpp, approved_ykpp_by, approved_ykpp_date, submited_ykpp_by, submited_ykpp_date, no_surat_ykpp, tgl_surat_ykpp, surat_ykpp, tahun_ykpp, penyaluran_ke, metode) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_resets_table	1
3	2019_08_19_000000_create_failed_jobs_table	1
4	2026_01_12_000001_create_nr_csr_schemas	1
5	2026_01_12_000010_create_nr_csr_tables_part_1	2
6	2026_01_12_000011_create_nr_csr_tables_part_2	2
7	2026_01_12_000012_create_nr_csr_tables_part_3	2
8	2026_01_12_000013_create_nr_csr_tables_part_4	2
9	2026_01_12_000014_create_nr_csr_tables_part_5	2
10	2026_01_12_000015_create_nr_csr_tables_part_6	2
11	2026_01_12_000016_create_nr_csr_tables_part_7	2
12	2026_01_12_000130_add_nr_csr_constraints_and_indexes	2
13	2026_01_12_000131_add_nr_csr_foreign_keys_todo	2
14	2026_01_12_000132_create_nr_csr_views	3
15	2026_01_13_131159_change_id_perusahaan_to_integer_in_tbl_users	3
16	2026_01_13_131759_fix_id_perusahaan_type_in_all_tables	3
\.


--
-- Data for Name: no_agenda; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.no_agenda (tahun, last_no) FROM stdin;
\.


--
-- Data for Name: tbl_alokasi; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_alokasi (id_alokasi, id_relokasi, proker, provinsi, tahun, nominal_alokasi, sektor_bantuan) FROM stdin;
\.


--
-- Data for Name: tbl_anggaran; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_anggaran (id_anggaran, nominal, tahun, perusahaan_old, id_perusahaan, perusahaan) FROM stdin;
1	2100000000.00	2026	\N	1	\N
2	2725800000.00	2025	\N	1	\N
\.


--
-- Data for Name: tbl_anggota; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_anggota (id_anggota, nama_anggota, fraksi, komisi, jabatan, staf_ahli, no_telp, foto_profile, status) FROM stdin;
\.


--
-- Data for Name: tbl_area; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_area (id_area, area_kerja, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: tbl_assessment_vendor; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_assessment_vendor (assessment_id, tanggal, id_vendor, tahun, created_by, created_date) FROM stdin;
\.


--
-- Data for Name: tbl_bakn; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_bakn (bakn_id, nomor, tanggal, pekerjaan_id, status, catatan, created_by, created_date, id_vendor, file_bakn, nilai_kesepakatan, sph_id, response_date, response_by) FROM stdin;
\.


--
-- Data for Name: tbl_bank; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_bank (bank_id, nama_bank) FROM stdin;
\.


--
-- Data for Name: tbl_bast_dana; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_bast_dana (id_bast_dana, no_agenda, pilar, bantuan_untuk, proposal_dari, alamat, provinsi, kabupaten, penanggung_jawab, bertindak_sebagai, no_surat, tgl_surat, perihal, nama_bank, no_rekening, atas_nama, no_bast_dana, created_by, created_date, no_bast_pihak_kedua, tgl_bast, nama_pejabat, jabatan_pejabat, nama_barang, jumlah_barang, satuan_barang, no_pelimpahan, tgl_pelimpahan, pihak_kedua, status, approved_by, approved_date, deskripsi, id_kelayakan, approver_id) FROM stdin;
\.


--
-- Data for Name: tbl_city; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_city (id_city, city_name) FROM stdin;
\.


--
-- Data for Name: tbl_detail_approval; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_detail_approval (id, id_kelayakan, id_hirarki, id_user, catatan, status, status_date, task_date, action_date, phase, created_by, pesan) FROM stdin;
\.


--
-- Data for Name: tbl_detail_kriteria; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_detail_kriteria (id_detail_kriteria, no_agenda, kriteria, created_at, updated_at, id_kelayakan) FROM stdin;
\.


--
-- Data for Name: tbl_detail_spk; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_detail_spk (id_detail_spk, no_agenda, "COLUMN1", "COLUMN2", "COLUMN3") FROM stdin;
\.


--
-- Data for Name: tbl_dokumen; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_dokumen (id, nama_dokumen, mandatori) FROM stdin;
\.


--
-- Data for Name: tbl_dokumen_mandatori_proyek; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_dokumen_mandatori_proyek (dokumen_id, nama_dokumen) FROM stdin;
\.


--
-- Data for Name: tbl_dokumen_mandatori_vendor; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_dokumen_mandatori_vendor (dokumen_id, nama_dokumen) FROM stdin;
\.


--
-- Data for Name: tbl_dokumen_vendor; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_dokumen_vendor (dokumen_id, id_vendor, nama_dokumen, nomor, tanggal, masa_berlaku, keterangan, catatan, file, "PARAMETER1", "PARAMETER2", "PARAMETER3", "PARAMETER4", "PARAMETER5", status, status_date, created_date, created_by, verifikasi_date, verifikasi_by) FROM stdin;
\.


--
-- Data for Name: tbl_evaluasi; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_evaluasi (id_evaluasi, no_agenda, rencana_anggaran, dokumen, denah, syarat, "EVALUATOR1", "CATATAN1", "EVALUATOR2", "CATATAN2", kadep, kadiv, status, approve_date, ket_kadiv, "KET_KADIN1", "KET_KADIN2", keterangan, approve_kadep, approve_kadiv, revisi_by, revisi_date, reject_by, reject_date, create_by, create_date, created_at, updated_at, "CATATAN1_NEW", "CATATAN2_NEW", id_kelayakan, created_by, sekper, dirut, ket_sekper, ket_dirut, approve_sekper, approve_dirut) FROM stdin;
\.


--
-- Data for Name: tbl_exception; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_exception (error_id, exception, error_date, error_by, status, remark) FROM stdin;
\.


--
-- Data for Name: tbl_hirarki; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_hirarki (id, id_user, id_level, status) FROM stdin;
\.


--
-- Data for Name: tbl_izin_usaha; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_izin_usaha (izin_usaha_id, id_vendor, nib, jenis_kbli, kode_kbli, alamat, file, created_date, created_by) FROM stdin;
\.


--
-- Data for Name: tbl_kebijakan; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_kebijakan (id_kebijakan, kebijakan) FROM stdin;
\.


--
-- Data for Name: tbl_kelayakan; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_kelayakan (no_agenda, tgl_terima, no_surat, tgl_surat, sebagai, provinsi, kabupaten, kelurahan, kodepos, bantuan_untuk, contact_person, nilai_pengajuan, sektor_bantuan, nama_bank, atas_nama, no_rekening, nilai_bantuan, nama_anggota, fraksi, jabatan, pic, asal_surat, komisi, sifat, status, email_pengaju, nama_person, mata_uang_pengajuan, mata_uang_bantuan, proposal, create_by, create_date, pengirim, perihal, pengaju_proposal, alamat, cabang_bank, jenis, hewan_kurban, jumlah_hewan, kode_bank, kode_kota, kota_bank, cabang, deskripsi, pilar, tpb, kode_indikator, keterangan_indikator, proker, indikator, smap, ykpp, checklist_by, checklist_date, nominal_approved, nominal_fee, total_ykpp, status_ykpp, approved_ykpp_by, approved_ykpp_date, submited_ykpp_by, submited_ykpp_date, no_surat_ykpp, tgl_surat_ykpp, penyaluran_ke_old, id_kelayakan, surat_ykpp, tahun_ykpp, penyaluran_ke, id_lembaga, id_pengirim, created_by, created_date, id_proker, kecamatan) FROM stdin;
\.


--
-- Data for Name: tbl_kode; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_kode (kode, provinsi) FROM stdin;
\.


--
-- Data for Name: tbl_ktp_pengurus; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_ktp_pengurus (ktp_id, id_vendor, nomor, nama, jabatan, no_telp, email, file, created_date, created_by) FROM stdin;
\.


--
-- Data for Name: tbl_lampiran; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_lampiran (id_lampiran, no_agenda, nama, lampiran, upload_by, upload_date, created_at, updated_at, id_kelayakan, created_by) FROM stdin;
\.


--
-- Data for Name: tbl_lampiran_ap; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_lampiran_ap (id_lampiran, id_realisasi, nama, lampiran, upload_by, upload_date) FROM stdin;
\.


--
-- Data for Name: tbl_lampiran_pekerjaan; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_lampiran_pekerjaan (lampiran_id, id_vendor, nomor, nama_file, file, type, size, status, catatan, upload_by, upload_date, nama_dokumen, pekerjaan_id) FROM stdin;
\.


--
-- Data for Name: tbl_lampiran_vendor; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_lampiran_vendor (lampiran_id, id_vendor, nomor, nama_file, file, type, size, status, catatan, upload_by, upload_date, nama_dokumen) FROM stdin;
\.


--
-- Data for Name: tbl_lembaga; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_lembaga (id_lembaga, nama_lembaga, nama_pic, alamat, no_telp, jabatan, no_rekening, atas_nama, nama_bank, cabang, kota_bank, kode_bank, kode_kota, perusahaan, id_perusahaan) FROM stdin;
\.


--
-- Data for Name: tbl_level_hirarki; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_level_hirarki (id, level, nama_level) FROM stdin;
\.


--
-- Data for Name: tbl_log; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_log (id, id_kelayakan, keterangan, created_by, created_date) FROM stdin;
\.


--
-- Data for Name: tbl_log_pekerjaan; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_log_pekerjaan (log_id, pekerjaan_id, update_by, update_date, action, keterangan) FROM stdin;
\.


--
-- Data for Name: tbl_log_relokasi; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_log_relokasi (id_log, id_proker, keterangan, status, status_date) FROM stdin;
\.


--
-- Data for Name: tbl_log_vendor; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_log_vendor (log_id, id_vendor, update_by, update_date, action, keterangan) FROM stdin;
\.


--
-- Data for Name: tbl_pejabat; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_pejabat (id, nama, jabatan, sk, tanggal) FROM stdin;
\.


--
-- Data for Name: tbl_pekerjaan; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_pekerjaan (pekerjaan_id, nama_pekerjaan, tahun, proker_id, nilai_perkiraan, status, created_by, created_date, ringkasan, kak, id_vendor, nilai_penawaran, nilai_kesepakatan) FROM stdin;
\.


--
-- Data for Name: tbl_pembayaran; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_pembayaran (id_pembayaran, no_agenda, no_bast, no_ba, termin, nilai_approved, persen, status, pr_id, create_date, create_by, export_date, export_by, id_kelayakan, deskripsi, fee, jumlah_pembayaran, subtotal, fee_persen, status_ykpp, approved_ykpp_by, approved_ykpp_date, submited_ykpp_by, submited_ykpp_date, no_surat_ykpp, tgl_surat_ykpp, surat_ykpp, tahun_ykpp, penyaluran_ke, metode) FROM stdin;
\.


--
-- Data for Name: tbl_pembayaran_vendor; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_pembayaran_vendor (id_pembayaran, pekerjaan_id, no_bast, no_ba, termin, nilai_kesepakatan, persen, jumlah_pembayaran, status, pr_id, create_date, create_by, export_date, export_by, id_vendor) FROM stdin;
\.


--
-- Data for Name: tbl_pengalaman_kerja; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_pengalaman_kerja (pengalaman_id, id_vendor, no_kontrak, tgl_kontrak, pekerjaan, pemberi_kerja, lokasi, file, created_by, created_date, nilai) FROM stdin;
\.


--
-- Data for Name: tbl_pengembalian_anggaran; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_pengembalian_anggaran (id, anggaran_id, pengembalian, created_by, created_date) FROM stdin;
\.


--
-- Data for Name: tbl_pengirim; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_pengirim (id_pengirim, pengirim, created_at, updated_at, perusahaan, id_perusahaan, status) FROM stdin;
\.


--
-- Data for Name: tbl_perusahaan; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_perusahaan (id_perusahaan, nama_perusahaan, kategori, kode, foto_profile, alamat, no_telp, pic, status) FROM stdin;
1	PT Nusantara Regas	Holding	NR	\N	Wisma Nusantara lt. 19, Jl. M.H. Thamrin No.59, Jakarta 10350, Indonesia. +62 21 315 9543-44 · +62 21 315 9525. Home. Home. About Us.	\N	\N	Active
\.


--
-- Data for Name: tbl_pilar; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_pilar (id_pilar, kode, nama) FROM stdin;
1	1	Pendidikan & Kebudayaan
2	2	Pemberdayaan Masyarakat
3	3	Sosial
4	4	Lingkungan
5	5	Infrastruktur
\.


--
-- Data for Name: tbl_proker; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_proker (id_proker, proker, id_indikator, tahun, anggaran, prioritas, eb, pilar, gols, perusahaan, id_perusahaan, kode_tpb) FROM stdin;
\.


--
-- Data for Name: tbl_provinsi; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_provinsi (id_provinsi, kode_provinsi, provinsi) FROM stdin;
\.


--
-- Data for Name: tbl_realisasi_ap; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_realisasi_ap (id_realisasi, no_proposal, tgl_proposal, pengirim, tgl_realisasi, sifat, perihal, besar_permohonan, kategori, nilai_bantuan, status, provinsi, kabupaten, deskripsi, id_proker, proker, pilar, gols, nama_yayasan, alamat, pic, jabatan, no_telp, no_rekening, atas_nama, nama_bank, kota_bank, cabang_bank, created_by, created_date, jenis, perusahaan, tahun, status_date, prioritas, id_perusahaan, kecamatan, kelurahan) FROM stdin;
\.


--
-- Data for Name: tbl_relokasi; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_relokasi (id_relokasi, proker_asal, nominal_asal, proker_tujuan, nominal_tujuan, request_by, request_date, status, approver, tahun, perusahaan, status_date, nominal_relokasi, id_perusahaan) FROM stdin;
\.


--
-- Data for Name: tbl_role; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_role (id_role, role, role_name) FROM stdin;
\.


--
-- Data for Name: tbl_sdg; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_sdg (id_sdg, nama, kode, pilar) FROM stdin;
\.


--
-- Data for Name: tbl_sektor; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_sektor (id_sektor, kode_sektor, sektor_bantuan) FROM stdin;
\.


--
-- Data for Name: tbl_sph; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_sph (sph_id, nomor, tanggal, pekerjaan_id, status, catatan, created_by, created_date, id_vendor, file_sph, nilai_penawaran, spph_id) FROM stdin;
\.


--
-- Data for Name: tbl_spk; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_spk (spk_id, nomor, tanggal, pekerjaan_id, status, catatan, created_by, created_date, id_vendor, file_spk, nilai_kesepakatan, sph_id, bakn_id, start_date, due_date, durasi, response_date, response_by) FROM stdin;
\.


--
-- Data for Name: tbl_spph; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_spph (spph_id, nomor, tanggal, pekerjaan_id, status, catatan, created_by, created_date, id_vendor, file_spph, response_date) FROM stdin;
\.


--
-- Data for Name: tbl_sub_pilar; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_sub_pilar (id_sub_pilar, tpb, kode_indikator, keterangan, pilar) FROM stdin;
\.


--
-- Data for Name: tbl_sub_proposal; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_sub_proposal (id_sub_proposal, no_agenda, no_sub_agenda, nama_ketua, nama_lembaga, kambing, sapi, total, harga_kambing, harga_sapi, provinsi, kabupaten, alamat, fee, subtotal, ppn) FROM stdin;
\.


--
-- Data for Name: tbl_survei; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_survei (id_survei, no_agenda, hasil_konfirmasi, hasil_survei, usulan, bantuan_berupa, nilai_bantuan, nilai_approved, termin, "RUPIAH1", "RUPIAH2", "RUPIAH3", "RUPIAH4", "SURVEI1", "SURVEI2", status, kadep, kadiv, "KET_KADIN1", "KET_KADIN2", ket_kadiv, keterangan, approve_date, approve_kadep, approve_kadiv, create_by, create_date, revisi_by, revisi_date, created_at, updated_at, bast, spk, pks, vendor_id, id_kelayakan, created_by, sekper, dirut, ket_sekper, ket_dirut, approve_sekper, approve_dirut, "PERSEN1", "PERSEN2", "PERSEN3", "PERSEN4") FROM stdin;
\.


--
-- Data for Name: tbl_user; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_user (id_user, username, email, nama, jabatan, password, role, area_kerja, status, foto_profile, remember_token, jk, old_email, perusahaan, vendor_id, id_perusahaan, no_sk, tgl_sk) FROM stdin;
999999	superadmin	superadmin@local.test	Super Admin (Local)	Administrator	$2y$10$5W4XPVx1V1xRE59bE.QiMe36IGeglumPtC78gmN68G0JTD5JfL6Pm	Admin	\N	Active	\N	\N	\N	\N	\N	\N	1	\N	\N
\.


--
-- Data for Name: tbl_vendor; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_vendor (vendor_id, nama_perusahaan, alamat, no_telp, email, website, no_ktp, nama_pic, jabatan, email_pic, no_hp, file_ktp, created_at, updated_at, status, approve_by, approve_date) FROM stdin;
\.


--
-- Data for Name: tbl_wilayah; Type: TABLE DATA; Schema: nr_csr; Owner: nrcsr_user
--

COPY nr_csr.tbl_wilayah (id_wilayah, province, city, city_name, sub_district, village, postal_code) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: nrcsr_user
--

COPY public.failed_jobs (id, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: nrcsr_user
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: nrcsr_user
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.migrations_id_seq', 16, true);


--
-- Name: tbl_anggaran_id_anggaran_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_anggaran_id_anggaran_seq', 2, true);


--
-- Name: tbl_anggota_id_anggota_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_anggota_id_anggota_seq', 1, false);


--
-- Name: tbl_assessment_vendor_assessment_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_assessment_vendor_assessment_id_seq', 1, false);


--
-- Name: tbl_bakn_bakn_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_bakn_bakn_id_seq', 1, false);


--
-- Name: tbl_bank_bank_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_bank_bank_id_seq', 1, false);


--
-- Name: tbl_bast_dana_id_bast_dana_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_bast_dana_id_bast_dana_seq', 1, false);


--
-- Name: tbl_detail_approval_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_detail_approval_id_seq', 1, false);


--
-- Name: tbl_detail_kriteria_id_detail_kriteria_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_detail_kriteria_id_detail_kriteria_seq', 1, false);


--
-- Name: tbl_detail_spk_id_detail_spk_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_detail_spk_id_detail_spk_seq', 1, false);


--
-- Name: tbl_dokumen_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_dokumen_id_seq', 1, false);


--
-- Name: tbl_dokumen_mandatori_proyek_dokumen_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_dokumen_mandatori_proyek_dokumen_id_seq', 1, false);


--
-- Name: tbl_dokumen_mandatori_vendor_dokumen_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_dokumen_mandatori_vendor_dokumen_id_seq', 1, false);


--
-- Name: tbl_dokumen_vendor_dokumen_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_dokumen_vendor_dokumen_id_seq', 1, false);


--
-- Name: tbl_exception_error_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_exception_error_id_seq', 1, false);


--
-- Name: tbl_hirarki_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_hirarki_id_seq', 1, false);


--
-- Name: tbl_izin_usaha_izin_usaha_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_izin_usaha_izin_usaha_id_seq', 1, false);


--
-- Name: tbl_kebijakan_id_kebijakan_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_kebijakan_id_kebijakan_seq', 1, false);


--
-- Name: tbl_kelayakan_id_kelayakan_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_kelayakan_id_kelayakan_seq', 1, false);


--
-- Name: tbl_ktp_pengurus_ktp_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_ktp_pengurus_ktp_id_seq', 1, false);


--
-- Name: tbl_lampiran_ap_id_lampiran_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_lampiran_ap_id_lampiran_seq', 1, false);


--
-- Name: tbl_lampiran_pekerjaan_lampiran_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_lampiran_pekerjaan_lampiran_id_seq', 1, false);


--
-- Name: tbl_lampiran_vendor_lampiran_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_lampiran_vendor_lampiran_id_seq', 1, false);


--
-- Name: tbl_lembaga_id_lembaga_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_lembaga_id_lembaga_seq', 1, false);


--
-- Name: tbl_level_hirarki_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_level_hirarki_id_seq', 1, false);


--
-- Name: tbl_log_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_log_id_seq', 1, false);


--
-- Name: tbl_log_pekerjaan_log_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_log_pekerjaan_log_id_seq', 1, false);


--
-- Name: tbl_log_relokasi_id_log_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_log_relokasi_id_log_seq', 1, false);


--
-- Name: tbl_log_vendor_log_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_log_vendor_log_id_seq', 1, false);


--
-- Name: tbl_pejabat_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_pejabat_id_seq', 1, false);


--
-- Name: tbl_pekerjaan_pekerjaan_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_pekerjaan_pekerjaan_id_seq', 1, false);


--
-- Name: tbl_pengalaman_kerja_pengalaman_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_pengalaman_kerja_pengalaman_id_seq', 1, false);


--
-- Name: tbl_pengembalian_anggaran_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_pengembalian_anggaran_id_seq', 1, false);


--
-- Name: tbl_pengirim_id_pengirim_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_pengirim_id_pengirim_seq', 1, false);


--
-- Name: tbl_perusahaan_id_perusahaan_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_perusahaan_id_perusahaan_seq', 1, false);


--
-- Name: tbl_pilar_id_pilar_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_pilar_id_pilar_seq', 5, true);


--
-- Name: tbl_proker_id_proker_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_proker_id_proker_seq', 1, false);


--
-- Name: tbl_realisasi_ap_id_realisasi_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_realisasi_ap_id_realisasi_seq', 1, false);


--
-- Name: tbl_relokasi_id_relokasi_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_relokasi_id_relokasi_seq', 1, false);


--
-- Name: tbl_sdg_id_sdg_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_sdg_id_sdg_seq', 1, false);


--
-- Name: tbl_sektor_id_sektor_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_sektor_id_sektor_seq', 1, false);


--
-- Name: tbl_sph_sph_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_sph_sph_id_seq', 1, false);


--
-- Name: tbl_spk_spk_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_spk_spk_id_seq', 1, false);


--
-- Name: tbl_spph_spph_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_spph_spph_id_seq', 1, false);


--
-- Name: tbl_sub_pilar_id_sub_pilar_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_sub_pilar_id_sub_pilar_seq', 1, false);


--
-- Name: tbl_sub_proposal_id_sub_proposal_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_sub_proposal_id_sub_proposal_seq', 1, false);


--
-- Name: tbl_user_id_user_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_user_id_user_seq', 1, false);


--
-- Name: tbl_vendor_vendor_id_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_vendor_vendor_id_seq', 1, false);


--
-- Name: tbl_wilayah_id_wilayah_seq; Type: SEQUENCE SET; Schema: nr_csr; Owner: nrcsr_user
--

SELECT pg_catalog.setval('nr_csr.tbl_wilayah_id_wilayah_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: nrcsr_user
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: nrcsr_user
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: tbl_anggaran tahun_unique; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_anggaran
    ADD CONSTRAINT tahun_unique UNIQUE (tahun, id_perusahaan);


--
-- Name: tbl_anggaran tbl_anggaran_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_anggaran
    ADD CONSTRAINT tbl_anggaran_pkey PRIMARY KEY (id_anggaran);


--
-- Name: tbl_anggota tbl_anggota_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_anggota
    ADD CONSTRAINT tbl_anggota_pkey PRIMARY KEY (id_anggota);


--
-- Name: tbl_assessment_vendor tbl_assessment_vendor_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_assessment_vendor
    ADD CONSTRAINT tbl_assessment_vendor_pkey PRIMARY KEY (assessment_id);


--
-- Name: tbl_bakn tbl_bakn_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_bakn
    ADD CONSTRAINT tbl_bakn_pkey PRIMARY KEY (bakn_id);


--
-- Name: tbl_bank tbl_bank_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_bank
    ADD CONSTRAINT tbl_bank_pkey PRIMARY KEY (bank_id);


--
-- Name: tbl_bast_dana tbl_bast_dana_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_bast_dana
    ADD CONSTRAINT tbl_bast_dana_pkey PRIMARY KEY (id_bast_dana);


--
-- Name: tbl_bast_dana tbl_bast_dana_uk1; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_bast_dana
    ADD CONSTRAINT tbl_bast_dana_uk1 UNIQUE (no_agenda);


--
-- Name: tbl_detail_approval tbl_detail_approval_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_detail_approval
    ADD CONSTRAINT tbl_detail_approval_pkey PRIMARY KEY (id);


--
-- Name: tbl_detail_kriteria tbl_detail_kriteria_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_detail_kriteria
    ADD CONSTRAINT tbl_detail_kriteria_pkey PRIMARY KEY (id_detail_kriteria);


--
-- Name: tbl_detail_spk tbl_detail_spk_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_detail_spk
    ADD CONSTRAINT tbl_detail_spk_pkey PRIMARY KEY (id_detail_spk);


--
-- Name: tbl_dokumen_mandatori_proyek tbl_dokumen_mandatori_proyek_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_dokumen_mandatori_proyek
    ADD CONSTRAINT tbl_dokumen_mandatori_proyek_pkey PRIMARY KEY (dokumen_id);


--
-- Name: tbl_dokumen_mandatori_vendor tbl_dokumen_mandatori_vendor_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_dokumen_mandatori_vendor
    ADD CONSTRAINT tbl_dokumen_mandatori_vendor_pkey PRIMARY KEY (dokumen_id);


--
-- Name: tbl_dokumen tbl_dokumen_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_dokumen
    ADD CONSTRAINT tbl_dokumen_pkey PRIMARY KEY (id);


--
-- Name: tbl_dokumen_vendor tbl_dokumen_vendor_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_dokumen_vendor
    ADD CONSTRAINT tbl_dokumen_vendor_pkey PRIMARY KEY (dokumen_id);


--
-- Name: tbl_exception tbl_exception_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_exception
    ADD CONSTRAINT tbl_exception_pkey PRIMARY KEY (error_id);


--
-- Name: tbl_hirarki tbl_hirarki_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_hirarki
    ADD CONSTRAINT tbl_hirarki_pkey PRIMARY KEY (id);


--
-- Name: tbl_izin_usaha tbl_izin_usaha_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_izin_usaha
    ADD CONSTRAINT tbl_izin_usaha_pkey PRIMARY KEY (izin_usaha_id);


--
-- Name: tbl_kebijakan tbl_kebijakan_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_kebijakan
    ADD CONSTRAINT tbl_kebijakan_pkey PRIMARY KEY (id_kebijakan);


--
-- Name: tbl_kelayakan tbl_kelayakan_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_kelayakan
    ADD CONSTRAINT tbl_kelayakan_pkey PRIMARY KEY (id_kelayakan);


--
-- Name: tbl_kelayakan tbl_kelayakan_uk1; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_kelayakan
    ADD CONSTRAINT tbl_kelayakan_uk1 UNIQUE (no_agenda);


--
-- Name: tbl_ktp_pengurus tbl_ktp_pengurus_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_ktp_pengurus
    ADD CONSTRAINT tbl_ktp_pengurus_pkey PRIMARY KEY (ktp_id);


--
-- Name: tbl_lampiran_ap tbl_lampiran_ap_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_lampiran_ap
    ADD CONSTRAINT tbl_lampiran_ap_pkey PRIMARY KEY (id_lampiran);


--
-- Name: tbl_lampiran_pekerjaan tbl_lampiran_pekerjaan_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_lampiran_pekerjaan
    ADD CONSTRAINT tbl_lampiran_pekerjaan_pkey PRIMARY KEY (lampiran_id);


--
-- Name: tbl_lampiran_vendor tbl_lampiran_vendor_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_lampiran_vendor
    ADD CONSTRAINT tbl_lampiran_vendor_pkey PRIMARY KEY (lampiran_id);


--
-- Name: tbl_lembaga tbl_lembaga_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_lembaga
    ADD CONSTRAINT tbl_lembaga_pkey PRIMARY KEY (id_lembaga);


--
-- Name: tbl_level_hirarki tbl_level_hirarki_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_level_hirarki
    ADD CONSTRAINT tbl_level_hirarki_pkey PRIMARY KEY (id);


--
-- Name: tbl_log_pekerjaan tbl_log_pekerjaan_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_log_pekerjaan
    ADD CONSTRAINT tbl_log_pekerjaan_pkey PRIMARY KEY (log_id);


--
-- Name: tbl_log tbl_log_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_log
    ADD CONSTRAINT tbl_log_pkey PRIMARY KEY (id);


--
-- Name: tbl_log_relokasi tbl_log_relokasi_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_log_relokasi
    ADD CONSTRAINT tbl_log_relokasi_pkey PRIMARY KEY (id_log);


--
-- Name: tbl_log_vendor tbl_log_vendor_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_log_vendor
    ADD CONSTRAINT tbl_log_vendor_pkey PRIMARY KEY (log_id);


--
-- Name: tbl_pejabat tbl_pejabat_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pejabat
    ADD CONSTRAINT tbl_pejabat_pkey PRIMARY KEY (id);


--
-- Name: tbl_pekerjaan tbl_pekerjaan_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pekerjaan
    ADD CONSTRAINT tbl_pekerjaan_pkey PRIMARY KEY (pekerjaan_id);


--
-- Name: tbl_pengalaman_kerja tbl_pengalaman_kerja_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pengalaman_kerja
    ADD CONSTRAINT tbl_pengalaman_kerja_pkey PRIMARY KEY (pengalaman_id);


--
-- Name: tbl_pengembalian_anggaran tbl_pengembalian_anggaran_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pengembalian_anggaran
    ADD CONSTRAINT tbl_pengembalian_anggaran_pkey PRIMARY KEY (id);


--
-- Name: tbl_pengirim tbl_pengirim_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pengirim
    ADD CONSTRAINT tbl_pengirim_pkey PRIMARY KEY (id_pengirim);


--
-- Name: tbl_perusahaan tbl_perusahaan_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_perusahaan
    ADD CONSTRAINT tbl_perusahaan_pkey PRIMARY KEY (id_perusahaan);


--
-- Name: tbl_pilar tbl_pilar_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_pilar
    ADD CONSTRAINT tbl_pilar_pkey PRIMARY KEY (id_pilar);


--
-- Name: tbl_proker tbl_proker_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_proker
    ADD CONSTRAINT tbl_proker_pkey PRIMARY KEY (id_proker);


--
-- Name: tbl_realisasi_ap tbl_realisasi_ap_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_realisasi_ap
    ADD CONSTRAINT tbl_realisasi_ap_pkey PRIMARY KEY (id_realisasi);


--
-- Name: tbl_relokasi tbl_relokasi_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_relokasi
    ADD CONSTRAINT tbl_relokasi_pkey PRIMARY KEY (id_relokasi);


--
-- Name: tbl_sdg tbl_sdg_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sdg
    ADD CONSTRAINT tbl_sdg_pkey PRIMARY KEY (id_sdg);


--
-- Name: tbl_sektor tbl_sektor_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sektor
    ADD CONSTRAINT tbl_sektor_pkey PRIMARY KEY (id_sektor);


--
-- Name: tbl_sektor tbl_sektor_uk1; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sektor
    ADD CONSTRAINT tbl_sektor_uk1 UNIQUE (kode_sektor);


--
-- Name: tbl_sph tbl_sph_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sph
    ADD CONSTRAINT tbl_sph_pkey PRIMARY KEY (sph_id);


--
-- Name: tbl_spk tbl_spk_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_spk
    ADD CONSTRAINT tbl_spk_pkey PRIMARY KEY (spk_id);


--
-- Name: tbl_spph tbl_spph_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_spph
    ADD CONSTRAINT tbl_spph_pkey PRIMARY KEY (spph_id);


--
-- Name: tbl_sub_pilar tbl_sub_pilar_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sub_pilar
    ADD CONSTRAINT tbl_sub_pilar_pkey PRIMARY KEY (id_sub_pilar);


--
-- Name: tbl_sub_proposal tbl_sub_proposal_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_sub_proposal
    ADD CONSTRAINT tbl_sub_proposal_pkey PRIMARY KEY (id_sub_proposal);


--
-- Name: tbl_user tbl_user_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_user
    ADD CONSTRAINT tbl_user_pkey PRIMARY KEY (id_user);


--
-- Name: tbl_user tbl_user_uk1; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_user
    ADD CONSTRAINT tbl_user_uk1 UNIQUE (username);


--
-- Name: tbl_user tbl_user_uk2; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_user
    ADD CONSTRAINT tbl_user_uk2 UNIQUE (email);


--
-- Name: tbl_vendor tbl_vendor_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_vendor
    ADD CONSTRAINT tbl_vendor_pkey PRIMARY KEY (vendor_id);


--
-- Name: tbl_wilayah tbl_wilayah_pkey; Type: CONSTRAINT; Schema: nr_csr; Owner: nrcsr_user
--

ALTER TABLE ONLY nr_csr.tbl_wilayah
    ADD CONSTRAINT tbl_wilayah_pkey PRIMARY KEY (id_wilayah);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: nrcsr_user
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: nrcsr_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: nrcsr_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: no_bakn; Type: INDEX; Schema: nr_csr; Owner: nrcsr_user
--

CREATE UNIQUE INDEX no_bakn ON nr_csr.tbl_bakn USING btree (nomor);


--
-- Name: no_sph; Type: INDEX; Schema: nr_csr; Owner: nrcsr_user
--

CREATE UNIQUE INDEX no_sph ON nr_csr.tbl_sph USING btree (nomor);


--
-- Name: no_spph; Type: INDEX; Schema: nr_csr; Owner: nrcsr_user
--

CREATE UNIQUE INDEX no_spph ON nr_csr.tbl_spph USING btree (nomor);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: nrcsr_user
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: SCHEMA nr_csr; Type: ACL; Schema: -; Owner: postgres
--

GRANT ALL ON SCHEMA nr_csr TO nrcsr_user;


--
-- Name: SCHEMA nr_payment; Type: ACL; Schema: -; Owner: postgres
--

GRANT ALL ON SCHEMA nr_payment TO nrcsr_user;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: pg_database_owner
--

GRANT ALL ON SCHEMA public TO nrcsr_user;


--
-- PostgreSQL database dump complete
--

\unrestrict IOR8r8yiamEmCiGxOUnhwiHytmZfHe6qQSlHMbyvd4ggI838dIg9rMR4pSGqZmj
