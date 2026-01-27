<?php

namespace App\Http\Controllers;

use App\Helper\APIHelper;
use App\Models\Dokumen;
use App\Models\DokumenVendor;
use App\Models\KTPPengurus;
use App\Models\KTPVendor;
use App\Models\Lampiran;
use App\Models\LampiranVendor;
use App\Models\Log;
use App\Models\LogVendor;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Exception;

class VendorController extends Controller
{
    function tanggal_indo($tanggal)
    {
        $bulan = array(1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }

    public function index()
    {
        $data = Vendor::orderBy('vendor_id', 'ASC')->get();
        return view('master.vendor.index')
            ->with([
                'dataVendor' => $data,
            ]);
    }

    public function create()
    {
        return view('master.vendor.create');
    }

    public function createProfile()
    {
        $namaPerusahaan = session('user')->perusahaan;
        return view('master.vendor.createProfile')
                ->with([
                    'namaPerusahaan' => $namaPerusahaan,
                ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'namaPerusahaan' => 'required',
            'emailPerusahaan' => 'required|email',
            'alamat' => 'required',
            'noTelp' => 'required',
            'namaPIC' => 'required',
            'noHP' => 'required',
            'noKTP' => 'required',
            'jabatan' => 'required',
            'emailPIC' => 'required|email',
        ]);

        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $name = str_replace(' ', '-', $image->getClientOriginalName());
            $featured_new_name = time() . "-" . $name;
            $image->move('attachment', $featured_new_name);

            $dataVendor = [
                'nama_perusahaan' => $request->namaPerusahaan,
                'alamat' => $request->alamat,
                'no_telp' => $request->noTelp,
                'email' => $request->emailPerusahaan,
                'website' => $request->website,
                'no_ktp' => $request->noKTP,
                'nama_pic' => $request->namaPIC,
                'jabatan' => $request->jabatan,
                'email_pic' => $request->emailPIC,
                'no_hp' => $request->noHP,
                'file_ktp' => $featured_new_name,
            ];
        }else{
            $dataVendor = [
                'nama_perusahaan' => $request->namaPerusahaan,
                'alamat' => $request->alamat,
                'no_telp' => $request->noTelp,
                'email' => $request->emailPerusahaan,
                'website' => $request->website,
                'no_ktp' => $request->noKTP,
                'nama_pic' => $request->namaPIC,
                'jabatan' => $request->jabatan,
                'email_pic' => $request->emailPIC,
                'no_hp' => $request->noHP,
            ];
        }

        try {
            DB::table('tbl_vendor')->insert($dataVendor);
            return redirect()->route('profilePerusahaan')->with('sukses', 'Data vendor berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Data vendor gagal disimpan');
        }
    }

    public function edit($vendorID)
    {
        try {
            $logID = decrypt($vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        $data = Vendor::where('vendor_id', $logID)->first();
        return view('master.vendor.edit')
            ->with([
                'data' => $data,
            ]);
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'namaPerusahaan' => 'required',
            'emailPerusahaan' => 'required|email',
            'alamat' => 'required',
            'noTelp' => 'required',
            'namaPIC' => 'required',
            'noHP' => 'required',
            'noKTP' => 'required',
            'jabatan' => 'required',
            'emailPIC' => 'required|email',
        ]);

        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $name = str_replace(' ', '-', $image->getClientOriginalName());
            $featured_new_name = time() . "-" . $name;
            $image->move('attachment', $featured_new_name);

            $dataVendor = [
                'nama_perusahaan' => $request->namaPerusahaan,
                'alamat' => $request->alamat,
                'no_telp' => $request->noTelp,
                'email' => $request->emailPerusahaan,
                'website' => $request->website,
                'no_ktp' => $request->noKTP,
                'nama_pic' => $request->namaPIC,
                'jabatan' => $request->jabatan,
                'email_pic' => $request->emailPIC,
                'no_hp' => $request->noHP,
                'file_ktp' => $featured_new_name,
            ];
        }else{
            $dataVendor = [
                'nama_perusahaan' => $request->namaPerusahaan,
                'alamat' => $request->alamat,
                'no_telp' => $request->noTelp,
                'email' => $request->emailPerusahaan,
                'website' => $request->website,
                'no_ktp' => $request->noKTP,
                'nama_pic' => $request->namaPIC,
                'jabatan' => $request->jabatan,
                'email_pic' => $request->emailPIC,
                'no_hp' => $request->noHP,
            ];
        }

