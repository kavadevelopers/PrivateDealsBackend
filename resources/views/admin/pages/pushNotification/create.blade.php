<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('broadcast_notification.create') }}
    @endsection
    <style>
        textarea.autosize {
            field-sizing: content;
        }
    </style>

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" id="wpBroadcastForm" method="POST"
                action="{{ route('admin.broadcast.pushNotification.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="dynamic_urls" id="dynamicUrlsInput">
                <input type="hidden" name="variables" id="variablesInput">
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Select Template</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-label required">Title</label>
                                <input name="title" class="form-control mb-2 input" placeholder="Enter Title"
                                    tabindex="0" type="text" value="{{ old('title') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'title',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <label class="form-label required">Body</label>
                                <textarea id="key_information" name="body"
                                    class="form-control mb-2 input kt_docs_tinymce_basic" placeholder="Enter Body"
                                    tabindex="0">{{ old('body') }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'body',
                                ])
                            </div>

                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-label">Image</label>
                                <input name="image" class="form-control mb-2 input" placeholder="Enter Avtar"
                                    tabindex="0" type="file" value="{{ old('image') }}"
                                    onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}', 0.3)">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'image',
                                ])
                            </div>
                            <div class="fv-row fv-plugins-icon-container ">
                                <label class="required form-label">Send To</label>
                                <select class="form-select" name="send_to" aria-label="Select User To Send">
                                    <option value="">-- Select User To Send --</option>
                                    @foreach (App\Enums\SendToUserTypeEnum::cases() as $sendTo)
                                    <option value="{{ $sendTo->value }}" {{ old('send_to')===$sendTo->value ? 'selected'
                                        : '' }}>
                                        {{ ucfirst($sendTo->value) }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'send_to',
                                ])
                            </div>

                        </div>
                        <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">
                            <div id="topicInputDiv" class="mt-4 d-none">
                                <label class="form-label required">Topic</label>
                                <select name="topic" class="form-select" data-control="select2"
                                    data-placeholder="Select topic">
                                    <option value="">Select topic</option>
                                    <option value="guest_topic" {{ old('topic')=='guest_topic' ? 'selected' : '' }}>
                                        Guest Topic</option>
                                    <option value="inactive_users" {{ old('topic')=='inactive_users' ? 'selected' : ''
                                        }}>Inactive Users</option>
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'topic'])
                            </div>

                            <div class="fv-row w-100 flex-md-root d-none" id="access_type_div">
                                <label class="required form-label">Access Type</label>
                                <select class="form-select" name="access_type" id="access_type"
                                    aria-label="Select Access Type">
                                    <option value="all" {{ old('access_type')=='all' ? 'selected' : '' }}>All</option>
                                    <option value="startup" {{ old('access_type')=='startup' ? 'selected' : '' }}>
                                        Startup</option>
                                    <option value="preipo" {{ old('access_type')=='preipo' ? 'selected' : '' }}>Pre-IPO
                                    </option>
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'access_type'])
                            </div>

                            <div class="fv-row w-100 flex-md-root" id="redirect_to_div">
                                <label class="form-label">Redirect To</label>
                                <select class="form-select" name="redirect_to" id="redirect_to"
                                    aria-label="Select Redirect">
                                    <option value="">-- Select Redirect Option --</option>
                                    <option value="home/primary" {{ old('redirect_to')=='home/primary' ? 'selected' : ''
                                        }}>Startup Home</option>
                                    <option value="home/pre-ipo" {{ old('redirect_to')=='home/pre-ipo' ? 'selected' : ''
                                        }}>Pre-IPO Home</option>
                                    <option value="home/livepitch" {{ old('redirect_to')=='home/livepitch' ? 'selected'
                                        : '' }}>Live Pitch</option>
                                    <option value="home/primary/startupdetail" {{
                                        old('redirect_to')=='home/primary/startupdetail' ? 'selected' : '' }}>Specific
                                        Startup</option>
                                    <option value="home/pre-ipo/companydetail" {{
                                        old('redirect_to')=='home/pre-ipo/companydetail' ? 'selected' : '' }}>Specific
                                        Company</option>
                                    <option value="home/livepitch/detail" {{ old('redirect_to')=='home/livepitch/detail'
                                        ? 'selected' : '' }}>Specific Live Pitch </option>
                                    <option value="home/pre-ipo/news" {{ old('redirect_to')=='home/pre-ipo/news'
                                        ? 'selected' : '' }}>Specific News </option>
                                    <option value="home/pre-ipo/transactiondetail" {{
                                        old('redirect_to')=='home/pre-ipo/transactiondetail' ? 'selected' : '' }}>
                                        Specific Pre-IPO Transaction
                                    </option>
                                    <option value="home/kyc" {{ old('redirect_to')=='home/kyc' ? 'selected' : '' }}>
                                        KYC Page
                                    </option>
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'redirect_to'])
                            </div>

                            <div class="fv-row w-100 flex-md-root d-none" id="specific_startup_div">
                                <label class="required form-label">Select Startup</label>
                                <select class="form-select" name="specific_startup_id" id="specific_startup_id"
                                    aria-label="Select Startup">
                                    <option value="">-- Select Startup --</option>
                                    @foreach($startups as $startup)
                                    <option value="{{ $startup->id }}" {{ old('specific_startup_id')==$startup->id ?
                                        'selected' : '' }}>
                                        {{ $startup->brand_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'specific_startup_id'])
                            </div>

                            <div class="fv-row w-100 flex-md-root d-none" id="specific_company_div">
                                <label class="required form-label">Select Company</label>
                                <select class="form-select" name="specific_company_id" id="specific_company_id"
                                    aria-label="Select Company">
                                    <option value="">-- Select Company --</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('specific_company_id')==$company->id ?
                                        'selected' : '' }}>
                                        {{ $company->brand_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'specific_company_id'])
                            </div>

                            <div class="fv-row w-100 flex-md-root d-none" id="specific_livepitch_div">
                                <label class="required form-label">Select Pitch</label>
                                <select class="form-select" name="specific_pitch_id" id="specific_pitch_id"
                                    aria-label="Select Company">
                                    <option value="">-- Select Pitch --</option>
                                    @foreach($pitches as $pitch)
                                    <option value="{{ $pitch->id }}" {{ old('specific_pitch_id')==$pitch->id ?
                                        'selected' : '' }}>
                                        {{ $pitch->title }} {{ DateTimeHelper::formatDateTime($pitch->scheduled_date,
                                        'd-m-Y h:i A') }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'specific_pitch_id'])
                            </div>
                            <div class="fv-row w-100 flex-md-root d-none" id="specific_news_div">
                                <label class="required form-label">Select News</label>
                                <select class="form-select" name="specific_news_id" id="specific_news_id"
                                    aria-label="Select Company">
                                    <option value="">-- Select News --</option>
                                    @foreach($news as $new)
                                    <option value="{{ $new->id }}" {{ old('specific_news_id')==$new->id ? 'selected' :
                                        '' }}>
                                        {{ $new->title }} {{ DateTimeHelper::formatDateTime($new->created_at, 'd-m-Y h:i
                                        A') }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'specific_news_id'])
                            </div>
                            <div class="fv-row w-100 flex-md-root d-none" id="specific_preipo_transaction_div">
                                <label class="required form-label">Select Pre-IPO Transaction</label>
                                <select class="form-select" name="specific_preipo_transaction_id"
                                    id="specific_preipo_transaction_id" aria-label="Select Transaction">
                                    <option value="">-- Select Transaction --</option>
                                    @foreach($preipo_transactions as $transaction)
                                    <option value="{{ $transaction->id }}" {{
                                        old('specific_preipo_transaction_id')==$transaction->id ? 'selected' : '' }}>
                                        #{{ $transaction->transaction_invoice_no }} - {{
                                        $transaction->company->brand_name ?? 'N/A' }}
                                        ({{ DateTimeHelper::formatDateTime($transaction->created_at, 'd-m-Y') }})
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' =>
                                'specific_preipo_transaction_id'])
                            </div>
                        </div>
                    </div>
                </div>
                <div id="userDataSection" style="display: none;">
                    <div class="card mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Investors Data</span>
                            </h3>
                        </div>
                        <div class="card-body py-3" style="height: 500px;overflow-y: scroll">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="w-25px">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input checkAll" type="checkbox" value="1"
                                                        data-group-id="1">
                                                </div>
                                            </th>
                                            <th class="min-w-200px">Name</th>
                                            <th class="min-w-150px">Email</th>
                                            <th class="min-w-150px">Mobile Number</th>
                                            <th class="min-w-150px">Access</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($investors as $investor)
                                        <tr class="investor-row"
                                            data-startup="{{ ($investor->is_primary_access || $investor->is_secondary_access) ? 'true' : 'false' }}"
                                            data-preipo="{{ $investor->is_preipo_access ? 'true' : 'false' }}">
                                            <td>
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid ">
                                                    <input class="form-check-input checkSingle" data-group-id="1"
                                                        type="checkbox" value="{{ $investor->id }}"
                                                        name="selected_investors[]">
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-gray-900 fw-bold text-hover-primary fs-6">{{
                                                            $investor->name }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-900 fw-bold text-hover-primary fs-6">{{
                                                        $investor->email }}</span>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-900 fw-bold text-hover-primary fs-6">{{
                                                        $investor->mobile_number }}</span>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-900 fw-bold text-hover-primary fs-6">
                                                        @if($investor->is_primary_access ||
                                                        $investor->is_secondary_access)
                                                        <span class="badge badge-light-primary mb-1">Startup</span>
                                                        @endif
                                                        @if($investor->is_preipo_access)
                                                        <span class="badge badge-light-info">Pre-IPO</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Distributor Data</span>
                            </h3>
                        </div>
                        <div class="card-body py-3" style="height: 500px;overflow-y: scroll">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="w-25px">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input checkAll" type="checkbox" value="1"
                                                        data-group-id="2">
                                                </div>
                                            </th>
                                            <th class="min-w-200px">Name</th>
                                            <th class="min-w-150px">Email</th>
                                            <th class="min-w-150px">Mobile Number</th>
                                            <th class="min-w-150px">Access</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($partners as $partner)
                                        <tr class="partner-row"
                                            data-startup="{{ ($partner->is_primary_access || $partner->is_secondary_access) ? 'true' : 'false' }}"
                                            data-preipo="{{ $partner->is_preipo_access ? 'true' : 'false' }}">
                                            <td>
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid ">
                                                    <input class="form-check-input checkSingle" data-group-id="2"
                                                        type="checkbox" value="{{ $partner->id }}"
                                                        name="selected_partners[]">
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-gray-900 fw-bold text-hover-primary fs-6">{{
                                                            $partner->name }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-900 fw-bold text-hover-primary fs-6">{{
                                                        $partner->email }}</span>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-900 fw-bold text-hover-primary fs-6">{{
                                                        $partner->mobile_number }}</span>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-900 fw-bold text-hover-primary fs-6">
                                                        @if($partner->is_primary_access ||
                                                        $partner->is_secondary_access)
                                                        <span class="badge badge-light-primary mb-1">Startup</span>
                                                        @endif
                                                        @if($partner->is_preipo_access)
                                                        <span class="badge badge-light-info">Pre-IPO</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'selected_partners',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end" style="position: fixed; top: 100px; right: 30px;">
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress d-none">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
                const SendToUserTypeEnum = @json(array_column(\App\Enums\SendToUserTypeEnum::cases(), 'value', 'name'));
                
                function filterTableRows(accessType) {
                    if (!accessType || accessType === 'all') {
                        // Show all rows if no access type is selected or "all" is selected
                        $('.investor-row, .partner-row').show();
                        return;
                    }
                    
                    // Filter investor rows
                    $('.investor-row').each(function() {
                        const row = $(this);
                        const hasStartupAccess = row.data('startup') === true;
                        const hasPreipoAccess = row.data('preipo') === true;
                        
                        if (accessType === 'startup' && hasStartupAccess) {
                            row.show();
                        } else if (accessType === 'preipo' && hasPreipoAccess) {
                            row.show();
                        } else {
                            row.hide();
                            // Uncheck hidden checkboxes
                            row.find('input[type="checkbox"]').prop('checked', false);
                        }
                    });
                    
                    // Filter partner rows
                    $('.partner-row').each(function() {
                        const row = $(this);
                        const hasStartupAccess = row.data('startup') === true;
                        const hasPreipoAccess = row.data('preipo') === true;
                        
                        if (accessType === 'startup' && hasStartupAccess) {
                            row.show();
                        } else if (accessType === 'preipo' && hasPreipoAccess) {
                            row.show();
                        } else {
                            row.hide();
                            // Uncheck hidden checkboxes
                            row.find('input[type="checkbox"]').prop('checked', false);
                        }
                    });
                    
                    // Update "check all" checkboxes state
                    updateCheckAllState();
                }

                function updateCheckAllState() {
                    // Update investors check all
                    const visibleInvestorCheckboxes = $('.investor-row:visible .checkSingle[data-group-id="1"]');
                    const checkedInvestorCheckboxes = $('.investor-row:visible .checkSingle[data-group-id="1"]:checked');
                    $('.checkAll[data-group-id="1"]').prop('checked', 
                        visibleInvestorCheckboxes.length > 0 && visibleInvestorCheckboxes.length === checkedInvestorCheckboxes.length
                    );
                    
                    // Update partners check all
                    const visiblePartnerCheckboxes = $('.partner-row:visible .checkSingle[data-group-id="2"]');
                    const checkedPartnerCheckboxes = $('.partner-row:visible .checkSingle[data-group-id="2"]:checked');
                    $('.checkAll[data-group-id="2"]').prop('checked', 
                        visiblePartnerCheckboxes.length > 0 && visiblePartnerCheckboxes.length === checkedPartnerCheckboxes.length
                    );
                }

                function handleRedirectChange() {
                    const redirectValue = $('#redirect_to').val();
                    
                    // Hide all specific divs first
                    $('#specific_startup_div').addClass('d-none');
                    $('#specific_company_div').addClass('d-none');
                    $('#specific_livepitch_div').addClass('d-none');
                    $('#specific_news_div').addClass('d-none');
                    $('#specific_preipo_transaction_div').addClass('d-none');
                    
                    // Clear the select values
                    $('#specific_startup_id').val('');
                    $('#specific_startup_id').val('');
                    $('#specific_pitch_id').val('');
                    $('#specific_news_id').val('');
                    $('#specific_preipo_transaction_id').val('');
                    
                    // Show the appropriate div based on selection
                    if (redirectValue === 'home/primary/startupdetail') {
                        $('#specific_startup_div').removeClass('d-none');
                    } else if (redirectValue === 'home/pre-ipo/companydetail') {
                        $('#specific_company_div').removeClass('d-none');
                    } else if (redirectValue === 'home/livepitch/detail') {
                        $('#specific_livepitch_div').removeClass('d-none');
                    }
                    else if (redirectValue === 'home/pre-ipo/news') {
                        $('#specific_news_div').removeClass('d-none');
                    }
                    else if (redirectValue === 'home/pre-ipo/transactiondetail') {
                        $('#specific_preipo_transaction_div').removeClass('d-none');
                    }
                }




                $('#userDataSection').hide();
                $('#access_type_div').addClass('d-none');
                handleRedirectChange();
                const currentSelection = $('select[name="send_to"]').val();
                if (currentSelection === SendToUserTypeEnum.user) {
                    $('#userDataSection').show();
                    $('#access_type_div').removeClass('d-none');
                    $('#topicInputDiv').addClass('d-none');
                } else if (currentSelection === SendToUserTypeEnum.topic) {
                    $('#userDataSection').hide();
                    $('#topicInputDiv').removeClass('d-none');
                    $('#access_type_div').addClass('d-none');
                }
                
                $('select[name="send_to"]').on('change', function() {
                    let selected = $(this).val();
                    $('#access_type').val('all').trigger('change');
                    if (selected === SendToUserTypeEnum.user) {
                        $('#userDataSection').show();
                        $('#access_type_div').removeClass('d-none');
                        $('#topicInputDiv').addClass('d-none');
                        filterTableRows('all');
                    } else if (selected === SendToUserTypeEnum.topic) {
                        $('#userDataSection').hide();
                        $('#topicInputDiv').removeClass('d-none');
                        $('#access_type_div').addClass('d-none');
                    } else {
                        $('#userDataSection').hide();
                        $('#topicInputDiv').addClass('d-none');
                        $('#access_type_div').addClass('d-none');
                    }
                });

                $('#redirect_to').on('change', function() {
                    handleRedirectChange();
                });
                $('#access_type').on('change', function() {
                    const accessType = $(this).val();
                    filterTableRows(accessType);
                });
                
                // Handle check all functionality
                $(document).on('change', '.checkAll', function() {
                    const groupId = $(this).data('group-id');
                    const isChecked = $(this).prop('checked');
                    
                    if (groupId === 1) {
                        $('.investor-row:visible .checkSingle[data-group-id="1"]').prop('checked', isChecked);
                    } else if (groupId === 2) {
                        $('.partner-row:visible .checkSingle[data-group-id="2"]').prop('checked', isChecked);
                    }
                });
                
                // Handle individual checkbox change
                $(document).on('change', '.checkSingle', function() {
                    updateCheckAllState();
                });

                $(document).on('submit', '#wpBroadcastForm', function() {
                    const sendTo = $('select[name="send_to"]').val();
                    if (sendTo === SendToUserTypeEnum.user) {
                        const selectedInvestors = $('input[name="selected_investors[]"]:checked').length;
                        const selectedPartners = $('input[name="selected_partners[]"]:checked').length;
                        if (selectedInvestors === 0 && selectedPartners === 0) {
                            showErrorMessage('Please select at least one investor or partner', 'error');
                            return false;
                        }
                    } else if (sendTo === SendToUserTypeEnum.topic) {
                        const topicValue = $('select[name="topic"]').val().trim();
                        if (!topicValue) {
                            showErrorMessage('Topic is required when sending to a topic', 'error');
                            return false;
                        }
                    }
                    const $submitBtn = $('#kt_ecommerce_edit_order_submit');
                    $submitBtn.prop('disabled', true);
                    $submitBtn.find('.indicator-label').addClass('d-none');
                    $submitBtn.find('.indicator-progress').removeClass('d-none');
                    return true;
                });

                // $('input[name="image"]').on('change', function() {
                //     const fileInput = this;
                //     const maxSizeInBytes = 300 * 1024; // 300KB in bytes
                    
                //     if (fileInput.files && fileInput.files[0]) {
                //         const fileSize = fileInput.files[0].size;
                        
                //         if (fileSize > maxSizeInBytes) {
                //             $(this).val('');
                //             showErrorMessage('Image size exceeds 300KB limit. Please select a smaller image.', 'error');
                //             return false;
                //         }
                //     }
                // });
            });
    </script>
    @endpush
</x-default-layout>