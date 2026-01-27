<div class="form-group">
    <label>Yayasan/Lembaga <span class="text-danger">*</span></label>
    <select class="form-control pilihLembaga" name="dari" id="dari" required>
        <option value="" disabled {{ old('dari', $data->id_lembaga ?? '') == '' ? 'selected' : '' }}>
            -- Pilih Lembaga --
        </option>
        @foreach ($dataLembaga as $lembaga)
            <option value="{{ $lembaga->id_lembaga }}" alamat="{{ $lembaga->alamat }}"
                {{ old('dari', $data->id_lembaga ?? '') == $lembaga->id_lembaga ? 'selected' : '' }}>
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
    <textarea name="alamat" id="alamat" class="form-control bg-white" rows="3" readonly required>{{ old('alamat', $data->alamat ?? '') }}</textarea>
    @error('alamat')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label>Besar Permohonan <span class="text-danger">*</span></label>
        <input type="text" class="form-control" autocomplete="off" name="besarPermohonan" id="besarPermohonan"
            placeholder="Contoh: Rp. 1.000.000"
            value="{{ old('besarPermohonan', 'Rp. ' . number_format($data->nilai_pengajuan ?? '', 0, ',', '.')) }}"
            required>
        <input type="hidden" name="besarPermohonanAsli" id="besarPermohonanAsli"
            value="{{ old('besarPermohonanAsli', $data->nilai_pengajuan ?? '') }}">
        @error('besarPermohonan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label>Kategori <span class="text-danger">*</span></label>
        <select class="form-control" name="perihal" required>
            <option value="" disabled {{ old('perihal', $data->perihal ?? '') == '' ? 'selected' : '' }}>
                -- Pilih Kategori --
            </option>
            @foreach (['Permohonan Bantuan Dana', 'Permohonan Bantuan Barang'] as $kategori)
                <option value="{{ $kategori }}"
                    {{ old('perihal', $data->perihal ?? '') == $kategori ? 'selected' : '' }}>
                    {{ $kategori }}
                </option>
            @endforeach
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
        <select class="form-control pilihProvinsi" name="provinsi" id="provinsi" required>
            <option value="" disabled {{ old('provinsi', $data->provinsi ?? '') == '' ? 'selected' : '' }}>
                -- Pilih Provinsi --
            </option>
            @foreach ($dataProvinsi as $prov)
                <option value="{{ ucwords($prov->provinsi) }}"
                    {{ old('provinsi', $data->provinsi ?? '') == ucwords($prov->provinsi) ? 'selected' : '' }}>
                    {{ ucwords($prov->provinsi) }}
                </option>
            @endforeach
        </select>
        @error('provinsi')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label>Kabupaten/Kota <span class="text-danger">*</span></label>
        <select class="form-control pilihKabupaten bg-white" name="kabupaten" id="kabupaten" required>
            @if (old('kabupaten', $data->kabupaten ?? false))
                <option value="{{ old('kabupaten', $data->kabupaten) }}" selected>
                    {{ old('kabupaten', $data->kabupaten) }}
                </option>
            @else
                <option value="" disabled selected>-- Pilih Kabupaten/Kota --</option>
            @endif
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
            @if (old('kecamatan', $data->kecamatan ?? false))
                <option value="{{ old('kecamatan', $data->kecamatan) }}" selected>
                    {{ old('kecamatan', $data->kecamatan) }}</option>
            @endif
        </select>
        @error('kecamatan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label>Kelurahan/Desa <span class="text-danger">*</span></label>
        <select id="kelurahan" name="kelurahan" class="form-control pilihKelurahan" required>
            <option disabled selected>-- Pilih Kelurahan --</option>
            @if (old('kelurahan', $data->kelurahan ?? false))
                <option value="{{ old('kelurahan', $data->kelurahan) }}" selected>
                    {{ old('kelurahan', $data->kelurahan) }}</option>
            @endif
        </select>
        @error('kelurahan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
<div class="form-group">
    <label>Deskripsi Bantuan <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="deskripsiBantuan"
        value="{{ old('deskripsiBantuan', $data->deskripsi ?? '') }}" required>
    @error('deskripsiBantuan')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
