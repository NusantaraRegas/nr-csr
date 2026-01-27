<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use App\Models\SPPH;
use App\Models\Vendor;
use App\Models\ViewPekerjaan;
use App\Models\ViewSPPH;
use Illuminate\Http\Request;
use DB;
use Exception;
use Mail;

class DocumentProcurementController extends Controller
{
    public function indexSPPH()
    {
        $tahun = date("Y");
        $role = session('user')->role;

        if ($role == "Vendor"){
            $vendor = session('user')->perusahaan;
            $dataVendor = Vendor::where('nama_perusahaan', $vendor)->first();

            $data = ViewSPPH::where('tahun', $tahun)->where('id_vendor', $dataVendor->vendor_id)->orderBy('tanggal', 'ASC')->get();
        }else{
            $data = ViewSPPH::where('tahun', $tahun)->orderBy('tanggal', 'ASC')->get();
        }

        return view('Pekerjaan.indexSPPH')
            ->with([
                'tahun' => $tahun,
                'dataSPPH' => $data,
            ]);
    }
}
