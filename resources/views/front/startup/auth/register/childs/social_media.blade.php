<div class="register_steps reg_investor startup_register_step">
    <div id="main">
        <div class="extra_section">
            <div class="container_custom">
                <div class="content bg_style">
                    <div class="steps_option">
                        <div class="steps ">
                            <div class="icon">
                                <span class="fa fa-users"></span>
                            </div>
                            <div class="info">
                                <h3>Team Details</h3>
                                <p>Provide team details</p>
                            </div>
                        </div>
                        <div class="steps ">
                            <div class="icon">
                                <span class="fa fa-building"></span>
                            </div>
                            <div class="info">
                                <h3>Startup Details</h3>
                                <p>Add Startup Details</p>
                            </div>
                        </div>
                        <div class="steps ">
                            <div class="icon">
                                <span class="fa fa-file"></span>
                            </div>
                            <div class="info">
                                <h3>Documents</h3>
                                <p>Submit Documents</p>
                            </div>
                        </div>
                        <div class="steps step_active">
                            <div class="icon">
                                <span class="fa fa-share-nodes"></span>
                            </div>
                            <div class="info">
                                <h3>Social Media</h3>
                                <p>Add Social Link</p>
                            </div>
                        </div>
                    </div>
                    <div class="steps_content">
                        <div class="heading">
                            <h2>Social Media Links</h2>
                            <p>Add Social Media Links</p>
                        </div>
                        <form class="" action="#" method="post"
                            data-action="{{ route('front.raise.auth.post.register.socialmedia') }}"
                            id="startupsocialmedia" enctype="multipart/form-data">
                            @csrf
                            <div class="all_field">
                                <div style="width:100%; display: flex;-webkit-box-orient: vertical;-webkit-box-direction: normal;-ms-flex-direction: column;flex-direction: column;row-gap: 30px;"
                                    id="startup-social-media-links">
                                    <div class="member startup-social-media-link">
                                        <div class="member_head">
                                            {{-- <h3 class="title">Link 1</h3> --}}
                                            <!-- <button type="button" class="icon btn-removeOtherDoc"><i class="fa-solid fa-trash"></i></button> -->
                                        </div>
                                        <div class="member_body">
                                            <div class="group">
                                                <div class="field_group">
                                                    <label>Select Link Type <span class="required">*</span></label>
                                                    <select required class="select" name="socialtype[]">
                                                        <option value="">-- Select --</option>
                                                        @foreach (UtillsHelper::getSocialMediaType() as $key => $value)
                                                            <option value="{{ $value->id }}">{{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <i class="fa-solid fa-link input_icon"></i>
                                                </div>
                                                <div class="field_group">
                                                    <label>Link <span class="required">*</span></label>
                                                    <input required class="field" type="text" name="sociallink[]"
                                                        placeholder="Enter URL">
                                                    <i class="fa-solid fa-link input_icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="add_member btn_custom_line" type="button"
                                    id="btn-add-social-media-row"><i class="fa-solid fa-plus"></i> Add More
                                    Social Link</button>
                            </div>
                            <button type="submit" class="btn_custom reg_otp">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
