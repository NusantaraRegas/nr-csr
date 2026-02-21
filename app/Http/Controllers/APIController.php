<?php

namespace App\Http\Controllers;

use App\Helper\APIHelper;

use App\Models\Anggaran;
use App\Models\Kelayakan;
use App\Models\Pembayaran;
use App\Models\Pilar;
use App\Models\Proker;
use App\Models\Provinsi;
use App\Models\SektorBantuan;
use App\Models\ViewPembayaran;
use App\Models\ViewProker;
use App\Http\Requests\ApiUpdateStatusRequest;
use App\Http\Requests\PostPaymentRequestAnnualRequest;
use App\Actions\API\PostPaymentRequestAnnualAction;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Exception;
use DB;

class APIController extends Controller
{
    
    public function storePaymentRequest(Request $request)
    {

        try {
            $pembayaranID = decrypt($request->pembayaranID);
        } catch (Exception $e) {
            abort(404);
        }


        $request->validate([
            'noInvoice' => 'required',
            'invoiceDate' => 'required|date',
            'invoiceDueDate' => 'required|date',
        ], [
            'noInvoice.required'   => 'Nomor invoice harus diisi',
            'invoiceDate.required' => 'Tanggal invoice harus diisi',
            'invoiceDate.date'  => 'Format tanggal invoice tidak valid',
            'invoiceDueDate.required' => 'Due date harus diisi',
            'invoiceDueDate.date'  => 'Format due date tidak valid',
        ]);

        $pembayaran = ViewPembayaran::findOrFail($pembayaranID);

        if(empty($pembayaran)){
            return redirect()->back()->with('gagalDetail', "Data pembayaran tidak ditemukan")->withInput();
        }

        $username = session('user')->username;

        $paramUser = array(
            "username" => $username
        );


        $callUser = APIHelper::instance()->httpCallJson('POST', env('BASEURLPOPAYSAP') . '/api/APISAPTravelManagement/CheckUser', $paramUser, '');
        $resultUser = json_decode(strstr($callUser, '{'), true);

        $status = $resultUser['status'];

        if ($status == 'S') {

            $roleID = $resultUser['data']['role_id'];
            $userID = $resultUser['data']['id'];
            $user_name = $resultUser['data']['username'];
            $divID = $resultUser['data']['div_id'];
            $orgID = $resultUser['data']['org_id'];

            if (strcasecmp($roleID, 'Maker') !== 0) {
                return redirect()->back()->with('gagalDetail', 'Anda tidak terdaftar sebagai maker Popay');
            }

            $dateTime = date("Y-m-d H:i:s");
            
            $deskripsi = 'POPAY/' . strtoupper($request->noInvoice);

            $param = array(
                'user_id' => $userID,
                'user_name' => $user_name,
                'org_id' => $orgID,
                'div_id' => $divID,
                'category' => "INVOICE MIRO",
                "payment_type" => "CSR 517/518",
                "budget_year" => $pembayaran->tahun,
                "budget_name" => "RKAP $pembayaran->tahun",
                'description_bank' => strtoupper(substr($deskripsi, 0, 30)),
                'description_detail' => strtoupper(strtoupper($pembayaran->deskripsi_pembayaran)),
                'invoice_num' => strtoupper($request->noInvoice),
                "invoice_date" => date("Y-m-d", strtotime($request->invoiceDate)),
                "invoice_due_date" => date("Y-m-d", strtotime($request->invoiceDueDate)),
                'invoice_curr' => "IDR",
                'invoice_amount' => $pembayaran->subtotal,
                'sap_header_amount' => $pembayaran->subtotal,
                'invoice_amount_paid' => $pembayaran->subtotal,
                'supplier_type' => null,
                'supplier_number' => null,
                'supplier_name' => null,
                'supplier_site_address' => null,
                'supplier_email' => null,
                'supplier_npwp' => null,
                'sap_vendor_number' => null,
                'sap_vendor_glacc' => null,
                'attribute1' => null,
                'attribute2' => null,
                'attribute3' => null,
                'attribute4' => null
            );

            try {
                $store = APIHelper::instance()->httpCallJson('POST', env('BASEURLPOPAYSAP') . '/api/APIPaymentRequest/StorePaymentRequestWithAttribute', $param, '');
                $return = json_decode(strstr($store, '{'), true);
                $statusRequest = $return['status'];
                $pesanRequest = $return['message'];

                if ($statusRequest == "S"){
                    $prID = $return['data']['pr_id'];

                    $dataUpdate = [
                        'pr_id' => $prID,
                        'status' => 'Exported',
                        'export_by' => session('user')->username,
                        'export_date' => $dateTime,
                    ];

                    DB::table('tbl_pembayaran')->where('id_pembayaran', $pembayaranID)->update($dataUpdate);
                    return redirect()->back()->with('sukses', "$pesanRequest");
                }else{
                    return redirect()->back()->with('gagal', "$pesanRequest");
                }  
            } catch (Exception $e) {
                return redirect()->back()->with('gagal', 'Pembayaran gagal diexport ke popay');
            }
        } else {
            return redirect()->back()->with('peringatan', 'Anda tidak terdaftar sebagai maker Popay');
        }

    }

