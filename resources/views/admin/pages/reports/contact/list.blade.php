<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('contact.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <button type="button" class="btn btn-danger btn-sm btn-flex d-none" id="btn_delete_selected">
                                <i class="fas fa-trash"></i> Delete Selected
                            </button>
                            <a href="{{ route('admin.reports.cms.contact.export') }}"
                                class="btn btn-primary btn-sm btn-flex">
                                <i class="fa fa-download"></i> Export
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="contact_list_table" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="w-25px text-center">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="check_all_contacts" />
                                            </div>
                                        </th>
                                        <th class="pe-7">Name</th>
                                        <th class="pe-7">Mobile No</th>
                                        <th class="pe-7">Subject</th>
                                        <th class="pe-7">Date and Time</th>
                                        <th class="text-center">Action</th>
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

    <div class="modal fade" id="contactDetailsModal" tabindex="-1" aria-labelledby="contactDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="contactDetailsModalLabel">Contact Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-row-dashed align-middle">
                            <tbody>
                                <tr>
                                    <th class="text-gray-600 w-200px">Name</th>
                                    <td id="detail_name">—</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600">Company</th>
                                    <td id="detail_company">—</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600">Email</th>
                                    <td id="detail_email">—</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600">Mobile No</th>
                                    <td id="detail_mobile_no">—</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600">Subject</th>
                                    <td id="detail_subject">—</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600">Description</th>
                                    <td id="detail_description">—</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600">User Type</th>
                                    <td id="detail_user_type">—</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600">Date and Time</th>
                                    <td id="detail_date_time">—</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let table;

        $(document).ready(function() {
            table = $("#contact_list_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.reports.cms.contact.list') }}",
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'name', name: 'firstname' },
                    { data: 'mobile_no', name: 'mobile_no' },
                    { data: 'subject', name: 'subject' },
                    { data: 'date_time', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[4, 'desc']],
                language: {
                    lengthMenu: "Show _MENU_",
                },
                dom: "<'row mb-2'" +
                    "<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                    ">" +
                    "<'table-responsive'tr>" +
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });

            table.on('draw.dt', function() {
                $('#check_all_contacts').prop('checked', false);
                toggleDeleteSelectedBtn();
            });

            $(document).on('change', '#check_all_contacts', function() {
                $('.contact-checkbox').prop('checked', $(this).prop('checked'));
                toggleDeleteSelectedBtn();
            });

            $(document).on('change', '.contact-checkbox', function() {
                const total = $('.contact-checkbox').length;
                const checked = $('.contact-checkbox:checked').length;
                $('#check_all_contacts').prop('checked', total > 0 && total === checked);
                toggleDeleteSelectedBtn();
            });

            function toggleDeleteSelectedBtn() {
                if ($('.contact-checkbox:checked').length > 0) {
                    $('#btn_delete_selected').removeClass('d-none');
                } else {
                    $('#btn_delete_selected').addClass('d-none');
                }
            }

            function getSelectedContactIds() {
                const ids = [];
                $('.contact-checkbox:checked').each(function() {
                    ids.push($(this).val());
                });
                return ids;
            }

            $('#btn_delete_selected').on('click', function() {
                const ids = getSelectedContactIds();
                if (ids.length === 0) {
                    return;
                }

                Swal.fire({
                    text: 'Are you sure you want to delete ' + ids.length + ' selected item(s)?',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return;
                    }

                    const btn = $('#btn_delete_selected');
                    btn.prop('disabled', true);

                    $.ajax({
                        url: "{{ route('admin.reports.cms.contact.bulk-delete') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: ids
                        },
                        success: function(response) {
                            if (response.status === 1) {
                                Swal.fire({
                                    text: response.message,
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: { confirmButton: 'btn btn-primary' }
                                });
                                $('#check_all_contacts').prop('checked', false);
                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire({
                                    text: response.message || 'Unable to delete',
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: { confirmButton: 'btn btn-primary' }
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                text: xhr.responseJSON?.message || 'Unable to delete',
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, got it!',
                                customClass: { confirmButton: 'btn btn-primary' }
                            });
                        },
                        complete: function() {
                            btn.prop('disabled', false);
                        }
                    });
                });
            });

            $(document).on('click', '.view-contact', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.reports.cms.contact.view', ['id' => '__ID__']) }}".replace('__ID__', id),
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 1) {
                            const data = response.data;
                            $('#detail_name').text(data.name);
                            $('#detail_company').text(data.company);
                            $('#detail_email').text(data.email);
                            $('#detail_mobile_no').text(data.mobile_no);
                            $('#detail_subject').text(data.subject);
                            $('#detail_description').html(nl2br(data.description));
                            $('#detail_user_type').text(data.user_type);
                            $('#detail_date_time').text(data.date_time);
                            $('#contactDetailsModal').modal('show');
                        } else {
                            Swal.fire({
                                text: response.message || 'Unable to load details',
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, got it!',
                                customClass: { confirmButton: 'btn btn-primary' }
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            text: xhr.responseJSON?.message || 'Unable to load details',
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, got it!',
                            customClass: { confirmButton: 'btn btn-primary' }
                        });
                    }
                });
            });

            $(document).on('click', '.delete-contact', function() {
                const id = $(this).data('id');

                Swal.fire({
                    text: 'Are you sure you want to delete this item?',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $.ajax({
                        url: "{{ route('admin.reports.cms.contact.delete', ['id' => '__ID__']) }}".replace('__ID__', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 1) {
                                Swal.fire({
                                    text: response.message,
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: { confirmButton: 'btn btn-primary' }
                                });
                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire({
                                    text: response.message || 'Unable to delete',
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: { confirmButton: 'btn btn-primary' }
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                text: xhr.responseJSON?.message || 'Unable to delete',
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, got it!',
                                customClass: { confirmButton: 'btn btn-primary' }
                            });
                        }
                    });
                });
            });
        });

        function nl2br(str) {
            if (!str || str === '—') {
                return '—';
            }
            return $('<div>').text(str).html().replace(/\n/g, '<br>');
        }
    </script>
    @endpush
</x-default-layout>
