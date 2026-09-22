<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('cms.pages.edit') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        @if (isset($item))
            <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
                <form class="form" method="POST" action="{{ route('admin.cms.pages.update', ['page' => $item->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">

                        <div class="card-header">
                            <div class="card-title">
                                <h2>Edit</h2>
                            </div>
                        </div>



                        <div class="card-body pt-0 w-lg-1200px" data-select2-id="select2-data-128-idrh">
                            <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">

                                    <label class="required form-label">Name</label>



                                    <input name="name" class="form-control mb-2 input" placeholder="Enter Name"
                                        tabindex="0" type="text" value="{{ old('name', $item->name) }}">



                                    <div class="text-muted fs-7">Set the name of the pages.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">

                                    <label class="form-label">Banner</label>



                                    <input name="banner" class="form-control mb-2 input" placeholder="Enter Banner"
                                        tabindex="0" type="file" value="{{ old('banner', $item->banner) }}">



                                    <div class="text-muted fs-7">Set the banner of the pages. size must be (2560w x
                                        891h)</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row fv-plugins-icon-container">

                                    <label class="required form-label">Description</label>



                                    <textarea name="description" class="form-control mb-2 input kt_docs_tinymce_basic" placeholder="Enter Description"
                                        tabindex="0" type="text">{{ old('description', $item->description) }}</textarea>



                                    <div class="text-muted fs-7">Set the description of the pages.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.cms.pages.index') }}" class="btn btn-light me-5">
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
        @endif
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
