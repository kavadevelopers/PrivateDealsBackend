<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('reports.resourceBilling.list') }}
    @endsection


    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.reports.resourceBilling.create') }}" class="btn btn-sm btn-primary">
                            Create
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive" id="resourcebilling-table">
                            @include('admin.pages.resourceBilling.table', [
                                'resourceBilling' => $list,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addResourceHistoryModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="addResourceHistoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            {{-- <form id="roundForm" action="{{ route('admin.startup.updateRoundDetails') }}" method="post">
                @csrf --}}
            <form id="addResourceHistoryForm" action="{{ route('admin.reports.resourceBilling.createBillingHistory') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="resource_billing_id" id="resource_billing_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="addResourceHistoryId">Add Resource History</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Upload Billing File</label>
                                <input name="file" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'file',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Purchase Date</label>
                                <input name="purchase_date" class="form-control mb-2 input flat-datepicker"
                                    placeholder="Enter Purchase Date" tabindex="0" type="text"
                                    value="{{ old('purchase_date') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'purchase_date',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Expire Date</label>
                                <input name="expire_date" class="form-control mb-2 input flat-datepicker"
                                    placeholder="Enter Renewal Date" tabindex="0" type="text"
                                    value="{{ old('expire_date') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'expire_date',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Billing Amount</label>
                                <input placeholder="Enter Billing Amount" name="amount" value="{{ old('amount') }}"
                                    class="form-control mb-2 input-decimal-number" tabindex="0"
                                    type="text"></input>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'amount',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Renewal Amount</label>
                                <input placeholder="Enter Renewal Amount" name="renewal_amount"
                                    value="{{ old('renewal_amount') }}" class="form-control mb-2 input-decimal-number"
                                    tabindex="0" type="text"></input>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'renewal_amount',
                                ])
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" name="submitform" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </div>

            </form>
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

            $(document).on('click', '.addResourceHistory', function(event) {
                event.preventDefault();
                var billingId = $(this).data('billing-id');
                $('#resource_billing_id').val(billingId);
                $('#addResourceHistoryForm')[0].reset();
                $('#addResourceHistoryModal').modal('show');
            });

            // Handle form submission
            $('#addResourceHistoryForm').on('submit', function(event) {
                event.preventDefault();
                showSpinningLoader(true);

                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        showSpinningLoader(false);
                        $('#addResourceHistoryModal').modal('hide');
                        $('#resourcebilling-table').html(response.table);
                        showErrorMessage(response.message, "success");

                    },
                    error: function(xhr) {
                        console.log('hii');
                        showSpinningLoader(false);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var firstError = Object.values(errors)[0][0];
                            showErrorMessage(firstError, "error");
                        } else {
                            showErrorMessage(
                                "An unexpected error occurred. Please try again.",
                                "error");
                        }
                    }
                });
            });
        </script>
    @endpush

</x-default-layout>
