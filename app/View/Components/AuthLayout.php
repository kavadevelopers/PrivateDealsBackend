<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use Illuminate\View\View;

class AuthLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     * 
     */
    public $data;
    public function __construct($data = [])
    {
        // Init layout file
        $this->data = $data;
        // Log::alert('data - ' . json_encode($data));
        app(config('settings.KT_THEME_BOOTSTRAP.auth'))->init();
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view(config('settings.KT_THEME_LAYOUT_DIR') . '._auth')->with($this->data);
    }
}
