<?php

namespace App\Http\Controllers;

use App\Actions\SubProposal\StoreSubProposalAction;
use App\Exports\PaymentExport;
use App\Exports\SubProposalExport;
use App\Http\Requests\StoreSubProposalRequest;
use App\Helper\APIHelper;
use App\Models\Kelayakan;
use App\Models\Provinsi;
use App\Models\SubProposal;
use App\Models\Survei;
use Illuminate\Http\Request;
use DB;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class SubProposalController extends Controller
{
    public function index($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $kelayakan = Kelayakan::where('no_agenda', $logID)->first();
        $survei = Survei::where('no_agenda', $logID)->first();
        $subProposal = SubProposal::where('no_agenda', $logID)->orderBy('id_sub_proposal', 'ASC')->get();
        $total = DB::table('TBL_SUB_PROPOSAL')
            ->select(DB::raw('sum(SUBTOTAL) as jumlah'))
            ->where([
                ['no_agenda', $logID],
            ])
            ->first();

        return view('transaksi.data_sub_proposal')
            ->with([
                'dataKelayakan' => $kelayakan,
                'nilaiApproved' => $survei->nilai_approved,
                'dataSubProposal' => $subProposal,
                'noAgenda' => $logID,
                'total' => $total->jumlah,
            ]);
    }

    public function input($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $provinsi = Provinsi::all();

        return view('transaksi.input_sub_proposal')
            ->with([
                'dataProvinsi' => $provinsi,
                'noAgenda' => $logID,
            ]);
    }

    public function store(StoreSubProposalRequest $request, StoreSubProposalAction $action)
    {
        return $action->execute($request);
    }

    public function ubah($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $subProposal = SubProposal::where('id_sub_proposal', $logID)->first();
        $provinsi = Provinsi::all();
        return view('transaksi.edit_sub_proposal')
            ->with([
                'data' => $subProposal,
                'dataProvinsi' => $provinsi,
                'noAgenda' => $subProposal->no_agenda,
            ]);
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->proposalID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'namaKetua' => 'required',
            'namaLembaga' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
        ]);

        $nomor = SubProposal::where('no_agenda', $request->noAgenda)->count();
        $nomorUrut = $nomor + 1;
        $nomorSubAgenda = $request->noAgenda . '.' . $nomorUrut;

        $hargaKambing = str_replace(".", "", $request->hargaKambing);
        $hargaSapi = str_replace(".", "", $request->hargaSapi);

        $totalKambing = $request->kambing * $hargaKambing;
        $totalSapi = $request->sapi * $hargaSapi;

        $subTotal = $totalKambing + $totalSapi;
        $fee = $subTotal * 10 / 100;
        $ppn = $fee * 10 / 100;
        $grandTotal = $subTotal + $fee + $ppn;

        $dataSubProposal = [
            'no_sub_agenda' => $nomorSubAgenda,
            'nama_ketua' => $request->namaKetua,
            'nama_lembaga' => $request->namaLembaga,
            'kambing' => $request->kambing,
            'harga_kambing' => $hargaKambing,
            'sapi' => $request->sapi,
            'harga_sapi' => $hargaSapi,
            'total' => $subTotal,
            'fee' => $fee,
            'ppn' => $ppn,
            'subtotal' => $grandTotal,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
        ];

        try {
            SubProposal::where('id_sub_proposal', $logID)->update($dataSubProposal);
            return redirect()->route('dataSubProposal', encrypt($request->noAgenda))->with('sukses', 'Sub Proposal berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Sub Proposal gagal diubah');
        }

    }

    public function delete($sub_proposalID)
    {
        try {
            $logID = decrypt($sub_proposalID);
        } catch (Exception $e) {
            abort(404);
        }

        SubProposal::where('id_sub_proposal', $logID)->delete();
        return redirect()->back()->with('sukses', 'Sub Proposal berhasil dihapus');
    }

    public function export($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = $tanggalMenit . '_hewanQurban.xlsx';
        return Excel::download(new SubProposalExport($logID), $namaFile);
    }
}
