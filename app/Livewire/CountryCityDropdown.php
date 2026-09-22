<?php

namespace App\Livewire;

use App\Models\MasterCityModel;
use App\Models\MasterCountryModel;
use App\Models\MasterStateModel;
use Livewire\Component;
use Illuminate\Support\Facades\Request;

class CountryCityDropdown extends Component
{
    public $countries = [];
    public $states = [];
    public $cities = [];
    public $selectedCountry;
    public $selectedState;
    public $selectedCity;
    public $isOptional;
    public $isAdminRoute = false;

    protected $listeners = ['formSubmitted' => 'refreshDropdowns'];

    public function mount($selectedCountry = null, $selectedState = null, $selectedCity = null, $isOptional = false)
    {
        $this->countries = MasterCountryModel::where('is_deleted', '0')->get()->toArray();
        $this->isAdminRoute = Request::is('admin/*');
        $this->selectedCountry = $selectedCountry;
        $this->selectedState = $selectedState;
        $this->selectedCity = $selectedCity;
        $this->isOptional = $isOptional;
        if ($this->selectedCountry) {
            $this->updatedSelectedCountry($this->selectedCountry);
        }
        if ($this->selectedState) {
            $this->updatedSelectedState($this->selectedState);
        }
    }

    public function updatedSelectedCountry($country = null)
    {
        $country = $country ?: $this->selectedCountry;
        $this->states = MasterStateModel::where('country_id', $country)
            ->where('is_deleted', '0')
            ->get()->toArray();
        if ($this->selectedState && !in_array($this->selectedState, array_column($this->states, 'id'))) {
            $this->selectedState = null;
        }
        $this->cities = [];
        if ($this->selectedState) {
            $this->updatedSelectedState($this->selectedState);
        } else {
            $this->selectedCity = null;
        }
    }

    public function updatedSelectedState($state = null)
    {
        $state = $state ?: $this->selectedState;
        $this->cities = MasterCityModel::where('state_id', $state)
            ->where('is_deleted', '0')
            ->get()->toArray();
        if ($this->selectedCity && !in_array($this->selectedCity, array_column($this->cities, 'id'))) {
            $this->selectedCity = null;
        }
    }

    public function refreshDropdowns()
    {
        $this->mount($this->selectedCountry, $this->selectedState, $this->selectedCity);
    }

    public function render()
    {
        return view('admin.livewire.country-city-dropdown');
    }
}
