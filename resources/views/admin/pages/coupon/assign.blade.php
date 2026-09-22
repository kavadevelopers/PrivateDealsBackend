<x-default-layout>
    @section('title') {{ getPageTitle() }} @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-900px mb-7 me-7 me-lg-10">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.coupon.assign.store') }}" id="assignForm">
                @csrf
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Assign Coupon to Investors</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">

                        <div class="fv-row mb-7">
                            <label class="required form-label">Select Coupon</label>
                            <select class="form-select" name="coupon_id" required>
                                <option value="">-- Select Coupon --</option>
                                @foreach($coupons as $coupon)
                                <option value="{{ $coupon->id }}" {{ old('coupon_id')==$coupon->id ? 'selected' : '' }}>
                                    {{ $coupon->code }} — {{ $coupon->type }} ({{ $coupon->discount_value }})
                                </option>
                                @endforeach
                            </select>
                            @error('coupon_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required form-label">Select Investors</label>
                            <div class="mb-3">
                                <input type="text" id="investor_search" class="form-control"
                                    placeholder="Search by name, mobile or email...">
                            </div>
                            <div class="card">
                                <div class="card-body py-3" style="height: 350px; overflow-y: scroll;">
                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-3"
                                        id="investors-table">
                                        <thead>
                                            <tr class="fw-bold text-muted">
                                                <th class="w-25px">
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="checkAllInvestors">
                                                    </div>
                                                </th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($investors as $investor)
                                            <tr>
                                                <td>
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input investor-checkbox"
                                                            type="checkbox" name="investor_ids[]"
                                                            value="{{ $investor->id }}" {{ in_array($investor->id,
                                                        old('investor_ids', [])) ? 'checked' : '' }}
                                                        data-name="{{ strtolower($investor->name) }}"
                                                        data-mobile="{{ $investor->mobile_number }}"
                                                        data-email="{{ strtolower($investor->email) }}">
                                                    </div>
                                                </td>
                                                <td><span class="text-gray-900 fw-bold">{{ $investor->name }}</span>
                                                </td>
                                                <td>{{ $investor->mobile_number }}</td>
                                                <td>{{ $investor->email }}</td>
                                            </tr>
                                            @endforeach
                                            <tr id="investors-no-data" style="display: none;">
                                                <td colspan="4" class="text-center text-muted fst-italic py-5">No
                                                    investors found</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @error('investor_ids') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="text-muted fs-7">
                            <strong>Note:</strong> If a coupon is already active/assigned to an investor, it will be
                            skipped.
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.coupon.list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary">Assign Coupon</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {

        $('#investor_search').on('input', function () {
            const q = $(this).val().toLowerCase().trim();

            if (q === '') {
                $('#investors-table tbody tr').not('#investors-no-data').show();
                $('#investors-no-data').hide();
                return;
            }

            let visible = 0;

            $('#investors-table tbody tr').not('#investors-no-data').each(function () {
                const name   = String($(this).find('.investor-checkbox').data('name') || '').toLowerCase();
                const mobile = String($(this).find('.investor-checkbox').data('mobile') || '');
                const email  = String($(this).find('.investor-checkbox').data('email') || '').toLowerCase();

                if (name.includes(q) || mobile.includes(q) || email.includes(q)) {
                    $(this).show();
                    visible++;
                } else {
                    $(this).hide();
                }
            });

            $('#investors-no-data').toggle(visible === 0);
        });

        $('#checkAllInvestors').on('change', function () {
            $('#investors-table tbody tr:visible .investor-checkbox').prop('checked', $(this).prop('checked'));
        });

    });
    </script>
    @endpush
</x-default-layout>