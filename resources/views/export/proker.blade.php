<table>
    <thead>
        <tr>
            <th colspan="8" style="font-weight: bold; font-size: 14px; text-align: center;">
                Program Kerja {{ $perusahaan }} - {{ $tahun ?? '' }}
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black; text-align: center;">ID Proker</th>
            <th style="border: 1px solid black;">Proker</th>
            <th style="border: 1px solid black;">Pilar</th>
            <th style="border: 1px solid black;">TPB</th>
            <th style="border: 1px solid black;">Prioritas</th>
            <th style="border: 1px solid black; text-align: right;">Anggaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataProker as $item)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $item->id_proker }}</td>
                <td style="border: 1px solid black;">{{ $item->proker }}</td>
                <td style="border: 1px solid black;">{{ $item->pilar }}</td>
                <td style="border: 1px solid black;">{{ $item->kode_tpb . '. ' . $item->gols }}</td>
                <td style="border: 1px solid black;">
                    {{ $item->prioritas }}
                </td>
                <td style="border: 1px solid black; text-align: right;">
                    {{ $item->anggaran }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
