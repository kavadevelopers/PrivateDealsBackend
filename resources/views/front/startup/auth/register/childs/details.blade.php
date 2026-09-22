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
                        <div class="steps step_active">
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
                            <h2>Startup Details</h2>
                            <p>Enter startup details</p>
                        </div>
                        <form action="#" id="startup-detail-form" method="post"
                            data-action="{{ route('front.raise.auth.post.register.details') }}">
                            @csrf
                            <div class="all_field">
                                <div class="group">

                                    <div class="field_group">
                                        <label>Brand Name <span class="required">*</span></label>
                                        <input required class="field" type="text" name="brand_name" value=""
                                            placeholder="Enter Brand Name">
                                        <i class="fa-solid fa-building input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label>Company Name (Legal Name) <span class="required">*</span></label>
                                        <input required class="field" type="text" name="company_name" value=""
                                            placeholder="Enter Company Name">
                                        <i class="fa-solid fa-building input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label>Sector <span class="required">*</span></label>
                                        <select class="select" name="sector_id" required>
                                            <option value="">-- Select --</option>
                                            @foreach (UtillsHelper::getSectors() as $kEy => $vAlUe)
                                                <option value="{{ $vAlUe->id }}">
                                                    {{ ucfirst($vAlUe->name) }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-city input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label>Email <span class="required">*</span></label>
                                        <input required class="field" type="email" name="email" value=""
                                            placeholder="Enter Email">
                                        <i class="fa-solid fa-envelope input_icon"></i>
                                    </div>
                                </div>

                                <div class="field_group">
                                    <label>Brief Description of Startup <span class="required">*</span></label>
                                    <textarea required class="big_field" name="brief_description" placeholder="Enter Brief Description of Startup"></textarea>
                                    <i class="fa-solid fa-circle-info input_icon"></i>
                                </div>

                                <div class="field_group">
                                    <label>Registered Address <span class="required">*</span></label>
                                    <textarea required class="big_field" name="registered_address" placeholder="Enter Registered Address"></textarea>
                                    <i class="fa-solid fa-location-dot input_icon"></i>
                                </div>

                                <div class="group">
                                    <div class="field_group">
                                        <label>City <span class="required">*</span></label>
                                        <select class="select" name="city_id" required>
                                            <option value="">-- Select --</option>
                                            @foreach (UtillsHelper::getCities() as $kEy => $vAlUe)
                                                <option value="{{ $vAlUe->id }}">
                                                    {{ ucfirst($vAlUe->name) }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-city input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label>DPIIT Number (Optional)</label>
                                        <input class="field" type="text" name="dpiit_number"
                                            placeholder="Enter DPIIT Number" value="">
                                        <i class="fa-solid fa-box-archive input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label>PAN of company (Optional)</label>
                                        <input class="field" type="text" name="company_pan" maxlength="10"
                                            minlength="10" placeholder="Enter PAN of company" value="">
                                        <i class="fa-solid fa-building input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label>CIN (Optional)</label>
                                        <input class="field" type="text" name="company_cin"
                                            placeholder="Enter CIN" value="">
                                        <i class="fa-solid fa-building input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label>Representative Name</label>
                                        <input class="field" type="text" name="representative_name"
                                            placeholder="Enter Representative Name" value="">
                                        <i class="fa-solid fa-desktop input_icon"></i>
                                    </div>

                                    <div class="field_group">
                                        <label>PAN of representative (Optional)</label>
                                        <input class="field" type="text" name="representative_pan"
                                            maxlength="10" minlength="10" placeholder="Enter PAN of representative"
                                            value="">
                                        <i class="fa-solid fa-building input_icon"></i>
                                    </div>

                                </div>
                                <div class="field_group">
                                    <label>Address of representative (Optional)</label>
                                    <textarea class="big_field" name="representative_address" placeholder="Enter Address of representative"></textarea>
                                    <i class="fa-solid fa-location-dot input_icon"></i>
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
