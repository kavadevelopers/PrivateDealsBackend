<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DefaultLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data = [])
    {
        // Init layout file
        $this->data = $data;
        app(config('settings.KT_THEME_BOOTSTRAP.default'))->init();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View
    {
        // See also starterkit/app/Core/Bootstrap/BootstrapDefault.php
        return view(config('settings.KT_THEME_LAYOUT_DIR') . '._default')->with($this->data);
    }
}
