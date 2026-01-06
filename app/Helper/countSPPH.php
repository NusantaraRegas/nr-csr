<?php
namespace App\Helper;

use App\Models\BAKN;
use App\Models\SPPH;
use App\Models\SPK;
use App\Models\Vendor;

class countSPPH
{

    public static function total_spph()
    {
        $vendor = session('user')->perusahaan;

        $dataVendor = Vendor::where('nama_perusahaan', $vendor)->first();

        $jumlahSPPH = SPPH::where('id_vendor', $dataVendor->vendor_id)->where('status', 'Submitted')->count();
        $jumlahBAKN = BAKN::where('id_vendor', $dataVendor->vendor_id)->where('status', 'Submitted')->count();
        $jumlahSPK = SPK::where('id_vendor', $dataVendor->vendor_id)->where('status', 'Submitted')->count();

        $total = $jumlahSPPH + $jumlahBAKN + $jumlahSPK;

        return $total;
    }

    public static function instance()
    {
        return new countSPPH();
    }

}