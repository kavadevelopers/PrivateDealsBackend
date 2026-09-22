<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('company.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.company.customDataSave') }}"
                enctype="multipart/form-data">
                @csrf

                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Import file</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Excel for custom data</label>
                                <input name="custom" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.xlsx,.xls','{{ CommonHelper::appSettings('file_image_max_size') }}')"
                                    required>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'custom',
                                ])
                                <p>
                                    <a href="{{ url('core/documents/OtherDataTemplate.xlsx') }}" download class="btn btn-light-primary btn-sm">
                                        <i class="fa-solid fa-download me-2"></i>
                                        Download empty template
                                    </a>
                                        
                                    <a href="{{ route('admin.company.financialsDownload', $company->uuid) }}" class="btn btn-light-primary btn-sm">
                                        <i class="fa-solid fa-download me-2"></i>Download Current Financials
                                    </a>
                                </p>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="fv-row w-100 flex-md-root ">
                                <input type="hidden" name="item" value="{{ $company->id }}">
                                <a href="{{ route('admin.company.list') }}" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                                    <span class="indicator-label">Import</span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

</x-default-layout>
