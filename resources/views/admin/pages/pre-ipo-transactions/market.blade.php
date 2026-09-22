<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('preipotransactions.list') }}
    @endsection

    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Pending Orders</span>

                <span class="text-muted mt-1 fw-semibold fs-7">{{ $transactions->count() }} new orders</span>
            </h3>
            <div class="card-toolbar">
                {{-- <a href="#" class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-2"></i> New Member
                </a> --}}
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="ps-4 min-w-225px rounded-start">Investor</th>
                            <th class="ps-4 min-w-225px rounded-start">Company</th>
                            <th class="min-w-200px">Shares</th>
                            <th class="min-w-200px">Distributer</th>
                            <th class="min-w-150px">Timer</th>
                            <th class="min-w-100px">Date</th>
                            <th class="min-w-150px text-end rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->

                    <!--begin::Table body-->
                    <tbody>
                        @if ($transactions->count() > 0)
                        @foreach ($transactions as $item)
                        @php
                        $item->company->makeVisible(['share_price']);
                        @endphp
                        <tr id="row-{{ $item->id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-5">
                                        <img class="shimmer lazy"
                                            data-src="{{ FileUpDownHelper::get_investor_profile_photo_url($item->investor) }}"
                                            alt="">
                                    </div>

                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="{{ route('admin.investor.view', ['uuid' => $item->investor->uuid]) }}"
                                            class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6"
                                            target="_blank">{{ $item->investor->name }}</a>
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{
                                            $item->investor->mobile_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-5">
                                        <img class="shimmer lazy"
                                            data-src="{{ FileUpDownHelper::get_company_logo_url($item->company) }}"
                                            alt="">
                                    </div>

                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="{{ route('admin.company.view', ['uuid' => $item->company->uuid]) }}"
                                            target="_blank"
                                            class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{
                                            $item->company->brand_name }}</a>
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{
                                            UtillsHelper::rupee() }}{{
                                            UtillsHelper::moneyFormatIndia($item->company->share_price) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="javascript:;"
                                    class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $item->shares
                                    }}
                                    shares</a>
                                <span class="text-muted fw-semibold text-muted d-block fs-7">At
                                    {{ UtillsHelper::rupee() }}{{ UtillsHelper::moneyFormatIndia($item->share_price)
                                    }}</span>
                                <span class="text-muted fw-semibold text-muted d-block fs-7">Total
                                    {{ UtillsHelper::rupee() }}{{
                                    UtillsHelper::moneyFormatIndia($item->investment_amount) }}</span>
                            </td>

                            <td>
                                <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $item->is_distributer &&
                                    $item->investor->partner ? 'By ' . $item->investor->partner->name : 'NA' }}</span>
                            </td>

                            <td>
                                @if ($item->transaction_cancel_timer)
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        <span class="text-dark fw-semibold d-block fs-7" id="timer-{{ $item->id }}">
                                            {{ DateTimeHelper::formatDateTime($item->transaction_cancel_timer, 'd M Y
                                            h:i A') }}
                                        </span>
                                        <small class="text-muted d-block">
                                            @php
                                            $diffInSeconds = $item->transaction_cancel_timer->diffInSeconds(now());
                                            if ($diffInSeconds > 0) {
                                            $hours = intdiv($diffInSeconds, 3600);
                                            $minutes = intdiv(($diffInSeconds % 3600), 60);
                                            echo $hours . 'h ' . $minutes . 'm remaining';
                                            } else {
                                            echo 'Timer expired';
                                            }
                                            @endphp
                                        </small>
                                    </div>
                                    <button class="btn btn-sm btn-light-warning extend-timer-btn"
                                        data-id="{{ $item->id }}" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Extend Timer">
                                        <i class="ki-duotone ki-time fs-2"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </button>
                                </div>
                                @else
                                <span class="text-muted fw-semibold d-block fs-7">No Timer</span>
                                @endif
                            </td>

                            <td>
                                <span class="text-muted fw-semibold text-muted d-block fs-7">{{
                                    DateTimeHelper::formatDateTime($item->created_at, 'd M Y h:i A') }}</span>
                            </td>

                            <td class="text-end">
                                <a href="#"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 preipo-status-btn"
                                    data-bs-toggle="tooltip" data-bs-placement="left" title="Approve"
                                    data-status="approve" data-id="{{ $item->id }}" data-row="row-{{ $item->id }}">
                                    <i class="ki-duotone ki-double-check fs-1"><span class="path1"></span><span
                                            class="path2"></span></i> </a>

                                <a href="#"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm preipo-status-btn"
                                    data-bs-toggle="tooltip" data-bs-placement="left" title="Reject"
                                    data-status="reject" data-id="{{ $item->id }}" data-row="row-{{ $item->id }}">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span></i> </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center">No data found</td>
                        </tr>
                        @endif
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>


    <div class="modal fade" tabindex="-1" id="extend-timer-modal">
        <form action="" method="post" id="extend-timer-form">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Extend Timer</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <div class="modal-body">
                        <div class="fv-row mb-5">
                            <label class="form-label">Extension Duration (Hours)</label>
                            <input type="number" class="form-control" name="extend_hours"
                                placeholder="Leave empty for default extension" min="1" max="168">
                            <small class="text-muted d-block mt-2">Leave empty to use default duration for this
                                transaction status</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="transaction_id" id="extend-transaction-id">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Extend Timer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" tabindex="-1" id="status-modal">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Pre-IPO Status</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Select Seller</label>
                                <select class="form-select" name="seller" aria-label="Select Seller">
                                    <option value="">-- Select Seller --</option>
                                    @foreach ($sellers as $seller)
                                    <option value="{{ $seller->id }}">
                                        {{ ucfirst($seller->company_name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Notes (Optional)</label>
                                <textarea placeholder="Enter Notes if any" name="notes" class="form-control mb-2 input"
                                    tabindex="0"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Confirmation File</label>
                                <input name="confirmation_file" class="form-control mb-2 input" tabindex="0"
                                    type="file">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="status">
                        <input type="hidden" name="transaction">
                        <input type="hidden" name="row">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Change Status</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(function() {
                // Extend timer button handler
                $('.extend-timer-btn').click(function(e) {
                    e.preventDefault();
                    const transactionId = $(this).data('id');
                    $('#extend-transaction-id').val(transactionId);
                    $('#extend-timer-form')[0].reset();
                    $('#extend-timer-modal').modal('show');
                });

                // Extend timer form submission
                $('#extend-timer-form').submit(function(e) {
                    e.preventDefault();
                    const transactionId = $('#extend-transaction-id').val();
                    const extendHours = $('input[name=extend_hours]').val() || '';
                    
                    showSpinningLoader();
                    axios.post(
                        "{{ route('admin.preipotransaction.extendTimer', ['transaction_id' => '__ID__']) }}".replace('__ID__', transactionId),
                        { extend_hours: extendHours }
                    )
                    .then(function(response) {
                        showSpinningLoader(false);
                        if (response.data.status) {
                            $('#extend-timer-modal').modal('hide');
                            showErrorMessage(response.data.message, 'success');
                            // Optionally reload the page to show updated timer
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showErrorMessage(response.data.message, 'error');
                        }
                    })
                    .catch(function(error) {
                        showSpinningLoader(false);
                        console.error("There was an error!", error);
                        showErrorMessage('An error occurred while extending the timer', 'error');
                    });
                });

                $('.preipo-status-btn').click(function(e) {
                    e.preventDefault();
                    if ($(this).data('status') == 'approve') {
                        $('#status-modal select[name=seller]').closest('.fv-row').show();
                        $('#status-modal .modal-title').html('Pre-IPO Transaction Approve');
                        $('#status-modal button[type=submit]').html('Approve Deal');
                    } else {
                        $('#status-modal select[name=seller]').closest('.fv-row').hide();
                        $('#status-modal .modal-title').html('Pre-IPO Transaction Reject');
                        $('#status-modal button[type=submit]').html('Reject Deal');
                    }
                    $('#status-modal form')[0].reset();
                    $('#status-modal input[name=status]').val($(this).data('status'));
                    $('#status-modal input[name=transaction]').val($(this).data('id'));
                    $('#status-modal input[name=row]').val($(this).data('row'));
                    $('#status-modal').modal('show');
                });
                $('#status-modal form').submit(function(e) {
                    e.preventDefault();
                    showSpinningLoader();
                    $this =
                        axios.post("{{ route('admin.preipotransaction.approve') }}", new FormData(this))
                        .then(function(response) {
                            showSpinningLoader(false);
                            if (response.data.status) {
                                $('#' + $('#status-modal input[name=row]').val()).remove();
                                $('#status-modal').modal('hide');
                                showErrorMessage(response.data.message, 'success');
                            } else {
                                if ('remove_transaction' in response.data) {
                                    $('#' + $('#status-modal input[name=row]').val()).remove();
                                    $('#status-modal').modal('hide');
                                }
                                showErrorMessage(response.data.message, 'error');
                            }
                        })
                        .catch(function(error) {
                            showSpinningLoader(false);
                            console.error("There was an error!", error);
                        });
                })
            });
    </script>
    @endpush

</x-default-layout>