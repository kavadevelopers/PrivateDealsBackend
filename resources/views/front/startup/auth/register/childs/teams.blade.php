<div class="startup_register_step register_steps reg_investor">
    <div id="main">
        <div class="extra_section">
            <div class="container_custom">
                <div class="content bg_style">
                    <div class="steps_option">
                        <div class="steps step_active">
                            <div class="icon">
                                <span class="fa fa-users"></span>
                            </div>
                            <div class="info">
                                <h3>Team Details</h3>
                                <p>Provide team details</p>
                            </div>
                        </div>
                        <div class="steps">
                            <div class="icon">
                                <span class="fa fa-building"></span>
                            </div>
                            <div class="info">
                                <h3>Startup Details</h3>
                                <p>Add Startup Details</p>
                            </div>
                        </div>
                        <div class="steps">
                            <div class="icon">
                                <span class="fa fa-file"></span>
                            </div>
                            <div class="info">
                                <h3>Documents</h3>
                                <p>Submit Documents</p>
                            </div>
                        </div>
                        <div class="steps">
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
                            <h2>Team Details</h2>
                            <p>Enter Your Team Details</p>
                        </div>
                        <form class="" action="" method="post" id="startupteamdetail"
                            enctype="multipart/form-data"
                            data-action="{{ route('front.raise.auth.post.register.team') }}">
                            @csrf
                            <div class="all_field">
                                <div style="width:100%; display: flex;-webkit-box-orient: vertical;-webkit-box-direction: normal;-ms-flex-direction: column;flex-direction: column;row-gap: 30px;"
                                    id="startup-team-blocks">
                                    <div class="member startup-team-item">
                                        {{-- <div class="member_head">
                                            <h3 class="title">Member 1</h3>
                                            <!-- <button class="icon btn-removeTeam"><i class="fa-solid fa-trash"></i></button> -->
                                        </div> --}}
                                        <div class="member_body">
                                            <div class="group">
                                                <div class="field_group">
                                                    <label>Name <span class="required">*</span></label>
                                                    <input class="field" type="text" name="teamname[]"
                                                        placeholder="Enter Name" required>
                                                    <i class="fa-solid fa-user input_icon"></i>
                                                </div>

                                                <div class="field_group">
                                                    <label><span>Photo <span class="required">*</span></span>
                                                        <span class="info">Photo Size Should Be (512 X 512 ,1024 X
                                                            1024)px</span></label>
                                                    <input class="file" type="file" name="teamphoto[]"
                                                        onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg','{{ CommonHelper::appSettings('file_image_max_size') }}')"
                                                        required>
                                                    <i class="fa-solid fa-image input_icon"></i>
                                                </div>



                                                <div class="field_group">
                                                    <label>Linkedin Link <span class="required">*</span></label>
                                                    <input class="field" type="text" name="linkedinlink[]"
                                                        placeholder="Enter LinkedIn Link" required>
                                                    <i class="fa-solid fa-link input_icon"></i>
                                                </div>

                                                <div class="field_group">
                                                    <label>Designation <span class="required">*</span></label>
                                                    <input class="field" type="text" name="teamdesignation[]"
                                                        placeholder="Enter Designation" required>
                                                    <i class="fa-solid fa-briefcase input_icon"></i>
                                                </div>
                                            </div>
                                            <div class="field_group">
                                                <label>Brief Introduction <span class="required">*</span></label>
                                                <textarea class="big_field" name="teaminfo[]" placeholder="Enter Brief Introduction" required></textarea>
                                                <i class="fa-solid fa-location-dot input_icon"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" name="teamid[]" value="">
                                    </div>
                                </div>
                                <button type="button" class="add_member btn_custom_line" id="startup-add-team-btn"><i
                                        class="fa-solid fa-plus"></i>
                                    Add Member</button>
                            </div>
                            <button type="submit" class="btn_custom">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
