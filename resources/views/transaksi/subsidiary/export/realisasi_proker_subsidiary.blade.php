<table>
    <thead>
    <tr>
        <th style="text-align: center">Proker ID</th>
        <th>Program Kerja</th>
        <th>Prioritas</th>
        <th>Pilar</th>
        <th>Goals</th>
        <th style="text-align: center">Anggaran</th>
        <th style="text-align: center">Realisasi</th>
        <th style="text-align: center">Sisa</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dataProker as $data)
        <?php
        $totalRealisasi = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('perusahaan', $comp)
            ->where('tahun', $tahun)
            ->where('id_proker', $data->id_proker)
            ->first();

        $sisa = $data->anggaran - $totalRealisasi->total;
        ?>
        <tr>
            <td style="text-align: center">{{ $data->id_proker }}</td>
            <td nowrap>{{ $data->proker }}</td>
            <td>{{ $data->prioritas }}</td>
            <td nowrap>{{ $data->pilar }}</td>
            <td nowrap>{{ $data->gols }}</td>
            <td style="text-align: right">
                {{ $data->anggaran }}
            </td>
            <td style="text-align: right">
                {{ $totalRealisasi->total }}
            </td>
            <td style="text-align: right">
                @if($sisa >= 0)
                    {{ $sisa }}
                @else
                    {{ $sisa }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
