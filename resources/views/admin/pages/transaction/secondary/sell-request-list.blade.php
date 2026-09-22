<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        @if (request()->routeIs('admin.secondarySellRequest.pending'))
            {{ Breadcrumbs::render('secondarySellRequest.pending') }}
        @elseif(request()->routeIs('admin.secondarySellRequest.completed'))
            {{ Breadcrumbs::render('secondarySellRequest.completed') }}
        @elseif(request()->routeIs('admin.secondarySellRequest.inProgress'))
            {{ Breadcrumbs::render('secondarySellRequest.inProgress') }}
        @endif
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Investor</th>
                                        <th class="pe-7">Instrument</th>
                                        <th class="pe-7">Startup</th>
                                        <th class="pe-7 text-center">Shares</th>
                                        @if (request()->routeIs('admin.secondarySellRequest.pending'))
                                            <th class="text-center">Action</th>
                                        @endif
                                        {{-- <th class="pe-7">Investment</th> --}}
                                        {{-- <th class="text-center">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sellRequestlist as $item)
                                        <tr>
                                            <td>{{ $item->investor->name }}</td>
                                            <td>{{ $item->instrument }}</td>
                                            <td>{{ $item->startup->brand_name }}</td>
                                            <td class="text-center">{{ $item->shares }}</td>
                                            @if (request()->routeIs('admin.secondarySellRequest.pending'))
                                                <td class="text-center">
                                                    <!-- Delete Form -->
                                                    <form
                                                        action="{{ route('admin.secondarySellRequest.destroy', ['id' => $item->id]) }}"
                                                        method="POST" style="display:inline;"
                                                        id="delete-form-{{ $item->id }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <!-- Delete Button -->
                                                        <a href="#"
                                                            class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1"
                                                            onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this item?')) document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                            <i class="fas fa-trash fs-6"></i>
                                                        </a>
                                                    </form>
                                                </td>
                                            @endif
                                            {{-- <td>{{ $item->investment_amount }}</td> --}}
                                            {{-- <td class="text-center">
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
                                                                Download Documents</div>
                                                        </div>
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        @if ($item->ssa_document)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('download.web', ['path' => $item->ssa_document->signed_path, 'name' => $item->ssa_document->display_name]) }}"
                                                                    class="menu-link px-3">
                                                                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> SSA
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if ($item->mgt_challan_document)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('download.web', ['path' => $item->mgt_challan_document->signed_path, 'name' => $item->mgt_challan_document->display_name]) }}"
                                                                    class="menu-link px-3">
                                                                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> MGT-14 Challan
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if ($item->mgt_zip_document)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('download.web', ['path' => $item->mgt_zip_document->signed_path, 'name' => $item->mgt_zip_document->display_name]) }}"
                                                                    class="menu-link px-3">
                                                                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> MGT-14 Zip
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if ($item->offer_document)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('download.web', ['path' => $item->offer_document->signed_path, 'name' => $item->offer_document->display_name]) }}"
                                                                    class="menu-link px-3">
                                                                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> Offer Letter
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if ($item->rtgs_receipt)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('download.web', ['path' => $item->rtgs_receipt->signed_path, 'name' => $item->rtgs_receipt->display_name]) }}"
                                                                    class="menu-link px-3">
                                                                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> RTGS Receipt
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if ($item->counter_slip)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('download.web', ['path' => $item->counter_slip->signed_path, 'name' => $item->counter_slip->display_name]) }}"
                                                                    class="menu-link px-3">
                                                                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> Counter
                                                                    Receipt
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if ($item->pas_zip_document)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('download.web', ['path' => $item->pas_zip_document->signed_path, 'name' => $item->pas_zip_document->display_name]) }}"
                                                                    class="menu-link px-3">
                                                                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> PAS3 Zip
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if ($item->sha_document)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('download.web', ['path' => $item->sha_document->signed_path, 'name' => $item->sha_document->display_name]) }}"
                                                                    class="menu-link px-3">
                                                                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> SHA
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
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
