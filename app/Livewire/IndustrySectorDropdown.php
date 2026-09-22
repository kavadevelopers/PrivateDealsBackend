<?php

namespace App\Livewire;

use App\Models\MasterIndustryModel;
use App\Models\MasterSectorsModel;
use Livewire\Component;
use Illuminate\Support\Facades\Request;

class IndustrySectorDropdown extends Component
{
    public $industries;
    public $sectors = [];
    public $selectedIndustry;
    public $selectedSector;
    public $isAdminRoute = false;

    public function mount($selectedIndustry = null, $selectedSector = null)
    {
        $this->industries = MasterIndustryModel::where('is_deleted', '0')->get();
        $this->selectedIndustry = $selectedIndustry;
        $this->selectedSector = $selectedSector;
        $this->isAdminRoute = Request::is('admin/*');

        if ($this->selectedIndustry) {
            $this->sectors = MasterSectorsModel::where('industry_id', $this->selectedIndustry)
                ->where('is_deleted', '0')
                ->get();
        }
    }

    public function updatedSelectedIndustry()
    {
        $this->sectors = MasterSectorsModel::where('industry_id', $this->selectedIndustry)
            ->where('is_deleted', '0')
            ->get();
        $this->selectedSector = null;
    }
    public function render()
    {
        return view('admin.livewire.industry-sector-dropdown');
    }
}
