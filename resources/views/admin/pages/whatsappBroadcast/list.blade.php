<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('broadcast.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>WhatsApp Broadcast List</h2>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <div class="m-0">
                                <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Filter
                                </a>

                                <div class="menu menu-sub menu-sub-dropdown w-350px w-md-400px" data-kt-menu="true"
                                    id="filter-model">
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                    </div>
                                    <div class="separator border-gray-200"></div>

                                    <form method="GET" id="filterForm">
                                        <div class="px-7 py-5">
                                            <div class="d-flex flex-wrap gap-5 mb-5">
                                                <div class="fv-row w-100">
                                                    <label class="form-label fw-semibold">Template Name</label>
                                                    <input type="text" class="form-control form-control-solid"
                                                        name="template_filter" id="template_filter"
                                                        placeholder="Search template name">
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="reset"
                                                    class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                    onclick="resetFilters()">Reset</button>
                                                <button type="submit" class="btn btn-sm btn-primary">Apply
                                                    Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <a href="{{ route('admin.broadcast.whatsapp.create') }}" class="btn btn-sm btn-primary">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Create Broadcast
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="whatsapp_broadcast_table" class="table table-row-bordered gy-5 gs-7">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800">
                                    <th class="pe-7 text-center">#</th>
                                    <th class="pe-7">Template</th>
                                    <th class="pe-7 text-center">Recipients</th>
                                    <th class="pe-7 text-center">Pending</th>
                                    <th class="pe-7 text-center">Sent</th>
                                    <th class="pe-7 text-center">Delivered</th>
                                    <th class="pe-7 text-center">Seen</th>
                                    <th class="pe-7 text-center">Replied</th>
                                    <th class="pe-7 text-center">Failed</th>
                                    <th class="pe-7 text-center">Date</th>
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

    @push('scripts')
    <script>
        let table;
        
        $(document).ready(function() {
            table = $("#whatsapp_broadcast_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.broadcast.whatsapp.list') }}",
                    data: function(d) {
                        d.template_filter = $('#template_filter').val();
                    }
                },
                columns: [
                    { data: 'broadcast_info', name: 'broadcast_id', orderable: false, searchable: false },
                    { data: 'template_name', name: 'template_name' },
                    { data: 'recipients_count', name: 'recipients_count', className: 'text-center' },
                    { data: 'pending_count', name: 'pending_count', className: 'text-center' },
                    { data: 'sent_count', name: 'sent_count', className: 'text-center' },
                    { data: 'delivered_count', name: 'delivered_count', className: 'text-center' },
                    { data: 'seen_count', name: 'seen_count', className: 'text-center' },
                    { data: 'replied_count', name: 'replied_count', className: 'text-center' },
                    { data: 'failed_count', name: 'failed_count', className: 'text-center' },
                    { data: 'created_date', name: 'created_at', className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[9, 'desc']],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row mb-2'" +
                    "<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                    ">" +
                    "<'table-responsive'tr>" +
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });
            
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
                $('[data-kt-menu-trigger]').trigger('click');
            });
        });

        function resetFilters() {
            $('#filterForm')[0].reset();
            table.ajax.reload();
        }

        function handleResendSubmit(form, failedCount, templateName) {
            if (!confirm(`Are you sure you want to create a new broadcast for ${failedCount} failed messages from "${templateName}"?`)) {
                return false;
            }
            
            const submitBtn = form.querySelector('.resend-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin fs-6"></i>';
                submitBtn.title = 'Processing...';
            }
            
            return true;
        }

        function handleCancelSubmit(form, pendingCount, templateName) {
            if (!confirm(`Are you sure you want to cancel ${pendingCount} pending messages from "${templateName}"? This action cannot be undone.`)) {
                return false;
            }
            
            const submitBtn = form.querySelector('.cancel-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin fs-6"></i>';
                submitBtn.title = 'Cancelling...';
            }
            
            return true;
        }

        $(document).ajaxComplete(function(event, xhr, settings) {
            if (xhr.status === 200 && (settings.url.includes('cancel') || settings.url.includes('resend'))) {
                table.ajax.reload();
            }
        });
    </script>
    @endpush
</x-default-layout>