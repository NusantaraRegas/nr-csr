<div class="ribbon-wrapper card" style="font-family: Tahoma">
    <div class="ribbon ribbon-default">{{ $relokasi->sektor_bantuan }}</div>
    <small class="text-right"
           style="margin-top: -30px">{{ $relokasi->tahun }}</small>
    <h4 class="ribbon-content"
        style="margin-top: 15px;">
        <small style="font-size: 14px;color: red; font-family: Tahoma">Nominal</small><br>
        IDR {{ number_format($relokasi->nominal_relokasi,0,',','.') }}
    </h4>
    <h4 class="ribbon-content">
        <small style="font-size: 14px;color: red; font-family: Tahoma">Alokasi</small><br>
        IDR {{ number_format($relokasi->nominal_relokasi,0,',','.') }}
    </h4>
    <h4 class="ribbon-content">
        <small style="font-size: 14px;color: red; font-family: Tahoma">Sisa</small><br>
        IDR {{ number_format($relokasi->nominal_relokasi,0,',','.') }}
    </h4>
    <div class="text-right m-t-10">
        <button class="btn btn-info btn-sm" type="button" data-toggle="collapse"
                data-target="#collapseExample{{ $relokasi->id_relokasi }}" aria-expanded="false"
                aria-controls="collapseExample{{ $relokasi->id_relokasi }}">View Alokasi Program
            Kerja
        </button>
        <button type="button" data-toggle="modal" data-target=".modal-alokasi"
                class="btn btn-primary btn-sm tambah"
                data-id="{{ encrypt($relokasi->id_relokasi) }}"
                data-sektor="{{ encrypt($relokasi->sektor_bantuan) }}"
                data-tahun="{{ $relokasi->tahun }}">Tambah Program
            Kerja
        </button>
    </div>
    <div class="collapse" id="collapseExample{{ $relokasi->id_relokasi }}">
        <br>
        @if($jumAlokasi->jumlah > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>PROGRAM KERJA</th>
                    <th>PROVINSI</th>
                    <th>NOMINAL</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $dataAlokasi = DB::table('tbl_alokasi')
                    ->select('tbl_alokasi.*')
                    ->where([
                        ['id_relokasi', $relokasi->id_relokasi],
                    ])
                    ->orderBy('proker', 'ASC')
                    ->get();
                ?>
                @foreach($dataAlokasi as $alokasi)
                <tr>
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    <td>{{ $alokasi->proker }}</td>
                    <td>{{ $alokasi->provinsi }}</td>
                    <td>
                        IDR {{ number_format($alokasi->nominal_alokasi,0,',','.') }}</td>
                    <td>
                        <a href="#!" class="edit-proker"
                           data-id="{{ encrypt($alokasi->id_alokasi) }}"
                           data-proker="{{ $alokasi->proker }}"
                           data-sektor="{{ $alokasi->sektor_bantuan }}"
                           data-tahun="{{ $alokasi->tahun }}"
                           data-target=".modal-edit" data-toggle="modal">
                            <i class="fa fa-pencil" style="font-size: 18px"></i>
                        </a>
                        <a href="#!" class="delete text-danger"
                           data-id="{{ encrypt($alokasi->id_alokasi) }}">
                            <i class="fa fa-trash" style="font-size: 18px"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-warning">
            Belum ada alokasi untuk sektor {{ $relokasi->sektor_bantuan }}
        </div>
        @endif
    </div>
</div>