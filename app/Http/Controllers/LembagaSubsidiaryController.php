<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use Illuminate\Http\Request;
use DB;
use Exception;

class LembagaSubsidiaryController extends Controller
{
    public function index()
    {
        $perusahaanID = session('user')->id_perusahaan;
        $company = session('user')->perusahaan;

        $lembaga = Lembaga::where('id_perusahaan', $perusahaanID)->orderBy('id_lembaga', 'ASC')->get();
        return view('subsidiary.master.lembaga')
            ->with([
                'dataLembaga' => $lembaga,
                'comp' => $company,
            ]);
    }

    public function store(Request $request)
    {

        $perusahaanID = session('user')->id_perusahaan;
        $company = session('user')->perusahaan;

        $this->validate($request, [
            'namaLembaga' => 'required',
            'alamat' => 'required',
            'pic' => 'required',
            'jabatan' => 'required',
            'noTelp' => 'required',
        ]);

        $dataLembaga = [
            'nama_lembaga' => $request->namaLembaga,
            'alamat' => $request->alamat,
            'nama_pic' => $request->pic,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->noTelp,
            'id_perusahaan' => $perusahaanID,
            'perusahaan' => $company
        ];

        try {
            DB::table('tbl_lembaga')->insert($dataLembaga);
            return redirect()->back()->with('berhasil', 'Lembaga/yayasan penerima bantuan berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Lembaga/yayasan penerima bantuan gagal disimpan');
        }
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->lembagaID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'namaLembaga' => 'required',
            'alamat' => 'required',
            'pic' => 'required',
            'jabatan' => 'required',
            'noTelp' => 'required',
        ]);

        $company = session('user')->perusahaan;

        $dataLembaga = [
            'nama_lembaga' => $request->namaLembaga,
            'alamat' => $request->alamat,
            'nama_pic' => $request->pic,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->noTelp,
            'perusahaan' => $company
        ];

        try {
            Lembaga::where('id_lembaga', $logID)->update($dataLembaga);
            return redirect()->back()->with('berhasil', 'Lembaga/yayasan penerima bantuan berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Lembaga/yayasan penerima bantuan gagal diubah');
        }
    }

    public function delete($lembagaID)
    {
        try {
            $logID = decrypt($lembagaID);
        } catch (Exception $e) {
            abort(404);
        }

        Lembaga::where('id_lembaga', $logID)->delete();
        return redirect()->back()->with('berhasil', 'Lembaga/yayasan penerima bantuan berhasil dihapus');
    }
}
