<div class="card mb-5 mb-xl-10">
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">CMS</h3>
        </div>
        <div class="card-toolbar">
            <a href="#" class="btn btn-sm btn-primary edit-files-btn" data-startupid="{{ $startup->id }}">
                Edit
            </a>
        </div>
    </div>
    <div class="card-body p-9" id="startup-banner-data">
        @include('admin.pages.startup.child.child.files.banners')
    </div>
</div>


<div class="card mb-5 mb-xl-10">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Documents</h3>
        </div>
        <div class="card-toolbar">
            <a href="#" class="btn btn-sm btn-primary edit-files-btn" data-startupid="{{ $startup->id }}">
                Edit
            </a>
        </div>
    </div>
    <div class="card-body p-9" id="startup-document-data">
        @include('admin.pages.startup.child.child.files.documents')
    </div>
</div>


@push('scripts')
    <script>
        $(function() {
            $('.edit-files-btn').click(function(e) {
                e.preventDefault();
                $('#editStartupFiles form')[0].reset();
                $('#editStartupFiles input[name=startup_id]').val($(this).data('startupid'));
                $('#editStartupFiles').modal('show');
            });
            $('#editStartupFiles form').submit(function(e) {
                e.preventDefault();
                showSpinningLoader(true);
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.startup.updatecms') }}",
                    data: formData,
                    contentType: false, // Required for FormData
                    processData: false, // Prevent jQuery from automatically transforming the data
                    success: function(response) {
                        showSpinningLoader(false);
                        if (response.status) {
                            $('#editStartupFiles').modal('hide');
                            $('#startup-document-data').html(response.document);
                            $('#startup-banner-data').html(response.banner);
                            showErrorMessage("Data Uploaded", "success");
                        } else {
                            showErrorMessage(response.message, "error");
                        }
                    }
                });
            });


        })
    </script>
@endpush

<div class="modal fade" id="editStartupFiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="startup_id" name="startup_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle">Edit Files</h1>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Logo</label>
                            <input name="logo" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Banner</label>
                            <input name="banner" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Long Banner</label>
                            <input name="long_banner" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Product Video</label>
                            <input name="product_video" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_video_extensions_allowed') }}','{{ CommonHelper::appSettings('file_video_max_size') }}')">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Pitch Video</label>
                            <input name="pitch_video" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_video_extensions_allowed') }}','{{ CommonHelper::appSettings('file_video_max_size') }}')">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Pitch Deck</label>
                            <input name="pitch_deck" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Financial Projection</label>
                            <input name="financial_projection" class="form-control mb-2 input" tabindex="0"
                                type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_document_extensions_allowed') }}','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">DD Report</label>
                            <input name="dd_report" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_document_extensions_allowed') }}','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">DPIIT Certificate</label>
                            <input name="dpiit_report" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_document_extensions_allowed') }}','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">PrivateDeals Research Report</label>
                            <input name="shuruup_research_report" class="form-control mb-2 input" tabindex="0"
                                type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_document_extensions_allowed') }}','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                            <label class="form-label">Valuation Report</label>
                            <input name="valuation_report" class="form-control mb-2 input" tabindex="0"
                                type="file"
                                onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_document_extensions_allowed') }}','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="submitform" class="btn btn-primary" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
