<table>
    <thead>
        <tr>
            <th colspan="8" style="font-weight: bold; font-size: 14px; text-align: center;">
                Rekap Realisasi Program Kerja - {{ $tahun ?? '' }}
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black; text-align: center;">ID Proker</th>
            <th style="border: 1px solid black;">Proker</th>
            <th style="border: 1px solid black;">Pilar</th>
            <th style="border: 1px solid black;">TPB</th>
            <th style="border: 1px solid black;">Prioritas</th>
            <th style="border: 1px solid black; text-align: right;">Anggaran</th>
            <th style="border: 1px solid black; text-align: right;">Realisasi</th>
            <th style="border: 1px solid black; text-align: right;">Sisa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            @continue(!is_object($item)) {{-- Skip jika bukan object --}}
            @php
                $realisasi = $realisasiData[$item->id_proker] ?? 0;
                $sisaAnggaran = $item->anggaran - $realisasi;
            @endphp
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $item->id_proker }}</td>
                <td style="border: 1px solid black;">{{ $item->proker }}</td>
                <td style="border: 1px solid black;">{{ $item->pilar }}</td>
                <td style="border: 1px solid black;">{{ $item->kode_tpb . '. ' . $item->gols }}</td>
                <td style="border: 1px solid black;">
                    @if (empty($item->prioritas))
                        Sosial/Ekonomi
                    @else
                        {{ $item->prioritas }}
                    @endif
                </td>
                <td style="border: 1px solid black; text-align: right;">
                    {{ $item->anggaran }}
                </td>
                <td style="border: 1px solid black; text-align: right;">{{ $realisasi }}
                </td>
                <td style="border: 1px solid black; text-align: right;">{{ $sisaAnggaran }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
