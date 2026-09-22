{{--
<!--begin::Chart widget 24-->
<div class="card card-flush overflow-hidden h-xl-100">
    <!--begin::Header-->
    <div class="card-header py-5">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Human Resources</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-6">Reports by states and ganders</span>
        </h3>
        <!--end::Title-->
        <!--begin::Toolbar-->
        <div class="card-toolbar">
            <!--begin::Menu-->
            <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end"
                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">{!!
                getIcon('dots-square', 'fs-1') !!}</button>
            @include('admin.partials/menus/_menu-2')
            <!--end::Menu-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <div class="card-body pt-0">
        <!--begin::Chart-->
        <div id="kt_charts_widget_24" class="min-h-auto" style="height: 300px"></div>
        <!--end::Chart-->
    </div>

</div>
<!--end::Chart widget 24--> --}}


<!--begin::Chart widget 24-->
<div class="card card-flush overflow-hidden h-xl-100">
    <div class="card-header py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Human Resources</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-6">Reports by states and genders</span>
        </h3>
        <div class="card-toolbar">
            <!-- Toolbar/Menu if needed -->
        </div>
    </div>
    <div class="card-body pt-0">
        <div id="kt_charts_widget_24" class="min-h-auto" style="height: 300px"></div>
        <!-- Use $hrReports data for chart via JS -->
    </div>
</div>
<!--end::Chart widget 24-->