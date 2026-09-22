<div class="register_steps reg_investor startup_register_step">
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
                            <h2>Startup Details</h2>
                            <p>Enter startup details</p>
                        </div>
                        <div class="form">
                            <form action="#" id="startup-registration-form" method="post"
                                data-action="{{ route('front.raise.auth.post.register.details') }}">
                                @csrf
                                <div class="all_field">
                                    <div class="group">
                                        <div class="field_group">
                                            <label>Company Name (Legal Name) <span class="required">*</span></label>
                                            <input class="field" type="text" name="company_name" value=""
                                                placeholder="Enter Company Name">
                                            <i class="fa-solid fa-building input_icon"></i>
                                        </div>

                                        <div class="field_group">
                                            <label>Brand Name <span class="required">*</span></label>
                                            <input class="field" type="text" name="brand_name" value=""
                                                placeholder="Enter Brand Name">
                                            <i class="fa-solid fa-building input_icon"></i>
                                        </div>

                                        <div class="field_group">
                                            <label>Brief Description of Startup <span class="required">*</span></label>
                                            <textarea class="big_field" name="brief_description" placeholder="Enter Brief Description of Startup"></textarea>
                                            <i class="fa-solid fa-circle-info input_icon"></i>
                                        </div>

                                        <div class="field_group">
                                            <label>Registered Address <span class="required">*</span></label>
                                            <textarea class="big_field" name="registered_address" placeholder="Enter Registered Address"></textarea>
                                            <i class="fa-solid fa-location-dot input_icon"></i>
                                        </div>
                                    </div>
                                    @livewire('country-city-dropdown')
                                    <div class="group">
                                        <div class="field_group">
                                            <label>Email <span class="required">*</span></label>
                                            <input class="field" type="text" name="email" value=""
                                                placeholder="Enter Email">
                                            <i class="fa-solid fa-envelope input_icon"></i>
                                        </div>
                                    </div>
                                    @livewire('industry-sector-dropdown')

                                </div>
                                <button type="submit" class="btn_custom reg_otp">Continue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
