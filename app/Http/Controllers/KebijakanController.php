<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertKebijakan;
use App\Models\Kebijakan;
use Illuminate\Http\Request;
use DB;
use Exception;

class KebijakanController extends Controller
{
    public function index()
    {
        $data = Kebijakan::all();
        return view('master.data_kebijakan')
            ->with([
                'dataKebijakan' => $data
            ]);
    }

    public function insertKebijakan(InsertKebijakan $request)
    {
        $dataKebijakan = [
            'kebijakan' => ucwords($request->kebijakan),
        ];

        try {
            Kebijakan::create($dataKebijakan);
            return redirect()->back()->with('sukses', "Kebijakan berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Kebijakan yang anda input sudah ada');
        }
    }

    public function editKebijakan(InsertKebijakan $request)
    {
        try {
            $logID = decrypt($request->idkebijakan);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'kebijakan' => ucwords($request->kebijakan),
        ];

        try {
            Kebijakan::where('id_kebijakan', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Kebijakan berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Kebijakan yang anda input sudah ada');
        }
    }

    public function deleteKebijakan($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }
        Kebijakan::where('id_kebijakan', $logID)->delete();
        return redirect()->back()->with('sukses', "Kebijakan berhasil dihapus");
    }
}
