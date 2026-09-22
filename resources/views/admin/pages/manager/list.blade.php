<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manager.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List Admin</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.manager.create') }}" class="btn btn-sm btn-primary">
                            Create
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Profile Photo</th>
                                        <th class="pe-7">Name</th>
                                        <th class="pe-7">Username</th>
                                        <th class="pe-7">Mobile</th>
                                        <th class="pe-7">Email</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px me-5">
                                                    <img class="shimmer lazy"
                                                        data-src="{{ FileUpDownHelper::subadmin_profile_photo_url($user->profile_photo) }}" />
                                                </div>
                                            </td>
                                            <td>{{ ucfirst($user->name) }}</td>
                                            <td>{{ ucfirst($user->username) }}</td>
                                            <td>{{ ucfirst($user->mobile_no) }}</td>
                                            <td>{{ ucfirst($user->email) }}</td>
                                            <td class="text-center">
                                                {{-- <a href="{{ route('admin.manager.view', ['uuid' => $user->uuid]) }}"
                                                    class="btn btn-info hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-eye fs-6"></i>
                                                </a> --}}

                                                <a href="{{ route('admin.manager.edit', ['uuid' => $user->uuid]) }}"
                                                    class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-pencil fs-6"></i>
                                                </a>



                                                <!-- Delete Form -->
                                                <form action="{{ route('admin.manager.destroy', ['id' => $user->id]) }}"
                                                    method="POST" style="display:inline;"
                                                    id="delete-form-{{ $user->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <!-- Delete Button -->
                                                    <a href="#"
                                                        class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                        <i class="fas fa-trash fs-6"></i>
                                                    </a>
                                                </form>
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