    public function storePaymentRequestIdulAdha(Request $request)
    {
        $this->validate($request, [
            'noInvoice' => 'required',
            'invoiceDate' => 'required',
            'invoiceDueDate' => 'required',
            'budget' => 'required',
            'deskripsi' => 'required',
            'receiverName' => 'required',
            'receiverType' => 'required',
            'receiverNumber' => 'required',
            'receiverEmail' => 'required',
            'siteName' => 'required',
            'receiverAddress' => 'required',
            'accountNumber' => 'required',
            'accountName' => 'required',
            'bankName' => 'required',
            'bankCity' => 'required',
            'bankBranch' => 'required',
            'emailBank' => 'required',
            'receiverBank' => 'required',
            'citizen' => 'required',
            'totalAmount' => 'required',
        ]);

        if (session('user')->role == '1') {
            $username = 'dinar.valupi-e';
        } else {
            $username = session('user')->username;
        }

        $paramUser = array(
            "code" => "abc123def",
            "username" => $username
        );


        $callUser = APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIUser/detail', $paramUser, '');
        $resultUser = json_decode(strstr($callUser, '{'), true);

        $maker = $resultUser['role_id'];
        $userID = $resultUser['id'];
        $user_name = $resultUser['username'];
        $divID = $resultUser['div_id'];
        $orgID = $resultUser['org_id'];

        if ($maker == 'Maker') {
            $dateTime = date("Y-m-d H:i:s");
            $dataPembayaran = ViewPembayaran::where('id_pembayaran', $request->ID)->first();

            $param = array(
                "budget_year" => $request->budget,
                "category" => "STANDARD",
                "description_detail" => strtoupper($request->deskripsi),
                "div_id" => $divID,
                "invoice_amount" => $dataPembayaran->jumlah_pembayaran,
                "invoice_amount_paid" => $dataPembayaran->jumlah_pembayaran,
                "invoice_curr" => "IDR",
                "invoice_date" => date("Y-m-d", strtotime($request->invoiceDate)),
                "invoice_due_date" => date("Y-m-d", strtotime($request->invoiceDueDate)),
                "invoice_num" => strtoupper($request->noInvoice),
                "invoice_refund" => 0,
                "org_id" => $orgID,
                "payment_type" => "CSR 517/518",
                "supplier_email" => $request->receiverEmail,
                "supplier_name" => $request->receiverName,
                "supplier_npwp" => $request->receiverTax,
                "supplier_number" => $request->receiverNumber,
                "supplier_site_address" => $request->receiverAddress,
                "supplier_site_name" => $request->siteName,
                "supplier_type" => $request->receiverType,
                "user_id" => $userID,
                "user_name" => $user_name,
                "attribute1" => "Idul Adha",
                "attribute2" => $dataPembayaran->sektor_bantuan,
                "attribute3" => $dataPembayaran->provinsi,
                "attribute4" => $dataPembayaran->kabupaten
            );

            try {
                $store = APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIPaymentRequest/StorePaymentRequestWithAttribute', $param, '');
                $return = json_decode(strstr($store, '{'), true);
                $data = $return['data'];

                $paramBank = array(
                    "ben_bank_account" => $request->accountNumber,
                    "ben_bank_cabang" => $request->bankBranch,
                    "ben_bank_city" => $request->bankCity,
                    "ben_bank_code" => $request->bankName,
                    "ben_email" => $request->emailBank,
                    "ben_name" => $request->accountName,
                    "ben_nasabah_type" => $request->receiverBank,
                    "ben_nationality" => $request->citizen,
                    "pr_id" => $data['pr_id'],
                    "receive_amount" => str_replace(".", "", $request->totalAmount)
                );

                APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIReceiver/StorePaymentReceiver', $paramBank, '');

                $dataUpdate = [
                    'pr_id' => $data['pr_id'],
                    'status' => 'exported',
                    'export_by' => session('user')->username,
                    'export_date' => $dateTime,
                ];

                DB::table('tbl_pembayaran')
                    ->where('id_pembayaran', $request->ID)
                    ->update($dataUpdate);
                return redirect()->route('listPaymentRequestProposal')->with('sukses', 'Realisasi proposal berhasil diexport ke Popay');
            } catch (Exception $e) {
                return redirect()->back()->with('gagal', 'Realisasi proposal gagal diexport ke Popay');
            }
        } else {
            return redirect()->back()->with('peringatan', 'Anda bukan maker Popay');
        }

    }

