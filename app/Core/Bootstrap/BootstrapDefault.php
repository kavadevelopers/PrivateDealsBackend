<?php

namespace App\Core\Bootstrap;


class BootstrapDefault
{
    public function init(): void
    {
        // 1) Light sidebar layout (default.html)
        // $this->initLightSidebarLayout();

        // 2) Dark sidebar layout (default.html)
        $this->initDarkSidebarLayout();

        // 3) Dark header layout (default_header_layout.html)
        // $this->initDarkHeaderLayout();

        // 4) Light header layout (default_header_layout.html)
        // $this->initLightHeaderLayout();

        # Init global assets for default layout
        $this->initAssets();
    }

    public function initAssets(): void
    {
        # Include global vendors
        addVendors(['datatables']);

        # Include global javascript files
        addJavascriptFile('assets/js/custom/widgets.js');
        addJavascriptFile('assets/js/custom/apps/chat/chat.js');
        addJavascriptFile('assets/js/custom/utilities/modals/upgrade-plan.js');
        addJavascriptFile('assets/js/custom/utilities/modals/create-app.js');
        addJavascriptFile('assets/js/custom/utilities/modals/users-search.js');
        addJavascriptFile('assets/js/custom/utilities/modals/new-target.js');
    }

    public function initDarkSidebarLayout(): void
    {
        addHtmlAttribute('body', 'data-kt-app-layout', 'dark-sidebar');
        addHtmlAttribute('body', 'data-kt-app-header-fixed', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-enabled', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-fixed', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-hoverable', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-push-header', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-push-toolbar', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-push-footer', 'true');
        addHtmlAttribute('body', 'data-kt-app-toolbar-enabled', 'true');

        addHtmlClass('body', 'app-default');
    }

    public function initLightSidebarLayout(): void
    {
        addHtmlAttribute('body', 'data-kt-app-layout', 'light-sidebar');
        addHtmlAttribute('body', 'data-kt-app-header-fixed', 'false');
        addHtmlAttribute('body', 'data-kt-app-sidebar-enabled', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-fixed', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-hoverable', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-push-header', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-push-toolbar', 'true');
        addHtmlAttribute('body', 'data-kt-app-sidebar-push-footer', 'true');
        addHtmlAttribute('body', 'data-kt-app-toolbar-enabled', 'true');

        addHtmlClass('body', 'app-default');
    }

    public function initDarkHeaderLayout(): void
    {
        addHtmlAttribute('body', 'data-kt-app-layout', 'dark-header');
        addHtmlAttribute('body', 'data-kt-app-header-fixed', 'true');
        addHtmlAttribute('body', 'data-kt-app-toolbar-enabled', 'true');

        addHtmlClass('body', 'app-default');
    }

    public function initLightHeaderLayout(): void
    {
        addHtmlAttribute('body', 'data-kt-app-layout', 'light-header');
        addHtmlAttribute('body', 'data-kt-app-header-fixed', 'true');
        addHtmlAttribute('body', 'data-kt-app-toolbar-enabled', 'true');

        addHtmlClass('body', 'app-default');
    }
}
