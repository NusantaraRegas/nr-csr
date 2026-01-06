<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InsertLokasiAsal;
use DB;
use App\Models\LokasiAsal;
use Exception;

class LokasiAsalController extends Controller
{
    public function index(){
        $data = LokasiAsal::get();
        return view('master.data_lokasi_asal')
            ->with([
                'dataLokasiAsal' => $data,
            ]);
    }

    public function insertLokasiAsal(InsertLokasiAsal $request)
    {
        $dataLokasiAsal = [
            'lokasi_asal' => ucwords($request->lokasi),
        ];

        LokasiAsal::create($dataLokasiAsal);
        return redirect()->back()->with('sukses', 'Data berhasil disimpan');

//        try {
//
//        } catch (Exception $e) {
//            return redirect()->back()->with('gagalSimpan', 'Data gagal disimpan');
//        }
    }

    public function editLokasiAsal(InsertLokasiAsal $request)
    {
        try {
            $logID = decrypt($request->idlokasi);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'lokasi_asal' => ucwords($request->lokasi),
        ];

        try {
            LokasiAsal::where('id_lokasi_asal', $logID)->update($dataUpdate);
            return redirect(route('data-lokasiAsal'))->with('sukses', 'Data berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalSimpan', 'Data gagal disimpan');
        }
    }

    public function deleteLokasiAsal($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }
        LokasiAsal::where('id_lokasi_asal', $logID)->delete();
        return redirect()->back()->with('sukses', 'Data berhasil dihapus');
    }

}
