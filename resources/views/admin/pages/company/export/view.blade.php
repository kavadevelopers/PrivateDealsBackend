<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('company.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">
            <div class="card card-flush py-4 mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Export Companies Report</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Category Selection -->
                    <div class="d-flex flex-wrap gap-10 mb-5">
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Select Category</label>
                            <select class="form-select" id="category" aria-label="Select Category Type" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat->value }}">{{ ucfirst(str_replace('_', ' ', $cat->value)) }}
                                </option>
                                @endforeach
                                <option value="exclusive_liquid">Exclusive & Liquid</option>
                            </select>
                            <div class="invalid-feedback" id="category-error" style="display: none;">
                                Please select a category
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-3">
                        <!-- Download PDF Button -->
                        <form method="POST" action="{{ route('admin.company.export.pdf') }}" style="display: inline;"
                            id="pdf-form">
                            @csrf
                            <input type="hidden" name="category" id="download-category">
                            <button type="submit" class="btn btn-primary d-flex align-items-center" id="download-btn"
                                disabled style="min-width: 150px;">
                                <span class="indicator-label d-flex align-items-center">
                                    <i class="ki-duotone ki-file-down fs-3 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Download PDF
                                </span>
                                <span class="indicator-progress d-flex align-items-center"
                                    style="display: none !important;">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Please wait...
                                </span>
                            </button>
                        </form>

                        <!-- Send to Partner Button -->
                        <form method="POST" action="{{ route('admin.company.export.send-partner') }}"
                            style="display: inline;" id="partner-form">
                            @csrf
                            <input type="hidden" name="category" id="partner-category">
                            <button type="button" class="btn btn-success d-flex align-items-center" id="partner-btn"
                                disabled style="min-width: 160px;">
                                <span class="indicator-label d-flex align-items-center">
                                    <i class="fab fa-whatsapp fs-3 me-2"></i>
                                    Send to Partner
                                </span>
                                <span class="indicator-progress d-flex align-items-center"
                                    style="display: none !important;">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Sending...
                                </span>
                            </button>
                        </form>

                        <!-- Send to Demo Button -->
                        <form method="POST" action="{{ route('admin.company.export.send-demo') }}"
                            style="display: inline;" id="demo-form">
                            @csrf
                            <input type="hidden" name="category" id="demo-category">
                            <button type="button" class="btn btn-warning d-flex align-items-center" id="demo-btn"
                                disabled style="min-width: 150px;">
                                <span class="indicator-label d-flex align-items-center">
                                    <i class="fab fa-whatsapp fs-3 me-2"></i>
                                    Send to Demo
                                </span>
                                <span class="indicator-progress d-flex align-items-center"
                                    style="display: none !important;">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Sending...
                                </span>
                            </button>
                        </form>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success mt-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger mt-4">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationModalLabel">Verify Companies & Prices</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <h6>Category: <span id="modalCategory" class="badge bg-info"></span></h6>
                        <p>Total Companies: <strong id="totalCompanies">0</strong></p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Company Name</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody id="companiesTableBody">
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Loading companies...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back & Edit</button>
                    <button type="button" class="btn btn-success" id="confirmSendBtn">
                        <i class="fab fa-whatsapp me-2"></i>Confirm & Send
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            const downloadBtn = document.getElementById('download-btn');
            const partnerBtn = document.getElementById('partner-btn');
            const demoBtn = document.getElementById('demo-btn');
            
            const downloadCategoryInput = document.getElementById('download-category');
            const partnerCategoryInput = document.getElementById('partner-category');
            const demoCategoryInput = document.getElementById('demo-category');
            
            const categoryError = document.getElementById('category-error');
            const verificationModal = new bootstrap.Modal(document.getElementById('verificationModal'));
            const confirmSendBtn = document.getElementById('confirmSendBtn');
            let pendingFormId = null;

            categorySelect.addEventListener('change', function() {
                const selectedValue = this.value;
                
                if (selectedValue) {
                    downloadBtn.disabled = false;
                    partnerBtn.disabled = false;
                    demoBtn.disabled = false;
                    
                    downloadCategoryInput.value = selectedValue;
                    partnerCategoryInput.value = selectedValue;
                    demoCategoryInput.value = selectedValue;
                    
                    categoryError.style.display = 'none';
                    categorySelect.classList.remove('is-invalid');
                } else {
                    downloadBtn.disabled = true;
                    partnerBtn.disabled = true;
                    demoBtn.disabled = true;
                    
                    downloadCategoryInput.value = '';
                    partnerCategoryInput.value = '';
                    demoCategoryInput.value = '';
                }
            });

            // Download PDF - direct submit
            const pdfForm = document.getElementById('pdf-form');
            if (pdfForm) {
                pdfForm.addEventListener('submit', function(e) {
                    const category = categorySelect.value;
                    if (!category) {
                        e.preventDefault();
                        categoryError.style.display = 'block';
                        categorySelect.classList.add('is-invalid');
                        return false;
                    }
                    
                    const btn = this.querySelector('button[type="submit"]');
                    const label = btn.querySelector('.indicator-label');
                    const progress = btn.querySelector('.indicator-progress');
                    
                    label.style.display = 'none';
                    progress.style.display = 'flex !important';
                    btn.disabled = true;
                });
            }

            // Partner and Demo buttons - show modal first
            partnerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!categorySelect.value) {
                    categoryError.style.display = 'block';
                    categorySelect.classList.add('is-invalid');
                    return;
                }
                pendingFormId = 'partner-form';
                showVerificationModal();
            });

            demoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!categorySelect.value) {
                    categoryError.style.display = 'block';
                    categorySelect.classList.add('is-invalid');
                    return;
                }
                pendingFormId = 'demo-form';
                showVerificationModal();
            });

            function showVerificationModal() {
                const category = categorySelect.value;
                document.getElementById('modalCategory').textContent = category.toUpperCase().replace(/_/g, ' ');
                
                // Fetch companies data
                fetchCompaniesData(category);
                verificationModal.show();
            }

            function fetchCompaniesData(category) {
                const tableBody = document.getElementById('companiesTableBody');
                tableBody.innerHTML = '<tr><td colspan="2" class="text-center"><span class="spinner-border spinner-border-sm me-2"></span>Loading...</td></tr>';

                fetch(`{{ route('admin.company.export.get-companies') }}?category=${category}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.companies && data.companies.length > 0) {
                            document.getElementById('totalCompanies').textContent = data.companies.length;
                            tableBody.innerHTML = data.companies.map(company => `
                                <tr>
                                    <td><strong>${company.name}</strong></td>
                                    <td class="text-end"><strong>₹${parseFloat(company.price).toFixed(2)}</strong></td>
                                </tr>
                            `).join('');
                        } else {
                            tableBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">No companies found</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        tableBody.innerHTML = '<tr><td colspan="2" class="text-center text-danger">Error loading companies</td></tr>';
                    });
            }

            confirmSendBtn.addEventListener('click', function() {
                if (pendingFormId) {
                    const form = document.getElementById(pendingFormId);
                    const btn = form.querySelector('button');
                    const label = btn.querySelector('.indicator-label');
                    const progress = btn.querySelector('.indicator-progress');
                    
                    verificationModal.hide();
                    label.style.display = 'none';
                    progress.style.display = 'flex !important';
                    btn.disabled = true;
                    
                    form.submit();
                }
            });
        });
    </script>
    @endpush
</x-default-layout>