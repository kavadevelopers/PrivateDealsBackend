<div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
    <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Rounds</h2>
                </div>
                <div class="card-toolbar">
                    <a href="#" class="btn btn-sm btn-primary createRoundDetails"
                        data-startupid="{{ $startup->id }}">
                        Create
                    </a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex flex-column gap-5 gap-md-7">
                    <div class="table-responsive" id="round-table">
                        @include('admin.pages.startup.child.child.round-table', [
                            'rounds' => $startup->rounds,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editRoundModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="roundForm" action="{{ route('admin.startup.updateRoundDetails') }}" method="post">
            @csrf
            {{-- @method('PUT') --}}
            <input type="hidden" id="startup_id" name="startup_id">
            <input type="hidden" id="round_id" name="round_id">
            <input type="hidden" id="formMethod" name="_method">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle">Edit Round Details</h1>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">

                            <label class="required form-label">Round Name</label>
                            <input type="text" name="round_name" id="round_name" class="form-control"
                                placeholder="Enter Round Name">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Round Type</label>
                            <select class="form-select" name="round_type" id="round_type" aria-label="Select example">
                                <option value="">Select Round Type</option>
                                @foreach (App\Enums\StartupRoundTypeEnum::cases() as $round_type)
                                    <option value="{{ $round_type->value }}">
                                        {{ $round_type->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Round Status</label>
                            <select class="form-select" name="round_status" id="round_status"
                                aria-label="Select example">
                                <option value="">Select Round Status</option>
                                @foreach (App\Enums\StartupPrimaryRoundStatusEnum::cases() as $round_status)
                                    <option value="{{ $round_status->value }}">
                                        {{ $round_status->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Share Price</label>
                            <input type="text" name="share_price" id="share_price"
                                class="form-control input-decimal-number input-number-words"
                                placeholder="Enter Share Price">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Shuru Commission</label>
                            <input type="text" name="shuru_commission" id="shuru_commission"
                                class="form-control input-decimal-number" placeholder="Enter Shuru Commission">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Instrument Type</label>
                            <select class="form-select" name="instrument" id="instrument" aria-label="Select example">
                                <option value="">Select Round Status</option>
                                @foreach (App\Enums\InstrumentTypeEnum::cases() as $instrument)
                                    <option value="{{ $instrument->value }}">
                                        {{ $instrument->value }}
                                    </option>
                                @endforeach
                            </select>
                            @include('admin.partials.form.input-error-message', [
                                'key' => 'instrument',
                            ])
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Floor</label>
                            <input type="text" name="floor" id="floor"
                                class="form-control input-decimal-number input-number-words" placeholder="Enter Floor">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Cap</label>
                            <input type="text" name="cap" id="cap"
                                class="form-control input-decimal-number input-number-words" placeholder="Enter Cap">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Equity Offered</label>
                            <input type="text" name="equity_offered" id="equity_offered"
                                class="form-control input-decimal-number" placeholder="Enter Equity Offered">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Minimum Investment</label>
                            <input type="text" name="minimum_investment" id="minimum_investment"
                                class="form-control input-decimal-number input-number-words"
                                placeholder="Enter Minimum Investment">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Minimum Investment AIF</label>
                            <input type="text" name="minimum_investment_aif" id="minimum_investment_aif"
                                class="form-control input-decimal-number input-number-words"
                                placeholder="Enter Minimum Investment AIF">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Total Fund Requirement</label>
                            <input type="text" name="total_fund_requirement" id="total_fund_requirement"
                                class="form-control input-decimal-number input-number-words"
                                placeholder="Enter Total Fund Requirement">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Shuru Fund Requirement</label>
                            <input type="text" name="fund_requirement" id="fund_requirement"
                                class="form-control input-decimal-number input-number-words"
                                placeholder="Enter Fund Requirement">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row col-12 col-md-6 col-lg-4">
                            <label class="required form-label">Round Date</label>
                            <input name="date" class="form-control mb-2 input flat-datepicker"
                                placeholder="Select Round Date" tabindex="0" type="text">
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
@push('scripts')
    <script>
        $(document).ready(function() {
            // For Editing
            $(document).on('click', '.editRoundDetails', function() {
                var round_id = $(this).data('id');
                var url =
                    "{{ route('admin.startup.editRoundDetails', ['round_id' => ':round_id']) }}"
                    .replace(':round_id', round_id);
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        $('#modalTitle').text('Edit Round Details');
                        $('#round_name').val(response.round.name);
                        $('#round_type').val(response.round.round_type).change();
                        $('#round_status').val(response.round.round_status)
                            .change();
                        $('#share_price').val(response.round.share_price);
                        $('#shuru_commission').val(response.round.shuru_commission);
                        $('#instrument').val(response.round.instrument).change();
                        $('#floor').val(response.round.floor);
                        $('#cap').val(response.round.cap);
                        $('#equity_offered').val(response.round.equity_offered);
                        $('#minimum_investment').val(response.round
                            .minimum_investment);
                        $('#minimum_investment_aif').val(response.round
                            .minimum_investment_aif);
                        $('#total_fund_requirement').val(response.round
                            .total_fund_requirement);
                        $('#fund_requirement').val(response.round.fund_requirement);
                        $('#round_id').val(round_id);
                        $('#editRoundModel input[name=date]').val(response.round
                            .formatted_created_at);
                        // alert(response.round.created_at);
                        $('#editRoundModel').modal('show');
                        initClasses();

                    },
                });
            });

            // For Creating
            $('.createRoundDetails').on('click', function() {
                $('#roundForm')[0].reset();
                var startupId = $(this).data('startupid');
                $('#roundForm input[name=startup_id]').val(startupId);
                $('#roundForm .modal-title').html('Create Round Details');
                $('#round_id').val('');
                $('#editRoundModel').modal('show');
                initClasses();
            });

            // Form Submission (handles both create and update)
            $('#roundForm').on('submit', function(event) {
                event.preventDefault();
                showSpinningLoader(true);
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        showSpinningLoader(false);
                        $('#editRoundModel').modal('hide');
                        $('#round-table').html(response.table);
                        showErrorMessage(response.message,
                            "success");
                    },
                    error: function(xhr) {
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
        });
    </script>
@endpush
