<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use DB;

class WilayahController extends Controller
{
    public function getProvinsi()
    {
        $data = Provinsi::all();

        foreach ($data as $d) {
            $result[] = [
                'id_provinsi' => $d->id_provinsi,
                'provinsi' => $d->provinsi,
            ];
        }
        return response()->json(['dataProvinsi' => $result]);
    }

    public function getKabupaten($prov)
    {
        $data = DB::table('TBL_WILAYAH')->select('city_name')
            ->where('province', $prov)

            ->groupBy('city_name')
            ->orderBy('city_name','ASC')
            ->get();

        foreach ($data as $d) {
            $result[] = [
                'kabupaten' => $d->city_name,
            ];
        }
        return response()->json(['dataKabupaten' => $result]);
    }

    public function getKecamatan(Request $request)
    {
        $prov = $request->provinsi;
        $kab = $request->kabupaten;

        $data = DB::table('TBL_WILAYAH')->select('sub_district')
            ->where([
                ['province', $prov],
                ['city_name', $kab],
            ])
            ->groupBy('sub_district')
            ->orderBy('sub_district','ASC')
            ->get();

        foreach ($data as $d) {
            $result[] = [
                'kecamatan' => $d->sub_district,
            ];
        }
        return response()->json(['dataKecamatan' => $result]);
    }

    public function getKelurahan(Request $request)
    {
        $prov = $request->provinsi;
        $kab = $request->kabupaten;
        $kec = $request->kecamatan;

        $data = DB::table('TBL_WILAYAH')->select('village')
            ->where([
                ['province', $prov],
                ['city_name', $kab],
                ['sub_district', $kec],
            ])
            ->groupBy('village')
            ->orderBy('village','ASC')
            ->get();

        foreach ($data as $d) {
            $result[] = [
                'kelurahan' => $d->village,
            ];
        }
        return response()->json(['dataKelurahan' => $result]);
    }

    public function getKodePos(Request $request)
    {
        $prov = $request->provinsi;
        $kab = $request->kabupaten;
        $kec = $request->kecamatan;
        $kel = $request->kelurahan;

        $data = DB::table('TBL_WILAYAH')->select('postal_code')
            ->where([
                ['province', $prov],
                ['city_name', $kab],
                ['sub_district', $kec],
                ['village', $kel],
            ])
            ->groupBy('postal_code')
            ->orderBy('postal_code','ASC')
            ->get();

        foreach ($data as $d) {
            $result[] = [
                'kodepos' => $d->postal_code,
            ];
        }
        return response()->json(['dataKodePos' => $result]);
    }
}
