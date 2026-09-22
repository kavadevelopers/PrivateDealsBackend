<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('company-deals.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Company Deals</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.company-deals.create') }}" class="btn btn-sm btn-primary">
                            Create Deal
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th>Company</th>
                                        <th>Added By</th>
                                        <th>Type</th>
                                        <th>Available Qty</th>
                                        <th>Share Price</th>
                                        <th>Minimum Qty</th>
                                        <th>Processing Fee</th>
                                        <th>Hot</th>
                                        <th>Expires At</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            $("#kt_datatable_dom_positioning").DataTable({
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.company-deals.list') }}",
                    "type": "GET"
                },
                "columns": [
                    { "data": "company", "name": "company" },
                    { "data": "seller", "name": "seller", "orderable": false },
                    { "data": "deal_type", "name": "deal_type" },
                    { "data": "available_quantity", "name": "available_quantity" },
                    { "data": "share_price", "name": "share_price" },
                    { "data": "minimum_qty", "name": "minimum_qty" },
                    { "data": "processing_fee_percentage", "name": "processing_fee_percentage" },
                    { "data": "is_hot_deal", "name": "is_hot_deal", "orderable": false },
                    { "data": "expired_at", "name": "expired_at", "orderable": false },
                    { "data": "status", "name": "status", "orderable": false },
                    { "data": "action", "name": "action", "orderable": false, "searchable": false, "className": "text-center" }
                ],
                "order": [[0, 'asc']],
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
        });
    </script>
    @endpush
</x-default-layout>
