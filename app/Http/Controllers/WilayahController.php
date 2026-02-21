<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiGetKecamatanRequest;
use App\Http\Requests\ApiGetKelurahanRequest;
use App\Http\Requests\ApiGetKodePosRequest;
use App\Models\Provinsi;
use App\Support\ApiResponse;
use DB;

class WilayahController extends Controller
{
    public function getProvinsi()
    {
        $data = Provinsi::all();
        $result = [];

        foreach ($data as $d) {
            $result[] = [
                'id_provinsi' => $d->id_provinsi,
                'provinsi' => $d->provinsi,
            ];
        }

        return ApiResponse::success($result, 'Data provinsi berhasil ditampilkan');
    }

    public function getKabupaten($prov)
    {
        $data = DB::table('TBL_WILAYAH')->select('city_name')
            ->where('province', $prov)
            ->groupBy('city_name')
            ->orderBy('city_name', 'ASC')
            ->get();
        $result = [];

        foreach ($data as $d) {
            $result[] = [
                'kabupaten' => $d->city_name,
            ];
        }

        return ApiResponse::success($result, 'Data kabupaten berhasil ditampilkan');
    }

    public function getKecamatan(ApiGetKecamatanRequest $request)
    {
        $prov = $request->provinsi;
        $kab = $request->kabupaten;

        $data = DB::table('TBL_WILAYAH')->select('sub_district')
            ->where([
                ['province', $prov],
                ['city_name', $kab],
            ])
            ->groupBy('sub_district')
            ->orderBy('sub_district', 'ASC')
            ->get();
        $result = [];

        foreach ($data as $d) {
            $result[] = [
                'kecamatan' => $d->sub_district,
            ];
        }

        return ApiResponse::success($result, 'Data kecamatan berhasil ditampilkan');
    }

    public function getKelurahan(ApiGetKelurahanRequest $request)
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
            ->orderBy('village', 'ASC')
            ->get();
        $result = [];

        foreach ($data as $d) {
            $result[] = [
                'kelurahan' => $d->village,
            ];
        }

        return ApiResponse::success($result, 'Data kelurahan berhasil ditampilkan');
    }

    public function getKodePos(ApiGetKodePosRequest $request)
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
            ->orderBy('postal_code', 'ASC')
            ->get();
        $result = [];

        foreach ($data as $d) {
            $result[] = [
                'kodepos' => $d->postal_code,
            ];
        }

        return ApiResponse::success($result, 'Data kode pos berhasil ditampilkan');
    }
}
