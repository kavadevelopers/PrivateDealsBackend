<x-default-layout>

    @section('title')
    {{ getPageTitle() }}
    @endsection

    <div class="card card-flush py-4">

        <div class="card-header">
            <div class="card-title">
                <h2>Upload App Build</h2>
            </div>
        </div>

        <div class="card-body pt-0">

            <form method="POST" action="{{ route('admin.systemConfiguration.appbuild.store') }}"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <label class="form-label">Version <span class="text-muted"></span></label>
                    <input type="text" name="version" class="form-control" placeholder="shuruup 1.0.0"
                        value="{{ old('version') }}">
                </div>

                <div class="mb-5">
                    <label class="required form-label">Upload APK / AAB / IPA</label>
                    <input type="file" name="build" class="form-control" accept=".apk,.aab,.ipa">
                    <div class="text-muted mt-1">Max size: 500MB. Allowed: .apk, .aab, .ipa</div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.systemConfiguration.appbuild.list') }}"
                        class="btn btn-light me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>

            </form>

        </div>
    </div>

</x-default-layout>