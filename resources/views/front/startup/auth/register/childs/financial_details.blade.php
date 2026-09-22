<body>
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
                            <div class="steps step_active">
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
                                <h2>Financial Details</h2>
                            </div>
                            <form action="#" id="startup-financial-detail-form" method="post"
                            data-action="{{ route('front.raise.auth.post.register.financialdetails') }}">
                            @csrf
                                <div class="all_field">
                                    <div class="group">
                                        <h3><span>Enter financial details for the current financial year</span></h3>
                                    </div>
                                    <div class="repeater" id="fund-raises" style="width: -webkit-fill-available;">
                                        <div class="repeater-item">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="previous_raised_year">Year<span class="required">*</span></label>
                                                        <input
                                                            class="field"
                                                            type="number"
                                                            name="previous_raised_year[]"
                                                            value="{{ date('Y') }}"
                                                        readonly
                                                            placeholder="Enter year"
                                                            required
                                                        />
                                                        <i class="fa fa-calendar input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="net_revenue">Net Revenue ({{ date('Y') }} - {{ date('Y') + 1 }})<span class="required">*</span></label>
                                                        <input
                                                            id="net_revenue"
                                                            class="field"
                                                            type="number"
                                                            name="net_revenue[]"
                                                            placeholder="Enter Net Revenue"
                                                            required
                                                        />
                                                        <i class="fa fa-money input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="ebitda">EBITDA ({{ date('Y') }} - {{ date('Y') + 1 }})<span class="required">*</span></label>
                                                        <input
                                                            id="ebitda"
                                                            class="field"
                                                            type="number"
                                                            name="ebitda[]"
                                                            placeholder="Enter EBITDA"
                                                            required
                                                        />
                                                        <i class="fa fa-line-chart input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="pat">PAT ({{ date('Y') }} - {{ date('Y') + 1 }})<span class="required">*</span></label>
                                                        <input
                                                            id="pat"
                                                            class="field"
                                                            type="number"
                                                            name="pat"
                                                            placeholder="Enter PAT"
                                                            required
                                                        />
                                                        <i class="fa fa-bar-chart input_icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="form-actions">
                                                        <button type="button" class="btn btn-danger remove-item">
                                                            <i class="fa fa-trash"></i> <!-- Bin icon for delete -->
                                                        </button>
                                                        <button type="button" class="btn btn-primary add-item">
                                                            <i class="fa fa-plus"></i> <!-- Plus icon for add -->
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <h3><span>Enter post fund raise financial details</span></h3>
                                    </div>
                                    <div class="repeater" id="post-fund-raises">
                                        <div class="repeater-item">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="post_raised_year">Year<span class="required">*</span></label>
                                                        <input
                                                            class="field"
                                                            type="number"
                                                            name="post_raised_year[]"
                                                            placeholder="Enter year"
                                                            value="{{ date('Y') }}"
                                                            readonly
                                                            required
                                                        />
                                                        <i class="fa fa-calendar input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="revenue_expected">Expected Revenue (in Rs Cr)<span class="required">*</span></label>
                                                        <input
                                                            id="revenue_expected"
                                                            class="field"
                                                            type="number"
                                                            name="revenue_expected[]"
                                                            placeholder="Enter revenue expected"
                                                            required
                                                        />
                                                        <i class="fa fa-line-chart input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="current_fy_closing_ebitda">Current FY closing EBITDA<span class="required">*</span></label>
                                                        <input
                                                            id="current_fy_closing_ebitda"
                                                            class="field"
                                                            type="number"
                                                            name="current_fy_closing_ebitda[]"
                                                            placeholder="Enter closing EBITDA"
                                                            required
                                                        />
                                                        <i class="fa fa-line-chart input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="current_fy_closing_pat">Current FY closing PAT<span class="required">*</span></label>
                                                        <input
                                                            id="current_fy_closing_pat"
                                                            class="field"
                                                            type="number"
                                                            name="current_fy_closing_pat[]"
                                                            placeholder="Enter closing PAT"
                                                            required
                                                        />
                                                        <i class="fa fa-bar-chart input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="next_fy_revenue">Next FY revenue<span class="required">*</span></label>
                                                        <input
                                                            id="next_fy_revenue"
                                                            class="field"
                                                            type="number"
                                                            name="next_fy_revenue[]"
                                                            placeholder="Enter next FY revenue"
                                                            required
                                                        />
                                                        <i class="fa fa-money input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="next_fy_expense">Next FY expense<span class="required">*</span></label>
                                                        <input
                                                            id="next_fy_expense"
                                                            class="field"
                                                            type="number"
                                                            name="next_fy_expense[]"
                                                            placeholder="Enter next FY expense"
                                                            required
                                                        />
                                                        <i class="fa fa-money input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="next_fy_ebitda">Next FY EBITDA<span class="required">*</span></label>
                                                        <input
                                                            id="next_fy_ebitda"
                                                            class="field"
                                                            type="number"
                                                            name="next_fy_ebitda[]"
                                                            placeholder="Enter next FY EBITDA"
                                                            required
                                                        />
                                                        <i class="fa fa-line-chart input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field_group">
                                                        <label for="next_fy_pat">Next FY PAT<span class="required">*</span></label>
                                                        <input
                                                            id="next_fy_pat"
                                                            class="field"
                                                            type="number"
                                                            name="next_fy_pat[]"
                                                            placeholder="Enter next FY PAT"
                                                            required
                                                        />
                                                        <i class="fa fa-bar-chart input_icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-actions">
                                                        <button type="button" class="btn btn-danger remove-item">
                                                            <i class="fa fa-trash"></i> <!-- Bin icon for delete -->
                                                        </button>
                                                        <button type="button" class="btn btn-primary add-item">
                                                            <i class="fa fa-plus"></i> <!-- Plus icon for add -->
                                                        </button>
                                                    </div>
                                                </div>
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

    <script>
        $(document).ready(function () {
            const formId = '#startup-financial-detail-form';
            const fundRaisesContainer = document.getElementById('fund-raises');
            const postFundRaisesContainer = document.getElementById('post-fund-raises');
        
            // Function to get the financial year for the repeater item
            function getFinancialYear(index, baseYear, increment) {
                return baseYear + (index * increment);
            }
        
            // Function to add a new repeater item
            function addRepeaterItem(container, type) {
                const currentItems = container.querySelectorAll('.repeater-item');
                const newItem = currentItems[0].cloneNode(true);
                const baseYear = new Date().getFullYear();
                const yearIncrement = type === 'previous' ? -1 : 1;
        
                // Update the year fields
                newItem.querySelectorAll('input[name$="year[]"]').forEach((input, index) => {
                    input.value = getFinancialYear(index + currentItems.length, baseYear, yearIncrement);
                });
        
                // Clear other fields
                newItem.querySelectorAll('input').forEach(input => {
                    if (!input.name.includes('year')) {
                        input.value = '';
                    }
                });
        
                container.appendChild(newItem);
            }
        
            // Function to remove a repeater item
            function removeRepeaterItem(event, container) {
                if (container.children.length > 1) {
                    event.target.closest('.repeater-item').remove();
                } else {
                    alert('At least one item is required.');
                }
            }
        
            // Event delegation for add and remove buttons
            $(document).on('click', `${formId} .add-item`, function (event) {
                const container = $(this).closest('.repeater')[0];
                if (container === fundRaisesContainer) {
                    addRepeaterItem(fundRaisesContainer, 'previous');
                } else if (container === postFundRaisesContainer) {
                    addRepeaterItem(postFundRaisesContainer, 'post');
                }
            });
        
            $(document).on('click', `${formId} .remove-item`, function (event) {
                const container = $(this).closest('.repeater')[0];
                if (container === fundRaisesContainer) {
                    removeRepeaterItem(event, fundRaisesContainer);
                } else if (container === postFundRaisesContainer) {
                    removeRepeaterItem(event, postFundRaisesContainer);
                }
            });
        
            // Initialize the year fields on page load
            function initializeYearFields() {
                const baseYear = new Date().getFullYear();
                
                $(formId).find('input[name="year[]"]').each((index, input) => {
                    input.value = getFinancialYear(index, baseYear, -1);
                });
        
                $(formId).find('input[name="post_raised_year[]"]').each((index, input) => {
                    input.value = getFinancialYear(index, baseYear, 1);
                });
            }
        
            initializeYearFields();
        });
        </script>
        
</body>
