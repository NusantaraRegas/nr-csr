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
        $proker = \App\Models\Proker::where('id_proker', $data['proker_id'])->first();
        $sisa = $proker->anggaran - ($data['progress'] + $data['paid']);
        ?>
        <tr>
            <td style="text-align: center">{{ $data['proker_id'] }}</td>
            <td nowrap>{{ $proker->proker }}</td>
            <td>{{ $proker->prioritas }}</td>
            <td nowrap>{{ $proker->pilar }}</td>
            <td nowrap>{{ $proker->gols }}</td>
            <td style="text-align: right">
                {{ $proker->anggaran }}
            </td>
            <td style="text-align: right">
                {{ $data['paid'] + $data['progress'] }}
            </td>
            <td style="text-align: right">
                @if($sisa >= 0)
                    <b>{{ $sisa }}</b>
                @else
                    <b style="color: red">{{ $sisa }}</b>
                @endif
            </td>
        </tr>
    @endforeach
    @foreach($prokerNonRelokasi as $dp)
        <tr>
            <td style="text-align: center">{{ $dp->id_proker }}</td>
            <td nowrap>{{ $dp->proker }}</td>
            <td>{{ $dp->prioritas }}</td>
            <td nowrap>{{ $dp->pilar }}</td>
            <td nowrap>{{ $dp->gols }}</td>
            <td style="text-align: right">
                {{ $dp->anggaran }}
            </td>
            <td style="text-align: right">
                0
            </td>
            <td style="text-align: right">
                <b>{{ $dp->anggaran }}</b>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
