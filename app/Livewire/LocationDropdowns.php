<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class LocationDropdown extends Component
{
    // Properti untuk menampung daftar pilihan
    public $provinces;
    public $cities = [];
    public $districts = [];
    public $villages = [];

    // Properti untuk menampung nilai yang TERPILIH
    public $selectedProvince = null;
    public $selectedCity = null;
    public $selectedDistrict = null;
    public $selectedVillage = null;

    /**
     * Method ini akan dipanggil saat komponen pertama kali di-load.
     */
    public function mount()
    {
        // Isi dropdown provinsi saat halaman pertama kali dimuat
        $this->provinces = Province::orderBy('name', 'asc')->get();
        
    }

    /**
     * Method ini akan otomatis dipanggil setiap kali 
     * properti $selectedProvince berubah (dihubungkan dengan wire:model).
     */
    public function updatedSelectedProvince($provinceCode)
    {
        if ($provinceCode) {
            // Ambil daftar kabupaten berdasarkan provinsi yang dipilih
            $this->cities = City::where('province_code', $provinceCode)->orderBy('name', 'asc')->get()->toArray();
        } else {
            // Kosongkan daftar jika tCodeak ada provinsi yang dipilih
            $this->cities = [];
        }
        
        // Reset dropdown di bawahnya
        $this->selectedCity = null;
        $this->selectedDistrict = null;
        $this->selectedVillage = null;
        $this->districts = [];
        $this->villages = [];
    }

    /**
     * Method ini akan otomatis dipanggil setiap kali
     * properti $selectedCity berubah.
     */
    public function updatedSelectedCity($cityCode)
    {
        if ($cityCode) {
            $this->districts = District::where('city_code', $cityCode)->orderBy('name', 'asc')->get()->toArray();
        } else {
            $this->districts = [];
        }

        // Reset dropdown di bawahnya
        $this->selectedDistrict = null;
        $this->selectedVillage = null;
        $this->villages = [];
    }

    /**
     * Method ini akan otomatis dipanggil setiap kali
     * properti $selectedDistrict berubah.
     */
    public function updatedSelectedDistrict($districtCode)
    {
        if ($districtCode) {
            $this->villages = Village::where('district_code', $districtCode)->orderBy('name', 'asc')->get()->toArray();
        } else {
            $this->villages = [];
        }
        
        // Reset dropdown di bawahnya
        $this->selectedVillage = null;
    }

    /**
     * Method ini me-render tampilan (file blade).
     */
    public function render()
    {
        return view('livewire.location-dropdowns');
    }
}