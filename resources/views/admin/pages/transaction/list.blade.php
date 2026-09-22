<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('primarytransactions.pending') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">
                        {{-- <a href="{{ route('admin.startup.mis.create') }}" class="btn btn-sm btn-primary">
                            Create
                        </a> --}}
                        <a href="{{ route('admin.primarytransactions.completed') }}" title="Refresh"
                            class="btn btn-success hover-elevate-up btn-icon btn-sm me-1">
                            <i class="fas fa-refresh fs-6"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            {!! $dataTable->table(['class' => 'table table-row-bordered gy-5 gs-7']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadDocumentForm"
                        action="{{ route('admin.primarytransactions.uploadDocument.storeSingleTransactionDoc') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="transaction_id" id="transaction_id">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Select Type</label>
                                <select class="form-select" name="doc_type" id="doc_type" aria-label="Select example">
                                    <option value="">Select Document Type</option>
                                    @foreach (App\Enums\DocumentTypeEnum::singlePrimary() as $doc_type)
                                        <option value="{{ $doc_type->value }}"
                                            {{ old('doc_type') == $doc_type->value ? 'selected' : '' }}>
                                            {{ $doc_type->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Upload File</label>
                                <input type="file" name="doc_file" class="form-control" accept=".pdf">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'doc_file',
                                ])
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        {!! $dataTable->scripts() !!}

        <script>
            $(document).ready(function() {
                let table = $("#kt_datatable_dom_positioning").DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true, // Prevent reinitialization error
                    ajax: {
                        url: "{{ request()->routeIs('admin.primarytransactions.completed') ? route('admin.primarytransactions.completed') : route('admin.primarytransactions.pending') }}",
                        data: function(d) {
                            let urlParams = new URLSearchParams(window.location.search);
                            if (urlParams.has("investor_key")) {
                                d.investor_key = urlParams.get("investor_key");
                            }
                        },
                        complete: function() {
                            KTMenu.createInstances(); // Reinitialize dropdowns
                        }
                    },
                    columns: [{
                            data: "investor",
                            searchable: true
                        },
                        {
                            data: "startup",
                            searchable: true,
                            orderable: false
                        },
                        // { data: "round", searchable: true },
                        {
                            data: "instrument",
                            searchable: true
                        },
                        {
                            data: "investment",
                            searchable: true
                        },
                        {
                            data: "share_price",
                            searchable: true
                        },
                        {
                            data: "shares",
                            searchable: true
                        },
                        {
                            data: "date_formatted",
                            name: "date", // This helps with server-side ordering
                            searchable: true,
                            orderable: true
                        },
                        {
                            data: "action",
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [6, 'desc']
                    ],
                    pageLength: 10,
                    searching: true,
                    language: {
                        lengthMenu: "Show _MENU_ records per page",
                        zeroRecords: "No matching records found",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No records available",
                        infoFiltered: "(filtered from _MAX_ total records)"
                    },
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                });

                table.on('draw.dt', function() {
                    KTMenu.createInstances();
                });

                $(document).on('click', '.uploadDocumentBtn', function() {
                    var transactionId = $(this).data('transactionid');
                    $('#transaction_id').val(transactionId);
                    $('#uploadDocumentModal').modal('show');
                });

                $('#uploadDocumentForm').on('submit', function(e) {
                    e.preventDefault();
                    showSpinningLoader(true);

                    var formData = new FormData(this);

                    $.ajax({
                        type: "POST",
                        url: $(this).attr('action'),
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            showSpinningLoader(false);

                            if (response.status === 1) {
                                $('#uploadDocumentModal').modal('hide');
                                $('#uploadDocumentForm')[0].reset();
                                showErrorMessage(response.message, "success");
                                table.ajax.reload(null, false);
                            } else {
                                showErrorMessage(response.message, "error");
                            }
                        },
                        error: function(xhr) {
                            showSpinningLoader(false);
                            let response = xhr.responseJSON;

                            if (xhr.status === 422) {
                                let errorMessage = response.message || "Validation failed.";
                                showErrorMessage(errorMessage, "error");
                            } else {
                                showErrorMessage(response.message ||
                                    "Error uploading document. Please try again.", "error");
                            }
                        }
                    });
                });

            });
        </script>
    @endpush
</x-default-layout>
