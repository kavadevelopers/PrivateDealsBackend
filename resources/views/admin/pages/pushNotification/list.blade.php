<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('broadcast_notification.list') }}
    @endsection


    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.broadcast.pushNotification.create') }}" class="btn btn-sm btn-primary">
                            Create
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive" id="resourcebilling-table">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Image</th>
                                        <th class="pe-7">Title</th>
                                        <th class="pe-7 text-center">Body</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px symbol-2by3">
                                                    <img class="shimmer lazy"
                                                        data-src="{{ FileUpDownHelper::get_cms_avtar_url($item->image) }}" />
                                                </div>
                                            </td>
                                            <td>{{ ucfirst($item->title) }}</td>
                                            <td class="text-center">{{ $item->body }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.broadcast.whatsapp.view', ['item' => $item->id]) }}"
                                                    class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-eye fs-6"></i>
                                                </a>
                                            </td>
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
    @endpush

</x-default-layout>
