<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('company.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.company.pendingSeller') }}" class="btn btn-sm btn-light-warning me-2">
                            Pending seller companies
                        </a>
                        <a href="{{ route('admin.company.create') }}" class="btn btn-sm btn-primary">
                            Create
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th>Logo</th>
                                        <th>Brand Name</th>
                                        <th>Company Name</th>
                                        <th>Category</th>
                                        <th>Share Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody> 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sharePriceModal" tabindex="-1" aria-labelledby="sharePriceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sharePriceModalLabel">Share Prices</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="px-5 pt-5 pb-4 border-bottom bg-body flex-shrink-0">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label" for="share_price_date_from">Date from</label>
                            <input type="text" id="share_price_date_from" class="form-control flat-datepicker"
                                placeholder="Select date" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="share_price_date_to">Date to</label>
                            <input type="text" id="share_price_date_to" class="form-control flat-datepicker"
                                placeholder="Select date" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary me-2" id="sharePriceFilterApply">Apply</button>
                            <button type="button" class="btn btn-light" id="sharePriceFilterClear">Clear</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body overflow-auto" id="sharePriceScroll">
                    <div id="sharePriceModalLoading" class="text-center py-10 d-none">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="sharePriceModalError" class="alert alert-danger d-none"></div>
                    <div class="table-responsive">
                        <table class="table table-row-bordered gy-3 gs-5">
                            <thead class="sticky-top bg-body">
                                <tr class="fw-semibold fs-6 text-gray-800">
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Distributer Price</th>
                                    <th>Base Price</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody id="sharePriceTableBody"></tbody>
                        </table>
                    </div>
                    <div id="sharePriceLoadMore" class="text-center py-4 d-none">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="sharePricePageInfo" class="text-muted fs-7 mt-3"></div>
                    <div id="sharePriceScrollSentinel" class="py-1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
    $(document).ready(function() {
    const table = $("#kt_datatable_dom_positioning").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.company.companyList') }}",
            complete: function() {
                KTMenu.createInstances();
            }
        },
        columns: [
            { data: "logo", orderable: false, searchable: false },
            { data: "brand_name", searchable: true },
            { data: "company_name", searchable: true },
            { data: "category", searchable: true },
            { data: "share_price", searchable: true },
            { data: "action", orderable: false, searchable: false }
        ],
        language: {
            lengthMenu: "Show _MENU_ records per page",
            zeroRecords: "No matching records found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No records available",
            infoFiltered: "(filtered from _MAX_ total records)"
        },
        order: [],
        pageLength: 10,
        searching: true,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
    });

    table.on('draw.dt', function() {
        KTMenu.createInstances();
    });

    const sharePriceListUrlTemplate = @json(route('admin.company.sharePrice', ['uuid' => '__UUID__']));
    const sharePriceDeleteUrlTemplate = @json(route('admin.company.sharePriceDelete', ['uuid' => '__UUID__', 'id' => '__ID__']));
    const sharePriceState = {
        uuid: null,
        page: 1,
        perPage: 15,
        dateFrom: '',
        dateTo: '',
        lastPage: 1,
        total: 0,
        loaded: 0,
        loading: false,
        hasMore: true
    };

    function sharePriceListUrl(uuid) {
        return sharePriceListUrlTemplate.replace('__UUID__', encodeURIComponent(uuid));
    }

    function sharePriceDeleteUrl(uuid, id) {
        return sharePriceDeleteUrlTemplate
            .replace('__UUID__', encodeURIComponent(uuid))
            .replace('__ID__', encodeURIComponent(id));
    }

    function initSharePriceDatepickers() {
        $('#share_price_date_from, #share_price_date_to').each(function() {
            if (this._flatpickr) {
                return;
            }
            $(this).flatpickr({
                dateFormat: 'd-m-Y',
                allowInput: true
            });
        });
    }

    function resetSharePriceScroll() {
        const scroller = document.getElementById('sharePriceScroll');
        if (scroller) {
            scroller.scrollTop = 0;
        }
    }

    function setSharePriceLoading(isLoading, append) {
        if (append) {
            $('#sharePriceLoadMore').toggleClass('d-none', !isLoading);
            return;
        }
        $('#sharePriceModalLoading').toggleClass('d-none', !isLoading);
        $('#sharePriceTableBody').closest('.table-responsive').toggleClass('d-none', isLoading);
        $('#sharePricePageInfo').toggleClass('d-none', isLoading);
        $('#sharePriceLoadMore').addClass('d-none');
    }

    function showSharePriceError(message) {
        $('#sharePriceModalError').removeClass('d-none').text(message || 'Unable to load share prices');
    }

    function hideSharePriceError() {
        $('#sharePriceModalError').addClass('d-none').text('');
    }

    function updateSharePricePageInfo() {
        if (!sharePriceState.total) {
            $('#sharePricePageInfo').text('No records');
            return;
        }
        $('#sharePricePageInfo').text(
            'Loaded ' + sharePriceState.loaded + ' of ' + sharePriceState.total +
            (sharePriceState.hasMore ? ' â€” scroll for more' : '')
        );
    }

    function sharePriceRowHtml(row) {
        return '<tr class="js-share-price-row" data-id="' + escapeSharePriceHtml(row.id) + '">' +
            '<td>' + escapeSharePriceHtml(row.date) + '</td>' +
            '<td>' + escapeSharePriceHtml(row.price) + '</td>' +
            '<td>' + escapeSharePriceHtml(row.distributer_price) + '</td>' +
            '<td>' + escapeSharePriceHtml(row.base_price) + '</td>' +
            '<td class="text-end">' +
                '<button type="button" class="btn btn-sm btn-light-danger js-share-price-delete" data-id="' + escapeSharePriceHtml(row.id) + '">' +
                    '<i class="fas fa-trash fs-7"></i> Delete' +
                '</button>' +
            '</td>' +
        '</tr>';
    }

    function renderSharePriceRows(rows, append) {
        const $body = $('#sharePriceTableBody');
        if (!append) {
            $body.empty();
        }
        $body.find('.js-share-price-empty').remove();
        if ((!rows || !rows.length) && !append) {
            $body.append(
                '<tr class="js-share-price-empty"><td colspan="5" class="text-center text-muted py-8">No share prices found</td></tr>'
            );
            sharePriceState.loaded = 0;
            return;
        }
        (rows || []).forEach(function(row) {
            if ($body.find('tr.js-share-price-row[data-id="' + row.id + '"]').length) {
                return;
            }
            $body.append(sharePriceRowHtml(row));
        });
        sharePriceState.loaded = $body.find('tr.js-share-price-row').length;
        if (!sharePriceState.loaded) {
            $body.append(
                '<tr class="js-share-price-empty"><td colspan="5" class="text-center text-muted py-8">No share prices found</td></tr>'
            );
        }
    }

    function escapeSharePriceHtml(value) {
        return $('<div>').text(value == null ? '' : String(value)).html();
    }

    function maybeLoadMoreSharePrices() {
        if (sharePriceState.loading || !sharePriceState.hasMore) {
            return;
        }
        const scroller = document.getElementById('sharePriceScroll');
        if (!scroller) {
            return;
        }
        if (scroller.scrollHeight <= scroller.clientHeight + 80) {
            loadSharePrices(false);
        }
    }

    function loadSharePrices(reset) {
        if (!sharePriceState.uuid || sharePriceState.loading) {
            return;
        }
        if (!reset && !sharePriceState.hasMore) {
            return;
        }
        if (reset) {
            sharePriceState.page = 1;
            sharePriceState.hasMore = true;
            sharePriceState.loaded = 0;
        }
        sharePriceState.loading = true;
        hideSharePriceError();
        setSharePriceLoading(true, !reset);
        $.ajax({
            url: sharePriceListUrl(sharePriceState.uuid),
            type: 'GET',
            dataType: 'json',
            data: {
                page: sharePriceState.page,
                per_page: sharePriceState.perPage,
                date_from: sharePriceState.dateFrom,
                date_to: sharePriceState.dateTo
            }
        }).done(function(payload) {
            const rows = payload.data || [];
            sharePriceState.lastPage = payload.last_page || 1;
            sharePriceState.total = payload.total || 0;
            renderSharePriceRows(rows, !reset);
            sharePriceState.hasMore = sharePriceState.page < sharePriceState.lastPage;
            if (rows.length) {
                sharePriceState.page = sharePriceState.page + 1;
            } else {
                sharePriceState.hasMore = false;
            }
            updateSharePricePageInfo();
            if (reset) {
                resetSharePriceScroll();
            }
        }).fail(function(xhr) {
            if (reset) {
                renderSharePriceRows([], false);
            }
            showSharePriceError(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Unable to load share prices');
        }).always(function() {
            sharePriceState.loading = false;
            setSharePriceLoading(false, !reset);
            maybeLoadMoreSharePrices();
        });
    }

    $(document).on('click', '.js-share-price-modal', function(e) {
        e.preventDefault();
        sharePriceState.uuid = $(this).data('uuid');
        sharePriceState.dateFrom = '';
        sharePriceState.dateTo = '';
        $('#sharePriceModalLabel').text('Share prices of ' + ($(this).data('name') || ''));
        $('#share_price_date_from').val('');
        $('#share_price_date_to').val('');
        if ($('#share_price_date_from')[0] && $('#share_price_date_from')[0]._flatpickr) {
            $('#share_price_date_from')[0]._flatpickr.clear();
        }
        if ($('#share_price_date_to')[0] && $('#share_price_date_to')[0]._flatpickr) {
            $('#share_price_date_to')[0]._flatpickr.clear();
        }
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('sharePriceModal'));
        modal.show();
        initSharePriceDatepickers();
        loadSharePrices(true);
    });

    $('#sharePriceModal').on('shown.bs.modal', function() {
        maybeLoadMoreSharePrices();
    });

    $('#sharePriceFilterApply').on('click', function() {
        sharePriceState.dateFrom = $('#share_price_date_from').val();
        sharePriceState.dateTo = $('#share_price_date_to').val();
        loadSharePrices(true);
    });

    $('#sharePriceFilterClear').on('click', function() {
        sharePriceState.dateFrom = '';
        sharePriceState.dateTo = '';
        $('#share_price_date_from').val('');
        $('#share_price_date_to').val('');
        if ($('#share_price_date_from')[0] && $('#share_price_date_from')[0]._flatpickr) {
            $('#share_price_date_from')[0]._flatpickr.clear();
        }
        if ($('#share_price_date_to')[0] && $('#share_price_date_to')[0]._flatpickr) {
            $('#share_price_date_to')[0]._flatpickr.clear();
        }
        loadSharePrices(true);
    });

    $('#sharePriceScroll').on('scroll', function() {
        const scroller = this;
        if (sharePriceState.loading || !sharePriceState.hasMore) {
            return;
        }
        if (scroller.scrollTop + scroller.clientHeight >= scroller.scrollHeight - 80) {
            loadSharePrices(false);
        }
    });

    $(document).on('click', '.js-share-price-delete', function() {
        const id = $(this).data('id');
        if (!id || !sharePriceState.uuid) {
            return;
        }
        const $btn = $(this);
        Swal.fire({
            text: 'Are you sure you want to delete this share price?',
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            }
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }
            $btn.prop('disabled', true);
            $.ajax({
                url: sharePriceDeleteUrl(sharePriceState.uuid, id),
                type: 'DELETE',
                dataType: 'json'
            }).done(function(payload) {
                Swal.fire({
                    text: payload.message || 'Share price deleted',
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' }
                });
                $btn.closest('tr.js-share-price-row').remove();
                sharePriceState.loaded = $('#sharePriceTableBody tr.js-share-price-row').length;
                sharePriceState.total = Math.max(0, sharePriceState.total - 1);
                if (sharePriceState.loaded === 0) {
                    if (sharePriceState.hasMore) {
                        loadSharePrices(false);
                    } else {
                        renderSharePriceRows([], false);
                    }
                }
                updateSharePricePageInfo();
                table.ajax.reload(null, false);
                maybeLoadMoreSharePrices();
            }).fail(function(xhr) {
                $btn.prop('disabled', false);
                Swal.fire({
                    text: xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Unable to delete share price',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' }
                });
            });
        });
    });
});
    </script>
    @endpush

</x-default-layout>
