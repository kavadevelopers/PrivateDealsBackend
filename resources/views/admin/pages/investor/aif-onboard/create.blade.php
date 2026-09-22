<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('investor.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.investor.manual-aif.save') }}"
                enctype="multipart/form-data">
                <input type="hidden" name="uuid" value="{{ $item->uuid }}">
                @csrf
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Documents</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">PPM PFD</label>
                                <input name="ppm" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'ppm',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">CA PDF</label>
                                <input name="ca" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'ca',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
