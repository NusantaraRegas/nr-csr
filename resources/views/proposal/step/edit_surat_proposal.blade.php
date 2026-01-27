<div class="form-row">
    <div class="form-group col-md-4">
        <label>No Agenda <span class="text-danger">*</span></label>
        <input type="text" name="noAgenda" class="form-control text-uppercase" value="{{ $data->no_agenda }}" required>
        @error('noAgenda')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label>Tanggal Penerimaan <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="text" name="tglPenerimaan" class="form-control tgl-terima"
                value="{{ date('d-M-Y', strtotime($data->tgl_terima)) }}" required>
            <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
            </div>
        </div>
        @error('tglPenerimaan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label>Pengirim <span class="text-danger">*</span></label>
        <select name="pengirim" class="form-control pilihPengirim" required>
            <option disabled selected>-- Pilih Pengirim --</option>
            @foreach ($dataPengirim as $pengirim)
                <option value="{{ $pengirim->id_pengirim }}"
                    {{ old('pengirim', $data->id_pengirim) == $pengirim->id_pengirim ? 'selected' : '' }}>
                    {{ $pengirim->pengirim }}
                </option>
            @endforeach
        </select>
        @error('pengirim')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label>Nomor Surat <span class="text-danger">*</span></label>
        <input type="text" name="noSurat" class="form-control text-uppercase" value="{{ $data->no_surat }}" required>
        @error('noSurat')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label>Tanggal Surat <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="text" name="tglSurat" class="form-control tgl-surat"
                value="{{ date('d-M-Y', strtotime($data->tgl_surat)) }}" required>
            <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-calendar text-info"></i></span>
            </div>
        </div>
        @error('tglSurat')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label>Sifat <span class="text-danger">*</span></label>
        @php
            $selectedSifat = old('sifat', $data->sifat ?? '');
        @endphp
        <select name="sifat" class="form-control" required>
            <option disabled {{ $selectedSifat ? '' : 'selected' }}>-- Sifat Surat --</option>
            @foreach (['Biasa', 'Segera', 'Amat Segera'] as $sifat)
                <option value="{{ $sifat }}" {{ $selectedSifat == $sifat ? 'selected' : '' }}>
                    {{ $sifat }}
                </option>
            @endforeach
        </select>
        @error('sifat')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label>Jenis Proposal <span class="text-danger">*</span></label>
        @php
            $selectedJenis = old('jenis', $data->jenis ?? '');
        @endphp
        <select name="jenis" class="form-control" required>
            <option value="" disabled {{ $selectedJenis ? '' : 'selected' }}>-- Pilih Jenis --</option>
            @foreach (['Bulanan', 'Santunan', 'Idul Adha', 'Natal', 'Aspirasi'] as $jenis)
                <option value="{{ $jenis }}" {{ $selectedJenis == $jenis ? 'selected' : '' }}>
                    {{ $jenis }}
                </option>
            @endforeach
        </select>
        @error('jenis')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-8">
        <label>Perihal <span class="text-danger">*</span></label>
        <input type="text" name="digunakanUntuk" class="form-control" maxlength="200"
            value="{{ $data->bantuan_untuk }}" required>
        @error('digunakanUntuk')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
