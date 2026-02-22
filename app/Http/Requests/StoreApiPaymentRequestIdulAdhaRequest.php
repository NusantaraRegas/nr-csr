<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApiPaymentRequestIdulAdhaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ID' => 'required',
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
        ];
    }
}
