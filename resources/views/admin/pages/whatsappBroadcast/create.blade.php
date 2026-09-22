<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('broadcast.create') }}
    @endsection
    <style>
        textarea.autosize {
            field-sizing: content;
        }

        .no-data-row {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
        }
    </style>

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" id="wpBroadcastForm" method="POST" action="{{ route('admin.broadcast.whatsapp.store') }}"
                enctype="multipart/form-data">
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
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">User Type</label>
                                <select class="form-select" name="user_type" id="user_type"
                                    aria-label="Select User Type" required>
                                    <option value="existing">Existing Users</option>
                                    <option value="guest">Guest Users</option>
                                </select>
                            </div>
                            <div class="fv-row w-100 flex-md-root" id="access_type_div">
                                <label class="required form-label">Access Type</label>
                                <select class="form-select" name="access_type" id="access_type"
                                    aria-label="Select Access Type">
                                    <option value="all">All</option>
                                    <option value="startup">Startup</option>
                                    <option value="preipo">Pre-IPO</option>
                                </select>
                            </div>
                            <div class="fv-row w-100 flex-md-root" id="startup-select-div" style="display: none;">
                                <label class="form-label">Startup</label>
                                <select class="form-select" name="selected_startup" id="startup-select"
                                    aria-label="Select Startup">
                                    <option value="">-- All Startups --</option>
                                    @foreach($startups as $startup)
                                    <option value="{{ $startup->id }}">{{ $startup->brand_name }}</option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'selected_startup'])
                            </div>

                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Template Name</label>
                                <select class="form-select" name="template_name" aria-label="Select Template Name"
                                    required>
                                    <option value="">-- Select Template Name --</option>
                                    @foreach ($templates as $template)
                                    <option value="{{ $template['name'] }}"
                                        data-template-text="{{ json_encode($template) }}" {{
                                        old('template_name')==$template['name'] ? 'selected' : '' }}>
                                        {{ $template['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'template_name',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root" id="uploadHeaderDiv" style="display: none;">
                                <label class="required form-label">Upload Header File</label>
                                <input name="header_file" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'*','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'header_file',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Template Data</label>
                                <textarea name="template_data" class="form-control mb-2 autosize" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-5" style="display: none;">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Variables</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="dynamicVariablesFields" class="d-flex flex-column gap-3 mb-5">

                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-5" style="display: none;">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Dynamic URL's</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="card-block" id="dynamic-btns">

                        </div>
                    </div>
                </div>

                <div id="existing_user_section">
                    <div class="card mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Investors Data</span>
                            </h3>
                        </div>
                        <div class="card-body py-3" style="height: 500px;overflow-y: scroll">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                                    id="investors-table">
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
                                        <tr data-startup="{{ ($investor->is_primary_access || $investor->is_secondary_access) ? 'true' : 'false' }}"
                                            data-preipo="{{ $investor->is_preipo_access ? 'true' : 'false' }}"
                                            data-startup-all="true">

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
                                        <tr id="investors-no-data" class="no-data-found" style="display: none;">
                                            <td colspan="5" class="no-data-row">
                                                <div class="d-flex flex-column align-items-center py-5">
                                                    <i class="fas fa-users fs-2x text-muted mb-3"></i>
                                                    <span class="fs-5 fw-semibold text-muted">No investors found with
                                                        selected access type</span>
                                                </div>
                                            </td>
                                        </tr>
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
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                                    id="partners-table">
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
                                        <tr data-startup="{{ $partner->is_primary_access || $partner->is_secondary_access ? 'true' : 'false' }}"
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
                                        <tr id="partners-no-data" class="no-data-found" style="display: none;">
                                            <td colspan="5" class="no-data-row">
                                                <div class="d-flex flex-column align-items-center py-5">
                                                    <i class="fas fa-handshake fs-2x text-muted mb-3"></i>
                                                    <span class="fs-5 fw-semibold text-muted">No partners found with
                                                        selected access type</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'selected_partners',
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div id="guest_upload_section" style="display: none;">
                    <div class="card mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Guest Users Data</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <div class="mb-5">
                                <label for="guest_excel" class="form-label">Upload Guest Excel File</label>
                                <input type="file" name="guest_excel" id="guest_excel" class="form-control"
                                    accept=".xlsx,.xls">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'guest_excel',
                                ])
                            </div>

                            {{-- <div class="mb-3">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="register_guest"
                                        name="register_guest" value="1">
                                    <label class="form-check-label" for="register_guest">
                                        Register
                                    </label>
                                </div>
                            </div> --}}
                            <div class="mb-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" id="register_guest"
                                                name="register_guest" value="1">
                                            <label class="form-check-label" for="register_guest">
                                                Register
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="button_response_container" style="display: none;">
                                        <div class="form-group">
                                            <label for="button_response_dropdown" class="form-label">Default Button
                                                Response</label>
                                            <select class="form-select" name="default_button_response"
                                                id="button_response_dropdown">
                                                <option value="">-- Select Button --</option>
                                                <!-- Options will be dynamically populated -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden input to store all template buttons data -->
                            <input type="hidden" name="template_buttons" id="template_buttons_input">

                            <div class="d-flex align-items-center mb-5">
                                <a href="{{ route('admin.broadcast.whatsapp.downloadGuestTemplate') }}"
                                    class="btn btn-light-primary btn-sm">
                                    <i class="fa-solid fa-download me-2"></i>Download Excel Template
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end" style="position: fixed; top: 100px; right: 30px;">
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
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
                 console.log('Total investors on page:', $('#investors-table tbody tr').not('.no-data-found').length);
                 console.log('Total partners on page:', $('#partners-table tbody tr').not('.no-data-found').length);
    
                $(document).on('change', '.checkAll', function() {
                    const groupId = $(this).data('group-id');
                    const isChecked = $(this).prop('checked');

                    // ✅ Only select visible checkboxes (matching groupId)
                    $(`.checkSingle[data-group-id="${groupId}"]`).each(function() {
                        const row = $(this).closest('tr');
                        if (row.is(':visible')) {
                            $(this).prop('checked', isChecked);
                        } else {
                            $(this).prop('checked', false); // make sure hidden rows are always unchecked
                        }
                    });
                });

                // Updated individual checkbox change handler
                $('.checkSingle').on('change', function() {
                    const groupId = $(this).data('group-id');
                    updateCheckAllState(groupId);
                    // Get all visible checkboxes for this group
                    // const visibleCheckboxes = $(`.checkSingle[data-group-id="${groupId}"]`).filter(function() {
                    //     const row = $(this).closest('tr');
                    //     return row.is(':visible') && !row.hasClass('no-data-found');
                    // });
                    
                    // const totalVisible = visibleCheckboxes.length;
                    // const checkedVisible = visibleCheckboxes.filter(':checked').length;
                    
                    // // Update "Check All" checkbox state
                    // const checkAllBox = $(`.checkAll[data-group-id="${groupId}"]`);
                    // if (checkedVisible === 0) {
                    //     checkAllBox.prop('checked', false);
                    //     checkAllBox.prop('indeterminate', false);
                    // } else if (checkedVisible === totalVisible) {
                    //     checkAllBox.prop('checked', true);
                    //     checkAllBox.prop('indeterminate', false);
                    // } else {
                    //     checkAllBox.prop('checked', false);
                    //     checkAllBox.prop('indeterminate', true);
                    // }
                });
                $('#startup-select').on('change', function() {
                    const startupId = $(this).val();
                    const investorGroupId = 1;
                    
                    // Reset investor checkboxes
                    $('.checkSingle[data-group-id="' + investorGroupId + '"]').prop('checked', false);
                    
                    if (startupId) {
                        // Fetch invested investors for this startup and auto-check only those
                        $.getJSON("{{ route('admin.broadcast.whatsapp.investedInvestors') }}", {
                            startup_id: startupId
                        }).done(function(resp) {
                            const ids = (resp && resp.investor_ids) ? resp.investor_ids : [];
                            let checkedCount = 0;

                            // Uncheck all first (again, for safety)
                            $('.checkSingle[data-group-id="' + investorGroupId + '"]').prop('checked', false);

                            // Check only investors returned by API
                            ids.forEach(function(id) {
                                const $cb = $('#investors-table .checkSingle[data-group-id="' + investorGroupId + '"][value="' + id + '"]');
                                if ($cb.length) {
                                    $cb.prop('checked', true);
                                    checkedCount++;
                                }
                            });

                            console.log('Auto-checked ' + checkedCount + ' invested investors for startup ' + startupId);
                            updateCheckAllState(investorGroupId);
                            filterTablesByAccess($('#access_type').val());
                        }).fail(function(xhr) {
                            console.log('Failed to fetch invested investors', xhr);
                            updateCheckAllState(investorGroupId);
                            filterTablesByAccess($('#access_type').val());
                        });
                        return; // prevent running the below immediate update while ajax is pending
                    }
                    
                    updateCheckAllState(investorGroupId);
                    filterTablesByAccess(accesstype.val());
                });


                $('#user_type, #register_guest').on('change', function() {
                    checkRegisterGuestButtonVisibility();
                });
                $('select[name="template_name"]').on('change', function() {
                    const selectedOption = $(this).val();
                    const templateText = $(this).find('option:selected').attr('data-template-text');
                    const jsonTemplate = formatTemplateContent(templateText);
                    $('textarea[name="template_data"]').val(jsonTemplate);
                    $('#dynamicUrlsInput').val('');
                    $('#variablesInput').val('');
                    updateButtonResponseVisibility();
                    // checkRegisterGuestButtonVisibility();
                });
                $(document).on('keyup', '.custom-value-container', function() {
                    refreshVariables();
                });
                $(document).on('input', 'input[name="button_url[]"]', function() {
                    let urls = [];
                    $('input[name="button_url[]"]').each(function() {
                        urls.push($(this).val());
                    });
                    $('#dynamicUrlsInput').val(JSON.stringify(urls));
                });
                $(document).on('change', '.variable-type-select', function() {
                    const row = $(this).data('row');
                    const selectedValue = $(this).val();
                    const customContainer = $(this).closest('.row').find('.custom-value-container');

                    if (selectedValue === 'custom') {
                        customContainer.removeClass('d-none');
                        customContainer.find('input').attr('required', true);
                    } else {
                        customContainer.addClass('d-none');
                        customContainer.find('input').removeAttr('required');
                    }

                    refreshVariables();
                });

                 $('#user_type').on('change', function() {  
                    if ($(this).val() === 'guest') {
                        $('#existing_user_section').hide();
                        $('#guest_upload_section').show();
                        updateButtonResponseVisibility();
                    } else {
                        $('#existing_user_section').show();
                        $('#guest_upload_section').hide();
                        $('#access_type_div').show();
                        $('#button_response_container').hide();
                        filterTablesByAccess($('#access_type').val());
                    }
                });

                 $('#access_type').on('change', function() {
                    const accessType = $(this).val();

                     // 🔁 Reset all checkboxes on access type change
                    $('input[name="selected_investors[]"]').prop('checked', false);
                    $('input[name="selected_partners[]"]').prop('checked', false);

                    // 🔁 Reset "Select All" checkboxes and remove indeterminate state
                    $('.checkAll').prop('checked', false).prop('indeterminate', false);

                     const startupDiv = $('#startup-select-div');
                    if (accessType === 'startup') {
                        startupDiv.show();
                    } else {
                        startupDiv.hide();
                        $('#startup-select').val('').trigger('change');
                    }

                    // 🔄 Now apply the filtering logic
                    filterTablesByAccess(accessType);
                    // First, uncheck only the hidden checkboxes
                    // $('.checkSingle').each(function() {
                    //     const row = $(this).closest('tr');
                    //     if (!row.is(':visible')) {
                    //         $(this).prop('checked', false);
                    //     }
                    // });

                    // $('.checkAll').prop('checked', false).prop('indeterminate', false);

                    // filterTablesByAccess(accessType); // Already handles show/hide
                });

                $('#register_guest').on('change', function() {
                    updateButtonResponseVisibility();
                });

                function updateButtonResponseVisibility() {
                    const userType = $('#user_type').val();
                    const registerGuest = $('#register_guest').is(':checked');
                    const hasQuickReplyButtons = $('#button_response_dropdown option').length > 1; // More than just the default option
                    
                    if (userType === 'guest' && registerGuest && hasQuickReplyButtons) {
                        $('#button_response_container').show();
                    } else {
                        $('#button_response_container').hide();
                    }
                }

                function updateCheckAllState(groupId) {
                    const visibleCheckboxes = $(`.checkSingle[data-group-id="${groupId}"]`).filter(function() {
                        const row = $(this).closest('tr');
                        return row.is(':visible') && !row.hasClass('no-data-found');
                    });
                    
                    const totalVisible = visibleCheckboxes.length;
                    const checkedVisible = visibleCheckboxes.filter(':checked').length;
                    
                    const checkAllBox = $(`.checkAll[data-group-id="${groupId}"]`);
                    
                    if (totalVisible === 0) {
                        // No visible checkboxes - uncheck and disable
                        checkAllBox.prop('checked', false);
                        checkAllBox.prop('indeterminate', false);
                    } else if (checkedVisible === 0) {
                        // No checked visible checkboxes
                        checkAllBox.prop('checked', false);
                        checkAllBox.prop('indeterminate', false);
                    } else if (checkedVisible === totalVisible) {
                        // All visible checkboxes are checked
                        checkAllBox.prop('checked', true);
                        checkAllBox.prop('indeterminate', false);
                    } else {
                        // Some visible checkboxes are checked
                        checkAllBox.prop('checked', false);
                        checkAllBox.prop('indeterminate', true);
                    }
                }

                $(document).on('submit', '#wpBroadcastForm', function() {
                    const userType = $('#user_type').val();
                    const $submitBtn = $('#kt_ecommerce_edit_order_submit');

                     if ($submitBtn.hasClass('disabled') || $submitBtn.prop('disabled')) {
                        e.preventDefault();
                        return false;
                    }
                    
                    if (userType === 'existing') {
                        const selectedInvestors = $('input[name="selected_investors[]"]:checked').length>0;
                        const selectedPartners = $('input[name="selected_partners[]"]:checked').length>0;
                        
                        if (selectedInvestors === 0 && selectedPartners === 0) {
                            showErrorMessage('Please select at least one investor or partner', 'error');
                            return false;
                        }
                    } else if (userType === 'guest') {
                        const guestCsvFile = $('input[name="guest_excel"]').val();
                        const excelUploaded = $('#excel_records_info').length > 0;
                        if (!guestCsvFile && !excelUploaded) {
                            showErrorMessage('Please upload guest user data via CSV or Excel', 'error');
                            return false;
                        }
                    }
                    $submitBtn.prop('disabled', true).addClass('disabled');
                    $submitBtn.find('.indicator-label').hide();
                    $submitBtn.find('.indicator-progress').show();

                    setTimeout(function() {
                        $submitBtn.prop('disabled', false).removeClass('disabled');
                        $submitBtn.find('.indicator-label').show();
                        $submitBtn.find('.indicator-progress').hide();
                    }, 30000);
                });
                filterTablesByAccess($('#access_type').val());
            });

             function filterTablesByAccess(accessType) {
                let visibleInvestors = 0;
                let visiblePartners = 0;
                
                // Process investor table
                $('#investors-table tbody tr').not('.no-data-found').each(function() {
                    const $row = $(this);
                    const $checkbox = $row.find('.checkSingle');
                    const hasStartup = $row.attr('data-startup') === 'true';
                    const hasPreIpo = $row.attr('data-preipo') === 'true';
                    
                    let shouldShow = false;
                    
                    if (accessType === 'all') {
                        shouldShow = true;
                    } else if (accessType === 'startup' && hasStartup) {
                        shouldShow = true;
                    } else if (accessType === 'preipo' && hasPreIpo) {
                        shouldShow = true;
                    }
                    
                    if (shouldShow) {
                        $row.show();
                        visibleInvestors++;
                    } else {
                        $row.hide();
                        // Uncheck hidden checkboxes
                        $checkbox.prop('checked', false);
                    }
                });
                
                // Process partner table
                $('#partners-table tbody tr').not('.no-data-found').each(function() {
                    const $row = $(this);
                    const $checkbox = $row.find('.checkSingle');
                    const hasStartup = $row.attr('data-startup') === 'true';
                    const hasPreIpo = $row.attr('data-preipo') === 'true';
                    
                    let shouldShow = false;
                    
                    if (accessType === 'all') {
                        shouldShow = true;
                    } else if (accessType === 'startup' && hasStartup) {
                        shouldShow = true;
                    } else if (accessType === 'preipo' && hasPreIpo) {
                        shouldShow = true;
                    }
                    
                    if (shouldShow) {
                        $row.show();
                        visiblePartners++;
                    } else {
                        $row.hide();
                        // Uncheck hidden checkboxes
                        $checkbox.prop('checked', false);
                    }
                });
                // Show/hide no data messages
                 if (visibleInvestors === 0) {
                    $('#investors-no-data').show();
                } else {
                    $('#investors-no-data').hide();
                }
                
                if (visiblePartners === 0) {
                    $('#partners-no-data').show();
                } else {
                    $('#partners-no-data').hide();
                }

                 updateCheckAllState(1); // Investors
                 updateCheckAllState(2);
                
                // $('.checkAll').each(function() {
                //     const groupId = $(this).data('group-id');
                //     const visibleCheckboxes = $(`.checkSingle[data-group-id="${groupId}"]`).filter(function() {
                //         return $(this).closest('tr').is(':visible') && !$(this).closest('tr').hasClass('no-data-found');
                //     });
                    
                //     if (visibleCheckboxes.length === 0) {
                //         $(this).prop('checked', false);
                //         $(this).prop('indeterminate', false);
                //     } else {
                //         const checkedVisible = visibleCheckboxes.filter(':checked').length;
                //         if (checkedVisible === 0) {
                //             $(this).prop('checked', false);
                //             $(this).prop('indeterminate', false);
                //         } else if (checkedVisible === visibleCheckboxes.length) {
                //             $(this).prop('checked', true);
                //             $(this).prop('indeterminate', false);
                //         } else {
                //             $(this).prop('checked', false);
                //             $(this).prop('indeterminate', true);
                //         }
                //     }
                // });
            }

            function updateCheckAllState(groupId) {
                const visibleCheckboxes = $(`.checkSingle[data-group-id="${groupId}"]`).filter(function() {
                    const row = $(this).closest('tr');
                    return row.is(':visible') && !row.hasClass('no-data-found');
                });
                
                const totalVisible = visibleCheckboxes.length;
                const checkedVisible = visibleCheckboxes.filter(':checked').length;
                
                const checkAllBox = $(`.checkAll[data-group-id="${groupId}"]`);
                
                if (totalVisible === 0) {
                    // No visible checkboxes
                    checkAllBox.prop('checked', false);
                    checkAllBox.prop('indeterminate', false);
                } else if (checkedVisible === 0) {
                    // No checked visible checkboxes
                    checkAllBox.prop('checked', false);
                    checkAllBox.prop('indeterminate', false);
                } else if (checkedVisible === totalVisible) {
                    // All visible checkboxes are checked
                    checkAllBox.prop('checked', true);
                    checkAllBox.prop('indeterminate', false);
                } else {
                    // Some visible checkboxes are checked
                    checkAllBox.prop('checked', false);
                    checkAllBox.prop('indeterminate', true);
                }
            }
        
            function formatTemplateContent(template) {
                $('#dynamic-btns').closest('.card').hide();
                $('#dynamicVariablesFields').closest('.card').hide();
                // $('#template_buttons_section').hide();
                try {
                    const parsedTemplate = JSON.parse(template);
                    if (!parsedTemplate.localizations || !parsedTemplate.localizations[0]) {
                        return '';
                    }

                    let formattedContent = '';
                    let hasHeader = false;
                    let templateButtons = [];
                    $('#dynamic-btns').html('');
                    $('#dynamicVariablesFields').html('');
                    $('#dynamicUrlFields').html('');
                    //  $('#template_buttons_dropdown').html('<option value="">-- Select Button --</option>');
                    $('#button_response_dropdown').html('<option value="">-- Select Button --</option>');
                    const components = parsedTemplate.localizations[0].components;
                    components.forEach(component => {
                        switch (component.type) {
                            case 'HEADER':
                                formattedContent += `[HEADER]\n`;
                                hasHeader = true; // Mark HEADER found
                                if (component.example && component.example.url) {
                                    formattedContent += `${component.example.url}\n\n`;
                                }
                                break;

                            case 'BODY':
                                var body = component.text;
                                formattedContent += `${component.text}\n\n`;
                                const bodyVariables = countTemplateVariables(body);
                                for (let i = 0; i < bodyVariables; i++) {
                                    const variableNumber = i + 1;
                                    const escapedVariable =
                                        `&#123;&#123;${variableNumber}&#125;&#125;`; // Escaped "{{ 1 }}"
                                    const newRow = `
                                        <div class='d-flex gap-3 align-items-center compulsory-row' id='row-${i}'>
                                            <div class='d-flex align-items-center gap-2 flex-grow-1'>
                                                <span class="badge bg-light-primary">${escapedVariable}</span>
                                                <div class="row w-100">
                                                    <div class="col">
                                                        <select class="form-select variable-type-select" data-row="${i}" required>
                                                            <option value="">-- Select Type --</option>
                                                            <option value="name">Name</option>
                                                            <option value="email">Email</option>
                                                            <option value="mobile_number">Mobile Number</option>
                                                            <option value="custom">Custom</option>
                                                        </select>
                                                    </div>
                                                    <div class="col custom-value-container d-none">
                                                        <input type="text" 
                                                            class="form-control custom-value" 
                                                            placeholder="Enter custom value"
                                                            data-row="${i}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                                    $('#dynamicVariablesFields').append(newRow);
                                }

                                break;

                            case 'BUTTONS':
                                formattedContent += `[BUTTONS]\n`;
                                let hasQuickReplyButtons = false;
                                component.buttons.forEach((button, index) => {
                                    if (button.type === 'QUICK_REPLY') {
                                        formattedContent += `${button.text}\n`;
                                        templateButtons.push({
                                            text: button.text,
                                            index: index,
                                            type: 'QUICK_REPLY'
                                        });
                                        
                                        // Add button to dropdown
                                        // $('#template_buttons_dropdown').append(`
                                        //     <option value="${button.text}">${button.text}</option>
                                        // `);
                                        $('#button_response_dropdown').append(`
                                            <option value="${button.text}">${button.text}</option>
                                        `);
                                        
                                        hasQuickReplyButtons = true;
                                    } else if (button.type === 'URL') {
                                        formattedContent += `${button.text}: ${button.url}\n`;
                                        templateButtons.push({
                                            text: button.text,
                                            index: index,
                                            type: 'URL',
                                            url: true
                                        });

                                        $('#dynamic-btns').append(`
                                            <div class='d-flex gap-3 align-items-center compulsory-row mb-5'>
                                                <div class='d-flex align-items-center gap-2 flex-grow-1'>
                                                    <span class="badge bg-light-primary">${button.text}</span>
                                                    <div class="row w-100">
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="button_url[]"
                                                                placeholder="Enter ${button.text} URL" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        `);
                                        
                                        // Also add URL buttons to dropdown
                                        // $('#template_buttons_dropdown').append(`
                                        //     <option value="${button.text}">${button.text}</option>
                                        // `);
                                    }
                                });
                                
                                // If template has buttons and we're in guest mode with register checked
                                // show the buttons section
                                // if (templateButtons.length > 0) {
                                //     $('#template_buttons_input').val(JSON.stringify(templateButtons));
                                //     checkRegisterGuestButtonVisibility();
                                // }
                                // break;
                                if (templateButtons.length > 0) {
                                    $('#template_buttons_input').val(JSON.stringify(templateButtons));
                                    
                                    // Show button response dropdown only if there are QUICK_REPLY buttons
                                    if (hasQuickReplyButtons) {
                                        $('#button_response_container').show();
                                    } else {
                                        $('#button_response_container').hide();
                                    }
                                } else {
                                    $('#button_response_container').hide();
                                }
                                break;
                        }
                    });

                    toggleHeaderUpload(hasHeader);


                    if ($('#dynamic-btns').html() != "") {
                        $('#dynamic-btns').closest('.card').show();
                    }

                    if ($('#dynamicVariablesFields').html() != "") {
                        $('#dynamicVariablesFields').closest('.card').show();
                    }

                    return formattedContent.trim();
                } catch (error) {
                    toggleHeaderUpload(false);
                    return '';
                }
            }

            function checkRegisterGuestButtonVisibility() {
                const userType = $('#user_type').val();
                const registerGuest = $('#register_guest').is(':checked');
                const hasButtons = $('#template_buttons_dropdown option').length > 1; // More than just the default option
                
                if (userType === 'guest' && registerGuest && hasButtons) {
                    $('#template_buttons_section').show();
                } else {
                    $('#template_buttons_section').hide();
                }
            }

            function toggleHeaderUpload(show) {
                $('#uploadHeaderDiv').hide();
                $('#uploadHeaderDiv input').attr('required', false);
                $('#uploadHeaderDiv input').val('');
                if (show) {
                    $('#uploadHeaderDiv').show();
                    $('#uploadHeaderDiv input').attr('required', true);
                }
            }

            function countTemplateVariables(text) {
                const regexPattern = /\{\{(\d+)\}\}/g;
                const matches = text.match(regexPattern) || [];
                return matches.length;
            }

            function refreshVariables() {
                const variables = [];

                $('#dynamicVariablesFields').find('.variable-type-select').each(function(index) {
                    const type = $(this).val();
                    const row = $(this).data('row');
                    const customValue = $(`input.custom-value[data-row="${row}"]`).val();

                    if (type) {
                        if (type === 'custom') {
                            variables.push({
                                type: type,
                                value: customValue ||
                                    null
                            });
                        } else {
                            variables.push({
                                type: type,
                                value: null
                            });
                        }
                    }
                });

                $('#variablesInput').val(JSON.stringify(variables));
            }
    </script>
    @endpush
</x-default-layout>