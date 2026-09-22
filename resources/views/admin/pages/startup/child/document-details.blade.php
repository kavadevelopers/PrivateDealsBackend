<div class="card mb-5 mb-xl-10" id="kt_uploaded_documents_view">
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Uploaded Documents</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body p-9">

        <div class="row">
            <div class="col-lg-4 mb-5">
                <div class="d-flex align-items-center">
                    <label class="col-lg-5 fw-semibold text-muted">Logo :</label>
                    <div class="col-lg-7">
                        <img src="{{ FileUpDownHelper::get_startup_document($startup->StartupDocumentOne->logo) }}"
                            alt="logo" class="img-fluid" style="max-width:50%; height: 50%;">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="d-flex align-items-center">
                    <label class="col-lg-5 fw-semibold text-muted">Banner :</label>
                    <div class="col-lg-7">
                        <img src="{{ FileUpDownHelper::get_startup_document($startup->StartupDocumentOne->banner) }}"
                            alt="banner" class="img-fluid" style="max-width:50%; height: 50%;">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="d-flex align-items-center">
                    <label class="col-lg-5 fw-semibold text-muted">Long Banner :</label>
                    <div class="col-lg-7">
                        <img src="{{ FileUpDownHelper::get_startup_document($startup->StartupDocumentOne->long_banner) }}"
                            alt="long banner" class="img-fluid" style="max-width:50%; height: 50%;">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="d-flex align-items-center">
                    <label class="col-lg-5 fw-semibold text-muted">Product Video :</label>
                    <div class="col-lg-7">
                        <div class="video">
                            <video class="card_video" src="{{ FileUpDownHelper::getStartupVideo($startup) }}"
                                poster="{{ FileUpDownHelper::getStartupBanner($startup) }}" controlsList="nodownload"
                                loop muted style="max-width:50%; height: 50%;"></video>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $files = [
                'DPIIT Startup Certificate' => $startup->StartupDocumentOne->dpiit_startup_certificate,
                'DD Report' => $startup->StartupDocumentOne->dd_report,
                'Valuation Report' => $startup->StartupDocumentOne->valuation_report,
                'DPIIT Certificate' => $startup->StartupDocumentOne->dpiit_certificate,
                'PrivateDeals Research Report' => $startup->StartupDocumentOne->shuruup_research_report,
                'Pitch Video' => $startup->StartupDocumentOne->pitch_deck_file,
            ];
        @endphp

        <div class="row">
            @foreach ($files as $label => $path)
                <div class="col-lg-4 mb-5">
                    <div class="d-flex align-items-center">
                        <label class="col-lg-5 fw-semibold text-muted">{{ $label }} :</label>
                        <div class="col-lg-7">
                            <div class="small_card card_custom">
                                @if ($path)
                                    <!-- Check if the path exists -->
                                    <a href="{{ route('download.web', ['path' => $path, 'name' => $label]) }}"
                                        class="btn-download">
                                        <i class="fa-solid fa-download"></i> <span>Download</span>
                                    </a>
                                @else
                                    <span class="text-muted">No file available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
