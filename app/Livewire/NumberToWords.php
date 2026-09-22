<?php

namespace App\Livewire;

use App\Helpers\UtillsHelper;
use Livewire\Component;

class NumberToWords extends Component
{
    public $number = '';
    public $words = '';
    public $name;
    public $label;
    public $placeholder;

    public function mount($name, $label, $placeholder)
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    public function updatedNumber()
    {
        if (is_numeric($this->number)) {
            $this->words = UtillsHelper::getIndianCurrencyinWords($this->number);
        } else {
            $this->words = '';
        }
    }

    // private function convertNumberToWords($number)
    // {
    //     $formatter = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
    //     return $formatter->format($number);
    // }

    public function render()
    {
        return view('admin.livewire.number-to-words');
    }
}
