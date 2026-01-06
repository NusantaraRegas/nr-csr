<table>
    <thead>
    <tr>
        <th>Tanggal</th>
        <th>Program Kerja</th>
        <th>Pilar</th>
        <th>Goals</th>
        <th>Prioritas</th>
        <th>Penerima Bantuan</th>
        <th>Deskripsi Bantuan</th>
        <th>Provinsi</th>
        <th>Kabupaten</th>
        <th>Jumlah (Rp)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dataRealisasi as $data)
        <tr>
            <td>{{ date('d-m-Y', strtotime($data->tgl_realisasi)) }}</td>
            <td>{{ $data->proker }}</td>
            <td>{{ $data->pilar }}</td>
            <td>{{ $data->gols }}</td>
            <td>{{ $data->prioritas }}</td>
            <td>{{ $data->nama_yayasan }}</td>
            <td>{{ $data->deskripsi }}</td>
            <td>{{ $data->provinsi }}</td>
            <td>{{ $data->kabupaten }}</td>
            <td>{{ $data->nilai_bantuan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
