@extends('admin.layout.master')

@section('content')
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            @if (!request()->routeIs('office.dashboard'))
                @include(config('settings.KT_THEME_LAYOUT_DIR') . '/partials/sidebar-layout/_header')
            @endif
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @if (!request()->routeIs('office.dashboard'))
                    @include(config('settings.KT_THEME_LAYOUT_DIR') . '/partials/sidebar-layout/_sidebar')
                @endif
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        @if (!request()->routeIs('office.dashboard'))
                            @include(config('settings.KT_THEME_LAYOUT_DIR') . '/partials/sidebar-layout/_toolbar')
                        @endif
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                {{ $slot }}
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    @if (!request()->routeIs('office.dashboard'))
                        @include(config('settings.KT_THEME_LAYOUT_DIR') . '/partials/sidebar-layout/_footer')
                    @endif
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    {{-- @include('admin.partials._drawers') --}}

    {{-- @include('admin.partials._modals') --}}

    @include('admin.partials._scrolltop')
@endsection
