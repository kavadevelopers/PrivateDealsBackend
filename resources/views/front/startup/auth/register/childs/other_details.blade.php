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
                        <div class="steps step_active">
                           <div class="icon">
                               <span class="fa fa-file"></span>
                           </div>
                           <div class="info">
                               <h3>Other Details</h3>
                               <p>Submit Other Details</p>
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
                    </div>
                    <div class="steps_content">
                        <div class="heading">
                            <h2>Other Details</h2>
                            <p>Enter details</p>
                        </div>
                        <div class="form">
                            <form action="" id="other-details-form" method="post"
                                data-action="{{ route('front.raise.auth.post.register.otherdetails') }}">
                                @csrf
                                <div class="all_field">
                                    <div class="group">
                                        <div class="field_group">
                                            <label>Number of Founders<span class="required">*</span></label>
                                            <input required class="field" type="number" name="number_of_founders"
                                                placeholder="Enter Number of Founders">
                                            <i class="fa fa-users input_icon"></i>
                                        </div>
                                        <div class="field_group">
                                            <label>Name of Founder<span class="required">*</span></label>
                                            <input required class="field" type="text" name="name_of_founder"
                                                placeholder="Enter Name of Founder">
                                            <i class="fa fa-user input_icon"></i>
                                        </div>
                                        <div class="field_group">
                                            <label>Age<span class="required">*</span></label>
                                            <input required class="field" type="number" name="age"
                                                placeholder="Enter Age">
                                            <i class="fa fa-calendar input_icon"></i>
                                        </div>
                                        <div class="field_group">
                                            <label>Education Qualification<span class="required">*</span></label>
                                            <input required class="field" type="text" name="education_qualification"
                                                placeholder="Enter Education Qualification">
                                            <i class="fa fa-graduation-cap input_icon"></i>
                                        </div>
                                        <div class="field_group">
                                            <label>Pitch Deck<span class="required">*</span></label>
                                            <input required class="field" type="url" name="pitchdeck"
                                                placeholder="Enter Pitch Deck URL">
                                            <i class="fa fa-file input_icon"></i>
                                        </div>
                                        <div class="field_group">
                                            <label>Financial Model<span class="required">*</span></label>
                                            <input required class="field" type="url" name="financial_model"
                                                placeholder="Enter Financial Model URL">
                                            <i class="fa fa-file-excel input_icon"></i>
                                        </div>
                                        <div class="field_group">
                                            <label>Founder Email ID<span class="required">*</span></label>
                                            <input required class="field" type="email" name="founder_email_id"
                                                placeholder="Enter Founder Email ID">
                                            <i class="fa fa-envelope input_icon"></i>
                                        </div>
                                        <div class="field_group">
                                            <label>Founder Contact Number<span class="required">*</span></label>
                                            <input required class="field" type="tel" name="founder_contact_number"
                                                placeholder="Enter Founder Contact Number">
                                            <i class="fa fa-phone input_icon"></i>
                                        </div>
                                        <div class="field_group">
                                            <label>Work Experience<span class="required">*</span></label>
                                            <input required class="field" type="text" name="work_exps"
                                                placeholder="Enter Work Experience">
                                            {{-- <i class="fa fa-user input_icon"></i> --}}
                                        </div>
                                       
                                        <div class="field_group">
                                            <label>Startup Failures/Successful Exits<span class="required">*</span></label>
                                            <textarea required class="big_field" name="startup_failures_successful_exits"
                                                placeholder="Enter Startup Failures/Successful Exits"></textarea>
                                            <i class="fa fa-trophy input_icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn_custom reg_otp">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
