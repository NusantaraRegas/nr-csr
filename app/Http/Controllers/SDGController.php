<?php

namespace App\Http\Controllers;

use App\Models\Kelayakan;
use App\Models\Pilar;
use App\Models\SDG;
use Illuminate\Http\Request;
use DB;
use Exception;

class SDGController extends Controller
{
    public function index()
    {
        $data = SDG::get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        return view('master.data_sdg')
            ->with([
                'dataSDG' => $data,
                'dataPilar' => $pilar,
            ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'kode' => 'required',
            'nama' => 'required',
            'pilar' => 'required',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'pilar' => $request->pilar,
        ];

        try {
            DB::table('tbl_sdg')->insert($data);
            return redirect()->back()->with('sukses', 'SDGs berhasil ditambahkan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'SDGs gagal ditambahkan');
        }
    }

    public function update(Request $request)
    {
        //dd($request->SDGID);

        try {
            $logID = decrypt($request->SDGID);
        } catch (Exception $e) {
            abort(404);
        }


        $this->validate($request, [
            'kode' => 'required',
            'nama' => 'required',
            'pilar' => 'required',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'pilar' => $request->pilar,
        ];

        try {
            SDG::where('id_sdg', $logID)->update($data);
            return redirect()->back()->with('sukses', 'SDGs berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'SDGs gagal diubah');
        }
    }

    public function delete($SDGID)
    {
        try {
            $logID = decrypt($SDGID);
        } catch (Exception $e) {
            abort(404);
        }

        SDG::where('id_sdg', $logID)->delete();
        return redirect()->back()->with('sukses', 'SDGs berhasil dihapus');
    }
}