    public function storeDetailAccountIdulAdha(Request $request)
    {

        $this->validate($request, [
            'prID' => 'required',
            'coaAccount' => 'required',
            'ppn' => 'required',
//            'ppnCode' => 'required',
//            'ppnPut' => 'required',
//            'taxCode' => 'required',
        ]);

        $username = session('user')->username;

        $paramUser = array(
            "code" => "abc123def",
            //"username" => $username
            "username" => "dinar.valupi-e",
        );


        $callUser = APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIUser/detail', $paramUser, '');
        $resultUser = json_decode(strstr($callUser, '{'), true);

        $maker = $resultUser['role_id'];
        $userID = $resultUser['id'];
        $user_name = $resultUser['username'];
        $divID = $resultUser['div_id'];
        $orgID = $resultUser['org_id'];

        if ($maker == 'Maker') {
            $dateTime = date("Y-m-d H:i:s");
            //$dataPembayaran = ViewPembayaran::where('id_pembayaran', $request->ID)->first();

            $paramCCID = array(
                "prr_id" => $request->prID,
                "segment1" => "100",
                "segment2" => $request->coaAccount,
                "segment3" => $divID,
                "segment4" => "000",
                "segment5" => $request->coaElemenBiaya,
                "segment6" => "000",
                "segment7" => "000",
                "segment8" => "000"
            );

            $storeCCID = APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIDetailAccount/CheckCCID', $paramCCID, '');
            $returnCCID = json_decode(strstr($storeCCID, '{'), true);
            $dataCCID = $returnCCID['Collection'][0];

            $prID = $request->prID;

            $param = array(
                "pr_id" => $prID,
            );

            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/viewPaymentRequest', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['dataPR'];
            $dataReceiver = $return['dataReceiver'];
            $dataDetail = $return['dataDetail'];
            $dataPopay = $data[0];

            $dataPembayaran = Pembayaran::where('pr_id', $request->prID)->first();
            $kelayakan = Kelayakan::where('no_agenda', $dataPembayaran->no_agenda)->first();

            //$dataSubProposal = SubProposal::where('no_agenda', $dataPembayaran->no_agenda)->get();

            $dataSubProposal = DB::table('TBL_SUB_PROPOSAL')
                ->where('NO_AGENDA', $dataPembayaran->no_agenda)
                ->get();

            foreach ($dataSubProposal as $sub) {
                if ($request->ppn == 'include') {
                    if ($request->taxRate == 1) {
                        $result[] = [
                            $debit = $sub->total * $dataPembayaran->persen / 100,
                            $ppnAmount = floor($debit / 101),
                            $dpp = $debit - $ppnAmount,

                            $paramDetail = [
                                "pr_id" => $request->prID,
                                "type" => "Item",
                                "debit" => $debit,
                                "credit" => "0",
                                "default_description" => $request->prID . "-" . strtoupper($dataPopay['supplier_name']) . "-" . strtoupper($dataPopay['description_detail']),
                                "coa_segment1" => "100",
                                "coa_segment2" => $request->coaAccount,
                                "coa_segment3" => $divID,
                                "coa_segment4" => "000",
                                "coa_segment5" => $request->coaElemenBiaya,
                                "coa_segment6" => "000",
                                "coa_segment7" => "000",
                                "coa_segment8" => "000",
                                "coa_combination" => $dataCCID['accountCombination'],
                                "coa_description" => $dataCCID['accountDescription'],
                                "ccid" => $dataCCID['ccid'],
                                "pph_tax_code" => $request->taxCode,
                                "ppn_tax_code" => $request->ppnCode,
                                "line_header_id" => null,
                                "project_id" => null,
                                "rcv_id" => null,
                                "tax_include" => $request->ppn,
                                "dpp" => $dpp,
                                "ppn_tax_amount" => $ppnAmount,
                                "attribute1" => $kelayakan->jenis,
                                "attribute2" => $kelayakan->sektor_bantuan,
                                "attribute3" => $sub->provinsi,
                                "attribute4" => $sub->kabupaten,
                            ],

                            #INSERT DETAIL
                            APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIDetailAccount/StoreDetailAccountWithAttribute', $paramDetail, ''),

                        ];
                    } else {
                        $result[] = [
                            $debit = $sub->total * $dataPembayaran->persen / 100,
                            $ppnAmount = floor($debit / 11),
                            $dpp = $debit - $ppnAmount,

                            $paramDetail = [
                                "pr_id" => $request->prID,
                                "type" => "Item",
                                "debit" => $debit,
                                "credit" => "0",
                                "default_description" => $request->prID . "-" . strtoupper($dataPopay['supplier_name']) . "-" . strtoupper($dataPopay['description_detail']),
                                "coa_segment1" => "100",
                                "coa_segment2" => $request->coaAccount,
                                "coa_segment3" => $divID,
                                "coa_segment4" => "000",
                                "coa_segment5" => $request->coaElemenBiaya,
                                "coa_segment6" => "000",
                                "coa_segment7" => "000",
                                "coa_segment8" => "000",
                                "coa_combination" => $dataCCID['accountCombination'],
                                "coa_description" => $dataCCID['accountDescription'],
                                "ccid" => $dataCCID['ccid'],
                                "pph_tax_code" => $request->taxCode,
                                "ppn_tax_code" => $request->ppnCode,
                                "line_header_id" => null,
                                "project_id" => null,
                                "rcv_id" => null,
                                "tax_include" => $request->ppn,
                                "dpp" => $dpp,
                                "ppn_tax_amount" => $ppnAmount,
                                "attribute1" => $kelayakan->jenis,
                                "attribute2" => $kelayakan->sektor_bantuan,
                                "attribute3" => $sub->provinsi,
                                "attribute4" => $sub->kabupaten,
                            ],

                            #INSERT DETAIL
                            APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIDetailAccount/StoreDetailAccountWithAttribute', $paramDetail, ''),

                        ];
                    }
                } else {
                    $result[] = [

                        $debit = $sub->total * ($dataPembayaran->persen / 100),
                        $ppnAmount = 0,
                        $dpp = $debit,

                        $paramDetail = [
                            "pr_id" => $request->prID,
                            "type" => "Item",
                            "debit" => $debit,
                            "credit" => "0",
                            "default_description" => $request->prID . "-" . strtoupper($dataPopay['supplier_name']) . "-" . strtoupper($dataPopay['description_detail']),
                            "coa_segment1" => "100",
                            "coa_segment2" => $request->coaAccount,
                            "coa_segment3" => $divID,
                            "coa_segment4" => "000",
                            "coa_segment5" => $request->coaElemenBiaya,
                            "coa_segment6" => "000",
                            "coa_segment7" => "000",
                            "coa_segment8" => "000",
                            "coa_combination" => $dataCCID['accountCombination'],
                            "coa_description" => $dataCCID['accountDescription'],
                            "ccid" => $dataCCID['ccid'],
                            "pph_tax_code" => $request->taxCode,
                            "ppn_tax_code" => $request->ppnCode,
                            "line_header_id" => null,
                            "project_id" => null,
                            "rcv_id" => null,
                            "tax_include" => $request->ppn,
                            "dpp" => $dpp,
                            "ppn_tax_amount" => $ppnAmount,
                            "attribute1" => $kelayakan->jenis,
                            "attribute2" => $kelayakan->sektor_bantuan,
                            "attribute3" => $sub->provinsi,
                            "attribute4" => $sub->kabupaten,
                        ],

                        #INSERT DETAIL
                        APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIDetailAccount/StoreDetailAccountWithAttribute', $paramDetail, ''),

                    ];
                }

            }
            return redirect()->route('listPaymentRequestProposal')->with('sukses', 'Detail account berhasil diexport ke Popay');

//            try {
//
//
//            } catch (Exception $e) {
//                return redirect()->back()->with('gagal', 'Detail account gagal diexport ke Popay');
//            }
        } else {
            return redirect()->back()->with('peringatan', 'Anda bukan maker Popay');
        }

    }

