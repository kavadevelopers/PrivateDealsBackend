<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('findcml.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">

            <form class="form" method="POST" action="{{ route('admin.master.findcml.store') }}"
                enctype="multipart/form-data">
                @csrf

                <!-- Basic Details -->
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Basic Details</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">

                            <!-- Name -->
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Name</label>
                                <input name="name" class="form-control mb-2 input" placeholder="Enter Name" type="text"
                                    value="{{ old('name') }}">

                                @include('admin.partials.form.input-error-message', [
                                'key' => 'name',
                                ])
                            </div>

                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">

                            <!-- Logo -->
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Logo</label>
                                <input name="logo" class="form-control mb-2 input" type="file"
                                    onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')">

                                @include('admin.partials.form.input-error-message', [
                                'key' => 'logo',
                                ])
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Description</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="fv-row w-100 flex-md-root">
                            <textarea name="description" class="form-control mb-2 input kt_docs_tinymce_basic"
                                placeholder="Enter Description">{{ old('description') }}</textarea>

                            @include('admin.partials.form.input-error-message', [
                            'key' => 'description',
                            ])
                        </div>
                    </div>
                </div>

                <!-- Video -->
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Demo Video</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Upload Video</label>
                            <input name="video" class="form-control mb-2 input" type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_video_extensions_allowed') }}','{{ CommonHelper::appSettings('file_video_max_size') }}')">

                            @include('admin.partials.form.input-error-message', [
                            'key' => 'video',
                            ])
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.master.findcml.list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-default-layout>