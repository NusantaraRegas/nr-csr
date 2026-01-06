<table>
    <thead>
    <tr>
        <th>PR ID</th>
        <th>Status</th>
        <th>Payment Type</th>
        <th>Invoice Number</th>
        <th>Description</th>
        <th>Billing Amount</th>
        <th>Total Amount</th>
        <th>Receiver Information</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dataPayment as $data)
    <tr>
        <td>{{ $data['id'] }}</td>
        <td>{{ $data['status'] }}</td>
        <td>{{ $data['payment_type'] }}</td>
        <td>{{ $data['invoice_num'] }}</td>
        <td>{{ $data['description_detail'] }}</td>
        <td>Rp. {{ number_format($data['invoice_amount'],2,',','.') }}</td>
        <td>Rp. {{ number_format($data['invoice_amount_paid'],2,',','.') }}</td>
        <td>{{ $data['supplier_name'] }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
