<div class="form-row">
    <div class="form-group col-md-4">
        <label>No Agenda <span class="text-danger">*</span></label>
        <input type="text" name="noAgenda" class="form-control text-uppercase" value="{{ old('noAgenda') }}" required>
        @error('noAgenda')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label>Tanggal Penerimaan <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="text" name="tglPenerimaan" class="form-control tgl-terima"
                value="{{ old('tglPenerimaan') }}" required>
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
            <option value="" disabled selected>-- Pilih Pengirim --</option>
            @foreach ($dataPengirim as $pengirim)
                <option value="{{ $pengirim->id_pengirim }}"
                    {{ old('pengirim') == $pengirim->id_pengirim ? 'selected' : '' }}>
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
        <input type="text" name="noSurat" class="form-control text-uppercase" value="{{ old('noSurat') }}" required>
        @error('noSurat')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label>Tanggal Surat <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="text" name="tglSurat" class="form-control tgl-surat" value="{{ old('tglSurat') }}"
                required>
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
        <select name="sifat" class="form-control" required>
            <option value="" disabled selected>-- Sifat Surat --</option>
            <option value="Biasa" {{ old('sifat') == 'Biasa' ? 'selected' : '' }}>Biasa
            </option>
            <option value="Segera" {{ old('sifat') == 'Segera' ? 'selected' : '' }}>Segera
            </option>
            <option value="Amat Segera" {{ old('sifat') == 'Amat Segera' ? 'selected' : '' }}>
                Amat Segera</option>
        </select>
        @error('sifat')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label>Jenis Proposal <span class="text-danger">*</span></label>
        <select name="jenis" class="form-control" required>
            <option value="" disabled selected>-- Pilih Jenis --</option>
            <option value="Bulanan" {{ old('jenis') == 'Bulanan' ? 'selected' : '' }}>Bulanan
            </option>
            <option value="Santunan" {{ old('jenis') == 'Santunan' ? 'selected' : '' }}>
                Santunan
            </option>
            <option value="Idul Adha" {{ old('jenis') == 'Idul Adha' ? 'selected' : '' }}>
                Idul Adha</option>
            <option value="Natal" {{ old('jenis') == 'Natal' ? 'selected' : '' }}>
                Natal</option>
            <option value="Aspirasi" {{ old('jenis') == 'Aspirasi' ? 'selected' : '' }}>
                Aspirasi</option>
        </select>
        @error('jenis')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-8">
        <label>Perihal <span class="text-danger">*</span></label>
        <input type="text" name="digunakanUntuk" class="form-control" maxlength="200"
            value="{{ old('digunakanUntuk') }}" required>
        @error('digunakanUntuk')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

{{-- <div class="form-row">
    <div class="form-group col-md-4">
        <label>Pilar <span class="text-danger">*</span></label>
        <select name="pilar" id="pilar" class="form-control" required>
            <option value="" disabled selected>-- Pilih Pilar --</option>
            @foreach ($dataPilar as $pilar)
                <option value="{{ $pilar->nama }}" {{ old('pilar') == $pilar->nama ? 'selected' : '' }}>
                    {{ $pilar->nama }}
                </option>
            @endforeach
        </select>
        @error('pilar')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-8">
        <label>TPB <span class="text-danger">*</span></label>
        <select id="tpb" name="tpb" class="form-control" required>
            <option disabled selected>-- Pilih TPB --</option>
        </select>
        @error('tpb')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div> --}}
