<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('investor.list') }}
    @endsection

    <div class="card card-flush py-4">
        <div class="card-header">
            <div class="card-title">
                <h2>Investor Documents</h2>
            </div>

            <div class="card-toolbar">
                <div class="d-flex align-items-center gap-2 gap-lg-3">

                    <!-- FILTER BUTTON -->
                    <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span
                                class="path2"></span></i>
                        Filter
                    </a>

                    <!-- FILTER DROPDOWN -->
                    <div class="menu menu-sub menu-sub-dropdown w-400px" data-kt-menu="true">
                        <div class="px-7 py-5">
                            <div class="fs-5 fw-bold">Filter Documents</div>
                        </div>
                        <div class="separator"></div>

                        <form id="documentFilterForm" class="px-7 py-5">

                            <div class="mb-5">
                                <label class="form-label fw-semibold">Investor Name</label>
                                <input type="text" id="investor_name" class="form-control"
                                    placeholder="Search by investor name">
                            </div>

                            <div class="mb-5">
                                <label class="form-label fw-semibold">Document Type</label>
                                <select id="type" class="form-select">
                                    <option value="">All Types</option>
                                    @foreach ($documentTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" id="resetFilter" class="btn btn-sm btn-light me-2"
                                    data-kt-menu-dismiss="true">
                                    Reset
                                </button>
                                <button type="button" id="applyFilter" class="btn btn-sm btn-primary"
                                    data-kt-menu-dismiss="true">
                                    Apply
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table id="documentsTable" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-muted">
                            <th>Document Name</th>
                            <th>Type</th>
                            <th>Investor(s)</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {

                const table = $('#documentsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.investor.documents.data') }}",
                        data: function (d) {
                            d.investor_name = $('#investor_name').val();
                            d.type = $('#type').val();
                        }
                    },
                    columns: [
                        { data: 'document_name', name: 'document_name' },
                        { data: 'type', name: 'type' },
                        { data: 'investors', name: 'investors', orderable: false },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'action', orderable: false, searchable: false }
                    ],
                    order: [[3, 'desc']],
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    dom:
                        "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                });

                // Apply filter
                $('#applyFilter').on('click', function () {
                    table.ajax.reload();
                });

                // Reset filter
                $('#resetFilter').on('click', function () {
                    $('#documentFilterForm')[0].reset();
                    table.ajax.reload();
                });

            });
    </script>
    @endpush
</x-default-layout>