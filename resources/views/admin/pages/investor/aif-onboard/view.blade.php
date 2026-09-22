<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img class="shimmer lazy"
                            data-src="{{ FileUpDownHelper::get_investor_profile_photo_url($investor) }}" />
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                        </div>
                    </div>
                </div>
                <!--end::Pic-->

                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $investor->name }}</a>
                                <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span
                                            class="path1"></span><span class="path2"></span></i></a>
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span><span
                                            class="path3"></span></i>{{ $investor->investor_type }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span></i> {{ $investor->city->name }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-sms fs-4"><span class="path1"></span><span
                                            class="path2"></span></i> {{ $investor->email }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                    <i class="ki-duotone ki-phone fs-4"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    +{{ $investor->mobile_country_code }}-{{ $investor->mobile_number }}
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->

                        <!--begin::Actions-->
                        <div class="d-flex my-4">
                            @if ($investor->aif_status == '0')
                                @if ($investor->aif && $investor->aif->status == 0)
                                    <a href="#" class="btn btn-sm btn-success me-3 btn-approve"
                                        data-aifid="{{ $investor->aif->id }}" data-status="2" data-bs-toggle="modal"
                                        data-bs-target="#approveModal">Approve</a>

                                    <a href="#" class="btn btn-sm btn-danger me-3 btn-approve"
                                        data-aifid="{{ $investor->aif->id }}" data-status="1" data-bs-toggle="modal"
                                        data-bs-target="#approveModal">Reject</a>
                                @endif
                            @endif
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->

                    <!--begin::Stats-->
                    <!-- Stats can be added here if needed -->
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home">
                        Basic Details </a>
                </li>
                @if ($investor->kyc)
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home2">
                            Aadhar Card Front </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home3">
                            Aadhar Card Back </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home4">
                            PAN Card </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home5">
                            Cheque </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home6">
                            CML/CMR </a>
                    </li>
                @endif
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home7">
                        Notes </a>
                </li> --}}
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            @include('admin.pages.investor.child.basic-details')
        </div>
        {{-- <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">

                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Notes</h3>
                    </div>
                    <!--end::Card title-->
                </div>



                <div class="card-body p-9">

                    <div class="row mb-7">

                        <label class="col-lg-4 fw-semibold text-muted">Notes</label>


                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $investor->name }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
            </div>
        </div> --}}
        @if ($investor->kyc)
            <div class="tab-pane fade" id="pills-home2" role="tabpanel" aria-labelledby="pills-profile-tab">
                <img class="image"
                    src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->aadhaar_front_image) }}"
                    alt="Investor Aadhar Front Photo" style="max-width: 100%; height: auto;" />
            </div>
            <div class="tab-pane fade" id="pills-home3" role="tabpanel" aria-labelledby="pills-contact-tab">
                <img class="image"
                    src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->aadhaar_back_image) }}"
                    alt="Investor Aadhar Back Photo" style="max-width: 100%; height: auto;" />
            </div>
            <div class="tab-pane fade" id="pills-home4" role="tabpanel" aria-labelledby="pills-contact-tab">
                <img class="image" src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->pan_image) }}"
                    alt="Investor PAN Photo" style="max-width: 100%; height: auto;" />
            </div>
            <div class="tab-pane fade" id="pills-home5" role="tabpanel" aria-labelledby="pills-contact-tab">
                <img class="image" src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->cheque_images) }}"
                    alt="Investor PAN Photo" style="max-width: 100%; height: auto;" />
            </div>
            <div class="tab-pane fade" id="pills-home6" role="tabpanel" aria-labelledby="pills-contact-tab">
                <img class="image" src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->cml_image) }}"
                    alt="Investor PAN Photo" style="max-width: 100%; height: auto;" />
            </div>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="approveForm" method="POST" action="{{ route('admin.aifonboard.approve') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModalLabel">AIF Onboard Status update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="aif_id" id="aif_id">
                        <input type="hidden" name="aif_status" id="aif_status">

                        <div class="mb-3 itemApprove">
                            <label for="ppmFile" class="form-label required">PPM PDF</label>
                            <input type="file" class="form-control" id="ppmFile" name="ppmFile"
                                onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                        </div>

                        <div class="mb-3 itemApprove">
                            <label for="caFile" class="form-label required">CA PDF</label>
                            <input type="file" class="form-control" id="caFile" name="caFile"
                                onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                        </div>

                        <div class="mb-3">
                            <label for="inputNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="inputNotes" name="notes" placeholder="Enter Notes if any"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                        </button>
                    </div>
            </form>
        </div>
    </div>
    </div>
    <!--end::Modal-->
    @push('scripts')
        <script>
            $(function() {
                $('.btn-approve').click(function() {
                    var aifId = $(this).data('aifid');
                    var status = $(this).data('status');
                    $('#aif_id').val(aifId);
                    $('#aif_status').val(status);
                    $('.itemApprove').show();
                    if (status == 1) {
                        $('.itemApprove').hide();
                        $('.itemApprove input').removeAttr('required');
                    }
                    if (status == 2) {
                        $('.itemApprove input').attr('required', 'required');
                    }
                    $('#approveModal').show();
                });
            })
            // document.addEventListener('DOMContentLoaded', function() {
            //     document.querySelectorAll('.btn-approve').forEach(button => {
            //         button.addEventListener('click', function() {
            //             var aifId = this.getAttribute('data-aifid');
            //             var status = this.getAttribute('data-status');
            //             document.getElementById('aif_id').value = aifId;
            //             document.getElementById('aif_status').value = status;
            //             if (status == 1) {
            //                 document.getElementById('aif_id').value = aifId;
            //             }
            //         });
            //     });
            // });
        </script>
    @endpush
</x-default-layout>
