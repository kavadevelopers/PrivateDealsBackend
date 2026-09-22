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
                </div>

                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_aadhar_pan"
                                class="table table-rounded table-striped border gy-2 gs-2">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                        <th>Investor Name</th>
                                        <th>Mobile Number</th>
                                        <th>Aadhar Number</th>
                                        <th>PAN Number</th>
                                        <th>Action</th>
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

    <!-- Approval Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve KYC Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="approveForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="temp_id" name="temp_id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="investor_name" class="form-label">Investor Name</label>
                                    <input type="text" class="form-control" id="investor_name" name="investor_name"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aadhar_no" class="form-label required">Aadhar Number</label>
                                    <input type="text" class="form-control" id="aadhar_no" name="aadhar_no" required>
                                    @include('admin.partials.form.input-error-message', ['key' => 'aadhar_no'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pan_no" class="form-label required">PAN Number</label>
                                    <input type="text" class="form-control" id="pan_no" name="pan_no" required>
                                    @include('admin.partials.form.input-error-message', ['key' => 'pan_no'])
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aadhar_name" class="form-label required">Aadhar Name</label>
                                    <input type="text" class="form-control" id="aadhar_name" name="aadhar_name"
                                        required>
                                    @include('admin.partials.form.input-error-message', ['key' => 'aadhar_name'])
                                </div>
                            </div> --}}
                        </div>

                        <div class="row">

                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pan_name" class="form-label required">PAN Name</label>
                                    <input type="text" class="form-control" id="pan_name" name="pan_name" required>
                                    @include('admin.partials.form.input-error-message', ['key' => 'pan_name'])
                                </div>
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dob" class="form-label required">Date of Birth</label>
                                    <input type="text" class="form-control flat-datepicker" id="dob" name="dob"
                                        placeholder="DD-MM-YYYY" required>
                                    @include('admin.partials.form.input-error-message', ['key' => 'dob'])
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label required">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"
                                        required></textarea>
                                    @include('admin.partials.form.input-error-message', ['key' => 'address'])
                                </div>
                            </div>
                        </div>

                        <div class="row">

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="aadhar_front_image" class="form-label">Aadhar Front Image</label>
                                    <input type="file" class="form-control" id="aadhar_front_image"
                                        name="aadhar_front_image" accept="image/*">
                                    @include('admin.partials.form.input-error-message', ['key' => 'aadhar_front_image'])
                                    <div class="mt-2" id="current_aadhar_front">
                                        <small class="text-muted">Current document:</small>
                                        <a href="#" target="_blank" id="current_aadhar_front_link"
                                            class="btn btn-sm btn-light-primary">
                                            <span>{!! getIcon('cloud-download', 'fs-6') !!}</span> Download Current
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="aadhar_back_image" class="form-label">Aadhar Back Image</label>
                                    <input type="file" class="form-control" id="aadhar_back_image"
                                        name="aadhar_back_image" accept="image/*">
                                    @include('admin.partials.form.input-error-message', ['key' => 'aadhar_back_image'])
                                    <div class="mt-2" id="current_aadhar_back">
                                        <small class="text-muted">Current document:</small>
                                        <a href="#" target="_blank" id="current_aadhar_back_link"
                                            class="btn btn-sm btn-light-primary">
                                            <span>{!! getIcon('cloud-download', 'fs-6') !!}</span> Download Current
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pan_image" class="form-label">PAN Image</label>
                                    <input type="file" class="form-control" id="pan_image" name="pan_image"
                                        accept="image/*">
                                    @include('admin.partials.form.input-error-message', ['key' => 'pan_image'])
                                    <div class="mt-2" id="current_pan">
                                        <small class="text-muted">Current document:</small>
                                        <a href="#" target="_blank" id="current_pan_link"
                                            class="btn btn-sm btn-light-primary">
                                            <span>{!! getIcon('cloud-download', 'fs-6') !!}</span> Download Current
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitApproval">
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            Approve KYC
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#kt_datatable_aadhar_pan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.investor.aadharPanVerification') }}",
                    type: 'GET'
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'mobile_number', name: 'mobile_number' },
                    { data: 'aadhar_no', name: 'aadhar_no' },
                    { data: 'pan_no', name: 'pan_no' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']],
                pageLength: 25,
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Handle approve button click
            $(document).on('click', '.approve-btn', function() {
                const tempId = $(this).data('id');
                
                // Clear previous form data
                $('#approveForm')[0].reset();
                
                // Set temp_id
                $('#temp_id').val(tempId);

                // Fetch temp data
                $.ajax({
                    url: "{{ route('admin.investor.getTempAadharPanDetails') }}",
                    type: 'POST',
                    data: {
                        id: tempId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 1) {
                            const data = response.data;
                            
                            // Populate form fields
                            $('#investor_name').val(data.investor_name);
                            // $('#aadhar_no').val(data.aadhar_no);
                            // $('#aadhar_name').val(data.aadhar_name);
                            // $('#pan_no').val(data.pan_no);
                            // $('#pan_name').val(data.pan_name);
                            // $('#dob').val(data.dob);
                            // $('#address').val(data.address);
                            
                            // Set current image links
                           if (data.aadhar_front) {
                                $('#current_aadhar_front_link').attr('href', data.aadhar_front);
                                $('#current_aadhar_front').show();
                            } else {
                                $('#current_aadhar_front').hide();
                            }
                            
                            if (data.aadhar_back) {
                                $('#current_aadhar_back_link').attr('href', data.aadhar_back);
                                $('#current_aadhar_back').show();
                            } else {
                                $('#current_aadhar_back').hide();
                            }
                            
                            if (data.pan) {
                                $('#current_pan_link').attr('href', data.pan);
                                $('#current_pan').show();
                            } else {
                                $('#current_pan').hide();
                            }
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to fetch data', 'error');
                    }
                });
            });

            // Handle form submission
            $('#approveForm').on('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = $('#submitApproval');
                const spinner = submitBtn.find('.spinner-border');
                
                // Show loading state
                submitBtn.prop('disabled', true);
                spinner.removeClass('d-none');
                
                const formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');
                
                $.ajax({
                    url: "{{ route('admin.investor.approveAadharPan') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status  === 1) {
                            Swal.fire('Success', response.message, 'success');
                            $('#approveModal').modal('hide');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'An error occurred';
                        Swal.fire('Error', errorMsg, 'error');
                    },
                    complete: function() {
                        // Hide loading state
                        submitBtn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });
        });
    </script>
    @endpush
</x-default-layout>