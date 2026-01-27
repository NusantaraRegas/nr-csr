<table>
    <thead>
        <tr>
            <th colspan="10" style="font-weight: bold; font-size: 14px; text-align: center;">
                Rekap Penyaluran TJSL - YKPP
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">No</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">No Agenda</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Tanggal Penerimaan</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Penerima Manfaat</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Deskripsi</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Provinsi</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Kabupaten</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Pilar</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">TPB</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Prioritas</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Jumlah</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Fee (5%)</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Subtotal</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Tahun Anggaran</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Penyaluran Ke</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td style="border: 1px solid black; text-align: center">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->no_agenda }}</td>
                <td style="border: 1px solid black; text-align: left">
                    {{ \Carbon\Carbon::parse($item->tgl_terima)->format('d-m-Y') }}
                </td>
                <td style="border: 1px solid black; text-align: left">{{ strtoupper($item->nama_lembaga) }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->deskripsi }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->provinsi }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->kabupaten }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->pilar }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->kode_tpb . '. ' . $item->gols }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->prioritas }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->jumlah_pembayaran }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->fee }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->subtotal }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->tahun_ykpp }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->penyaluran_ke }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->status_ykpp }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
