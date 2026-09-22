<?php

namespace App\Livewire\Admin;

use App\Models\NotificationsModel;
use Livewire\Component;

class NotificationsMenu extends Component
{
    public $notifications = [];
    protected $listeners = ['loadNotifications'];
    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = NotificationsModel::latest()->get();
    }

    public function render()
    {
        return view('admin.livewire.user.notifications-menu');
    }
}
