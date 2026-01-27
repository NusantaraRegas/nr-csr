<?php

namespace App\Http\Controllers;

use App\Models\Pilar;
use Illuminate\Http\Request;
use DB;
use Exception;

class PilarController extends Controller
{
    public function index()
    {
        $data = Pilar::orderBy('id_pilar', 'ASC')->get();
        return view('master.data_pilar')
            ->with([
                'dataPilar' => $data,
            ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'kode' => 'required',
            'nama' => 'required',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
        ];

        try {
            DB::table('tbl_pilar')->insert($data);
            return redirect()->back()->with('sukses', 'Pilar berhasil ditambahkan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Pilar gagal ditambahkan');
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
            'kode' => 'required',
            'nama' => 'required',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
        ];

        try {
            Pilar::where('id_pilar', $logID)->update($data);
            return redirect()->back()->with('sukses', 'Pilar berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Pilar gagal diubah');
        }
    }

    public function delete($pilarID)
    {
        try {
            $logID = decrypt($pilarID);
        } catch (Exception $e) {
            abort(404);
        }

        Pilar::where('id_pilar', $logID)->delete();
        return redirect()->back()->with('sukses', 'Pilar berhasil dihapus');
    }
}
