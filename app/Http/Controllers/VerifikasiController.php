<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Log;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Mail;
use Exception;

class VerifikasiController extends Controller
{
    public function approveDokumen($dokumenID)
    {
        try {
            $logID = decrypt($dokumenID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $dokumen = Dokumen::where('dokumen_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $dokumen->vendor_id)->first();

        $dataUpdate = [
            'status' => 'Sudah Diverifikasi',
            'status_date' => $tanggalMenit,
        ];


        $dataLog = [
            'vendor_id' => $logID,
            'update_name' => session('user')->nama,
            'update_email' => session('user')->email,
            'update_date' => $tanggalMenit,
            'action' => "Verifikasi dokumen $dokumen->nama_dokumen milik $vendor->badan_hukum $vendor->nama_perusahaan",
        ];

        try {
            DB::table('dokumen')->where('dokumen_id', $logID)->update($dataUpdate);
            Log::create($dataLog);
            return redirect()->back()->with('sukses', "Dokumen $dokumen->nama_dokumen berhasil diverifikasi");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Dokumen $dokumen->nama_dokumen gagal diverifikasi");
        }
    }

    public function rejectDokumen(Request $request)
    {
        try {
            $logID = decrypt($request->dokumenIDKTP);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'catatan' => 'required',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $dokumen = Dokumen::where('dokumen_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $dokumen->vendor_id)->first();

        $dataUpdate = [
            'status' => 'Dokumen Ditolak',
            'status_date' => $tanggalMenit,
            'catatan' => $request->catatan,
        ];

        $dataLog = [
            'vendor_id' => $logID,
            'update_name' => session('user')->nama,
            'update_email' => session('user')->email,
            'update_date' => $tanggalMenit,
            'action' => "Reject dokumen $dokumen->nama_dokumen milik $vendor->badan_hukum $vendor->nama_perusahaan",
        ];

        try {
            DB::table('dokumen')->where('dokumen_id', $logID)->update($dataUpdate);
            Log::create($dataLog);
            return redirect()->back()->with('sukses', "Dokumen $dokumen->nama_dokumen berhasil direject");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Dokumen $dokumen->nama_dokumen gagal direject");
        }
    }

    public function resetDokumen($dokumenID)
    {
        try {
            $logID = decrypt($dokumenID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $dokumen = Dokumen::where('dokumen_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $dokumen->vendor_id)->first();

        $dataUpdate = [
            'status' => 'Menunggu Verifikasi',
            'status_date' => $tanggalMenit,
            'catatan' => '',
        ];


        $dataLog = [
            'vendor_id' => $logID,
            'update_name' => session('user')->nama,
            'update_email' => session('user')->email,
            'update_date' => $tanggalMenit,
            'action' => "Reset status dokumen $dokumen->nama_dokumen milik $vendor->badan_hukum $vendor->nama_perusahaan",
        ];

        try {
            DB::table('dokumen')->where('dokumen_id', $logID)->update($dataUpdate);
            Log::create($dataLog);
            return redirect()->back()->with('sukses', "Status dokumen $dokumen->nama_dokumen berhasil direset");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Status dokumen $dokumen->nama_dokumen gagal direset");
        }
    }

    public function submitRevisi(Request $request)
    {
        try {
            $logID = decrypt($request->dokumenIDKTP);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'catatan' => 'required',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $dokumen = Dokumen::where('dokumen_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $dokumen->vendor_id)->first();

        $dataUpdate = [
            'status' => 'Menunggu Verifikasi',
            'status_date' => $tanggalMenit,
            'catatan' => $request->catatan,
        ];

        $dataLog = [
            'vendor_id' => $logID,
            'update_name' => session('user')->nama,
            'update_email' => session('user')->email,
            'update_date' => $tanggalMenit,
            'action' => "Reset status dokumen $dokumen->nama_dokumen milik $vendor->badan_hukum $vendor->nama_perusahaan",
        ];

        try {
            DB::table('dokumen')->where('dokumen_id', $logID)->update($dataUpdate);
            Log::create($dataLog);
            return redirect()->back()->with('sukses', "Revisi dokumen $dokumen->nama_dokumen berhasil disubmit");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Revisi dokumen $dokumen->nama_dokumen gagal disubmit");
        }
    }

    public function rejectAccount(Request $request)
    {
        try {
            $logID = decrypt($request->vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'catatan' => 'required',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $vendor = Vendor::where('vendor_id', $logID)->first();

        $dataUpdate = [
            'status' => 'Rejected',
            'status_date' => $tanggalMenit,
            'catatan' => $request->catatan,
        ];

        $dataLog = [
            'vendor_id' => $logID,
            'update_name' => session('user')->nama,
            'update_email' => session('user')->email,
            'update_date' => $tanggalMenit,
            'action' => "Reject register $vendor->badan_hukum $vendor->nama_perusahaan",
        ];

        try {
            DB::table('vendor')->where('vendor_id', $logID)->update($dataUpdate);
            Log::create($dataLog);
            return redirect()->back()->with('sukses', "$vendor->badan_hukum $vendor->nama_perusahaan berhasil direject");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "$vendor->badan_hukum $vendor->nama_perusahaan gagal direject");
        }
    }

    public function approveVendor($vendorID)
    {
        try {
            $logID = decrypt($vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        $role = session('user')->role;
        $bulan = date("m");
        $tahun = date("Y");
        $approver1 = User::where('role', 'Approver 1')->first();
        $approver2 = User::where('role', 'Approver 2')->first();

        $tanggalMenit = date("Y-m-d H:i:s");
        $vendor = Vendor::where('vendor_id', $logID)->first();

        function romawi($n)
        {
            $hasil = "";
            $iromawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", 20 => "XX", 30 => "XXX", 40 => "XL", 50 => "L",
                60 => "LX", 70 => "LXX", 80 => "LXXX", 90 => "XC", 100 => "C", 200 => "CC", 300 => "CCC", 400 => "CD", 500 => "D", 600 => "DC", 700 => "DCC",
                800 => "DCCC", 900 => "CM", 1000 => "M", 2000 => "MM", 3000 => "MMM");
            if (array_key_exists($n, $iromawi)) {
                $hasil = $iromawi[$n];
            } elseif ($n >= 11 && $n <= 99) {
                $i = $n % 10;
                $hasil = $iromawi[$n - $i] . Romawi($n % 10);
            } elseif ($n >= 101 && $n <= 999) {
                $i = $n % 100;
                $hasil = $iromawi[$n - $i] . Romawi($n % 100);
            } else {
                $i = $n % 1000;
                $hasil = $iromawi[$n - $i] . Romawi($n % 1000);
            }
            return $hasil;
        }

        $bulanromawi = romawi($bulan);
        $noSertifikat = "VMS.$vendor->vendor_id.$bulanromawi-$tahun";

        if ($role == 'Evaluator'){
            $dataUpdate = [
                'next_approver' => $approver1->email,
                'status' => 'Progress Approval',
                'status_date' => $tanggalMenit,
            ];
        }elseif($role == 'Approver 1'){
            $dataUpdate = [
                'next_approver' => '',
                'status' => 'Verified',
                'status_date' => $tanggalMenit,
                'nomor_sertifikat' => $noSertifikat,
            ];
        }

        $dataLog = [
            'vendor_id' => $logID,
            'update_name' => session('user')->nama,
            'update_email' => session('user')->email,
            'update_date' => $tanggalMenit,
            'action' => "Verifikasi $vendor->badan_hukum $vendor->nama_perusahaan",
        ];

        try {
            DB::table('vendor')->where('vendor_id', $logID)->update($dataUpdate);
            Log::create($dataLog);
            return redirect()->back()->with('sukses', "$vendor->badan_hukum $vendor->nama_perusahaan berhasil diverifikasi");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "$vendor->badan_hukum $vendor->nama_perusahaan berhasil diverifikasi");
        }
    }

}
