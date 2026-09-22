<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('cms.faqs') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        @if (isset($item))
        <div class="w-100 flex-lg-row-auto w-lg-400px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.cms.faqs.update', ['faq' => $item->uuid]) }}"
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
                        <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-label">Category</label>
                                <input name="category" class="form-control mb-2 input" placeholder="Enter Category"
                                    tabindex="0" type="text" value="{{ old('category',$item->category) }}">
                                <div class="text-muted fs-7">Set the category for FAQs.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="required form-label">Question</label>
                                <input name="question" class="form-control mb-2 input" placeholder="Enter Question"
                                    tabindex="0" type="text" value="{{ old('question', $item->question) }}">
                                <div class="text-muted fs-7">Set the question for FAQs.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="required form-label">Answer</label>
                                <input name="answer" class="form-control mb-2 input" placeholder="Enter Answer"
                                    tabindex="0" type="text" value="{{ old('answer', $item->answer) }}">
                                <div class="text-muted fs-7">Set the answer for FAQs.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-label">Display Order</label>
                                <input name="display_order" class="form-control mb-2 input"
                                    placeholder="Enter Display Order" tabindex="0" type="text" min="1" maxlength="4"
                                    value="{{ old('display_order', $item->display_order) }}">
                                <div class="text-muted fs-7">Set the display order for FAQs.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.cms.faqs.index') }}" class="btn btn-light me-5">
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
            <form class="form" method="POST" action="{{ route('admin.cms.faqs.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Create</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0" data-select2-id="select2-data-128-idrh">
                        <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-label">Category</label>
                                <input name="category" class="form-control mb-2 input" placeholder="Enter Category"
                                    tabindex="0" type="text"
                                    value="{{ old('category', isset($item) ? $item->category : '') }}">
                                <div class="text-muted fs-7">Set the category for FAQs.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="required form-label">Question</label>
                                <input name="question" class="form-control mb-2 input" placeholder="Enter Question"
                                    tabindex="0" type="text" value="{{ old('question') }}">
                                <div class="text-muted fs-7">Set the question for FAQs.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="required form-label">Answer</label>
                                <input name="answer" class="form-control mb-2 input" placeholder="Enter Answer"
                                    tabindex="0" type="text" value="{{ old('answer') }}">
                                <div class="text-muted fs-7">Set the answer for FAQs.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-label">Display Order</label>
                                <input name="display_order" class="form-control mb-2 input"
                                    placeholder="Enter Display Order" tabindex="0" type="text" min="1" maxlength="4"
                                    value="{{ old('display_order') }}">
                                <div class="text-muted fs-7">Set the display for FAQs.</div>
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
                                        <th class="pe-7">Questions</th>
                                        <th class="pe-7">Answer</th>
                                        <th class="pe-7">Category</th>
                                        <th class="pe-7">Display Order</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                    <tr>
                                        <td>{{ ucfirst($item->question) }}</td>
                                        <td>{{ ucfirst($item->answer) }}</td>
                                        <td>{{ $item->category ?? '-' }}</td>
                                        <td>{{ $item->display_order }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.cms.faqs.edit', ['faq' => $item->uuid]) }}"
                                                class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1">
                                                <i class="fas fa-pencil fs-6"></i>
                                            </a>
                                            <!-- Delete Form -->
                                            <form action="{{ route('admin.cms.faqs.destroy', ['faq' => $item->uuid]) }}"
                                                method="POST" style="display:inline;"
                                                id="delete-form-{{ $item->uuid }}">
                                                @csrf
                                                @method('DELETE')

                                                <!-- Delete Button -->
                                                <a href="#" class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->uuid }}').submit();">
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