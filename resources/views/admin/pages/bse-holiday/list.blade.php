<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('bse-holiday.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Holiday List</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.bse-holiday.create') }}" class="btn btn-sm btn-primary">
                            Create Holiday
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th>Image</th>
                                        <th>Holiday Date</th>
                                        <th>Holiday Name</th>
                                        <th>Type</th>
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
                        "url": "{{ route('admin.bse-holiday.list') }}",
                        "type": "GET",
                        "error": function(xhr, error, code) {
                           
                        }
                    },
                    "columns": [
                        { "data": "holiday_img", "name": "holiday_img", "orderable": false, "searchable": false },
                        { "data": "holiday_date", "name": "holiday_date" },
                        { "data": "holiday_name", "name": "holiday_name" },
                        { "data": "holiday_type", "name": "holiday_type", "orderable": false },
                        { "data": "is_active", "name": "is_active", "orderable": false },
                        { "data": "action", "name": "action", "orderable": false, "searchable": false, "className": "text-center" }
                    ],
                    "order": [[0, 'desc']],
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
                $("#kt_datatable_dom_positioning").on('draw.dt', function () {
                    $('img.lazy').each(function () {
                        $(this).attr('src', $(this).data('src'));
                    });
                });
            });
    </script>
    @endpush
</x-default-layout>