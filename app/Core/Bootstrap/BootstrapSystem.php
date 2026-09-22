<?php

namespace App\Core\Bootstrap;


class BootstrapSystem
{
    public function init(): void
    {
        // See also starterkit/app/View/Components/SystemLayout.php to change the layout

        addHtmlClass('body', 'app-blank');
    }
}
