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
                        <div class="steps step_active">
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
                             <h2>Fund Raise Details</h2>
                             <p>Enter fund raise details</p>
                         </div>
                         <div class="form">
                             <form action="#" id="startup-fund-detail-form" method="post"
                                 data-action="{{ route('front.raise.auth.post.register.funddetails') }}">
                                 @csrf
                                 <div class="all_field">
                                     <div class="group">
                                         <livewire:number-to-words name="fund_requirement" label="Fund Requirement"
                                             placeholder="Enter Fund Requirement" />

                                         <div class="field_group">
                                             <label>Committed Investors<span class="required">*</span></label>
                                             <input class="field" type="text" name="committed_investors"
                                                 placeholder="Enter Committed Investors"></input>
                                             <i class="fa-solid fa-building input_icon"></i>
                                         </div>
                                         <livewire:number-to-words name="pre_money_valuation"
                                             label="Pre Money Valuation" placeholder="Enter Pre Money Valuation" />
                                         <livewire:number-to-words name="current_fund_raise" label="Current Fund Raise"
                                             placeholder="Enter Current Fund Raise" />
                                     </div>
                                     <div class="group">
                                         <livewire:number-to-words name="funds_required_from_shuru"
                                             label="Funds Required From PrivateDeals" placeholder="Enter Funds Required" />

                                         <livewire:number-to-words name="min_ticket_size" label="Minimum Ticket Size"
                                             placeholder="Enter Minimum Ticket Size" />


                                         <div class="field_group">
                                             <label>Pre Money Valuation Basis<span class="required">*</span></label>
                                             <textarea class="big_field" type="text" name="pre_money_valuation_basis"
                                                 placeholder="Enter Pre Money Valuation Basis"></textarea>
                                             <i class="fa-solid fa-circle-info input_icon"></i>
                                         </div>

                                         <div class="field_group">
                                             <label>Instrument and Conversion Condition<span
                                                     class="required">*</span></label>
                                             <textarea class="big_field" name="instrument_and_conversion_condition"
                                                 placeholder="Enter Instrument and Conversion Condition"></textarea>
                                             <i class="fa-solid fa-circle-info input_icon"></i>
                                         </div>

                                         <div class="field_group">
                                             <label>Fund Utilisation Details<span class="required">*</span></label>
                                             <textarea class="big_field" type="text" name="fund_utilisation_details" value=""
                                                 placeholder="Enter Fund Utilisation Details"></textarea>
                                             <i class="fa-solid fa-circle-info input_icon"></i>
                                         </div>
                                     </div>
                                     <div class="group">
                                        <h3><span>Enter previous fund raise details</span></h3>
                                    </div>
                                    <div class="row" style="width: -webkit-fill-available;">
                                        {{-- <div class="col-sm-3">
                                            <div class="field_group">
                                                <label for="previous_raised_year">Year<span class="required">*</span></label>
                                                <input
                                                    class="field"
                                                    type="number"
                                                    name="previous_raised_year[]"
                                                    placeholder="Enter year"
                                                    required
                                                />
                                                <i class="fa fa-calendar input_icon"></i>
                                            </div>
                                        </div> --}}
                                        <div class="col-sm-3">
                                            <div class="field_group">
                                                <label for="prev_fund_raised_date">Raised Date:</label>
                                                <input class="field" type="date" name="prev_fund_raised_date" placeholder="Select date" />
                                                <i class="fa fa-calendar input_icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="field_group">
                                                <label for="prev_fund_raise_investor_name">Investor Name:</label>
                                                <input class="field" type="text" name="prev_fund_raise_investor_name" placeholder="Enter investor name" />
                                                <i class="fa fa-user input_icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="field_group">
                                                <label for="previous_fund_raised_amount">Previous Fund Raised Amount:</label>
                                                <input class="field" type="number" name="previous_fund_raised_amount" placeholder="Enter amount" />
                                                <i class="fa fa-inr input_icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="field_group">
                                                <label for="valuation_of_previous_round">Valuation of Previous Round:</label>
                                                <input class="field" type="number" name="valuation_of_previous_round" placeholder="Enter valuation" />
                                                <i class="fa fa-bar-chart input_icon"></i>
                                            </div>
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
 </div>
