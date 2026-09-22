<?php

namespace App\Livewire;

use App\Models\StartupModel;
use App\Models\StartupRoundModel;
use Livewire\Component;

class StartupRoundDropdown extends Component
{
    public $startups = [];
    public $rounds = [];
    public $selectedStartup = null;
    public $selectedRound = null;
    public $isOptional = false;

    public function mount($selectedStartup = null, $selectedRound = null, $isOptional = false)
    {
        $this->startups = StartupModel::where('is_deleted', 0)->get()->toArray();
        $this->selectedStartup = $selectedStartup;
        $this->selectedRound = $selectedRound;
        $this->isOptional = $isOptional;

        if ($this->selectedStartup) {
            $this->updatedSelectedStartup($this->selectedStartup);
        }
    }

    public function updatedSelectedStartup($startupId = null)
    {
        $startupId = $startupId ?: $this->selectedStartup;

        // Fetch rounds for the selected startup
        $this->rounds = StartupRoundModel::where('startup_id', $startupId)
            ->where('is_deleted', 0)
            ->get()
            ->toArray();

        // Reset selected round if it doesn't belong to the selected startup
        if ($this->selectedRound && !in_array($this->selectedRound, array_column($this->rounds, 'id'))) {
            $this->selectedRound = null;
        }
    }

    public function render()
    {
        return view('admin.livewire.startup-round-dropdown');
    }
}
