<?php

namespace App\Livewire;

use Livewire\Component;

class AlertComponent extends Component
{
    protected $listeners = ['showAlert'];

    public function showAlert($message, $icon = 'success', $confirmButtonText = 'Ok, got it!')
    {
        $this->emit('swal', $message, $icon, $confirmButtonText);
    }

    public function render()
    {
        return view('admin.layout.master');
    }
}
