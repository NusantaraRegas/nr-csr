<?php

namespace App\Http\Controllers;

use App\Helper\APIHelper;
use App\Models\Lembaga;
use App\Models\Bank;
use Illuminate\Http\Request;
use DB;
use Exception;

class LembagaController extends Controller
{
    public function index()
    {
        $perusahaanID = session('user')->id_perusahaan;

        $bank = Bank::orderBy('nama_bank')->get();
        $lembaga = Lembaga::where('id_perusahaan', $perusahaanID)->orderBy('id_lembaga', 'ASC')->get();
        return view('master.data_lembaga')
            ->with([
                'dataBank' => $bank,
                'dataLembaga' => $lembaga,
            ]);
    }

    public function input()
    {
        $release = APIHelper::instance()->apiCall('GET', env('BASEURL_POPAYV3') . '/api/APIPaymentRequest/form/bank/2312', '');
        $return = json_decode(strstr($release, '{'), true);

        $bank = $return['dataBank'];
        $city = $return['dataCity'];
        return view('master.input_lembaga')
            ->with([
                'dataBank' => $bank,
                'dataCity' => $city,
            ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'namaLembaga' => 'required|max:100|min:3',
            'alamat' => 'required|max:500|min:10',
            'pic' => 'required|max:100|min:3',
            'noTelp' => 'required|numeric|regex:/^[0-9]{10,15}$/|digits_between:10,15',
            'jabatan' => 'required|max:100|min:3',
        ], [
            'namaLembaga.required'  => 'Nama lembaga harus diisi',
            'namaLembaga.max' => 'Nama lembaga maksimal 100 karakter',
            'namaLembaga.min' => 'Nama lembaga minimal 3 karakter',
            'alamat.required'  => 'Alamat harus diisi',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'alamat.min' => 'Alamat minimal 10 karakter',
            'noTelp.required' => 'No HP harus diisi',
            'noTelp.regex' => 'No HP harus terdiri dari 10 sampai 15 angka',
            'jabatan.required'  => 'Jabatan harus diisi',
            'jabatan.max' => 'Jabatan maksimal 100 karakter',
            'jabatan.min' => 'Jabatan minimal 3 karakter',
        ]);

        $dataLembaga = [
            'nama_lembaga' => $request->namaLembaga,
            'alamat' => $request->alamat,
            'nama_pic' => $request->pic,
            'no_telp' => $request->noTelp,
            'jabatan' => $request->jabatan,
            'id_perusahaan' => session('user')->id_perusahaan,
        ];

       try {
            DB::table('tbl_lembaga')->insert($dataLembaga);
            return redirect()->route('dataLembaga')->with('sukses', 'Yayasan atau Lembaga berhasil disimpan');
       } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Yayasan atau Lembaga gagal disimpan');
       }
    }

    public function ubah($lembagaID)
    {
        try {
            $logID = decrypt($lembagaID);
        } catch (Exception $e) {
            abort(404);
        }

        $lembaga = Lembaga::where('id_lembaga', $logID)->first();
        $release = APIHelper::instance()->apiCall('GET', env('BASEURL_POPAYV3') . '/api/APIPaymentRequest/form/bank/2312', '');
        $return = json_decode(strstr($release, '{'), true);
        $bank = $return['dataBank'];
        $city = $return['dataCity'];
        return view('master.edit_lembaga')
            ->with([
                'data' => $lembaga,
                'dataBank' => $bank,
                'dataCity' => $city,
            ]);
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->lembagaID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'namaLembaga' => 'required|max:100|min:3',
            'alamat' => 'required|max:500|min:10',
            'pic' => 'required|max:100|min:3',
            'noTelp' => 'required|numeric|regex:/^[0-9]{10,15}$/|digits_between:10,15',
            'jabatan' => 'required|max:100|min:3',
        ], [
            'namaLembaga.required'  => 'Nama lembaga harus diisi',
            'namaLembaga.max' => 'Nama lembaga maksimal 100 karakter',
            'namaLembaga.min' => 'Nama lembaga minimal 3 karakter',
            'alamat.required'  => 'Alamat harus diisi',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'alamat.min' => 'Alamat minimal 10 karakter',
            'noTelp.required' => 'No HP harus diisi',
            'noTelp.regex' => 'No HP harus terdiri dari 10 sampai 15 angka',
            'jabatan.required'  => 'Jabatan harus diisi',
            'jabatan.max' => 'Jabatan maksimal 100 karakter',
            'jabatan.min' => 'Jabatan minimal 3 karakter',
        ]);

        $dataLembaga = [
            'nama_lembaga' => $request->namaLembaga,
            'alamat' => $request->alamat,
            'nama_pic' => $request->pic,
            'no_telp' => $request->noTelp,
            'jabatan' => $request->jabatan,
        ];

        try {
            Lembaga::where('id_lembaga', $logID)->update($dataLembaga);
            return redirect()->route('dataLembaga')->with('sukses', 'Yayasan atau Lembaga berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Yayasan atau Lembaga gagal diubah');
        }
    }

    public function updateBank(Request $request)
    {
        try {
            $logID = decrypt($request->lembagaID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'namaBank' => 'required',
            'noRekening' => 'required|numeric',
            'atasNama' => 'required|max:100|min:3',
        ], [
            'namaBank.required'  => 'Nama bank harus diisi',
            'noRekening.required' => 'No rekening harus diisi',
            'atasNama.required'  => 'Atas nama harus diisi',
            'atasNama.max' => 'Atas nama maksimal 100 karakter',
            'atasNama.min' => 'Atas nama minimal 3 karakter',
        ]);

        $dataBank = [
            'nama_bank' => $request->namaBank,
            'atas_nama' => $request->atasNama,
            'no_rekening' => $request->noRekening,
        ];

       try {
            Lembaga::where('id_lembaga', $logID)->update($dataBank);
            return redirect()->back()->with('sukses', 'Informasi bank berhasil diupdate');
       } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Informasi bank gagal diupdate');
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
        return redirect()->back()->with('sukses', 'Yayasan atau Lembaga berhasil dihapus');
    }
}
