<?php

namespace App\Http\Controllers;

use App\Models\SDG;
use App\Models\SubPilar;
use Illuminate\Http\Request;
use DB;
use Exception;

class SubPilarController extends Controller
{
    public function index()
    {
        $data = SubPilar::orderBy('id_sub_pilar', 'ASC')->get();
        $tpb = SDG::orderBy('id_sdg', 'ASC')->get();
        return view('master.data_indikator')
            ->with([
                'dataIndikator' => $data,
                'dataTPB' => $tpb,
            ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'tpb' => 'required',
            'pilar' => 'required',
            'kode' => 'required',
            'keterangan' => 'required',
        ]);

        $data = [
            'tpb' => $request->tpb,
            'kode_indikator' => $request->kode,
            'keterangan' => $request->keterangan,
            'pilar' => $request->pilar,
        ];

        try {
            DB::table('tbl_sub_pilar')->insert($data);
            return redirect()->back()->with('sukses', 'Indikator berhasil ditambahkan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Indikator gagal ditambahkan');
        }
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->pilarID);
        } catch (Exception $e) {
            abort(404);
        }


        $this->validate($request, [
            'tpb' => 'required',
            'pilar' => 'required',
            'kode' => 'required',
            'keterangan' => 'required',
        ]);

        $data = [
            'tpb' => $request->tpb,
            'kode_indikator' => $request->kode,
            'keterangan' => $request->keterangan,
            'pilar' => $request->pilar,
        ];

        try {
            SubPilar::where('id_sub_pilar', $logID)->update($data);
            return redirect()->back()->with('sukses', 'Indikator berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Indikator gagal diubah');
        }
    }

    public function delete($pilarID)
    {
        try {
            $logID = decrypt($pilarID);
        } catch (Exception $e) {
            abort(404);
        }

        SubPilar::where('id_sub_pilar', $logID)->delete();
        return redirect()->back()->with('sukses', 'Indikator berhasil dihapus');
    }
}
