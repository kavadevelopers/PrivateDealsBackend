<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('mgt14.list') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.startup.offerrequest.approveSave') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Fund Raise Details</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Offer ID</label>
                                <input name="offer_id" class="form-control mb-2 input" placeholder="Enter Offer ID"
                                    tabindex="0" type="text"
                                    value="{{ old('offer_id', $item->startup->StartupOtherOne ? $item->startup->StartupOtherOne->offer_id : '') }}"
                                    required>
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Offer Sign Coordinates</label>
                                <textarea name="offer_sign_coordinates" class="form-control mb-2 input" placeholder="Enter Offer Sign Coordinates"
                                    tabindex="0" type="text" value="" required>{{ old('offer_sign_coordinates', $item->startup->StartupOtherOne ? $item->startup->StartupOtherOne->offer_sign_coordinates : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Transactions</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mb-7">
                            <div class="col-lg-12 fv-row">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Investor name</th>
                                        <th>Offer Serial Number</th>
                                    </tr>
                                    @foreach ($transactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <input type="hidden" name="transaction[]"
                                                    value="{{ $transaction->id }}">
                                                <input class="form-control mb-2 input" tabindex="0" type="text"
                                                    value="{{ $transaction->investor->name }}" readonly>
                                            </td>
                                            <td><input name="serial_no[]" class="form-control mb-2 input"
                                                    placeholder="Enter Offer Serial number" tabindex="0"
                                                    type="text" value="{{ $transaction->offerletterno ?? $key + 1 }}"
                                                    required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <a href="{{ url()->previous() }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Update</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
