<?php

namespace App\Http\Controllers;

use App\Models\BAKN;
use App\Models\LampiranPekerjaan;
use App\Models\Pekerjaan;
use App\Models\SPK;
use App\Models\SPPH;
use App\Models\Vendor;
use Illuminate\Http\Request;
use DB;
use Mail;
use Exception;

class TasklistVendorController extends Controller
{
    public function TasksSPPH()
    {
        $company = session('user')->perusahaan;
        $vendor = Vendor::where('nama_perusahaan', $company)->first();

        if (!empty($vendor)){
            $vendorID = $vendor->vendor_id;
        }else{
            $vendorID = "";
        }

        $spph = SPPH::where('id_vendor', $vendorID)->where('status', 'Submitted')->orderBy('spph_id', 'ASC')->get();
        $jumlahSPPH = SPPH::where('id_vendor', $vendorID)->where('status', 'Submitted')->count();

        $bakn = BAKN::where('id_vendor', $vendorID)->where('status', 'Submitted')->orderBy('bakn_id', 'ASC')->get();
        $jumlahBAKN = BAKN::where('id_vendor', $vendorID)->where('status', 'Submitted')->count();

        $spk = SPK::where('id_vendor', $vendorID)->where('status', 'Submitted')->orderBy('spk_id', 'ASC')->get();
        $jumlahSPK = SPK::where('id_vendor', $vendorID)->where('status', 'Submitted')->count();

        return view('Pekerjaan.taskspph')
            ->with([
                'perusahaan' => $company,
                'dataSPPH' => $spph,
                'jumlahSPPH' => $jumlahSPPH,
                'dataBAKN' => $bakn,
                'jumlahBAKN' => $jumlahBAKN,
                'dataSPK' => $spk,
                'jumlahSPK' => $jumlahSPK,
            ]);
    }

    public function response(Request $request)
    {
        try {
            $logID = decrypt($request->spphID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $spph = SPPH::where('spph_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $spph->id_vendor)->first();

        if ($request->response == "Accepted"){
            $this->validate($request, [
                'nomor' => 'required',
                'tanggal' => 'required',
                'nilaiPenawaran' => 'required',
                'lampiran' => 'required',
            ]);

            $dataResponse = [
                'status' => $request->response,
                'catatan' => $request->komentar,
                'response_date' => $tanggalMenit,
            ];

            $image = $request->file('lampiran');
            $size = $image->getSize();
            $type = $image->getClientOriginalExtension();
            $name = $request->namaDokumen . time() . '.' . $type;
            $fileName = $name;
            $image->move(public_path() . '/attachment', $fileName);

            $dataSPH = [
                'nomor' => $request->nomor,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'pekerjaan_id' => $spph->pekerjaan_id,
                'id_vendor' => $spph->id_vendor,
                'status' => 'Submitted',
                'file_sph' => $name,
                'created_by' => session('user')->id_user,
                'created_date' => $tanggalMenit,
                'nilai_penawaran' => str_replace(".", "", $request->nilaiPenawaran),
                'spph_id' => $logID,
            ];

            $dataLampiran = [
                'id_vendor' => $spph->id_vendor,
                'pekerjaan_id' => $spph->pekerjaan_id,
                'nomor' => $request->nomor,
                'nama_file' => "$request->namaDokumen $vendor->nama_perusahaan",
                'nama_dokumen' => $request->namaDokumen,
                'file' => $name,
                'size' => $size,
                'type' => $type,
                'status' => 'Open',
                'upload_by' => session('user')->id_user,
                'upload_date' => $tanggalMenit,
            ];

            DB::table('tbl_sph')->insert($dataSPH);
            DB::table('tbl_lampiran_pekerjaan')->insert($dataLampiran);
        }else{
            $dataResponse = [
                'status' => $request->response,
                'catatan' => $request->komentar,
                'response_date' => $tanggalMenit,
            ];
        }

        $dataLog = [
            'pekerjaan_id' => $spph->pekerjaan_id,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Submit Surat Penawaran Harga",
        ];

        try {
            SPPH::where('spph_id', $logID)->update($dataResponse);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            return redirect()->back()->with('sukses', 'Permintaan Penawaran Harga berhasil direspon');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Permintaan Penawaran Harga gagal direspon');
        }
    }

    public function responseBAKN(Request $request)
    {
        try {
            $logID = decrypt($request->baknID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $bakn = BAKN::where('bakn_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $bakn->id_vendor)->first();

        $this->validate($request, [
            'responseBAKN' => 'required',
        ]);

        $dataResponse = [
            'status' => $request->responseBAKN,
            'catatan' => $request->komentar,
            'response_date' => $tanggalMenit,
            'response_by' => session('user')->id_user,
        ];

        $dataLampiran = [
            'status' => 'Approved',
        ];

        $dataLog = [
            'pekerjaan_id' => $bakn->pekerjaan_id,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Menerima Berita Acara Klarifikasi dan Negosiasi",
        ];

        try {
            BAKN::where('bakn_id', $logID)->update($dataResponse);
            LampiranPekerjaan::where('pekerjaan_id', $bakn->pekerjaan_id)->where('nomor', $bakn->nomor)->update($dataLampiran);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            return redirect()->back()->with('sukses', 'Respon Berita Acara Klarifikasi dan Negosiasi berhasil disubmit');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Respon Berita Acara Klarifikasi dan Negosiasi gagal disubmit');
        }
    }

    public function responseSPK(Request $request)
    {
        try {
            $logID = decrypt($request->spkID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $spk = SPK::where('spk_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $spk->id_vendor)->first();

        $this->validate($request, [
            'responseSPK' => 'required',
        ]);

        $dataResponse = [
            'status' => $request->responseSPK,
            'catatan' => $request->komentar,
            'response_date' => $tanggalMenit,
            'response_by' => session('user')->id_user,
        ];

        $dataLampiran = [
            'status' => 'Approved',
        ];

        $dataProject = [
            'status' => 'In Progress',
        ];

        $dataLog = [
            'pekerjaan_id' => $spk->pekerjaan_id,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Menerima Surat Pertintah Kerja",
        ];

        try {
            SPK::where('spk_id', $logID)->update($dataResponse);
            Pekerjaan::where('pekerjaan_id', $spk->pekerjaan_id)->update($dataProject);
            LampiranPekerjaan::where('pekerjaan_id', $spk->pekerjaan_id)->where('nomor', $spk->nomor)->update($dataLampiran);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            return redirect()->back()->with('sukses', 'Respon Surat Perintah Kerja berhasil disubmit');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Respon Surat Perintah Kerja gagal disubmit');
        }
    }

}
