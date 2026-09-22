<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection
    @section('breadcrumbs')
    {{ Breadcrumbs::render('cms.avtar.create') }}
    @endsection
    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST"
                action="{{ route('admin.startup.livepitch.update', ['livepitch' => $item->uuid]) }}"
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
                        <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <label class="form-label required">Title</label>
                                <input name="title" class="form-control mb-2 input" placeholder="Enter title"
                                    tabindex="0" type="text" value="{{ old('title', $item->title) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'title',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Startup</label>
                                <select class="form-select" data-control="select2" data-placeholder="Select Startup"
                                    name="startup_id" aria-label="Select example">
                                    <option value="">-- Select Startup --</option>
                                    @foreach ($startups as $startup)
                                    <option value="{{ $startup->id }}" {{ old('startup_id', $item->startup_id) ==
                                        $startup->id ? 'selected' : '' }}>
                                        {{ $startup->brand_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'startup_id',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Scheduled Date</label>
                                <input name="scheduled_date" class="form-control mb-2 input flat-datepicker"
                                    placeholder="Enter Date" tabindex="0" type="text"
                                    value="{{ old('scheduled_date', $item->scheduled_date) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'scheduled_date',
                                ])
                            </div>

                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control mb-2 " placeholder="Enter Description"
                                    tabindex="0" type="text">{{ old('description', $item->description) }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'description',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Meeting URl</label>
                                <input name="host_url" class="form-control mb-2" placeholder="Enter url" tabindex="0"
                                    type="text" value="{{ old('host_url', $item->host_url) }}" />
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'host_url',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Video URl</label>
                                <input name="video_url" class="form-control mb-2" placeholder="Enter url" tabindex="0"
                                    type="text" value="{{ old('video_url', $item->video_url) }}" />
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'video_url',
                                ])
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.startup.livepitch.index') }}" class="btn btn-light me-5">
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
    </div>
</x-default-layout>