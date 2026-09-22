<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('secondarytransactions.pending') }}
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
                        action="{{ route('admin.primarytransactions.uploadDocument.storeSingleSecTransactionDoc') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="transaction_id" id="transaction_id">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Select Type</label>
                                <select class="form-select" name="doc_type" id="doc_type" aria-label="Select example">
                                    <option value="">Select Document Type</option>
                                    @foreach (App\Enums\DocumentTypeEnum::secondary() as $doc_type)
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
                let table = $("#secondary_transactions_table").DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true, // Prevent reinitialization error
                    ajax: {
                        url: "{{ request()->routeIs('admin.secondarytransactions.completed') ? route('admin.secondarytransactions.completed') : route('admin.secondarytransactions.pending') }}",
                        complete: function() {
                            KTMenu.createInstances(); // Reinitialize dropdowns after table reload
                        }
                    },
                    columns: [{
                            data: "investor",
                            title: "Investor",
                            searchable: true
                        },
                        {
                            data: "seller",
                            title: "Seller",
                            searchable: true
                        },
                        {
                            data: "startup",
                            title: "Startup",
                            searchable: true
                        },
                        {
                            data: "instrument",
                            title: "Instrument",
                            searchable: true
                        },
                        {
                            data: "shares",
                            title: "Shares",
                            searchable: true
                        },
                        {
                            data: "investment",
                            title: "Investment",
                            searchable: true
                        },
                        {
                            data: "status",
                            title: "Status"
                        },
                        {
                            data: "action",
                            title: "Action",
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [],
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

                // Reinitialize dropdowns after each table draw
                table.on('draw.dt', function() {
                    KTMenu.createInstances();
                });

                // Open Upload Document Modal
                $(document).on('click', '.uploadDocumentBtn', function() {
                    var transactionId = $(this).data('transactionid');
                    $('#transaction_id').val(transactionId);
                    $('#uploadDocumentModal').modal('show');
                });

                // AJAX Upload Document Form Submission
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
                                table.ajax.reload(null,
                                    false); // Reload DataTable without resetting pagination
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
