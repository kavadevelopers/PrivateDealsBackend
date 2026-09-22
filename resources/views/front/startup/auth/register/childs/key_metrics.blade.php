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
                        <div class="steps step_active">
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
                              <h2>Key metrics Details</h2>
                              <p>Enter details</p>
                          </div>
                          <div class="form">
                              <form action="" id="startup-key-metrics-form" method="post"
                                  data-action="{{ route('front.raise.auth.post.register.keymetrics') }}">
                                  @csrf
                                  <div class="all_field">
                                      <div class="group">
                                          <livewire:number-to-words name="founder_capital_contribution"
                                              label="Founder Capital Contribution"
                                              placeholder="Enter Founder Capital Contribution" />
                                          <livewire:number-to-words name="monthly_revenue_run_rate"
                                              label="Monthly Revenue Run Rate"
                                              placeholder="Enter Monthly Revenue Run Rate" />
                                          <livewire:number-to-words name="annualized_revenue_run_rate"
                                              label="Annualized Revenue Run Rate"
                                              placeholder="Enter Annualized Revenue Run Rate" />
                                          <livewire:number-to-words name="current_monthly_burn"
                                              label="Current Monthly Burn" placeholder="Enter Current Monthly Burn" />
                                          <livewire:number-to-words name="current_cash_balance"
                                              label="Current Cash Balance" placeholder="Enter Current Cash Balance" />

                                          <div class="field_group">
                                              <label>Runway Months<span class="required">*</span></label>
                                              <input required class="field" type="text" name="runway_months"
                                                  placeholder="Enter Runway Months">
                                              <i class="fa-solid fa-building input_icon"></i>
                                          </div>

                                          <div class="field_group">
                                              <label>Traction Metrics<span class="required">*</span></label>
                                              <textarea required class="big_field" type="text" name="traction_metrics" placeholder="Enter Traction Metrics"></textarea>
                                              <i class="fa-solid fa-circle-info input_icon"></i>
                                          </div>
                                          <div class="field_group">
                                              <label>Key USP Differentiator Entry Barrier<span
                                                      class="required">*</span></label>
                                              <textarea required class="big_field" type="text" name="key_usp_differentiator_entry_barrier"
                                                  placeholder="Enter Key USP Differentiator Entry Barrier"></textarea>
                                              <i class="fa-solid fa-circle-info input_icon"></i>
                                          </div>
                                          <div class="field_group">
                                              <label>Competitors<span class="required">*</span></label>
                                              <input required class="field" type="text" name="competitors"
                                                  placeholder="Enter Competitors">
                                              <i class="fa-solid fa-building input_icon"></i>
                                          </div>
                                      </div>
                                  </div>
                                  <button type="submit" class="btn_custom reg_otp">Continue</button>
                                  {{-- <button type="submit" class="btn_custom reg_otp">Submit</button> --}}
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