        try {
            Vendor::where('vendor_id', $logID)->update($dataVendor);
            if (session('user')->role == "Vendor"){
                return redirect()->back()->with('sukses', 'Profile perusahaan berhasil diubah');
            }else{
                return redirect()->route('indexVendor')->with('sukses', 'Profile vendor berhasil diubah');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Profile perusahaan gagal diubah');
        }
    }

    public function delete($vendorID)
    {
        try {
            $logID = decrypt($vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        Vendor::where('vendor_id', $logID)->delete();
        return redirect()->back()->with('sukses', 'Vendor berhasil dihapus');
    }

    public function profile()
    {
        $namaPerusahaan = session('user')->perusahaan;

        $data = Vendor::where('nama_perusahaan', $namaPerusahaan)->first();
        $jumlah = Vendor::where('nama_perusahaan', $namaPerusahaan)->count();
        return view('master.vendor.profile')
            ->with([
                'dataVendor' => $data,
                'jumlahVendor' => $jumlah,
            ]);
    }

    public function view($vendorID)
    {
        try {
            $logID = decrypt($vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        $vendor = Vendor::where('vendor_id', $logID)->first();
        $lampiran = LampiranVendor::where('id_vendor', $logID)->get();
        $jumlahLampiran = LampiranVendor::where('id_vendor', $logID)->count();
        $jumlahDokumen = DokumenVendor::where('id_vendor', $logID)->where('nama_dokumen', 'NPWP')->count();
        $dokumen = DokumenVendor::where('id_vendor', $logID)->where('nama_dokumen', 'NPWP')->first();
        $user = User::where('email', $vendor->email)->count();

        return view('vendor.profile')
            ->with([
                'dataVendor' => $vendor,
                'jumlahLampiran' => $jumlahLampiran,
                'dataLampiran' => $lampiran,
                'jumlahDokumen' => $jumlahDokumen,
                'dokumen' => $dokumen,
                'user' => $user,
            ]);
    }

    public function viewKTP($vendorID)
    {
        try {
            $logID = decrypt($vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        $vendor = Vendor::where('vendor_id', $logID)->first();
        $jumlahLampiran = LampiranVendor::where('id_vendor', $logID)->count();
        $lampiran = LampiranVendor::where('id_vendor', $logID)->get();

        $jumlahDokumenKTP = DokumenVendor::where('id_vendor', $vendor->vendor_id)->where('nama_dokumen', 'KTP Pengurus')->count();
        $dokumenKTP = DokumenVendor::where('id_vendor', $vendor->vendor_id)->where('nama_dokumen', 'KTP Pengurus')->first();
        $jumlahKTP = KTPVendor::where('id_vendor', $vendor->vendor_id)->count();
        $dataKTP = KTPVendor::where('id_vendor', $vendor->vendor_id)->get();
        return view('vendor.ktp')
            ->with([
                'dataVendor' => $vendor,
                'jumlahLampiran' => $jumlahLampiran,
                'dataLampiran' => $lampiran,
                'jumlahDokumenKTP' => $jumlahDokumenKTP,
                'dokumenKTP' => $dokumenKTP,
                'jumlahKTP' => $jumlahKTP,
                'dataKTP' => $dataKTP,
            ]);
    }

    public function storeKTP(Request $request)
    {

        try {
            $logID = decrypt($request->vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        $jumlah = DokumenVendor::where('id_vendor', $logID)->where('nama_dokumen', 'KTP Pengurus')->count();
        $tanggalMenit = date("Y-m-d H:i:s");

        $this->validate($request, [
            'nomor' => 'required|size:16|numeric',
            'nama' => 'required',
            'jabatan' => 'required',
            'noTelp' => 'required|numeric',
            'email' => 'required|email',
            'lampiran' => 'required|max:100000',
        ]);

        $image = $request->file('lampiran');
        $size = $image->getSize();
        $type = $image->getClientOriginalExtension();
        $name = $request->namaDokumen . time() . '.' . $type;
        $fileName = $name;
        $image->move(public_path() . '/attachment', $fileName);

        $dataLog = [
            'id_vendor' => $logID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Update kelengkapan dokumen $request->namaDokumen untuk jabatan $request->jabatan",
        ];

        $dataLampiran = [
            'id_vendor' => $logID,
            'nomor' => $request->nomor,
            'nama_file' => "KTP $request->jabatan",
            'file' => $name,
            'size' => $size,
            'type' => $type,
            'status' => 'Open',
            'upload_by' => session('user')->id_user,
            'upload_date' => $tanggalMenit,
        ];

        $dataDokumen = [
            'id_vendor' => $logID,
            'nama_dokumen' => $request->namaDokumen,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu Verifikasi',
            'status_date' => $tanggalMenit,
            'created_date' => $tanggalMenit,
            'created_by' => session('user')->id_user,
        ];

        $dataKTP = [
            'id_vendor' => $logID,
            'nomor' => $request->nomor,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->noTelp,
            'email' => $request->email,
            'file' => $name,
            'created_date' => $tanggalMenit,
            'created_by' => session('user')->id_user,
        ];

        try {
            DB::table('tbl_log_vendor')->insert($dataLog);
            DB::table('tbl_ktp_pengurus')->insert($dataKTP);
            DB::table('tbl_lampiran_vendor')->insert($dataLampiran);

            if ($jumlah == 0) {
                DB::table('tbl_dokumen_vendor')->insert($dataDokumen);
            }

            return redirect()->back()->with('sukses', "Pengurus perusahaan berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Pengurus perusahaan gagal disimpan");
        }
    }

    public function updateKTP(Request $request)
    {

        try {
            $ktpID = decrypt($request->ktpID);
            $logID = decrypt($request->vendorID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $ktp = KTPVendor::where('ktp_id', $ktpID)->first();

        $this->validate($request, [
            'nomor' => 'required|size:16|numeric',
            'nama' => 'required',
            'jabatan' => 'required',
            'noTelp' => 'required|numeric',
            'email' => 'required|email',
        ]);

        $dataLog = [
            'id_vendor' => $logID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Edit data pengurus perusahaan",
        ];

        try {
            DB::table('tbl_log_vendor')->insert($dataLog);

            if ($request->hasFile('lampiran')) {
                $image = $request->file('lampiran');
                $size = $image->getSize();
                $type = $image->getClientOriginalExtension();
                $name = $request->namaDokumen . time() . '.' . $type;
                $fileName = $name;
                $image->move(public_path() . '/attachment', $fileName);

                $dataKTP = [
                    'nomor' => $request->nomor,
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'no_telp' => $request->noTelp,
                    'email' => $request->email,
                    'file' => $name,
                ];

                $dataLampiran = [
                    'id_vendor' => $logID,
                    'nomor' => $request->nomor,
                    'nama_file' => "KTP $request->jabatan",
                    'file' => $name,
                    'size' => $size,
                    'type' => $type,
                    'status' => 'Open',
                    'upload_by' => session('user')->email,
                    'upload_date' => $tanggalMenit,
                ];

                DB::table('tbl_ktp_pengurus')->where('ktp_id', $ktpID)->update($dataKTP);
                DB::table('tbl_lampiran_vendor')->where('id_vendor', $ktp->vendor_id)->where('nama_file', 'KTP ' . $ktp->jabatan)->delete();
                DB::table('tbl_lampiran_vendor')->insert($dataLampiran);
            } else {

                $dataKTP = [
                    'nomor' => $request->nomor,
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'no_telp' => $request->noTelp,
                    'email' => $request->email,
                ];

                DB::table('tbl_ktp_pengurus')->where('ktp_id', $ktpID)->update($dataKTP);
            }

            return redirect()->back()->with('sukses', "Pengurus perusahaan berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Pengurus perusahaan gagal diubah");
        }
    }

    public function deleteKTP($ktpID)
    {

        try {
            $logID = decrypt($ktpID);
        } catch (Exception $e) {
            abort(404);
        }

        $ktp = KTPVendor::where('ktp_id', $logID)->first();
        $jumlah = KTPVendor::where('id_vendor', $ktp->vendor_id)->count();

        try {
            if ($jumlah == 1) {
                DB::table('tbl_dokumen_vendor')->where('id_vendor', $ktp->vendor_id)->where('nama_dokumen', 'KTP Pengurus')->delete();
            }
            DB::table('tbl_ktp_pengurus')->where('ktp_id', $logID)->delete();
            DB::table('tbl_lampiran_vendor')->where('id_vendor', $ktp->vendor_id)->where('nama_file', 'KTP ' . $ktp->jabatan)->delete();
            return redirect()->back()->with('sukses', 'Pengurus perusahaan berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Pengurus perusahaan gagal dihapus');
        }

    }
}
