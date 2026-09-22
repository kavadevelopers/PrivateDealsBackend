<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('company.list') }}
    <!-- Using existing breadcrumbs -->
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-news-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Search News" />
                </div>
            </div>
            <div class="card-toolbar d-flex gap-2">
                <button type="button" class="btn btn-danger d-none" id="btn_delete_selected">
                    <i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Delete Selected
                </button>
                <a href="{{ route('admin.news-assignment.index') }}" class="btn btn-light-primary">
                    <i class="ki-duotone ki-arrow-left fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Back
                </a>
            </div>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    <!-- Change Company Modal -->
    <div class="modal fade" id="kt_modal_change_company" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="kt_modal_change_company_form" class="form" method="POST" action="">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Change Company for News</h1>
                            <div class="text-muted fw-semibold fs-5">Select a new company to assign this news item to.
                            </div>
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Select Company</span>
                            </label>
                            <select name="new_company_id" class="form-select form-select-solid" data-control="select2"
                                data-dropdown-parent="#kt_modal_change_company" data-placeholder="Select a Company..."
                                required>
                                <option></option>
                                @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">
                                    {{ $comp->brand_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{ $dataTable->scripts() }}

    <script>
        $('[data-kt-news-table-filter="search"]').on('keyup', function(e) {
                window.LaravelDataTables['news_assignment_news_table']
                    .search(e.target.value)
                    .draw();
            });

            // Handle Change Company Modal Open
            $(document).on('click', '.btn-change-company', function(e) {
                e.preventDefault();
                var newsId = $(this).data('id');
                var formAction = "{{ url('admin/news-assignment/news') }}/" + newsId + "/change-company";
                $('#kt_modal_change_company_form').attr('action', formAction);
                
                // select current company
                $('select[name="new_company_id"]').val('{{ $company->id }}').trigger('change');
                
                $('#kt_modal_change_company').modal('show');
            });

            // Handle bulk delete checkboxes
            $(document).on('change', '#check_all', function() {
                $('.news_checkbox').prop('checked', $(this).prop('checked'));
                toggleDeleteSelectedBtn();
            });

            $(document).on('change', '.news_checkbox', function() {
                toggleDeleteSelectedBtn();
            });

            function toggleDeleteSelectedBtn() {
                if ($('.news_checkbox:checked').length > 0) {
                    $('#btn_delete_selected').removeClass('d-none');
                } else {
                    $('#btn_delete_selected').addClass('d-none');
                }
            }

            $(document).on('click', '#btn_delete_selected', function() {
                if(confirm('Are you sure you want to delete the selected news items?')) {
                    var ids = [];
                    $('.news_checkbox:checked').each(function() {
                        ids.push($(this).val());
                    });
                    
                    var btn = $(this);
                    btn.attr('data-kt-indicator', 'on').prop('disabled', true);
                    
                    $.ajax({
                        url: "{{ route('admin.news-assignment.deleteBulkNews') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: ids
                        },
                        success: function(response) {
                            window.LaravelDataTables['news_assignment_news_table'].ajax.reload(null, false);
                            $('#check_all').prop('checked', false);
                            $('#btn_delete_selected').addClass('d-none');
                            btn.removeAttr('data-kt-indicator').prop('disabled', false);
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting.');
                            btn.removeAttr('data-kt-indicator').prop('disabled', false);
                        }
                    });
                }
            });
    </script>
    @endpush
</x-default-layout>