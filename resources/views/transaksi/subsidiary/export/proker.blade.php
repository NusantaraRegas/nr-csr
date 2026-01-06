<table>
    <thead>
    <tr>
        <th style="text-align: center">Proker ID</th>
        <th>Program Kerja</th>
        <th>Pilar</th>
        <th>Goals</th>
        <th style="text-align: center">Anggaran</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dataProker as $data)
        <tr>
            <td style="text-align: center">{{ $data->id_proker }}</td>
            <td nowrap>{{ $data->proker }}</td>
            <td nowrap>{{ $data->pilar }}</td>
            <td nowrap>{{ $data->gols }}</td>
            <td style="text-align: right">
                {{ $data->anggaran }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
