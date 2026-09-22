<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('common') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.manual.primary-transaction.save') }}"
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
                                <label class="required form-label">Types Investment</label>
                                <select class="form-select" name="type" aria-label="Select example">
                                    <option value="">-- Select Type --</option>
                                    @foreach (App\Enums\PrimaryTransactionTypeEnum::cases() as $transactionType)
                                        <option value="{{ $transactionType }}"
                                            {{ old('type') == $transactionType->value ? 'selected' : '' }}>
                                            {{ $transactionType }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'type',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Investor</label>
                                <select class="form-select" data-control="select2" data-placeholder="Select an investor"
                                    name="investor_id" aria-label="Select example">
                                    <option value="">-- Select Investor --</option>
                                    @foreach ($investors as $investor)
                                        <option value="{{ $investor->id }}"
                                            {{ old('investor_id') == $investor->id ? 'selected' : '' }}>
                                            {{ $investor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'investor_id',
                                ])
                            </div>
                        </div>

                        @livewire('startup-round-dropdown', [
                            'selectedStartup' => old('startup_id'),
                            'selectedRound' => old('round_id'),
                            'isOptional' => false,
                        ])

                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Share Price</label>
                                <input name="share_price"
                                    class="form-control mb-2 input input-decimal-number  input-number-words"
                                    placeholder="Enter Share Price" tabindex="0" type="text"
                                    value="{{ old('share_price') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'share_price',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Investment Amount</label>
                                <input name="investment_amount"
                                    class="form-control mb-2 input input-decimal-number input-number-words"
                                    placeholder="Enter Investment Amount" tabindex="0" type="text"
                                    value="{{ old('investment_amount') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'investment_amount',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Types Of Shares</label>
                                <select class="form-select" name="instrument" aria-label="Select example">
                                    <option value="">-- Select Type --</option>
                                    @foreach (App\Enums\InstrumentTypeEnum::cases() as $instrument)
                                        <option value="{{ $instrument }}"
                                            {{ old('instrument') == $instrument->value ? 'selected' : '' }}>
                                            {{ $instrument }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'instrument',
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
