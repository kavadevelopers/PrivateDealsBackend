<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('feedback.list') }}
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
                                        <th class="pe-7">Type</th>
                                        <th class="pe-7">Device</th>
                                        <th class="pe-7">Name</th>
                                        <th class="pe-7">Mobile Number</th>
                                        <th class="pe-7">Email</th>
                                        <th class="pe-7">Date</th>
                                        @if (request()->routeIs('admin.reports.cms.requestaccess.pending'))
                                            <th class="text-center">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>
                                                {{ $item->is_startup ? 'For Startup' : 'General' }}
                                            </td>
                                            <td>{{ ucfirst($item->device) }}</td>
                                            <td>{{ ucfirst($item->name) }}</td>
                                            <td>
                                                {{ ucfirst($item->mobile_number) }}
                                            </td>
                                            <td>{{ ucfirst($item->email) }}</td>
                                            <td>
                                                <span
                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{ DateTimeHelper::formatDateTime($item->created_at, 'd M Y h:i A') }}</span>
                                                {!! $item->notes != null ? nl2br($item->notes) : 'N/A' !!}
                                            </td>
                                            @if (request()->routeIs('admin.reports.cms.requestaccess.pending'))
                                                <td class="text-center">
                                                    @if ($item->is_readed == '0')
                                                        <a class="btn btn-sm btn-primary markAsRead"
                                                            data-startupid="{{ $item->id }}">
                                                            Mark As Read
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif
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
    <div class="modal fade" id="markAsRead" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="markAsReadForm" action="" method="post">
                @csrf
                <input type="hidden" id="entry_id" name="entry_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTitle">Write A Note</h1>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Note</label>
                                <textarea type="text" name="notes" id="notes" class="form-control" placeholder="Enter Note"></textarea>
                            </div>
                        </div>
                        <div class="mb-10">
                            <div class="d-flex flex-wrap">
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" name="is_converted" value="1">
                                    <span class="form-check-label">
                                        Approve ?
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="submitform" class="btn btn-primary" value="Submit">
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
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.markAsRead', function(e) {
                    e.preventDefault();
                    const entryId = $(this).data('startupid');
                    $('#entry_id').val(entryId);
                    $('#notes').val('');
                    const row = $(this).closest('tr');
                    const name = row.find('td:nth-child(2)').text().trim();
                    const mobileNumber = row.find('td:nth-child(3)').text().trim();
                    const mobileCountryCode = row.find('td:nth-child(3)').data('country-code') || '';
                    const email = row.find('td:nth-child(4)').text().trim();

                    // Store the fetched data for use after submission
                    $('#markAsRead').data('name', name);
                    $('#markAsRead').data('mobileNumber', mobileNumber);
                    $('#markAsRead').data('email', email);
                    $('#markAsRead').data('mobileCountryCode', mobileCountryCode);
                    $('#markAsRead').modal('show');
                });

                $('#markAsReadForm').on('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    showSpinningLoader(true);

                    $.ajax({
                        url: '{{ route('admin.reports.cms.requestaccess.markAsRead') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            showSpinningLoader(false);
                            $('#markAsRead').modal('hide');
                            if (response.status === 1) {
                                showErrorMessage(response.message, "success");
                                $(`.markAsRead[data-startupid="${response.entry_id}"]`).closest(
                                    'tr').remove();
                                if (response.is_converted) {
                                    const name = $('#markAsRead').data('name');
                                    const mobileNumber = $('#markAsRead').data('mobileNumber');
                                    const email = $('#markAsRead').data('email');
                                    const mobileCountryCode = $('#markAsRead').data(
                                        'mobileCountryCode');

                                    // Redirect to the admin.investor.create route with query parameters
                                    const url =
                                        `{{ route('admin.investor.create') }}?name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&mobile_number=${encodeURIComponent(mobileNumber)}&mobile_country_code=${encodeURIComponent(mobileCountryCode)}&from_markasread=1`;
                                    window.location.href = url;
                                }
                            } else {
                                showErrorMessage("Failed to update the note.", "error");
                            }
                        },
                        error: function(xhr) {
                            showSpinningLoader(false);
                            console.error(xhr.responseText);
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let firstError = Object.values(errors)[0][
                                    0
                                ];
                                showErrorMessage(firstError, "error");
                            } else {
                                showErrorMessage("An unexpected error occurred. Please try again.",
                                    "error");
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</x-default-layout>
