<?php

namespace App\Livewire;

use App\Models\NotificationsModel;
use Livewire\Component;
use Livewire\Attributes\On;

class AdminNotificationsMenu extends Component
{
    public $notifications = [];

    public function mount()
    {
        $this->loadNotifications();
    }

    // #[On('refreshNotifications')]
    public function loadNotifications()
    {
        $this->notifications = NotificationsModel::latest()->get();
    }

    public function render()
    {
        return view('admin.livewire.admin-notifications-menu');
    }
}
