<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('activeToday.list') }}
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
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Select Date</label>
                                    <form method="GET"

                                        action="{{ request()->routeIs('admin.reports.applogs.investor.*') ? route('admin.reports.applogs.investor.active-today.list') :route('admin.reports.applogs.distributer.active-today.list') }}">
                                        <input name="date" class="form-control mb-2 input flat-datepicker"
                                            placeholder="Enter Transaction Date" tabindex="0" type="text"
                                            value="{{ old('date', request()->date ?? date('d-m-Y')) }}">
                                        <button type="submit" class="btn btn-primary mt-2">Filter</button>
                                    </form>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'date',
                                    ])
                                </div>

                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">User</th>
                                        <th class="pe-7 text-center">Date</th>
                                        <th class="pe-7 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{ DateTimeHelper::formatDateTime($item->created_at, 'd M Y h:i A') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.reports.applogs.investor.active-today.view', ['userid' => $item->userid, 'usertype' => $item->usertype, 'date' => old('date', request()->date ?? date('d-m-Y'))]) }}"
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
