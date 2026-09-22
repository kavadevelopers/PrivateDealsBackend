<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection
    @section('breadcrumbs')
    {{ Breadcrumbs::render('cms.avtar.create') }}
    @endsection
    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.systemConfiguration.apiclient.store') }}"
                enctype="multipart/form-data">
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
                                <label class="form-label required">Name</label>
                                <input name="name" class="form-control mb-2 input" placeholder="Enter name" tabindex="0"
                                    type="text" value="{{ old('name') }}">
                                <div class="text-muted fs-7">Set the name of the pages</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>

                        </div>
                        <div class="d-flex flex-column gap-10" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container" id="descContainer">
                                <label class=" form-label">Description</label>
                                <textarea name="description" class="form-control  input" placeholder="Enter Description"
                                    tabindex="0" type="text">{{ old('description') }}</textarea>
                                <div class="text-muted fs-7">Set the description of the client.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="fv-row fv-plugins-icon-container" id="descContainer">
                                <label class="required form-label">Allowed Domains</label>
                                <textarea name="allowed_domains" class="form-control  input"
                                    placeholder="Enter allowed_domains" tabindex="0"
                                    type="text">{{ old('allowed_domains') }}</textarea>
                                <div class="text-muted fs-7">Use * for server AI clients (no Origin). Domain list for browser sandbox.</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-label">Client type</label>
                                <select name="is_ai" class="form-select">
                                    <option value="0" @selected((string) old('is_ai', '0') === '0')>Normal (sandbox / external)</option>
                                    <option value="1" @selected((string) old('is_ai', '0') === '1')>AI AutoWork</option>
                                </select>
                                <div class="text-muted fs-7">AI clients can call all <code>/api/sandbox/ai/*</code> routes. Use allowed domains <code>*</code> for server AI.</div>
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
</x-default-layout>