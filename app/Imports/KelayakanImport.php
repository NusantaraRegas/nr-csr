<?php

namespace App\Imports;

use App\Models\Evaluasi;
use App\Models\User;
use App\Models\Kelayakan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class KelayakanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        $tanggal = date("Y-m-d");
        $kadiv = User::where('role', 'Manager')->where('status', 'Active')->first();
        $kadep = User::where('role', 'Supervisor 1')->where('status', 'Active')->first();

        foreach ($collection as $row) {
            $tglTerima = ($row['tgl_penerimaan'] - 25569) * 86400;
            $tglSurat = ($row['tgl_surat'] - 25569) * 86400;


            $data[] = [
                [
                    $dataKelayakan = [
                        'no_agenda' => strtoupper($row['no_agenda']),
                        'pengirim' => ucwords($row['pengirim']),
                        'tgl_terima' => gmdate('Y-m-d', $tglTerima),
                        'sifat' => 'Segera',
                        'asal_surat' => 'CSR PGN',
                        'no_surat' => strtoupper($row['no_surat']),
                        'tgl_surat' => gmdate('Y-m-d', $tglSurat),
                        'perihal' => 'Permohonan Bantuan Dana',
                        'alamat' => ucwords($row['alamat']),
                        'provinsi' => $row['provinsi'],
                        'kabupaten' => $row['kabupaten'],
                        'pengaju_proposal' => ucwords($row['yayasan']),
                        'sebagai' => ucwords($row['bertindak_sebagai']),
                        'contact_person' => $row['no_telepon'],
                        'email_pengaju' => strtolower($row['email']),
                        'nilai_pengajuan' => str_replace(".", "", $row['nilai_bantuan']),
                        'nilai_bantuan' => str_replace(".", "", $row['nilai_bantuan']),
                        'bantuan_untuk' => ucwords($row['perihal']),
                        'deskripsi' => ucwords($row['deskripsi']),
                        'jenis' => 'Santunan',
                        'status' => 'Survei',
                        'id_proker' => '221',
                        'proker' => "Program Nuzulul Qur'an",
                        'pilar' => 'Sosial',
                        'tpb' => 'Tanpa Kemiskinan',
                        'mata_uang_pengajuan' => 'IDR',
                        'mata_uang_bantuan' => 'IDR',
                        'create_by' => 'bella.permatasari',
                        'create_date' => $tanggal,
                    ],

                    $dataEvaluasi = [
                        'no_agenda' => strtoupper($row['no_agenda']),
                        'rencana_anggaran' => 'ADA',
                        'dokumen' => 'ADA',
                        'denah' => 'TIDAK ADA',
                        'syarat' => 'Survei',
                        'evaluator1' => 'bella.permatasari',
                        'evaluator2' => 'saul.wakum',
                        'catatan1' => 'Sebagai bentuk kepedulian perusahaan terhadap masyarakat yang membutuhkan',
                        'kadep' => $kadep->username,
                        'kadiv' => $kadiv->username,
                        'status' => 'Create Survei',
                        'ket_kadin1' => 'Untuk ditindaklanjuti sesuai peraturan yang berlaku',
                        'approve_kadep' => $tanggal,
                        'ket_kadiv' => 'Untuk dapat diproses sesuai prosedur',
                        'approve_kadiv' => $tanggal,
                        'create_by' => 'bella.permatasari',
                        'create_date' => $tanggal,
                        'approve_date' => $tanggal,
                    ],

                    $dataKriteria1 = [
                        'no_agenda' => strtoupper($row['no_agenda']),
                        'kriteria' => 'Brand images/citra perusahaan',
                    ],

                    $dataKriteria2 = [
                        'no_agenda' => strtoupper($row['no_agenda']),
                        'kriteria' => 'Menjaga hubungan baik shareholders/stakeholders',
                    ],

                    $dataSurvei = [
                        'no_agenda' => strtoupper($row['no_agenda']),
                        'hasil_survei' => 'Yayasan/Lembaga sangat membutuhkan bantuan dana dari perusahaan',
                        'usulan' => 'Disarankan',
                        'bantuan_berupa' => 'Dana',
                        'nilai_bantuan' => str_replace(".", "", $row['nilai_bantuan']),
                        'termin' => 1,
                        'persen1' => 100,
                        'rupiah1' => str_replace(".", "", $row['nilai_bantuan']),
                        'survei1' => 'bella.permatasari',
                        'survei2' => 'saul.wakum',
                        'status' => 'Forward',
                        'kadep' => $kadep->username,
                        'kadiv' => $kadiv->username,
                        'create_by' => 'bella.permatasari',
                    ],

                    DB::table('tbl_kelayakan')->insert($dataKelayakan),
                    DB::table('tbl_evaluasi')->insert($dataEvaluasi),
                    DB::table('tbl_detail_kriteria')->insert($dataKriteria1),
                    DB::table('tbl_detail_kriteria')->insert($dataKriteria2),
                    DB::table('tbl_survei')->insert($dataSurvei),
                ]
            ];
        }
    }

}
