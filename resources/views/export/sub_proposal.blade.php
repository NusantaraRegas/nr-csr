<table>
    <thead>
    <tr>
        <th>Nomor</th>
        <th>Nama Ketua</th>
        <th>Nama Lembaga</th>
        <th>Provinsi</th>
        <th>Kabupaten</th>
        <th>Kambing</th>
        <th>Sapi</th>
        <th>Total</th>
        <th>Fee</th>
        <th>Sub Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dataProposal as $data)
        <tr>
            <td>{{ $data->no_sub_agenda }}</td>
            <td>{{ $data->nama_ketua }}</td>
            <td>{{ $data->nama_lembaga }}</td>
            <td>{{ $data->provinsi }}</td>
            <td>{{ $data->kabupaten }}</td>
            <td>{{ $data->kambing }}</td>
            <td>{{ $data->sapi }}</td>
            <td>{{ number_format($data->total,2,',','.') }}</td>
            <td>{{ number_format($data->fee,2,',','.') }}</td>
            <td>{{ number_format($data->subtotal,2,',','.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
