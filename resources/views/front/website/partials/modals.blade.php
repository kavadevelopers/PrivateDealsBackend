{{-- <div class="modal fade" id="inquiryVerifyModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Verify code</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-white">Verification Code <span
                                        class="required-label">*</span></label>
                                <input type="text" name="otp" class="form-control"
                                    placeholder="Enter Verification Code">
                                <input type="hidden" name="name">
                                <input type="hidden" name="mobile_number">
                                <input type="hidden" name="email">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" value="Verify & Send Inquiry"
                        id="resendInquiryOtp">Resend OTP</button>
                    <input type="submit" name="submitform" class="btn btn-primary" value="Verify & Send Inquiry">
                </div>
            </div>

        </form>
    </div>
</div> --}}


<div class="modal fade" id="inquiryModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="post">
            @csrf
            <input type="hidden" name="device" value="web">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Request Access</h1>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-white">Name <span class="required-label">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="text-white">Mobile Number <span class="required-label">*</span></label>
                            <input type="text" name="mobile_number" class="form-control"
                                placeholder="Enter Mobile Number">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-white">Email <span class="required-label">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-white">Firm Name </label>
                                <input type="firm_name" name="firm_name" class="form-control" placeholder="Enter Firm Name">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-10  col-sm-10 col-xs-10 col-10">
                            <div class="form-group">
                                <label class="text-white">Android Email</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Enter Android Email">
                            </div>
                        </div>
                        <div class="col-md-2  col-sm-2 col-xs-2 col-2">
                            <img src="{{ asset('website-assets/images/google-play.png') }}" alt="about us"
                                style="width: 40px; margin-top:32px;" />
                        </div>

                        <div class="col-md-10 col-sm-10 col-xs-10 col-10">
                            <div class="form-group">
                                <label class="text-white">Apple Email</label>
                                <input type="email" name="apple_email" class="form-control"
                                    placeholder="Enter Apple Email">
                            </div>
                        </div>
                        <div class="col-md-2  col-sm-2 col-xs-2 col-2">
                            <img src="{{ asset('website-assets/images/app-store.png') }}" alt="about us"
                                style="width: 40px; margin-top:32px;" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><b>Note : </b>Enter your email in the form above, and we’ll send you exclusive access
                                link to download the beta versions of our app for Android, iOS, and Windows. Get early
                                access to explore the latest features and experience the platform firsthand.</p>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="submitform" class="btn btn-primary" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="betaTestingModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Request Beta Access</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-white">Email <span class="required-label">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p><b>Note : </b>Enter your email in the form above, and we’ll send you exclusive access
                                link to download the beta versions of our app for Android, iOS, and Windows. Get early
                                access to explore the latest features and experience the platform firsthand.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="submitform" class="btn btn-primary" value="Send Request">
                </div>
            </div>
        </form>
    </div>
</div>
