<table>
    <thead>
    <tr>
        <th>Tanggal</th>
        <th>PR ID</th>
        <th nowrap>Proker ID</th>
        <th>Status</th>
        <th>Type Pembayaran</th>
        <th>Kategori</th>
        <th nowrap>No Invoice</th>
        <th nowrap>Tanggal Invoice</th>
        <th>Deskripsi</th>
        <th>Pilar</th>
        <th>Goals</th>
        <th>Prioritas</th>
        <th>Provinsi</th>
        <th>Kabupaten</th>
        <th>Jumlah</th>
        <th>Pengurangan</th>
        <th>Total</th>
        <th>Penerima</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dataPayment as $data)
        <tr>
            <td>{{ date('d-m-Y H:i:s', strtotime($data['created_at'])) }}</td>
            <td>{{ $data['id'] }}</td>
            <td>{{ $data['budget_name'] }}</td>
            <td>{{ $data['status'] }}</td>
            <td>{{ $data['payment_type'] }}</td>
            <td>
                @if($data['attribute1'] == 'Proposal')
                    Realisasi Proposal
                @else
                    {{ $data['attribute1'] }}
                @endif
            </td>
            <td>{{ $data['invoice_num'] }}</td>
            <td>{{ date('d-m-Y', strtotime($data['invoice_date'])) }}</td>
            <td>{{ $data['description_detail'] }}</td>
            <td>{{ $data['attribute2'] }}</td>
            <td>{{ $data['attribute5'] }}</td>
            <td>{{ $data['budget_status'] }}</td>
            <td>{{ $data['attribute3'] }}</td>
            <td>{{ $data['attribute4'] }}</td>
            <td>{{ $data['invoice_amount'] }}</td>
            <td>{{ $data['invoice_refund'] }}</td>
            <td>{{ $data['invoice_amount_paid'] }}</td>
            <td>{{ $data['supplier_name'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
