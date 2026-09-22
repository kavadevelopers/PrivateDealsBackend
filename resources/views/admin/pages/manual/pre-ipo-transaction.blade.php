<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('common') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.manual.preipo-transaction.save') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Create</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">

                        <div class="d-flex flex-wrap gap-10 mb-5">


                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Investor</label>
                                <select class="form-select" data-control="select2" data-placeholder="Select an investor"
                                    name="investor_id" aria-label="Select example">
                                    <option value="">-- Select Investor --</option>
                                    @foreach ($investors as $investor)
                                    <option value="{{ $investor->id }}" {{ old('investor_id')==$investor->id ?
                                        'selected' : '' }}>
                                        {{ $investor->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'investor_id',
                                ])
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Company</label>
                                <select class="form-select" data-control="select2" name="company_id"
                                    data-placeholder="Select Company" aria-label="Select example">
                                    <option value="">-- Select Company --</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id')==$company->id ? 'selected' :
                                        '' }}>
                                        {{ $company->brand_name }} -
                                        {{ $company->status ? 'Completed' : 'Raising now' }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'company_id',
                                ])
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Shares</label>
                                <input name="shares" class="form-control mb-2 input input-number  input-number-words"
                                    placeholder="Enter Shares" tabindex="0" type="text" value="{{ old('shares') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'shares'])
                            </div>


                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Share Price</label>
                                <input name="share_price"
                                    class="form-control mb-2 input input-decimal-number input-number-words"
                                    placeholder="Enter Share Price" tabindex="0" type="text"
                                    value="{{ old('share_price') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'share_price',
                                ])
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">PrivateDeals Price</label>
                                <input name="shuru_price"
                                    class="form-control mb-2 input input-decimal-number input-number-words"
                                    placeholder="Enter PrivateDeals Price" tabindex="0" type="text"
                                    value="{{ old('shuru_price') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'shuru_price',
                                ])
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Distributer Price</label>
                                <input name="distributer_price"
                                    class="form-control mb-2 input input-decimal-number input-number-words"
                                    placeholder="Enter Distributer Price" tabindex="0" type="text"
                                    value="{{ old('distributer_price') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'distributer_price',
                                ])
                            </div>


                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Is Distributer</label>
                                <select class="form-select" name="is_distributer" aria-label="Select example">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'is_distributer',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Seller</label>
                                <select class="form-select" data-control="select2" data-placeholder="Select an Seller"
                                    name="seller_id" aria-label="Select example">
                                    <option value="">-- Select Seller --</option>
                                    @foreach ($sellers as $seller)
                                    <option value="{{ $seller->id }}" {{ old('seller_id')==$seller->id ? 'selected' : ''
                                        }}>
                                        {{ $seller->company_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'seller_id',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Transaction Date</label>
                                <input name="date" class="form-control mb-2 input flat-datepicker"
                                    placeholder="Enter Transaction Date" tabindex="0" type="text"
                                    value="{{ old('date') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'date',
                                ])
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Transaction Type</label>
                                <select class="form-select" name="transaction_type"
                                    aria-label="Select transaction type">
                                    <option value="">-- Select Type --</option>
                                    <option value="begin" {{ old('transaction_type')=='begin' ? 'selected' : '' }}>
                                        Start from Begin (Goes to Market)
                                    </option>
                                    <option value="completed" {{ old('transaction_type')=='completed' ? 'selected' : ''
                                        }}>
                                        Completed Transaction
                                    </option>
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'transaction_type',
                                ])
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">
                                    Submit
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-default-layout>