<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InsertSektor;
use App\Models\SektorBantuan;
use DB;
use Exception;

class SektorController extends Controller
{
    public function index()
    {
        $data = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();
        return view('master.data_sektor')
            ->with([
                'dataSektor' => $data
            ]);
    }

    public function insertSektor(InsertSektor $request)
    {
        $dataSektor = [
            'kode_sektor' => $request->kode,
            'sektor_bantuan' => ucwords($request->sektor),
        ];

        try {
            SektorBantuan::create($dataSektor);
            return redirect()->back()->with('sukses', "Sektor bantuan berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Sektor bantuan gagal disimpan');
        }
    }

    public function editSektor(InsertSektor $request)
    {
        try {
            $logID = decrypt($request->idsektor);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'kode_sektor' => $request->kode,
            'sektor_bantuan' => ucwords($request->sektor),
        ];

        try {
            SektorBantuan::where('id_sektor', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Sektor bantuan berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Sektor bantuan gagal diubah');
        }
    }

    public function deleteSektor($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }
        SektorBantuan::where('id_sektor', $logID)->delete();
        return redirect()->back()->with('sukses', "Sektor bantuan berhasil dihapus");
    }
}
