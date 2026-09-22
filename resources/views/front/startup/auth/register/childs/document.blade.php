<div class="register_steps reg_investor startup_register_step">
    <div id="main">
        <div class="extra_section">
            <div class="container_custom">
                <div class="content bg_style">
                    <div class="steps_option">
                        <div class="steps">
                            <div class="icon">
                                <span class="fa fa-users"></span>
                            </div>
                            <div class="info">
                                <h3>Startup Details</h3>
                                <p>Add startup details</p>
                            </div>
                        </div>
                        <div class="steps">
                            <div class="icon">
                                <span class="fa fa-building"></span>
                            </div>
                            <div class="info">
                                <h3>Fund Raise Details</h3>
                                <p>Add Fund Raise Details</p>
                            </div>
                        </div>
                        <div class="steps">
                            <div class="icon">
                                <span class="fa fa-line-chart"></span>
                            </div>
                            <div class="info">
                                <h3>Startup Key Metrics</h3>
                                <p>Submit Key Metrics Details</p>
                            </div>
                        </div>
                        <div class="steps">
                           <div class="icon">
                               <span class="fa fa-wallet"></span>
                           </div>
                           <div class="info">
                               <h3>Financial Details</h3>
                               <p>Submit Financial Details</p>
                           </div>
                       </div>
                        <div class="steps">
                           <div class="icon">
                               <span class="fa fa-file"></span>
                           </div>
                           <div class="info">
                               <h3>Other Details</h3>
                               <p>Submit Other Details</p>
                           </div>
                       </div>
                        <div class="steps step_active">
                           <div class="icon">
                               <span class="fa fa-file"></span>
                           </div>
                           <div class="info">
                               <h3>Documents</h3>
                               <p>Submit Documents</p>
                           </div>
                       </div>
                    </div>
                    <div class="steps_content">
                        <div class="heading">
                            <h2>Documents</h2>
                            <p>Submit Your Documents</p>
                        </div>
                        <form class="" action="#" id="startup-document-detail-form" method="post" id="document-form"
                            data-action="{{ route('front.raise.auth.post.register.documents') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="all_field">
                                <div class="group">
                                    <div class="field_group">
                                        <label for="image">Pitch-deck (PDF) <span class="required">*</span></label>
                                        <input class="file" type="file" name="pitch_deck_file"
                                            onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')"
                                            required>
                                        <i class="fa-solid fa-file input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label for="image">Finacial Projections (PDF)</label>
                                        <input class="file" type="file" name="fina_projection"
                                            onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                        <i class="fa-solid fa-file input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label for="image">DD report(if available) (PDF)</label>
                                        <input class="file" type="file" name="dd_report"
                                            onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                        <i class="fa-solid fa-file input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label for="image">Valuation report (PDF)</label>
                                        <input class="file" type="file" name="vreport"
                                            onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                        <i class="fa-solid fa-file input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label for="image">DPIIT certificate (PDF)</label>
                                        <input class="file" type="file" name="dpiit_file"
                                            onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                        <i class="fa-solid fa-file input_icon"></i>
                                    </div>

                                    {{-- <div class="field_group">
                                        <label for="image">PrivateDeals Research Report (PDF)</label>
                                        <input class="file" type="file" name="pancard"
                                            onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                        <i class="fa-solid fa-file input_icon"></i>
                                    </div> --}}

                                    <div class="field_group">
                                        <label for="image">Long Banner</label>
                                        <input class="file" type="file" name="long_banner"
                                            onchange="fileExAllowedWithSize(this,'.jpg,.jpeg,.png','{{ CommonHelper::appSettings('file_video_max_size') }}')">
                                        <i class="fa-solid fa-video input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label for="image">Banner</label>
                                        <input class="file" type="file" name="banner"
                                            onchange="fileExAllowedWithSize(this,'.jpg,.jpeg,.png','{{ CommonHelper::appSettings('file_video_max_size') }}')">
                                        <i class="fa-solid fa-video input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label for="image">Logo</label>
                                        <input class="file" type="file" name="logo"
                                            onchange="fileExAllowedWithSize(this,'.jpg,.jpeg,.png','{{ CommonHelper::appSettings('file_video_max_size') }}')">
                                        <i class="fa-solid fa-video input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label for="image">Product Video (MKV, AVI, MP4)</label>
                                        <input class="file" type="file" name="product_video"
                                            onchange="fileExAllowedWithSize(this,'.mkv,.mp4,.avi','{{ CommonHelper::appSettings('file_video_max_size') }}')">
                                        <i class="fa-solid fa-video input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label for="image">Pitch Video (MKV, AVI, MP4)</label>
                                        <input class="file" type="file" name="pitch_video"
                                            onchange="fileExAllowedWithSize(this,'.mkv,.mp4,.avi','{{ CommonHelper::appSettings('file_video_max_size') }}')">
                                        <i class="fa-solid fa-video input_icon"></i>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn_custom reg_otp">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
