<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('startup.manage') }}
    @endsection
    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto w-lg-400px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.startup.shareprice.post') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="startup_id" value="{{ $item->id }}" />
                <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Update Price</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0" data-select2-id="select2-data-128-idrh">
                        <div class="d-flex flex-column gap-10 mb-5" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="required form-label">New Share Price</label>
                                <input name="share_price"
                                    class="form-control mb-2 input input-decimal-number input-number-words"
                                    placeholder="Enter New Share Price" tabindex="0" type="text"
                                    value="{{ old('share_price') }}">
                                <div class="text-muted fs-7">Enter Share Price</div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                                <span class="indicator-label">
                                    Submit
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Price</th>
                                        <th class="pe-7">Updated At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->sharePrices()->orderBy('created_at', 'desc')->get() as $price)
                                        <tr>
                                            <td>{{ UtillsHelper::moneyFormatIndia($price->price) }}</td>
                                            <td>{{ DateTimeHelper::viewDate($price->created_at) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.startup.shareprice.delete', ['id' => $price->id]) }}"
                                                    class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1"
                                                    onclick="return confirm('Are you sure you want to delete this?');">
                                                    <i class="fas fa-trash fs-6"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $("#kt_datatable_dom_positioning").DataTable({
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "order": [],
                    "dom": "<'row mb-2'" +
                        "<'col-sm-6 d-flex align-items-center justify-conten-start dt-toolbar'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">"
                });
            })
        </script>
    @endpush

</x-default-layout>
