<div class="form-row">
    <div class="form-group col-md-6">
        <label>Lembar Disposisi <span class="text-danger">*</span></label>
        <input type="file" class="form-control" name="disposisi" accept="application/pdf" required>
        @error('disposisi')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label>Surat Pengantar dan Proposal <span class="text-danger">*</span></label>
        <input type="file" class="form-control" name="lampiran" accept="application/pdf" required>
        @error('lampiran')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
