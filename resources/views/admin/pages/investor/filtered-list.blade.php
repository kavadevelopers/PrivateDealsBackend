<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('investor.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">

                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <div class="m-0">
                                <!--begin::Menu toggle-->
                                <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span
                                            class="path1"></span><span class="path2"></span></i>
                                    Filter
                                </a>
                                <!--end::Menu toggle-->

                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown w-400px w-md-500px" data-kt-menu="true"
                                    id="filter-model">
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                    </div>
                                    <div class="separator border-gray-200"></div>

                                    <!--begin::Filter Form-->
                                    <form method="GET" id="filterForm">
                                        <div class="px-7 py-5">
                                            <!-- Group 1: Active Status & Partner -->
                                            <div class="d-flex flex-wrap gap-10 mb-5">
                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="form-label fw-semibold">Active Status</label>
                                                    <select class="form-select form-select-solid" name="active_status"
                                                        id="active_filter" data-control="select2"
                                                        data-dropdown-parent="#filter-model">
                                                        <option value="">All</option>
                                                        <option value="today">Active Today</option>
                                                        <option value="overall">Active Overall</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>

                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="form-label fw-semibold">Partner</label>
                                                    <select class="form-select form-select-solid" name="partner"
                                                        id="partner_filter" data-control="select2"
                                                        data-dropdown-parent="#filter-model">
                                                        <option value="">All</option>
                                                        <option value="with">With Partner</option>
                                                        <option value="without">Without Partner</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Group 2: KYC & Access Type -->
                                            <div class="d-flex flex-wrap gap-10 mb-5">
                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="form-label fw-semibold">KYC</label>
                                                    <select class="form-select form-select-solid" name="kyc"
                                                        id="kyc_filter" data-control="select2"
                                                        data-dropdown-parent="#filter-model">
                                                        <option value="">All</option>
                                                        <option value="without">Without KYC</option>
                                                        <option value="swith">Startup KYC Completed</option>
                                                        <option value="pwith">Pre-IPO KYC Completed</option>
                                                        <option value="awith">All KYC Completed</option>
                                                    </select>
                                                </div>

                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="form-label fw-semibold">Access Type</label>
                                                    <select class="form-select form-select-solid" name="access"
                                                        id="access_filter" data-control="select2"
                                                        data-dropdown-parent="#filter-model">
                                                        <option value="">All</option>
                                                        <option value="primary">Primary Access</option>
                                                        <option value="secondary">Secondary Access</option>
                                                        <option value="preipo">Pre-IPO Access</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Group 3: Registration Date & Live/Demo -->
                                            <div class="d-flex flex-wrap gap-10 mb-5">
                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="form-label fw-semibold">Registration Date</label>
                                                    <select class="form-select form-select-solid" name="date_filter"
                                                        id="date_filter" data-control="select2"
                                                        data-dropdown-parent="#filter-model">
                                                        <option value="">All</option>
                                                        <option value="after_june_9">After June 9, 2025</option>
                                                        <option value="before_june_9">Before June 9, 2025</option>
                                                    </select>
                                                </div>

                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="form-label fw-semibold">Live/Demo</label>
                                                    <select class="form-select form-select-solid" name="demo"
                                                        id="demo_filter" data-control="select2"
                                                        data-dropdown-parent="#filter-model">
                                                        <option value="">All</option>
                                                        <option value="0">Live</option>
                                                        <option value="1">Demo</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Group 4: Startup & Pre-IPO Company -->
                                            <div class="d-flex flex-wrap gap-10 mb-5">
                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="form-label fw-semibold">Startup</label>
                                                    <select class="form-select form-select-solid" name="startup"
                                                        id="startup_filter" data-control="select2"
                                                        data-dropdown-parent="#filter-model">
                                                        <option value="">All Startups</option>
                                                        @foreach ($startups as $startup)
                                                        <option value="{{ $startup->id }}">
                                                            {{ $startup->brand_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="form-label fw-semibold">Pre-IPO Company</label>
                                                    <select class="form-select form-select-solid" name="preipo"
                                                        id="preipo_filter" data-control="select2"
                                                        data-dropdown-parent="#filter-model">
                                                        <option value="">All Companies</option>
                                                        @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}">
                                                            {{ $company->brand_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="d-flex justify-content-end">
                                                <button id="buttonReset" type="button"
                                                    class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                    data-kt-menu-dismiss="true">Reset</button>
                                                <button id="buttonApply" type="button" class="btn btn-sm btn-primary"
                                                    data-kt-menu-dismiss="true">Apply</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <a href="#" id="exportExcel" class="btn btn-primary btn-sm btn-flex">
                                <i class="fa fa-download"></i> Export
                            </a>
                        </div>
                    </div>


                </div>

                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        {{-- <div class="mb-4 row">
                            <div class="col-md-3">
                                <label>Active Status</label>
                                <select id="active_filter" class="form-select">
                                    <option value="">All</option>
                                    <option value="today">Active Today</option>
                                    <option value="overall">Active Overall</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Partner</label>
                                <select id="partner_filter" class="form-select">
                                    <option value="">All</option>
                                    <option value="with">With Partner</option>
                                    <option value="without">Without Partner</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>KYC</label>
                                <select id="kyc_filter" class="form-select">
                                    <option value="">All</option>
                                    <option value="without">Without KYC</option>
                                    <option value="swith">Startup Kyc Completed</option>
                                    <option value="pwith">Pre-IPO Kyc Completed</option>
                                    <option value="awith">All KYC Completed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Access Type</label>
                                <select id="access_filter" class="form-select">
                                    <option value="">All</option>
                                    <option value="primary">Primary Access</option>
                                    <option value="secondary">Secondary Access</option>
                                    <option value="preipo">Pre-IPO Access</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row mt-3">
                            <div class="col-md-3">
                                <label>Registration Date</label>
                                <select id="date_filter" class="form-select">
                                    <option value="">All</option>
                                    <option value="after_june_9">After June 9, 2025</option>
                                    <option value="before_june_9">Before June 9, 2025</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Startup</label>
                                <select id="startup_filter" class="form-select">
                                    <option value="">All Startups</option>
                                    @foreach ($startups as $startup)
                                    <option value="{{ $startup->id }}">{{ $startup->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Pre-IPO Company</label>
                                <select id="preipo_filter" class="form-select">
                                    <option value="">All Companies</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Live/Demo</label>
                                <select id="demo_filter" class="form-select">
                                    <option value="">All</option>
                                    <option value="0">Live</option>
                                    <option value="1">Demo</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning"
                                class="table table-rounded table-striped border gy-2 gs-2">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                        <th>Registered At</th>
                                        <th>Name</th>
                                        <th>Parents</th>
                                        <th>Mobile Number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        {{-- <th>Email</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
                const table = $("#kt_datatable_dom_positioning").DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: {
                        url: "{{ route('admin.investor.filter') }}",
                        data: function(d) {
                            d.status = $('#status_filter').val();
                            d.partner = $('#partner_filter').val();
                            d.kyc = $('#kyc_filter').val();
                            d.access = $('#access_filter').val();
                            d.date_filter = $('#date_filter').val();
                            d.startup_filter = $('#startup_filter').val();
                            d.preipo_filter = $('#preipo_filter').val();
                            d.active_filter = $('#active_filter').val();
                            d.demo_filter = $('#demo_filter').val();
                        }
                    },
                    columns: [{
                            data: 'created_at',
                            name: 'created_at',
                            title: 'Registered At',
                            orderable: true,
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'mobile_number'
                        }, 
                        {
                            data: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        lengthMenu: "Show _MENU_ records per page",
                        zeroRecords: "No matching records found",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No records available",
                        infoFiltered: "(filtered from _MAX_ total records)"
                    },
                    pageLength: 10,
                    searching: true,
                    scrollX: false,
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                });

                table.on('draw.dt', function() {
                    KTMenu.createInstances();
                });

                // Filter listeners
                // $('#status_filter, #partner_filter, #kyc_filter, #access_filter,#date_filter, #startup_filter, #preipo_filter, #active_filter,#demo_filter')
                //     .change(function() {
                //         table.ajax.reload();
                //     });

                $('#buttonApply').on('click', function() {
                    table.ajax.reload();
                });

                $('#buttonReset').on('click', function() {
                    $('#filterForm')[0].reset();
                    table.ajax.reload();
                });

                $('#exportExcel').on('click', function(e) {
                    e.preventDefault();

                    const params = {
                        status: $('#status_filter').val(),
                        partner: $('#partner_filter').val(),
                        kyc: $('#kyc_filter').val(),
                        access: $('#access_filter').val(),
                        date_filter: $('#date_filter').val(),
                        startup_filter: $('#startup_filter').val(),
                        preipo_filter: $('#preipo_filter').val(),
                        active_filter: $('#active_filter').val(),
                        demo_filter: $('#demo_filter').val(),
                    };

                    const queryString = new URLSearchParams(params).toString();
                    const url = "{{ route('admin.investor.export') }}" + "?" + queryString;
                    window.location.href = url;
                });


                $(document).on('click', '.deleteInvestor', function(e) {
                    e.preventDefault();

                    const uuid = $(this).data('uuid');

                    if (!uuid) return;

                    confirmAction({
                        title: 'Delete Investor?',
                        text: 'Are you sure you want to delete this investor?',
                        confirmButtonText: 'Yes, delete it!',
                        onConfirm: function() {
                            $.ajax({
                                url: "{{ route('admin.investor.destroy', ['id' => 'INVESTOR_ID_PLACEHOLDER']) }}"
                                    .replace('INVESTOR_ID_PLACEHOLDER', uuid),
                                type: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(response) {
                                    showErrorMessage('Investor deleted successfully.',
                                        'success');
                                    table.ajax.reload();
                                },
                                error: function(xhr) {
                                    let msg = xhr.responseJSON?.message ||
                                        'Could not delete investor.';
                                    showErrorMessage(msg, 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on("click", ".edit-manager", function(event) {
                    event.preventDefault();
                    $('#editManagerModel select[name=manager_id]').val($(this).data('manager'));
                    $('#editManagerModel input[name=investor_id]').val($(this).data('investor'));
                    $('#editManagerModel').modal('show');
                });
            });
    </script>
    @endpush

    @if (Auth::guard('admin')->user()->role == 'admin')
    <div class="modal fade" id="editManagerModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.investor.manager') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="investor_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Manager</h1>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Select Manager</label>
                                <select class="form-select" name="manager_id" required>
                                    <option value="">-- Select Select Manager --</option>
                                    @foreach ($managers as $manager)
                                    <option value="{{ $manager->id }}">
                                        {{ ucfirst($manager->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="submitform" class="btn btn-primary" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

</x-default-layout>