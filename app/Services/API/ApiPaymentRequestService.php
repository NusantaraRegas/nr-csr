<?php

namespace App\Services\API;

use App\Helper\APIHelper;
use App\Http\Requests\StoreApiPaymentRequestRequest;
use App\Models\ViewPembayaran;
use Exception;
use Illuminate\Support\Facades\DB;

class ApiPaymentRequestService
{
    public function storePaymentRequest(StoreApiPaymentRequestRequest $request)
    {
        try {
            $pembayaranID = decrypt($request->pembayaranID);
        } catch (Exception $e) {
            abort(404);
        }

        $pembayaran = ViewPembayaran::findOrFail($pembayaranID);

        if (empty($pembayaran)) {
            return redirect()->back()->with('gagalDetail', 'Data pembayaran tidak ditemukan')->withInput();
        }

        $username = session('user')->username;
        $paramUser = [
            'username' => $username,
        ];

        $callUser = APIHelper::instance()->httpCallJson('POST', env('BASEURLPOPAYSAP') . '/api/APISAPTravelManagement/CheckUser', $paramUser, '');
        $resultUser = json_decode(strstr($callUser, '{'), true);
        $status = $resultUser['status'];

        if ($status != 'S') {
            return redirect()->back()->with('peringatan', 'Anda tidak terdaftar sebagai maker Popay');
        }

        $roleID = $resultUser['data']['role_id'];
        $userID = $resultUser['data']['id'];
        $userName = $resultUser['data']['username'];
        $divID = $resultUser['data']['div_id'];
        $orgID = $resultUser['data']['org_id'];

        if (strcasecmp($roleID, 'Maker') !== 0) {
            return redirect()->back()->with('gagalDetail', 'Anda tidak terdaftar sebagai maker Popay');
        }

        $dateTime = date('Y-m-d H:i:s');
        $deskripsi = 'POPAY/' . strtoupper($request->noInvoice);

        $param = [
            'user_id' => $userID,
            'user_name' => $userName,
            'org_id' => $orgID,
            'div_id' => $divID,
            'category' => 'INVOICE MIRO',
            'payment_type' => 'CSR 517/518',
            'budget_year' => $pembayaran->tahun,
            'budget_name' => "RKAP $pembayaran->tahun",
            'description_bank' => strtoupper(substr($deskripsi, 0, 30)),
            'description_detail' => strtoupper(strtoupper($pembayaran->deskripsi_pembayaran)),
            'invoice_num' => strtoupper($request->noInvoice),
            'invoice_date' => date('Y-m-d', strtotime($request->invoiceDate)),
            'invoice_due_date' => date('Y-m-d', strtotime($request->invoiceDueDate)),
            'invoice_curr' => 'IDR',
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
            'attribute4' => null,
        ];

        try {
            $store = APIHelper::instance()->httpCallJson('POST', env('BASEURLPOPAYSAP') . '/api/APIPaymentRequest/StorePaymentRequestWithAttribute', $param, '');
            $return = json_decode(strstr($store, '{'), true);
            $statusRequest = $return['status'];
            $pesanRequest = $return['message'];

            if ($statusRequest == 'S') {
                $prID = $return['data']['pr_id'];

                $dataUpdate = [
                    'pr_id' => $prID,
                    'status' => 'Exported',
                    'export_by' => session('user')->username,
                    'export_date' => $dateTime,
                ];

                DB::table('tbl_pembayaran')->where('id_pembayaran', $pembayaranID)->update($dataUpdate);

                return redirect()->back()->with('sukses', $pesanRequest);
            }

            return redirect()->back()->with('gagal', $pesanRequest);
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Pembayaran gagal diexport ke popay');
        }
    }
}
