<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        @if (request()->routeIs('admin.companyEnquiry.pending'))
            {{ Breadcrumbs::render('companyEnquiry.pending') }}
        @elseif (request()->routeIs('admin.companyEnquiry.completed'))
            {{ Breadcrumbs::render('companyEnquiry.completed') }}
        @endif
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th>Partner</th>
                                        <th>User Type</th>
                                        <th>Type</th>
                                        <th>Company</th>
                                        <th>Deal</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Offer Price</th>
                                        <th>Valid Till</th>
                                        <th>Notes</th>
                                        <th>Created</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enquiries as $item)
                                        <tr>
                                            <td>{{ $item->user->name ?? '—' }}</td>
                                            <td>
                                                @php
                                                    $typeLabel = class_basename((string) $item->user_type);
                                                    $typeLabel = str_replace('Model', '', $typeLabel);
                                                @endphp
                                                {{ $typeLabel ?: '—' }}
                                            </td>
                                            <td>
                                                <span class="badge badge-light-{{ $item->enquiry_type?->value === 'buy' ? 'success' : 'warning' }}">
                                                    {{ strtoupper($item->enquiry_type?->value ?? '—') }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $item->company->brand_name ?? '—' }}
                                                @if ($item->company?->type)
                                                    <div class="text-muted fs-7">{{ ucfirst($item->company->type) }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->deal)
                                                    ₹{{ number_format((float) $item->deal->share_price, 2) }}
                                                    <div class="text-muted fs-7">
                                                        Avail: {{ $item->deal->available_quantity }}
                                                        · Min: {{ $item->deal->minimum_qty }}
                                                    </div>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">₹{{ number_format((float) $item->offer_price, 2) }}</td>
                                            <td>{{ optional($item->offer_valid_till)->format('d-m-Y') }}</td>
                                            <td>{{ $item->notes ? \Illuminate\Support\Str::limit($item->notes, 60) : '—' }}</td>
                                            <td>{{ optional($item->created_at)->format('d-m-Y H:i') }}</td>
                                            <td class="text-center">
                                                @if (request()->routeIs('admin.companyEnquiry.pending'))
                                                    <form
                                                        action="{{ route('admin.companyEnquiry.complete', ['id' => $item->id]) }}"
                                                        method="POST" style="display:inline;"
                                                        id="complete-form-{{ $item->id }}">
                                                        @csrf
                                                        <a href="#"
                                                            class="btn btn-success hover-elevate-up btn-icon btn-sm me-1"
                                                            title="Mark completed"
                                                            onclick="event.preventDefault(); if (confirm('Mark this enquiry as completed?')) document.getElementById('complete-form-{{ $item->id }}').submit();">
                                                            <i class="fas fa-check fs-6"></i>
                                                        </a>
                                                    </form>
                                                @endif
                                                <form
                                                    action="{{ route('admin.companyEnquiry.destroy', ['id' => $item->id]) }}"
                                                    method="POST" style="display:inline;"
                                                    id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#"
                                                        class="btn btn-danger hover-elevate-up btn-icon btn-sm"
                                                        title="Delete"
                                                        onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this enquiry?')) document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                        <i class="fas fa-trash fs-6"></i>
                                                    </a>
                                                </form>
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
            $("#kt_datatable_dom_positioning").DataTable({
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +
                    "<'table-responsive'tr>" +
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });
        </script>
    @endpush
</x-default-layout>
