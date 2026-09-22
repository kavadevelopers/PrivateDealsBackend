<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('mis.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.startup.mis.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Create</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Title</label>
                                <input name="title" class="form-control mb-2" placeholder="Enter Title" tabindex="0"
                                    type="text" value="{{ old('title') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'title'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">MIS File</label>
                                <input name="document" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.pdf,.xlsx,.csv','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                <div class="text-muted fs-7">Select .pdf,.xlsx,.csv files please</div>
                                @include('admin.partials.form.input-error-message', ['key' => 'document'])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Description</label>
                                <textarea name="description" class="form-control mb-2" placeholder="Enter Description" tabindex="0" type="text">{{ old('description') }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'description',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Startup</label>
                                <select class="form-select" data-control="select2" data-placeholder="Select an option"
                                    name="startup_id" aria-label="Select example">
                                    <option value="">-- Select Startup --</option>
                                    @foreach ($startups as $startup)
                                        <option value="{{ $startup->id }}"
                                            {{ old('startup_id') == $startup->id ? 'selected' : '' }}>
                                            {{ $startup->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'startup_id',
                                ])
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
