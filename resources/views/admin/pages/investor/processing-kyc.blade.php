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
                <h2>Processing KYC (Manual Verification)</h2>
            </div>
        </div>

        <div class="card-body pt-0">

            <div class="table-responsive">

                <table id="processingKycTable" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">

                    <thead>
                        <tr class="fw-bold text-muted">
                            <th>Investor</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Document</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>

                </table>

            </div>
        </div>
    </div>

    @push('scripts')

    <script>
        $(document).ready(function () {

            $('#processingKycTable').DataTable({

            processing: true,
            serverSide: true,

            ajax: "{{ route('admin.investor.processing-kyc.data') }}",

            columns: [
            { data: 'investor_name', name: 'investor_name' },
            { data: 'mobile', name: 'mobile' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'document', name: 'document', orderable:false, searchable:false },
            { data: 'action', orderable:false, searchable:false }
            ],

            order: [[3,'desc']],

            drawCallback: function () {
                KTMenu.createInstances();
            }

            });

            });

            $(document).on("click",".manual-kyc-btn",function(e){

                e.preventDefault();

                let investorId=$(this).data('investor');

                $('#manualInvestorId').val(investorId);

                $('#manualKycModal').modal('show');

            });

           $(document).on("click",".reject-kyc-btn",function(e){

                e.preventDefault();

                let investorId = $(this).data('investor');

                $('#rejectInvestorId').val(investorId);

                let modal = new bootstrap.Modal(document.getElementById('rejectKycModal'));
                modal.show();

            });

    </script>

    @endpush

</x-default-layout>


<div class="modal fade" id="manualKycModal" tabindex="-1">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('admin.investor.manualKycSubmit') }}" method="POST">
            @csrf

            <input type="hidden" name="investor_id" id="manualInvestorId">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Manual KYC Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="d-flex flex-wrap gap-10 mb-5">

                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">DP ID</label>
                            <input type="text" name="dp_id" class="form-control" required>
                        </div>

                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Client ID</label>
                            <input type="text" name="client_id" class="form-control" required>
                        </div>

                    </div>


                    <div class="d-flex flex-wrap gap-10 mb-5">

                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">PAN Number</label>
                            <input type="text" name="pan_number" class="form-control" required>
                        </div>

                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Account Holder Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                    </div>


                    <div class="d-flex flex-wrap gap-10 mb-5">

                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Account Number</label>
                            <input type="text" name="account_number" class="form-control">
                        </div>

                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">IFSC Code</label>
                            <input type="text" name="ifsc_code" class="form-control">
                        </div>

                    </div>


                    <div class="d-flex flex-wrap gap-10 mb-5">

                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control">
                        </div>

                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Date of Birth</label>
                            <input type="text" name="dob" class="form-control" placeholder="dd-mm-yyyy">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Submit KYC
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

<div class="modal fade" id="rejectKycModal" tabindex="-1">
    <div class="modal-dialog">

        <form action="{{ route('admin.investor.manualKycReject') }}" method="POST">
            @csrf

            <input type="hidden" name="investor_id" id="rejectInvestorId">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Reject KYC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="fv-row w-100">
                        <label class="required form-label">Reason</label>
                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Reject KYC
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>