    public function listProgressAll(Request $request)
    {
        $tahun = date("Y");

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listProgressPaymentRequestCSR', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function postProgressAllAnnual(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('listProgressAllAnnual', ['year' => $request->tahun]);
    }

    public function listProgressAllAnnual($year)
    {
        $tahun = $year;

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listProgressPaymentRequestCSR', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $proker = ViewProker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'tahun' => $tahun,
                'dataPayment' => $data,
                'dataSektor' => $sektor,
                'dataProker' => $proker,
                'dataProvinsi' => $provinsi,
            ]);
    }

    public function listPaymentRequestAllMonth($status, $month)
    {
        $tahun = date("Y");
        $bulan = $month;
        $bulanLalu = $bulan - 1;
        $stat = $status;

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
            "bulan" => $bulan,
            "status" => $stat,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRMonth', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $releaseStatus = APIHelper::instance()->apiCall('POST', env('BASEURL_PAYMENT') . '/api/statusPaymentRequest', '');
        $returnStatus = json_decode(strstr($releaseStatus, '{'), true);
        $dataStatus = $returnStatus['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'bulanLalu' => $bulanLalu,
                'status' => $stat,
                'dataStatus' => $dataStatus,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
            ]);
    }

    public function listPaymentRequestAllBulan(Request $request)
    {
        $this->validate($request, [
            'bulan' => 'required',
        ]);

        $tahun = date("Y");
        $bulan = $request->bulan;
        $bulanLalu = $request->bulan - 1;
        $stat = $request->status;

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
            "bulan" => $bulan,
            "status" => $stat,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRMonth', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'bulanLalu' => $bulanLalu,
                'status' => $stat,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
            ]);
    }

    public function listPaymentRequestAllDate(Request $request)
    {
        $this->validate($request, [
            'tanggal1' => 'required',
            'tanggal2' => 'required',
        ]);

        $tanggal1 = date("Y-m-d", strtotime($request->tanggal1));
        $tanggal2 = date("Y-m-d", strtotime($request->tanggal2));

        $param = array(
            "tanggal1" => $tanggal1,
            "tanggal2" => $tanggal2,
            "user_id" => "1211",
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRDate', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_periode')
            ->with([
                'dataPayment' => $data,
                'tanggal1' => $request->tanggal1,
                'tanggal2' => $request->tanggal2,
                'dataProvinsi' => $provinsi,
                'dataSektor' => $sektor,
            ]);
    }

    public function listPaymentRequestAll(Request $request)
    {
        $tahun = date("Y");
        $status = "Tahun $tahun";

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSR', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $releaseStatus = APIHelper::instance()->apiCall('POST', env('BASEURL_PAYMENT') . '/api/statusPaymentRequest', '');
        $returnStatus = json_decode(strstr($releaseStatus, '{'), true);
        $dataStatus = $returnStatus['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'status' => $status,
                'dataStatus' => $dataStatus,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
            ]);
    }

    public function listPaymentRequestAllProgress(Request $request)
    {
        $tahun = date("Y");
        $status = "Tahun $tahun";

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRProgress', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $releaseStatus = APIHelper::instance()->apiCall('POST', env('BASEURL_PAYMENT') . '/api/statusPaymentRequest', '');
        $returnStatus = json_decode(strstr($releaseStatus, '{'), true);
        $dataStatus = $returnStatus['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'status' => $status,
                'dataStatus' => $dataStatus,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
            ]);
    }

    public function listRealisasiAllToday($date)
    {

        $tanggal = date("Y-m-d", strtotime($date));

        $tahun = date("Y");
        $status = "$date";

        $param = array(
            "user_id" => "1211",
            "tanggal1" => $tanggal,
        );


        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRPAIDToday', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];
        $dataTotal = $return['dataTotal'][0];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment')
            ->with([
                'dataPayment' => $data,
                'Total' => $dataTotal['total'],
                'tahun' => $tahun,
                'status' => $status,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function listRealisasiAll(Request $request)
    {
        $tahun = date("Y");
        $status = "Tahun $tahun";

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRPAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];
        $dataTotal = $return['dataTotal'][0];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'status' => $status,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function postRealisasiAllMonthly(Request $request)
    {
        $this->validate($request, [
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        return redirect()->route('listRealisasiAllMonthly', ['month' => $request->bulan, 'year' => $request->tahun]);
    }

    public function listRealisasiAllMonthly($month, $year)
    {

        $company = session('user')->perusahaan;
        $tahun = $year;
        $bulan = $month;
        $status = "Monthly";
        $tanggal = date("Y-m-d");

        $param = array(
            "user_id" => "1211",
            "bulan" => $bulan,
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRPAIDBulan', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];
        $dataTotal = $return['dataTotal'][0];

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        if ($bulan == '01') {
            $bln = "Januari";
        } elseif ($bulan === '02') {
            $bln = "Februari";
        } elseif ($bulan == '03') {
            $bln = "Maret";
        } elseif ($bulan == '04') {
            $bln = "April";
        } elseif ($bulan == '05') {
            $bln = "Mei";
        } elseif ($bulan == '06') {
            $bln = "Juni";
        } elseif ($bulan == '07') {
            $bln = "Juli";
        } elseif ($bulan == '08') {
            $bln = "Agustus";
        } elseif ($bulan == '09') {
            $bln = "September";
        } elseif ($bulan == '10') {
            $bln = "Oktober";
        } elseif ($bulan == '11') {
            $bln = "November";
        } elseif ($bulan == '12') {
            $bln = "Desember";
        }

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'bulan' => $bulan,
                'tanggal' => $tanggal,
                'status' => $status,
                'persen' => $persen,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function postPaymentRequestAnnual(PostPaymentRequestAnnualRequest $request, PostPaymentRequestAnnualAction $action)
    {
        return $action->execute($request);
    }

    public function listRealisasiAllAnnual($year)
    {

        $company = session('user')->perusahaan;
        $tahun = $year;
        $status = "All Data";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRPAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];
        $dataTotal = $return['dataTotal'][0];

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'status' => $status,
                'persen' => $persen,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function listPaymentRequestProvinsi($year, $provinsi)
    {
        $company = session('user')->perusahaan;
        $tahun = $year;
        $status = "Provinsi";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "attribute3" => $provinsi,
            "budget_year" => $tahun,
        );

        if ($tahun > '2022') {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProvinsiPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        } else {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProvinsi', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        }

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $prov = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'provinsi' => $provinsi,
                'status' => $status,
                'persen' => $persen,
                'dataProvinsi' => $prov,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function listPaymentRequestKabupaten($year, $provinsi, $kabupaten)
    {
        $company = session('user')->perusahaan;
        $tahun = $year;
        $status = "Kabupaten";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "attribute3" => $provinsi,
            "attribute4" => $kabupaten,
            "budget_year" => $tahun,
        );

        if ($tahun > '2022') {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestKabupatenPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        } else {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestKabupaten', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        }

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $prov = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kab = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'provinsi' => $provinsi,
                'kabupaten' => $kabupaten,
                'status' => $status,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'persen' => $persen,
                'dataProvinsi' => $prov,
                'dataKabupaten' => $kab,
                'dataProker' => $proker,
            ]);
    }

    public function listPaymentRequest(Request $request)
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");
        $status = "All Data";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022') {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSRPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        } else {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSR', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        }

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $pilar = Pilar::all();
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'tahun' => $tahun,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'status' => $status,
                'persen' => $persen,
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
                'dataPilar' => $pilar,
            ]);
    }

    public function listPaymentRequestProgress(Request $request)
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");
        $status = "Progress";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022') {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSRProgressPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        } else {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSRProgress', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        }

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'status' => $status,
                'persen' => $persen,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function listPaymentRequestPAID(Request $request)
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");
        $status = "PAID";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022') {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSRPAIDPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        } else {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSRPAID', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        }

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'status' => $status,
                'persen' => $persen,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function listPaymentRequestProker($year, $prokerID)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $status = "Proker";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "budget_name" => $prokerID,
        );

        if ($tahun > '2022') {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProkerPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        } else {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProker', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
            $dataTotal = $return['dataTotal'][0];
        }

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'prokerID' => $prokerID,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'status' => $status,
                'persen' => $persen,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function listPaymentRequestToday($tanggal1, $tanggal2)
    {

        $company = session('user')->perusahaan;
        $tahun = date("Y");
        $status = "Periode";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "tanggal1" => $tanggal1,
            "tanggal2" => $tanggal2,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPeriodePAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];
        $dataTotal = $return['dataTotal'][0];

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'tanggal' => $tanggal,
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'bulan' => $bulan,
                'status' => $status,
                'persen' => $persen,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function listPaymentRequestPeriode(Request $request)
    {

        $this->validate($request, [
            'tanggal1' => 'required',
            'tanggal2' => 'required',
        ]);

        $company = session('user')->perusahaan;
        $tahun = date("Y");
        $status = "Periode";
        $tanggal = date("Y-m-d");
        $tanggal1 = date("Y-m-d", strtotime($request->tanggal1));
        $tanggal2 = date("Y-m-d", strtotime($request->tanggal2));
        $bulan = "";

        $param = array(
            "user_id" => "1211",
            "tanggal1" => $request->tanggal1,
            "tanggal2" => $request->tanggal2,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPeriodePAIDPopayV4', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];
        $dataTotal = $return['dataTotal'][0];

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal['total'] / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_progress')
            ->with([
                'dataPayment' => $data,
                'total' => $dataTotal['total'],
                'tahun' => $tahun,
                'tanggal' => $tanggal,
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'bulan' => $bulan,
                'status' => $status,
                'persen' => $persen,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function listPaymentRequestProposal(Request $request)
    {
        $tahun = date("Y");

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposal', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment')
            ->with([
                'tahun' => $tahun,
                'dataPayment' => $data,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
            ]);
    }

    public function listPaymentRequestProposalPAID(Request $request)
    {
        $tahun = date("Y");

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $releaseStatus = APIHelper::instance()->apiCall('POST', env('BASEURL_PAYMENT') . '/api/statusPaymentRequest', '');
        $returnStatus = json_decode(strstr($releaseStatus, '{'), true);
        $dataStatus = $returnStatus['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_request_proposal_paid')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'dataStatus' => $dataStatus,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'jenis' => "",
            ]);
    }

    public function listPaymentRequestProposalJenis($jenis)
    {
        $tahun = date("Y");

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
            "attribute1" => $jenis,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalJenis', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $releaseStatus = APIHelper::instance()->apiCall('POST', env('BASEURL_PAYMENT') . '/api/statusPaymentRequest', '');
        $returnStatus = json_decode(strstr($releaseStatus, '{'), true);
        $dataStatus = $returnStatus['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_request_proposal_jenis')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'dataStatus' => $dataStatus,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'jenis' => $jenis,
            ]);
    }

    public function listPaymentRequestProposalPeriodeJenis(Request $request)
    {
        $this->validate($request, [
            'tanggal1' => 'required',
            'tanggal2' => 'required',
        ]);

        $tanggal1 = date("Y-m-d", strtotime($request->tanggal1));
        $tanggal2 = date("Y-m-d", strtotime($request->tanggal2));
        $attribute1 = $request->attribute1;

        $param = array(
            "user_id" => "1211",
            "tanggal1" => $tanggal1,
            "tanggal2" => $tanggal2,
            "attribute1" => $attribute1,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalJenisPeriode', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        $releaseStatus = APIHelper::instance()->apiCall('POST', env('BASEURL_PAYMENT') . '/api/statusPaymentRequest', '');
        $returnStatus = json_decode(strstr($releaseStatus, '{'), true);
        $dataStatus = $returnStatus['data'];

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('report.data_payment_request_proposal_jenis_periode')
            ->with([
                'dataPayment' => $data,
                'dataStatus' => $dataStatus,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'jenis' => $attribute1,
                'tanggal1' => $request->tanggal1,
                'tanggal2' => $request->tanggal2,
            ]);
    }

    public function viewPaymentRequest($id)
    {
        $prID = $id;

        $param = array(
            "pr_id" => $prID,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/viewPaymentRequest', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['dataPR'];
        $dataReceiver = $return['dataReceiver'];
        $dataDetail = $return['dataDetail'];
        $dataPopay = $data[0];

        $pembayaran = ViewPembayaran::where('pr_id', $prID)->first();

        return view('report.update_popay')
            ->with([
                'data' => $dataPopay,
                'dataReceiver' => $dataReceiver,
                'dataDetail' => $dataDetail,
                'dataPembayaran' => $pembayaran,
            ]);
    }

    public function updatePaymentRequest(Request $request)
    {
        if ($request->kategori == "Proposal") {
            $this->validate($request, [
                'provinsi' => 'required',
                'kabupaten' => 'required',
            ]);

            $param = array(
                'pr_id' => $request->paymentID,
                'attribute1' => $request->kategori,
                'attribute2' => "$request->pilar",
                'attribute3' => $request->provinsi,
                'attribute4' => $request->kabupaten,
                'attribute5' => $request->gols,
                'budget_name' => $request->prokerID,
                'budget_status' => $request->prioritas,
            );

        } else {
            $param = array(
                'pr_id' => $request->paymentID,
                'attribute1' => $request->kategori,
                'attribute2' => "$request->pilar",
                'attribute3' => "",
                'attribute4' => "",
                'attribute5' => $request->gols,
                'budget_name' => $request->prokerID,
                'budget_status' => $request->prioritas,
            );
        }

        try {
            APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/UpdatePaymentRequest', $param, '');
            return redirect()->back()->with('berhasil', 'Attribute berhasil diupdate');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Attribute gagal diupdate');
        }

    }

    public function updatePaymentRequestPopayV4(Request $request)
    {
        if ($request->kategori == "Proposal") {
            $this->validate($request, [
                'provinsi' => 'required',
                'kabupaten' => 'required',
            ]);

            $param = array(
                'pr_id' => $request->paymentID,
                'attribute1' => $request->kategori,
                'attribute2' => "$request->pilar",
                'attribute3' => $request->provinsi,
                'attribute4' => $request->kabupaten,
                'attribute5' => $request->gols,
                'budget_name' => $request->prokerID,
                'budget_status' => $request->prioritas,
            );

        } else {
            $param = array(
                'pr_id' => $request->paymentID,
                'attribute1' => $request->kategori,
                'attribute2' => "$request->pilar",
                'attribute3' => "",
                'attribute4' => "",
                'attribute5' => $request->gols,
                'budget_name' => $request->prokerID,
                'budget_status' => $request->prioritas,
            );
        }

        try {
            APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/UpdatePaymentRequestPopayV4', $param, '');
            return redirect()->back()->with('berhasil', 'Attribute berhasil diupdate');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Attribute gagal diupdate');
        }

    }

    public function logApproval($id)
    {
        $paramLog = array(
            "pr_id" => $id,
        );

        $releaseLog = \App\Helper\APIHelper::instance()->httpCallJson('POST', env('BASEURL_PAYMENT') . '/api/logApprovalPopayV3', $paramLog, '');
        $returnLog = json_decode(strstr($releaseLog, '{'), true);
        $dataLog = $returnLog['data'];

        return view('report.log_approval')
            ->with([
                'dataLog' => $dataLog,
                'id' => $id,
            ]);
    }

    public function dataReceiver()
    {
        $param = array(
            "user_id" => "1211",
        );

        $release = APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIPaymentRequest/CreatePaymentRequest', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];
        $sup = $data['dataSupplier'];
        $supplier = $sup['Collection'];

        echo $output = '<option></option>';
        foreach ($supplier as $row) {
            echo $output = '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
        }
    }

    public function dataBank()
    {
        $release = APIHelper::instance()->apiCall('GET', env('BASEURL') . '/api/APIPaymentRequest/form/bank/2312', '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['dataBank'];

        echo $output = '<option></option>';
        foreach ($data as $row) {
            echo $output = '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
        }
    }

    public function dataSiteReceiver($number)
    {
        $param = array(
            "supplierNumber" => $number,
            "orgId" => "100",
        );

        $release = APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIPaymentRequest/GetSupplierSite', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['Collection'];

        echo $output = '<option></option>';
        foreach ($data as $row) {
            echo $output = '<option address="' . $row['siteAddress1'] . ', ' . $row['siteAddress2'] . ', ' . $row['siteAddress3'] . ', ' . $row['siteCity'] . ', ' . $row['siteProvince'] . ', ' . $row['siteState'] . ', ' . $row['siteCountry'] . '" value="' . $row['supplierSiteName'] . '">' . $row['supplierSiteName'] . '</option>';
        }
    }

    public function deletePaymentRequest($id)
    {
        $param = array(
            "pr_id" => $id,
            "user_id" => "1211"
        );

        $dataUpdate = [
            'pr_id' => $id,
            'status' => '',
            'export_by' => '',
            'export_date' => '',
        ];

        try {
            APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIPaymentRequest/DeletePaymentRequest', $param, '');

            DB::table('tbl_pembayaran')
                ->where('pr_id', $id)
                ->update($dataUpdate);

            return redirect()->back()->with('sukses', 'Payment request berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Payment request gagal dihapus');
        }

    }

    public function updateStatus(ApiUpdateStatusRequest $request)
    {
        $dataPR = [
            'pr_id' => $request->pr_id,
        ];

        $pembayaranID = $request->pembayaran_id;

        try {
            DB::table('tbl_pembayaran')
                ->where('id_pembayaran', $pembayaranID)
                ->update($dataPR);

            return ApiResponse::success([
                'pembayaran_id' => (int) $pembayaranID,
                'pr_id' => $request->pr_id,
            ], 'Data berhasil diubah');
        } catch (Exception $e) {
            report($e);

            return ApiResponse::error('Data gagal diubah', 500, 'UPDATE_STATUS_FAILED');
        }
    }

    public function listRealisasiProker()
    {
        $tahun = date("Y");
        $company = session('user')->perusahaan;
        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022') {
            //+++++++++TOTAL REALISASI PROGRESS+++++++++//
            $releaseProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgressPopayV4', $param, '');
            $returnProgress = json_decode(strstr($releaseProgress, '{'), true);
            $dataProgress = $returnProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releasePAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAIDPopayV4', $param, '');
            $returnPAID = json_decode(strstr($releasePAID, '{'), true);
            $dataPAID = $returnPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProkerPopayV4', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        } else {
            //+++++++++TOTAL REALISASI PROGRESS+++++++++//
            $releaseProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgress', $param, '');
            $returnProgress = json_decode(strstr($releaseProgress, '{'), true);
            $dataProgress = $returnProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releasePAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAID', $param, '');
            $returnPAID = json_decode(strstr($releasePAID, '{'), true);
            $dataPAID = $returnPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProker', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        }

        $excludedProkerIds = $this->extractProkerIds((array) $dataProker);
        [$prokerNonRelokasi, $jumlahProkerNonRelokasi] = $this->fetchNonRelokasiProker($tahun, $company, $excludedProkerIds);

        if ($dataProgress['total'] == '') {
            $totalProgress = 0;
        } else {
            $totalProgress = $dataProgress['total'];
        }

        if ($dataPAID['total'] == '') {
            $totalRealisasi = 0;
        } else {
            $totalRealisasi = $dataPAID['total'];
        }

        return view('report.data_realisasi_proker')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'jumlahProker' => $jumlahProker,
                'anggaran' => $anggaran->nominal,
                'realisasi' => $totalRealisasi,
                'progress' => $totalProgress,
                'totalRealisasi' => $totalProgress + $totalRealisasi,
                'dataProker' => $dataProker,
                'jumlahProkerNonRelokasi' => $jumlahProkerNonRelokasi,
                'prokerNonRelokasi' => $prokerNonRelokasi,
            ]);
    }

    public function postRealisasiProkerAnnual(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('listRealisasiProkerAnnual', ['year' => $request->tahun]);
    }

    public function listRealisasiProkerAnnual($year)
    {
        $tahun = $year;
        $company = session('user')->perusahaan;
        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022') {
            //+++++++++TOTAL REALISASI PROGRESS+++++++++//
            $releaseProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgressPopayV4', $param, '');
            $returnProgress = json_decode(strstr($releaseProgress, '{'), true);
            $dataProgress = $returnProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releasePAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAIDPopayV4', $param, '');
            $returnPAID = json_decode(strstr($releasePAID, '{'), true);
            $dataPAID = $returnPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProkerPopayV4', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        } else {
            //+++++++++TOTAL REALISASI PROGRESS+++++++++//
            $releaseProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgress', $param, '');
            $returnProgress = json_decode(strstr($releaseProgress, '{'), true);
            $dataProgress = $returnProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releasePAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAID', $param, '');
            $returnPAID = json_decode(strstr($releasePAID, '{'), true);
            $dataPAID = $returnPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProker', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        }

        $excludedProkerIds = $this->extractProkerIds((array) $dataProker);
        [$prokerNonRelokasi, $jumlahProkerNonRelokasi] = $this->fetchNonRelokasiProker($tahun, $company, $excludedProkerIds);

        if ($dataProgress['total'] == '') {
            $totalProgress = 0;
        } else {
            $totalProgress = $dataProgress['total'];
        }

        if ($dataPAID['total'] == '') {
            $totalRealisasi = 0;
        } else {
            $totalRealisasi = $dataPAID['total'];
        }

        return view('report.data_realisasi_proker')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'jumlahProker' => $jumlahProker,
                'anggaran' => $anggaran->nominal,
                'realisasi' => $totalRealisasi,
                'progress' => $totalProgress,
                'totalRealisasi' => $totalProgress + $totalRealisasi,
                'dataProker' => $dataProker,
                'jumlahProkerNonRelokasi' => $jumlahProkerNonRelokasi,
                'prokerNonRelokasi' => $prokerNonRelokasi,
            ]);
    }

    private function extractProkerIds(array $dataProker)
    {
        $ids = [];
        foreach ($dataProker as $row) {
            if (isset($row['proker_id']) && is_numeric($row['proker_id'])) {
                $ids[] = (int) $row['proker_id'];
            }
        }

        $ids = array_values(array_unique($ids));

        return empty($ids) ? [0] : $ids;
    }

    private function fetchNonRelokasiProker($tahun, $company, array $excludedProkerIds)
    {
        $baseQuery = DB::table('TBL_PROKER')
            ->where('TAHUN', $tahun)
            ->where('PERUSAHAAN', $company)
            ->whereNotIn('ID_PROKER', $excludedProkerIds);

        $prokerNonRelokasi = $baseQuery->get();
        $jumlahProkerNonRelokasi = (clone $baseQuery)->count();

        return [$prokerNonRelokasi, $jumlahProkerNonRelokasi];
    }

    public function dataProvinsi()
    {
        $data = Provinsi::orderBy('provinsi', 'ASC')->get();

        $result = [];
        foreach ($data as $d) {
            $result[] = [
                'provinsi' => $d->provinsi,
            ];
        }
        return response()->json(['code' => "200", 'message' => "Data provinsi berhasil ditampilkan", 'data' => $result]);
    }
}
