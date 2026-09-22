<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('company.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.company.updateSharePriceSave') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4 mb-5">
                    <div class="card-body d-flex justify-content-end mb-4">
                        <!-- OCR Upload Button - NEW ADDITION -->
                        <button type="button" class="btn btn-sm btn-success me-3" id="btn-ocr-upload">
                            <i class="ki-duotone ki-scanner fs-3 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>Extract from Image
                        </button>

                        <button type="button" class="btn btn-sm btn-danger me-3" id="removePriceBtn"
                            style="display:none;">
                            Remove Last Price Column
                        </button>
                        <button type="button" id="addPriceBtn" class="btn btn-sm btn-primary me-3">
                            Add Price Column
                        </button>
                    </div>
                    <div class="card-body pt-0">
                        <div class="price-table-container">
                            <table class="table table-bordered table-sm" id="priceTable">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                    </tr>
                                    <tr id="sellerRow">
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                    <tr data-commission="{{ $item->commission }}">
                                        <td>
                                            <strong>{{ $item->brand_name }}</strong><br>
                                            {{ $item->company_name }}
                                            <input type="hidden" name="company_id[]" value="{{ $item->id }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.company.list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- OCR Upload Modal - NEW ADDITION -->
    <div class="modal fade global_modal" id="ocrUploadModal" tabindex="-1" role="dialog" aria-labelledby="ocrModalLabel"
        aria-hidden="true">
        <form action="" id="uploadOcrForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" style="font-weight:bold;">
                            <i class="ki-duotone ki-scanner fs-3 me-2 text-white">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>Extract Financial Data from Image
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column - Upload Form -->
                            <div class="col-md-6">
                                <!-- Seller Name Input -->
                                <div class="mb-5">
                                    <label class="required form-label fw-bold">Seller Name</label>
                                    <input name="seller_name" class="form-control form-control-lg" type="text"
                                        value="Mukesh Babu" placeholder="Enter seller name" required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle text-primary"></i>
                                        This will be used as the seller name for all extracted prices
                                    </div>
                                </div>

                                <!-- File Upload -->
                                <div class="mb-5">
                                    <label class="required form-label fw-bold">Upload Financial Table Image</label>
                                    <input name="financial_image" class="form-control form-control-lg" type="file"
                                        accept="image/*" required id="imageInput">
                                    <div class="form-text">
                                        <i class="fas fa-check-circle text-success"></i>
                                        Supported: JPG, PNG, JPEG (Max: 10MB)<br>
                                        <i class="fas fa-lightbulb text-warning"></i>
                                        Best results with clear, high-contrast table images like the one shown
                                    </div>
                                </div>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mb-5" style="display: none;">
                                    <label class="form-label fw-bold">Image Preview:</label>
                                    <div class="border rounded p-3 bg-light">
                                        <img id="previewImg" src="" alt="Preview" class="img-fluid rounded"
                                            style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Expected Format & Results -->
                            <div class="col-md-6">
                                <!-- Expected Format -->
                                <div class="mb-5">
                                    <label class="form-label fw-bold">Expected Image Format:</label>
                                    <div class="border rounded p-3 bg-light">
                                        <div class="text-center mb-3">
                                            <strong>Financial Rates Table (15-Oct-25)</strong>
                                        </div>
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Script Name (FV)</th>
                                                    <th>Face Value</th>
                                                    <th>Selling Price*</th>
                                                    <th>Landing Price</th>
                                                </tr>
                                            </thead>
                                            <tbody class="small">
                                                <tr>
                                                    <td>Apollo Green</td>
                                                    <td>10</td>
                                                    <td>78.75</td>
                                                    <td>75.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Bootes</td>
                                                    <td>10</td>
                                                    <td>1,837.50</td>
                                                    <td>1750.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Care Insurance</td>
                                                    <td>10</td>
                                                    <td>157.50</td>
                                                    <td>150.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <small class="text-muted">
                                            <strong>Note:</strong> Selling Price = Your Retailer Price, Landing Price =
                                            Your Price
                                        </small>
                                    </div>
                                </div>

                                <!-- Extraction Results Preview -->
                                <div id="ocrPreviewArea" class="mb-3" style="display: none;">
                                    <label class="form-label fw-bold text-success">
                                        <i class="fas fa-check-circle"></i> Extracted Data Preview:
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered" id="ocrPreviewTable">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Landing Price</th>
                                                    <th>Selling Price</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="processOcrBtn">
                            <i class="fas fa-magic me-2"></i>
                            <span class="indicator-label">Extract & Apply Prices</span>
                            <span class="indicator-progress" style="display: none;">
                                <i class="fas fa-spinner fa-spin me-2"></i>
                                Processing... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(function() {
                let columnIndex = 0;

                // Your existing validation and price management functions remain the same...
                function validatePriceInputs($priceInputs) {
                    $priceInputs.siblings('.price-error').remove();
                    
                    let price = parseFloat($priceInputs.eq(0).val()) || 0;
                    let retailerPrice = parseFloat($priceInputs.eq(1).val()) || 0;
                    let commissionRate = parseFloat($priceInputs.closest('tr').attr('data-commission'))/100;
                    
                    let distributorPrice = price + (price * commissionRate);
                    
                    if (price > 0 && retailerPrice > 0) {
                        if (retailerPrice <= price) {
                            $priceInputs.eq(1).after(
                                '<div class="text-danger price-error">Retailer price must be higher than the price</div>'
                            );
                            return false;
                        }
                        
                        if (retailerPrice <= distributorPrice) {
                            $priceInputs.eq(1).after(
                                '<div class="text-danger price-error">Retailer price must be higher than distributor price (' + distributorPrice.toFixed(2) + ')</div>'
                            );
                            return false;
                        }
                    }
                    
                    return true;
                }

                function checkAllPriceValidations() {
                    let allValid = true;
                    
                    $('tbody tr').each(function() {
                        let $priceInputs = $(this).find('input[name^="price"], input[name^="retailer_price"]');
                        
                        if ($priceInputs.length === 2) {
                            if (!validatePriceInputs($priceInputs)) {
                                allValid = false;
                            }
                        }
                    });

                    $('#kt_ecommerce_edit_order_submit').prop('disabled', !allValid);
                }

                $('#kt_ecommerce_edit_order_submit').prop('disabled', false);
                
                $(document).on('input', 'input[name^="price"], input[name^="retailer_price"]', function() {
                    let $inputs = $(this).closest('td').find('input');
                    validatePriceInputs($inputs);
                    checkAllPriceValidations();
                });

                // Your existing add/remove price column functions remain the same...
                $('#addPriceBtn').click(function() {
                    columnIndex++;

                    let table = $('#priceTable');
                    let rows = table.find('tr');

                    $('#sellerRow').append('<th id="sellerCol' + columnIndex +
                        '"><input type="text" class="form-control" name="seller_name[]" placeholder="Seller Name" required></th>'
                    );

                    rows.eq(0).append('<th id="priceCol' + columnIndex + '">Price & Retailer Price</th>');

                    rows.slice(2).each(function() {
                        $(this).append('<td id="dataCol' + columnIndex +
                            '"><input type="text" class="form-control input-decimal-number" name="price[' +
                            columnIndex +
                            '][]" placeholder="Price" value="">' +
                            '<input type="text" class="form-control mt-2 input-decimal-number" name="retailer_price[' +
                            columnIndex +
                            '][]" placeholder="Retailer Price" value=""></td>');
                    });

                    if (columnIndex > 0) {
                        $('#removePriceBtn').show();
                    }
                });

                $('#removePriceBtn').click(function() {
                    if (columnIndex > 0) {
                        $('#sellerCol' + columnIndex).remove();
                        $('#priceCol' + columnIndex).remove();
                        $('td[id="dataCol' + columnIndex + '"]').remove();

                        columnIndex--;

                        if (columnIndex === 0) {
                            $('#removePriceBtn').hide();
                        }
                        checkAllPriceValidations();
                    }
                });

                // NEW OCR FUNCTIONALITY STARTS HERE
                
                // Image preview functionality
                $('#imageInput').change(function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#previewImg').attr('src', e.target.result);
                            $('#imagePreview').show();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        $('#imagePreview').hide();
                    }
                });

                // OCR Upload functionality
                $('#btn-ocr-upload').click(function(e) {
                    e.preventDefault();
                    $('#ocrUploadModal').modal('show');
                });

                // OCR Form submission
                $('#uploadOcrForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = $('#processOcrBtn');
                    const indicatorLabel = submitBtn.find('.indicator-label');
                    const indicatorProgress = submitBtn.find('.indicator-progress');
                    
                    // Show loading state
                    submitBtn.prop('disabled', true);
                    indicatorLabel.hide();
                    indicatorProgress.show();
                    
                    var formData = new FormData(this);
                    
                    axios.post('{{ route('admin.company.processOcrFinancialData') }}', formData)
                        .then(function(response) {
                            if (response.data.success) {
                                showOcrPreview(response.data.data);
                                applyOcrDataToPriceTable(response.data.data);
                                showErrorMessage(response.data.message, "success");
                                
                                // Show summary
                                const summary = `✅ Total Extracted: ${response.data.data.total_extracted} companies\n✅ Successfully Matched: ${response.data.data.total_matched} companies\n✅ Prices Applied: ${response.data.data.total_matched} records`;
                                showErrorMessage(summary, "success");
                                
                            } else {
                                showErrorMessage(response.data.message, "error");
                            }
                        })
                        .catch(function(error) {
                            const errorMsg = error.response?.data?.message || 'OCR processing failed. Please try again.';
                            showErrorMessage(errorMsg, "error");
                            console.error('OCR Error:', error);
                        })
                        .finally(function() {
                            // Reset loading state
                            submitBtn.prop('disabled', false);
                            indicatorLabel.show();
                            indicatorProgress.hide();
                        });
                });

                // Show OCR preview results
                function showOcrPreview(data) {
                    const previewArea = $('#ocrPreviewArea');
                    const previewTable = $('#ocrPreviewTable tbody');
                    
                    previewTable.empty();
                    
                    data.extracted_data.forEach(function(item) {
                        const statusBadge = item.match_status === 'found' 
                            ? '<span class="badge badge-success"><i class="fas fa-check"></i> Found</span>'
                            : '<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Not Found</span>';
                            
                        const row = `
                            <tr class="${item.match_status === 'found' ? 'table-light' : 'table-warning'}">
                                <td><strong>${item.extracted_name}</strong>
                                    ${item.company_name ? '<br><small class="text-muted">' + item.company_name + '</small>' : ''}
                                </td>
                                <td>${item.landing_price || 'N/A'}</td>
                                <td>${item.selling_price || 'N/A'}</td>
                                <td>${statusBadge}</td>
                            </tr>
                        `;
                        previewTable.append(row);
                    });
                    
                    previewArea.show();
                }

                // Apply OCR data to price table
                function applyOcrDataToPriceTable(data) {
                    // First, add a new price column if none exists
                    if (columnIndex === 0) {
                        $('#addPriceBtn').click();
                    }
                    
                    // Set seller name
                    $('input[name="seller_name[]"]').last().val(data.seller_name);
                    
                    let appliedCount = 0;
                    
                    // Apply prices to matching companies
                    data.extracted_data.forEach(function(item) {
                        if (item.match_status === 'found' && item.company_id) {
                            // Find the row for this company
                            const companyRow = $(`input[name="company_id[]"][value="${item.company_id}"]`).closest('tr');
                            
                            if (companyRow.length > 0) {
                                // Get the last price input columns (most recently added)
                                const lastColumnInputs = companyRow.find('td:last input');
                                
                                if (lastColumnInputs.length >= 2) {
                                    // Set landing price (your "price" field)
                                    if (item.landing_price && item.landing_price !== 'CNC' && !isNaN(item.landing_price)) {
                                        lastColumnInputs.eq(0).val(item.landing_price);
                                    }
                                    
                                    // Set selling price (your "retailer_price" field)  
                                    if (item.selling_price && item.selling_price !== 'CNC' && !isNaN(item.selling_price)) {
                                        lastColumnInputs.eq(1).val(item.selling_price);
                                    }
                                    
                                    // Trigger validation
                                    lastColumnInputs.trigger('input');
                                    appliedCount++;
                                    
                                    // Highlight the updated row briefly
                                    companyRow.addClass('table-success').delay(2000).queue(function() {
                                        $(this).removeClass('table-success').dequeue();
                                    });
                                }
                            }
                        }
                    });
                    
                    // Close modal after successful application
                    setTimeout(function() {
                        $('#ocrUploadModal').modal('hide');
                    }, 1500);
                }

                // Reset modal when closed
                $('#ocrUploadModal').on('hidden.bs.modal', function() {
                    $('#uploadOcrForm')[0].reset();
                    $('#imagePreview').hide();
                    $('#ocrPreviewArea').hide();
                });
            });
    </script>
    @endpush
</x-default-layout>