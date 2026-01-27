<table>
    <thead>
        <tr>
            <th colspan="10" style="font-weight: bold; font-size: 14px; text-align: center;">
                Rekap Kelayakan Proposal
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">No</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">No Agenda</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Tanggal Penerimaan</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Pengirim</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Penerima Manfaat</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Deskripsi</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Provinsi</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Kabupaten</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Jenis</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Status</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Dibuat Oleh</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle">Tanggal Input</th>
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
                <td style="border: 1px solid black; text-align: left">{{ strtoupper($item->pengirim) }}</td>
                <td style="border: 1px solid black; text-align: left">{{ strtoupper($item->nama_lembaga) }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->deskripsi }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->provinsi }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->kabupaten }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->jenis }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->status }}</td>
                <td style="border: 1px solid black; text-align: left">{{ $item->nama_maker }}</td>
                <td style="border: 1px solid black; text-align: left">
                    {{ \Carbon\Carbon::parse($item->created_date)->format('d-m-Y H:i:s') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
