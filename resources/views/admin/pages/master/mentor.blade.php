<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('master.mentor') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        @if (isset($item))
            <div class="w-100 flex-lg-row-auto w-lg-400px mb-7 me-7 me-lg-10">
                <form class="form" method="POST"
                    action="{{ route('admin.master.mentor.update', ['mentor' => $item->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">

                        <div class="card-header">
                            <div class="card-title">
                                <h2>Edit</h2>
                            </div>
                        </div>



                        <div class="card-body pt-0" data-select2-id="select2-data-128-idrh">
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Name</label>



                                    <input name="name" class="form-control mb-2 input" placeholder="Enter Name"
                                        tabindex="0" type="text" value="{{ old('name', $item->name) }}">



                                    <div class="text-muted fs-7">Set the name of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Mobile Number</label>



                                    <input name="mobile_no" class="form-control mb-2 input"
                                        placeholder="Enter Mobile Number" tabindex="0" type="tel"
                                        value="{{ old('mobile_no', $item->mobile_no) }}" pattern="\d{10}"
                                        maxlength="10">



                                    <div class="text-muted fs-7">Set the mobile number of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Email</label>



                                    <input name="email" class="form-control mb-2 input" placeholder="Enter Email"
                                        tabindex="0" type="email" value="{{ old('email', $item->email) }}">



                                    <div class="text-muted fs-7">Set the email of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Organization</label>



                                    <input name="organization" class="form-control mb-2 input"
                                        placeholder="Enter Organization" tabindex="0" type="text"
                                        value="{{ old('organization', $item->organization) }}">



                                    <div class="text-muted fs-7">Set the organization of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Designation</label>



                                    <input name="designation" class="form-control mb-2 input"
                                        placeholder="Enter Designation" tabindex="0" type="text"
                                        value="{{ old('designation', $item->designation) }}">



                                    <div class="text-muted fs-7">Set the designation of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Mentor Types</label>

                                    <select class="form-select" id="type" name="type" required
                                        aria-label="Select example">
                                        @foreach ($mentorTypes as $mentorType)
                                            <option value="{{ $mentorType->value }}"
                                                {{ old('type', $item->type) == $mentorType->value ? 'selected' : '' }}>
                                                {{ ucfirst($mentorType->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>


                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.master.mentor.index') }}" class="btn btn-light me-5">
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
                <form class="form" method="POST" action="{{ route('admin.master.mentor.store') }}">
                    @csrf

                    <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">

                        <div class="card-header">
                            <div class="card-title">
                                <h2>Create</h2>
                            </div>
                        </div>



                        <div class="card-body pt-0" data-select2-id="select2-data-128-idrh">
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Name</label>



                                    <input name="name" class="form-control mb-2 input" placeholder="Enter Name"
                                        tabindex="0" type="text" value="{{ old('name') }}">



                                    <div class="text-muted fs-7">Set the name of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Mobile Number</label>



                                    <input name="mobile_no" class="form-control mb-2 input"
                                        placeholder="Enter Mobile Number" tabindex="0" type="tel"
                                        value="{{ old('mobile_no') }}" pattern="\d{10}" maxlength="10">



                                    <div class="text-muted fs-7">Set the mobile number of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Email</label>



                                    <input name="email" class="form-control mb-2 input" placeholder="Enter Email"
                                        tabindex="0" type="email" value="{{ old('email') }}">



                                    <div class="text-muted fs-7">Set the email of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Organization</label>



                                    <input name="organization" class="form-control mb-2 input"
                                        placeholder="Enter Organization" tabindex="0" type="text"
                                        value="{{ old('organization') }}">



                                    <div class="text-muted fs-7">Set the organization of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Designation</label>



                                    <input name="designation" class="form-control mb-2 input"
                                        placeholder="Enter Designation" tabindex="0" type="text"
                                        value="{{ old('designation') }}">



                                    <div class="text-muted fs-7">Set the designation of the master mentor.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Mentor Types</label>

                                    <select class="form-select" id="type" name="type" required
                                        aria-label="Select example">
                                        <option value="">Select Mentor Type
                                        </option>
                                        @foreach ($mentorTypes as $mentorType)
                                            <option value="{{ $mentorType->value }}" {{ old('type') }}>
                                                {{ ucfirst($mentorType->value) }}
                                            </option>
                                        @endforeach
                                    </select>
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
                            <table id="kt_datatable_dom_positioning"
                                class="table table-striped table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Name</th>
                                        <th class="pe-7">Organization</th>
                                        <th class="pe-7">Designation</th>
                                        <th class="pe-7">Type</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ ucfirst($item->name) }}</td>
                                            <td>{{ ucfirst($item->organization) }}</td>
                                            <td>{{ ucfirst($item->designation) }}</td>
                                            <td>{{ ucfirst($item->type) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.master.mentor.edit', ['mentor' => $item->id]) }}"
                                                    class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1">
                                                    <i class="fas fa-pencil fs-6"></i>
                                                </a>
                                                <!-- Delete Form -->
                                                <form
                                                    action="{{ route('admin.master.mentor.destroy', ['mentor' => $item->id]) }}"
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
