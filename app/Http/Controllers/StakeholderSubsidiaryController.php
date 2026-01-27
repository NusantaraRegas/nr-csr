<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPengirim;
use App\Models\Pengirim;
use Illuminate\Http\Request;
use DB;
use Exception;

class StakeholderSubsidiaryController extends Controller
{
    public function index(){
        $company = session('user')->perusahaan;

        $data = Pengirim::where('perusahaan', $company)->orderBy('pengirim','ASC')->get();
        return view('subsidiary.master.stakeholder')
            ->with([
                'dataPengirim' => $data,
                'comp' => $company
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);

        $company = session('user')->perusahaan;

        $dataPengirim = [
            'pengirim' => $request->nama,
            'perusahaan' => $company,
        ];

        try {
            DB::table('tbl_pengirim')->insert($dataPengirim);
            return redirect()->back()->with('berhasil', "Stakeholder berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Stakeholder gagal disimpan');
        }
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->idpengirim);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'nama' => 'required',
        ]);

        $company = session('user')->perusahaan;

        $dataUpdate = [
            'pengirim' => $request->nama,
            'perusahaan' => $company,
        ];

        try {
            Pengirim::where('id_pengirim', $logID)->update($dataUpdate);
            return redirect()->back()->with('berhasil', "Stakeholder berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Stakeholder gagal diubah');
        }
    }

    public function deletePengirim($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }
        Pengirim::where('id_pengirim', $logID)->delete();
        return redirect()->back()->with('sukses', "Stakeholder berhasil dihapus");
    }
}
