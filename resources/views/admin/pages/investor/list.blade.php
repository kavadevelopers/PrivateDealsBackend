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
                        {{-- <a href="{{ route('admin.investor.create') }}" class="btn btn-sm btn-primary">
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
                                        <th class="pe-7">Profile Photo</th>
                                        <th class="pe-7">Types Of Investor</th>
                                        <th class="pe-7">Name</th>
                                        <th class="pe-7">Mobile Number</th>
                                        <th class="pe-7">Email</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px me-5">
                                                    <img class="shimmer lazy"
                                                        data-src="{{ FileUpDownHelper::get_investor_profile_photo_url($item) }}" />
                                                </div>
                                            </td>
                                            <td>{{ ucfirst($item->investor_type) }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->mobile_number }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td class="text-center">

                                                <div class="card-toolbar">
                                                    <button type="button"
                                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary show menu-dropdown"
                                                        data-kt-menu-trigger="click"
                                                        data-kt-menu-placement="bottom-end">
                                                        <i class="ki-duotone ki-category fs-6"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span></i>
                                                    </button>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                                        data-kt-menu="true" data-popper-placement="bottom-end">
                                                        <div class="menu-item px-3">
                                                            <div
                                                                class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                                                                Action</div>
                                                        </div>
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.investor.view', ['uuid' => $item->uuid]) }}"
                                                                class="menu-link px-3">
                                                                View
                                                            </a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.investor.edit', ['uuid' => $item->uuid]) }}"
                                                                class="menu-link px-3">
                                                                Edit
                                                            </a>
                                                        </div>
                                                        @if (!$item->kyc_status)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('admin.investor.manual-kyc.create', ['uuid' => $item->uuid]) }}"
                                                                    class="menu-link px-3">
                                                                    Complete KYC
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if (!$item->aif_status)
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('admin.investor.manual-aif.create', ['uuid' => $item->uuid]) }}"
                                                                    class="menu-link px-3">
                                                                    Complete AIF
                                                                </a>
                                                            </div>
                                                        @endif

                                                        @if (Auth::guard('admin')->user()->role == 'admin')
                                                            <div class="menu-item px-3">
                                                                <a href="#" class="menu-link px-3 edit-manager"
                                                                    data-investor="{{ $item->id }}"
                                                                    data-manager="{{ $item->created_by }}">
                                                                    Manager
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.investor.mark-demo', ['uuid' => $item->uuid]) }}"
                                                                class="menu-link px-3"
                                                                onclick="return confirm('Are you sure?')">
                                                                {{ $item->is_demo ? 'Mark as Live' : 'Mark as Demo' }}
                                                            </a>
                                                        </div>
                                                        @if (Auth::guard('admin')->user()->role == 'admin')
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('admin.investor.markBlock', ['uuid' => $item->uuid]) }}"
                                                                    class="menu-link px-3"
                                                                    onclick="return confirm('Are you sure?')">
                                                                    {{ $item->is_blocked ? 'Unblock' : 'Block' }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="separator mt-3 opacity-75"></div>
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content px-3 py-3">
                                                                {{-- <form
                                                                    action="{{ route('admin.investor.destroy', ['id' => $item->id]) }}"
                                                                    method="POST" style="display:inline;"
                                                                    id="delete-form-{{ $item->id }}">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <!-- Delete Button -->
                                                                    <a href="#" class="btn btn-danger btn-sm px-4"
                                                                        onclick="event.preventDefault(); 
                                                                        if (confirm('Are you sure you want to delete this item?')) {
                                                                            document.getElementById('delete-form-{{ $item->id }}').submit();
                                                                        }">
                                                                        <i class="fas fa-trash fs-6"></i> Delete
                                                                    </a>
                                                                </form> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if (($item->is_active == '0' || $item->is_active == '2') && $item->kyc_status == '1')
                                                    {{-- <a href="{{ route('admin.investor.activestatus', ['uuid' => $item->uuid, 'status' => '1']) }}"
                                                        class="btn btn-success hover-elevate-up btn-icon btn-sm me-1"
                                                        title="Approve Investor">
                                                        <i class="fas fa-check fs-6"></i>
                                                    </a> --}}
                                                @endif
                                                @if (($item->is_active == '0' || $item->is_active == '1') && $item->kyc_status == '1')
                                                    {{-- <a href="{{ route('admin.investor.activestatus', ['uuid' => $item->uuid, 'status' => '2']) }}"
                                                        class="btn btn-warning hover-elevate-up btn-icon btn-sm me-1"
                                                        title="Reject Investor">
                                                        <i class="fas fa-times fs-6"></i>
                                                    </a> --}}
                                                @endif
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


                $(document).on("click", ".edit-manager", function(event) {
                    event.preventDefault();
                    $('#editManagerModel select[name=manager_id]').val($(this).data('manager'));
                    $('#editManagerModel input[name=investor_id]').val($(this).data('investor'));
                    $('#editManagerModel').modal('show');
                });
            })
        </script>
    @endpush
</x-default-layout>
@if (Auth::guard('admin')->user()->role == 'admin')
    <div class="modal fade" id="editManagerModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.investor.manager') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="investor_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Manager</h1>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Select Manager</label>
                                <select class="form-select" name="manager_id" required>
                                    <option value="">-- Select Select Manager --</option>
                                    @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}">
                                            {{ ucfirst($manager->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="submitform" class="btn btn-primary" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
