<div>
    <div wire:loading>
        Memuat data...
    </div>

    <div class="form-group mb-3">
        <label for="provinsi">Provinsi</label>
        <select wire:model="selectedProvince" class="form-control" id="provinsi">
            <option value="">-- Pilih Provinsi --</option>
            @foreach($provinces as $province)
                <option value="{{ $province->code }}">{{ $province->name }}</option>
            @endforeach
        </select>
    </div>

    @if($selectedProvince)
        <div class="form-group mb-3">
            <label for="kabupaten">Kabupaten/Kota</label>
            <select wire:model="selectedCity" class="form-control" id="kabupaten">
                <option value="">-- Pilih Kabupaten/Kota --</option>
                @foreach($cities as $city)
                    <option value="{{ $city->code }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    @if($selectedCity)
        <div class="form-group mb-3">
            <label for="kecamatan">Kecamatan</label>
            <select wire:model="selectedDistrict" class="form-control" id="kecamatan">
                <option value="">-- Pilih Kecamatan --</option>
                @foreach($districts as $district)
                    <option value="{{ $district->code }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    @if($selectedDistrict)
        <div class="form-group mb-3">
            <label for="desa">Desa/Kelurahan</label>
            <select wire:model="selectedVillage" class="form-control" id="desa">
                <option value="">-- Pilih Desa/Kelurahan --</option>
                @foreach($villages as $village)
                    <option value="{{ $village->code }}">{{ $village->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
    
</div>