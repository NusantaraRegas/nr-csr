<div class="form-group">
    <label>Yayasan/Lembaga <span class="text-danger">*</span></label>
    <select class="pilihLembaga form-control" name="dari" id="dari" required>
        <option value="" disabled {{ old('dari') ? '' : 'selected' }}>-- Pilih Lembaga --</option>
        @foreach ($dataLembaga as $lembaga)
            <option value="{{ $lembaga->id_lembaga }}" alamat="{{ $lembaga->alamat }}"
                {{ old('dari') == $lembaga->id_lembaga ? 'selected' : '' }}>
                {{ strtoupper($lembaga->nama_lembaga) }}
            </option>
        @endforeach
    </select>
    @error('dari')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<div class="form-group">
    <label>Alamat <span class="text-danger">*</span></label>
    <textarea name="alamat" id="alamat" class="form-control bg-white" rows="3" readonly required>{{ old('alamat') }}</textarea>
    @error('alamat')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label>Besar Permohonan <span class="text-danger">*</span></label>
        <input type="text" onkeypress="return hanyaAngka(event)" class="form-control" autocomplete="off"
            name="besarPermohonan" id="besarPermohonan" placeholder="Contoh: Rp. 1.000.000"
            value="{{ old('besarPermohonan') }}" required>
        <input type="hidden" name="besarPermohonanAsli" id="besarPermohonanAsli"
            value="{{ old('besarPermohonanAsli') }}">
        @error('besarPermohonan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label>Kategori <span class="text-danger">*</span></label>
        <select class="form-control" name="perihal" required>
            <option>{{ old('perihal') }}</option>
            <option>Permohonan Bantuan Dana</option>
            <option>Permohonan Bantuan Barang</option>
        </select>
        @error('perihal')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label>Provinsi <small class="text-muted">(Lokasi Program Bantuan)</small> <span
                class="text-danger">*</span></label>
        <select class="pilihProvinsi form-control" name="provinsi" id="provinsi" required>
            <option value="" disabled {{ old('provinsi') ? '' : 'selected' }}>-- Pilih Provinsi --</option>
            @foreach ($dataProvinsi as $provinsi)
                <option value="{{ ucwords($provinsi->provinsi) }}"
                    {{ old('provinsi') == ucwords($provinsi->provinsi) ? 'selected' : '' }}>
                    {{ ucwords($provinsi->provinsi) }}
                </option>
            @endforeach
        </select>
        @error('provinsi')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label>Kabupaten/Kota <span class="text-danger">*</span></label>
        <select id="kabupaten" name="kabupaten" class="form-control pilihKabupaten" required>
            <option disabled selected>-- Pilih Kabupaten --</option>
        </select>
        @error('kabupaten')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label>Kecamatan <span class="text-danger">*</span></label>
        <select id="kecamatan" name="kecamatan" class="form-control pilihKecamatan" required>
            <option disabled selected>-- Pilih Kecamatan --</option>
        </select>
        @error('kecamatan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label>Kelurahan <span class="text-danger">*</span></label>
        <select id="kelurahan" name="kelurahan" class="form-control pilihKelurahan" required>
            <option disabled selected>-- Pilih Kelurahan --</option>
        </select>
        @error('kelurahan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
<div class="form-group">
    <label>Deskripsi Bantuan <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="deskripsiBantuan" value="{{ old('deskripsiBantuan') }}" required>
    @error('deskripsi')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
