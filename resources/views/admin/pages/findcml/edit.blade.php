<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('findcml.edit') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">

            <form method="POST" action="{{ route('admin.master.findcml.update', $item->uuid) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                                    value="{{ old('name', $item->name) }}">

                                @include('admin.partials.form.input-error-message', [
                                'key' => 'name',
                                ])
                            </div>

                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">

                            <!-- Logo -->
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Logo</label>

                                @if($item->logo)
                                <div class="mb-3">
                                    <img src="{{ FileUpDownHelper::get_findcml_logo_url($item->logo) }}"
                                        style="height:70px; border-radius:6px;" />
                                </div>
                                @endif

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
                                placeholder="Enter Description">{{ old('description', $item->description) }}</textarea>

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

                            @if(FileUpDownHelper::getFindCmlVideo($item))
                            <div class="mb-3">
                                <video width="220" controls style="border-radius:6px;">
                                    <source src="{{ FileUpDownHelper::getFindCmlVideo($item) }}">
                                </video>
                            </div>
                            @endif


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
                    <button type="submit" class="btn btn-primary" onclick="this.form.submit();">
                        <span class="indicator-label">Update</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-default-layout>