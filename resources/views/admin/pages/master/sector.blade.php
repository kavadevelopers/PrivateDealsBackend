<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('master.sector') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        @if (isset($item))
            <div class="w-100 flex-lg-row-auto w-lg-400px mb-7 me-7 me-lg-10">
                <form class="form" method="POST"
                    action="{{ route('admin.master.sector.update', ['sector' => $item->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">

                        <div class="card-header">
                            <div class="card-title">
                                <h2>Edit</h2>
                            </div>
                        </div>

                        <div class="card-body pt-0" data-select2-id="select2-data-128-idrh">
                            <div class="d-flex flex-column mb-5" data-select2-id="select2-data-127-fpwl">
                                <div class="fv-row fv-plugins-icon-container mb-5">
                                    <label class="required form-label">Industry</label>
                                    <select class="form-select" id="industry_id" name="industry_id" required
                                        aria-label="Select example">
                                        <option value="">-- Select
                                            industry --
                                        </option>
                                        @foreach ($industry as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ $item->industry_id == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-muted fs-7">Set the industry of the master sector.</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="required form-label">Name</label>
                                    <input name="name" class="form-control mb-2 input" placeholder="Enter Name"
                                        tabindex="0" type="text" value="{{ old('name', $item->name) }}">
                                    <div class="text-muted fs-7">Set the name of the sector type.</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                    <label class="form-label">Image</label>
                                    <input name="image" class="form-control mb-2 input" placeholder="Enter Image"
                                        tabindex="0" type="file">
                                    <div class="text-muted fs-7">Select Image size must be (150w x
                                        150h)</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="form-label">Display Order</label>
                                    <input name="display_order" class="form-control mb-2 input"
                                        placeholder="Enter Display Order" tabindex="0" type="text" min="1"
                                        maxlength="4" value="{{ old('display_order', $item->display_order) }}">
                                    <div class="text-muted fs-7">Set the display order of the master sector.</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.master.sector.index') }}" class="btn btn-light me-5">
                                    Cancel
                                </a>
                                <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        Update
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="w-100 flex-lg-row-auto w-lg-400px mb-7 me-7 me-lg-10">
                <form class="form" method="POST" action="{{ route('admin.master.sector.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Create</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column mb-5">
                                <div class="fv-row fv-plugins-icon-container mb-5">
                                    <label class="required form-label">Industry</label>
                                    <select class="form-select" id="industry_id" name="industry_id" required
                                        aria-label="Select example">
                                        <option value="">-- Select
                                            industry --
                                        </option>
                                        @foreach ($industry as $key => $value)
                                            <option value="{{ $value->id }}">
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-muted fs-7">Set the industry of the master sector.</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="required form-label">Name</label>
                                    <input name="name" class="form-control mb-2 input" placeholder="Enter Name"
                                        tabindex="0" type="text" value="{{ old('name') }}">
                                    <div class="text-muted fs-7">Set the name of the master sector.</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column mb-5">
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                    <label class="form-label">Image</label>
                                    <input name="image" class="form-control mb-2 input" placeholder="Enter Banner"
                                        tabindex="0" type="file">
                                    <div class="text-muted fs-7">Select Image size must be (150w x
                                        150h)</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="form-label">Display Order</label>
                                    <input name="display_order" class="form-control mb-2 input"
                                        placeholder="Enter Display Order" tabindex="0" type="text"
                                        min="1" maxlength="4" value="{{ old('display_order') }}">
                                    <div class="text-muted fs-7">Set the display order of the master sector.</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        Submit
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif
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
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Icon</th>
                                        <th class="pe-7">Name</th>
                                        <th class="pe-7">Display Order</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px me-5">
                                                    <img class="shimmer lazy"
                                                        data-src="{{ FileUpDownHelper::get_master_sector_url($item->icon_image) }}" />
                                                </div>
                                            </td>
                                            <td>{{ ucfirst($item->name) }}</td>
                                            <td>{{ $item->display_order }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.master.sector.edit', ['sector' => $item->id]) }}"
                                                    class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-pencil fs-6"></i>
                                                </a>
                                                <!-- Delete Form -->
                                                <form
                                                    action="{{ route('admin.master.sector.destroy', ['sector' => $item->id]) }}"
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
