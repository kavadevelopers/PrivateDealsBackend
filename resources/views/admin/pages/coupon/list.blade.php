<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('coupon.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Coupon List</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.coupon.create') }}" class="btn btn-sm btn-primary">
                            Create Coupon
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Discount</th>
                                        <th>Applies On</th>
                                        <th>Company Scope</th>
                                        <th>Valid From</th>
                                        <th>Valid To</th>
                                        <th>Status</th>
                                        <th>Usage Limit</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>
                                            <strong>{{ $coupon->code }}</strong>
                                            @if ($coupon->description)
                                            <br><small class="text-muted">{{ Str::limit($coupon->description, 50)
                                                }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">
                                                {{ $coupon->type }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($coupon->type === \App\Enums\CouponTypeEnum::percentagediscount->value)
                                            {{ number_format($coupon->discount_value, 2) }}%
                                            @if ($coupon->max_discount_amount)
                                            <br><small class="text-muted">Max: ₹{{
                                                number_format($coupon->max_discount_amount, 2) }}</small>
                                            @endif
                                            @elseif ($coupon->type === \App\Enums\CouponTypeEnum::flatdiscount->value)
                                            ₹{{ number_format($coupon->discount_value, 2) }}
                                            @elseif ($coupon->type ===
                                            \App\Enums\CouponTypeEnum::persharediscount->value)
                                            ₹{{ number_format($coupon->discount_value, 2) }}/share
                                            @elseif ($coupon->type === \App\Enums\CouponTypeEnum::cashback->value)
                                            ₹{{ number_format($coupon->discount_value, 2) }} (Cashback)
                                            @else
                                            ₹{{ number_format($coupon->discount_value, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-light-primary">
                                                {{ str_replace('_', ' ', ucwords($coupon->applies_on, '_')) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($coupon->company_id)
                                            <span class="badge badge-light-warning">{{
                                                \App\Enums\CouponCompanyScopeEnum::single->value }}</span>
                                            <br><small>{{ $coupon->company->brand_name ?? 'N/A' }}</small>
                                            @elseif ($coupon->companies->count() > 0)
                                            <span class="badge badge-light-success">{{
                                                \App\Enums\CouponCompanyScopeEnum::multiple->value }} ({{
                                                $coupon->companies->count() }})</span>
                                            @else
                                            <span class="badge badge-light-secondary">{{
                                                \App\Enums\CouponCompanyScopeEnum::all->value }} Companies</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $coupon->valid_from ? $coupon->valid_from->format('d M Y') : 'No Limit'
                                            }}
                                        </td>
                                        <td>
                                            {{ $coupon->valid_to ? $coupon->valid_to->format('d M Y') : 'No Limit' }}
                                        </td>
                                        <td>
                                            @if ($coupon->is_active)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                @if ($coupon->usage_limit_per_user)
                                                Per User: {{ $coupon->usage_limit_per_user }}
                                                @else
                                                Per User: Unlimited
                                                @endif
                                                <br>
                                                @if ($coupon->usage_limit_global)
                                                Global: {{ $coupon->usage_limit_global }}
                                                @else
                                                Global: Unlimited
                                                @endif
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.coupon.edit', ['uuid' => $coupon->uuid]) }}"
                                                class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1"
                                                title="Edit">
                                                <i class="fas fa-pencil fs-6"></i>
                                            </a>

                                            <form action="{{ route('admin.coupon.delete', ['uuid' => $coupon->uuid]) }}"
                                                method="POST" style="display:inline;" id="delete-form-{{ $coupon->id }}"
                                                onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1"
                                                    title="Delete">
                                                    <i class="fas fa-trash fs-6"></i>
                                                </button>
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