<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('cms.manage-info-icon.edit') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        @if (isset($item))
            <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
                <form class="form" method="POST"
                    action="{{ route('admin.cms.manage-info-icon.update', ['manage_info_icon' => $item->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">

                        <div class="card-header">
                            <div class="card-title">
                                <h2>Edit</h2>
                            </div>
                        </div>



                        <div class="card-body pt-0" data-select2-id="select2-data-128-idrh">
                            <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">

                                    <label class="required form-label">Title</label>



                                    <input name="title" class="form-control mb-2 input" placeholder="Enter Title"
                                        tabindex="0" type="text" value="{{ old('title', $item->title) }}">



                                    <div class="text-muted fs-7">Set the title of the manage-info-icon type.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>


                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">

                                    <label class="form-label">Sub Title</label>



                                    <input name="sub_title" class="form-control mb-2 input"
                                        placeholder="Enter Sub Title" tabindex="0" type="text"
                                        value="{{ old('sub_title', $item->sub_title) }}">



                                    <div class="text-muted fs-7">Set the sub title of the manage-info-icon type.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">

                                    <label class="form-label">Link Name</label>



                                    <input name="link_name" class="form-control mb-2 input" placeholder="Enter Link"
                                        tabindex="0" type="text" value="{{ old('link_name', $item->link_name) }}">



                                    <div class="text-muted fs-7">Set the link of the manage-info-icon type.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>


                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">

                                    <label class="form-label">Link</label>



                                    <input name="link" class="form-control mb-2 input" placeholder="Enter Link"
                                        tabindex="0" type="text" value="{{ old('link', $item->link) }}">



                                    <div class="text-muted fs-7">Set the link of the manage-info-icon type.</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">

                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">

                                    <label class="required form-label">Description</label>



                                    <textarea name="description" class="form-control mb-2 input" placeholder="Enter Description" tabindex="0"
                                        type="text">{{ old('description', $item->description) }}</textarea>



                                    <div class="text-muted fs-7">Set the description of the manage-info-icon type.
                                    </div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.cms.manage-info-icon.index') }}" class="btn btn-light me-5">
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
