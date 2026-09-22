<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('cms.blog.create') }}
    @endsection
    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.cms.blog.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Create</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0" data-select2-id="select2-data-128-idrh">
                        <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <label class="form-label">Blog Type</label>
                                <select class="form-select" id="blog_type" name="blog_type" required
                                    aria-label="Select example" onchange="checkType(this)">
                                    <option value="1" {{ old('blog_type') == 1 ? 'selected' : '' }}>
                                        Blog</option>
                                    <option value="2" {{ old('blog_type') == 2 ? 'selected' : '' }}>
                                        Third-party Link</option>
                                    {{-- @foreach ($industries as $industry)
                                            <option value="{{ $industry->id }}"
                                                {{ old('industry_id', $item->industry_id) == $industry->id ? 'selected' : '' }}>
                                                {{ $industry->name }}
                                            </option>
                                        @endforeach --}}
                                </select>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <label class="required form-label">Title</label>
                                <input name="title" class="form-control mb-2 input" placeholder="Enter Title"
                                    tabindex="0" type="text" value="{{ old('title') }}">
                                <div class="text-muted fs-7">Set the title of the blog type.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <label class="required form-label">Short Description</label>
                                <input name="short_description" class="form-control mb-2 input"
                                    placeholder="Enter Short Description" tabindex="0" type="text"
                                    value="{{ old('short_description') }}">
                                <div class="text-muted fs-7">Set the short description of the blog type.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <label class="form-label required">Banner</label>
                                <input name="banner" class="form-control mb-2 input" placeholder="Enter Banner"
                                    tabindex="0" type="file" value="{{ old('banner') }}">
                                <div class="text-muted fs-7">Set the banner of the pages. size must be (2560w x
                                    891h)</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-label">Display Order</label>
                                <input name="display_order" class="form-control mb-2 input"
                                    placeholder="Enter Display Order" tabindex="0" type="text" min="1"
                                    maxlength="4" value="{{ old('display_order') }}">
                                <div class="text-muted fs-7">Set the display order of the master blog.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container" id="descContainer">
                                <label class="required form-label">Long Description</label>
                                <textarea id="long_description" name="long_description" class="form-control mb-2 input kt_docs_tinymce_basic"
                                    placeholder="Enter Description" tabindex="0" type="text">{{ old('long_description') }}</textarea>
                                <div class="text-muted fs-7">Set the long description of the blog type.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container" id="linkContainer">
                                <label class="required form-label">Thirdparty Url </label>
                                <textarea id="thirdparty_url" name="long_description" class="form-control mb-2 input" placeholder="Enter Description"
                                    tabindex="0" type="text">{{ old('long_description') }}</textarea>
                                <div class="text-muted fs-7">Set the thirdparty url of the blog type.</div>
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
    </div>
    <script type="text/javascript">
        state = false;

        function checkType(inp) {
            if (state) {
                $('#linkContainer textarea').val('');
                $('#descContainer textarea').val('');
            }
            state = true;
            $('#linkContainer').hide();
            $('#descContainer').hide();
            $('#linkContainer textarea').attr('name', '');
            $('#descContainer textarea').attr('name', '');
            if (inp.value == "1") {
                $('#descContainer textarea').attr('name', 'long_description');
                $('#descContainer').show();
            } else if (inp.value == "2") {
                $('#linkContainer textarea').attr('name', 'long_description');
                $('#linkContainer').show();
            }
        }
    </script>
    @push('scripts')
        <script>
            $(function() {
                $('#blog_type').trigger('change');
            })
        </script>
    @endpush
</x-default-layout>
