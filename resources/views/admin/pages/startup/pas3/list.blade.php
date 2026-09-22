<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('pas3.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">
                        {{-- <a href="{{ route('admin.startup.manage.') }}" class="btn btn-sm btn-primary">
                            Create
                        </a> --}}
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Name</th>
                                        {{-- <th class="text-center">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ ucfirst($item->name) }}</td>
                                            {{-- <td class="text-center">
                                                <a href="{{ route('admin.investor.view', ['uuid' => $item->uuid]) }}"
                                                    class="btn btn-info hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-eye fs-6"></i>
                                                </a>
                                                <!-- Delete Form -->
                                                <form
                                                    action="{{ route('admin.investor.destroy', ['id' => $item->id]) }}"
                                                    method="POST" style="display:inline;"
                                                    id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <!-- Delete Button -->
                                                    <a href="#"
                                                        class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                        <i class="fas fa-trash fs-6"></i>
                                                    </a>
                                                </form>
                                                @if (($item->is_active == '0' || $item->is_active == '2') && $item->kyc_status == '1')
                                                    <a href="{{ route('admin.investor.activestatus', ['uuid' => $item->uuid, 'status' => '1']) }}"
                                                        class="btn btn-success hover-elevate-up btn-icon btn-sm me-1"
                                                        title="Approve Investor">
                                                        <i class="fas fa-check fs-6"></i>
                                                    </a>
                                                @endif
                                                @if (($item->is_active == '0' || $item->is_active == '1') && $item->kyc_status == '1')
                                                    <a href="{{ route('admin.investor.activestatus', ['uuid' => $item->uuid, 'status' => '2']) }}"
                                                        class="btn btn-warning hover-elevate-up btn-icon btn-sm me-1"
                                                        title="Reject Investor">
                                                        <i class="fas fa-times fs-6"></i>
                                                    </a>
                                                @endif
                                            </td> --}}
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
