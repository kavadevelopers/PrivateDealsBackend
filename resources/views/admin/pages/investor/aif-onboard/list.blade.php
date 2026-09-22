<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('investor.manualkyc') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Profile Photo</th>
                                        <th class="pe-7">Types Of Investor</th>
                                        <th class="pe-7">Name</th>
                                        <th class="pe-7">Mobile Number</th>
                                        <th class="pe-7">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        @if ($item->investor)
                                            <tr>
                                                <td>
                                                    <div class="symbol symbol-50px me-5">
                                                        <img class="shimmer lazy"
                                                            data-src="{{ FileUpDownHelper::get_investor_profile_photo_url($item->investor) }}" />
                                                    </div>
                                                </td>
                                                <td>{{ ucfirst($item->investor->investor_type) }}</td>
                                                <td>{{ ucfirst($item->investor->name) }}</td>
                                                <td>{{ $item->investor->mobile_number }}</td>
                                                <td>{{ $item->current_status }}</td>
                                                <td class="text-center">
                                                    @if ($item->status == 0)
                                                        <a href="{{ route('admin.aifonboard.view', ['uuid' => $item->investor->uuid]) }}"
                                                            class="btn btn-info hover-elevate-up btn-icon btn-sm me-1">
                                                            <i class="fas fa-eye fs-6"></i>
                                                        </a>
                                                    @endif
                                                    @if ($item->status > 1)
                                                        <div class="card-toolbar">
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary show menu-dropdown"
                                                                data-kt-menu-trigger="click"
                                                                data-kt-menu-placement="bottom-end">
                                                                <i class="ki-duotone ki-category fs-6"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span><span
                                                                        class="path3"></span><span
                                                                        class="path4"></span></i>
                                                            </button>
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                                                data-kt-menu="true" data-popper-placement="bottom-end">
                                                                <div class="menu-item px-3">
                                                                    <div
                                                                        class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                                                                        Action</div>
                                                                </div>
                                                                <div class="separator mb-3 opacity-75"></div>
                                                                @if ($item->status == 2)
                                                                    @if ($item->ppm_signed == 0)
                                                                        <div class="menu-item px-3">
                                                                            <a href="{{ route('admin.aifonboard.documentstatus', ['id' => $item->id, 'type' => 'ppm_signed']) }}"
                                                                                class="menu-link px-3">
                                                                                <span>{!! getIcon('arrows-loop', 'fs-2') !!}</span> PPM
                                                                                Sign
                                                                                Status
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                    @if ($item->ca_signed == 0)
                                                                        <div class="menu-item px-3">
                                                                            <a href="{{ route('admin.aifonboard.documentstatus', ['id' => $item->id, 'type' => 'ca_signed']) }}"
                                                                                class="menu-link px-3">
                                                                                <span>{!! getIcon('arrows-loop', 'fs-2') !!}</span> CA
                                                                                Sign
                                                                                Status
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                                @if ($item->status == 3)
                                                                    @if ($item->ppm_signed == 1)
                                                                        <div class="menu-item px-3">
                                                                            <a href="{{ route('download.web', ['path' => $item->ppm_document->signed_path, 'name' => $item->ppm_document->display_name]) }}"
                                                                                class="menu-link px-3"> 
                                                                                <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> PPM
                                                                                Download
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                    @if ($item->ca_signed == 1)
                                                                        <div class="menu-item px-3">
                                                                            <a href="{{ route('download.web', ['path' => $item->ca_document->signed_path, 'name' => $item->ca_document->display_name]) }}"
                                                                                class="menu-link px-3">
                                                                                <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> CA
                                                                                Download
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                                <div class="separator mt-3 opacity-75"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $("#kt_datatable_dom_positioning").DataTable({
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "order": [],
                    "dom": "<'row mb-2'" +
                        "<'col-sm-6 d-flex align-items-center justify-conten-start dt-toolbar'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">"
                });
            })
        </script>
    @endpush
</x-default-layout>
