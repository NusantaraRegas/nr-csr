<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApiPaymentRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pembayaranID' => 'required',
            'noInvoice' => 'required',
            'invoiceDate' => 'required|date',
            'invoiceDueDate' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'noInvoice.required' => 'Nomor invoice harus diisi',
            'invoiceDate.required' => 'Tanggal invoice harus diisi',
            'invoiceDate.date' => 'Format tanggal invoice tidak valid',
            'invoiceDueDate.required' => 'Due date harus diisi',
            'invoiceDueDate.date' => 'Format due date tidak valid',
        ];
    }
}
