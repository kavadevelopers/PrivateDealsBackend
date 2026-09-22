<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('master.bank') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">


            <div class="card card-flush py-4">

                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.master.headertoken.create') }}" class="btn btn-sm btn-primary">
                            Generate Token
                        </a>
                    </div>
                </div>



                <div class="card-body pt-0">

                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Sr. no.</th>
                                        <th class="pe-7">Name</th>
                                        <th class="pe-7">Created At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->token }}</td>
                                            <td>{{ DateTimeHelper::viewDate($item->created_at) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.master.headertoken.delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-trash fs-6"></i>
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
</x-default-layout>
