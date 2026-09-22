<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage-startup.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <!-- Existing List Card -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">
                        {{-- <a href="{{ route('admin.startup.manage.') }}" class="btn btn-sm btn-primary">
                            Create
                        </a> --}}
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Logo</th>
                                        <th class="pe-7">Brand Name</th>
                                        <th class="pe-7">Mobile No.</th>
                                        <th class="pe-7">Sector</th>
                                        <th class="pe-7">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px me-5">
                                                    <img class="shimmer lazy"
                                                        data-src="{{ FileUpDownHelper::get_startup_logo_url($item) }}" />
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->brand_name }}<br>-{{ $item->legalInfo->company_name ?? '' }}
                                            </td>
                                            <td>{{ $item->mobile_number }}</td>
                                            <td>{{ $item->sector->name ?? '' }}</td>
                                            <td>{{ $item->round_statuses }}</td>
                                            <td class="text-center">
                                                <div class="card-toolbar">
                                                    <button type="button"
                                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary show menu-dropdown"
                                                        data-kt-menu-trigger="click"
                                                        data-kt-menu-placement="bottom-end">
                                                        <i class="ki-duotone ki-category fs-6"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span></i>
                                                    </button>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                                        data-kt-menu="true" data-popper-placement="bottom-end">
                                                        <div class="menu-item px-3">
                                                            <div
                                                                class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                                                                Action</div>
                                                        </div>
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.startup.view', ['uuid' => $item->uuid]) }}"
                                                                class="menu-link px-3">
                                                                View
                                                            </a>
                                                        </div>
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        {{-- <div class="menu-item px-3">
                                                            <a href="{{ route('admin.startup.view.old', ['uuid' => $item->uuid]) }}"
                                                                class="menu-link px-3">
                                                                View Old
                                                            </a>
                                                        </div> --}}
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.startup.shareprice.get', ['uuid' => $item->uuid]) }}"
                                                                class="menu-link px-3">
                                                                Share Price
                                                            </a>
                                                        </div>
                                                        <div class="separator mt-3 opacity-75"></div>
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content px-3 py-3">
                                                                <form
                                                                    action="{{ route('admin.startup.destroy', ['id' => $item->id]) }}"
                                                                    method="POST" style="display:inline;"
                                                                    id="delete-form-{{ $item->id }}">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <!-- Delete Button -->
                                                                    <a href="#"
                                                                        class="btn btn-danger  btn-sm px-4"
                                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                                        <i class="fas fa-trash fs-6"></i> Delete
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td class="text-center">
                                                <a href="{{ route('admin.startup.view', ['uuid' => $item->uuid]) }}"
                                                    class="btn btn-info hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-eye fs-6"></i>
                                                </a>
                                                <a href="{{ route('admin.startup.view', ['uuid' => $item->uuid]) }}"
                                                    class="btn btn-info hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-eye fs-6"></i>
                                                </a>
                                                <!-- Delete Form -->
                                                <form action="{{ route('admin.startup.destroy', ['id' => $item->id]) }}"
                                                    method="POST" style="display:inline;"
                                                    id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <!-- Delete Button -->
                                                    <a href="#"
                                                        class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                        <i class="fas fa-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            </td> --}}
                                        </tr>
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
                        "<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
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
