<table>
    <thead>
        <tr>
            <th colspan="8" style="font-weight: bold; font-size: 14px; text-align: center;">
                Rekap Realisasi Prioritas - {{ $tahun ?? '' }}
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black; text-align: center;">No</th>
            <th style="border: 1px solid black;">Prioritas</th>
            <th style="border: 1px solid black; text-align: right;">Anggaran</th>
            <th style="border: 1px solid black; text-align: right;">Realisasi</th>
            <th style="border: 1px solid black; text-align: right;">Selisih</th>
            <th style="border: 1px solid black; text-align: right;">Persentase</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataPrioritas as $item)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $item['prioritas'] }}</td>
                <td style="border: 1px solid black; text-align: right;">
                    {{ $item['anggaran'] }}
                </td>
                <td style="border: 1px solid black; text-align: right;">
                    {{ $item['realisasi'] }}
                </td>
                <td style="border: 1px solid black; text-align: right;">
                    {{ $item['selisih'] }}
                </td>
                <td style="border: 1px solid black; text-align: right;">
                    {{ $item['persentase'] . '%' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
