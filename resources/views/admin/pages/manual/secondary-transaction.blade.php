<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('common') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.manual.secondary-transaction.save') }}"
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
                                <label class="required form-label">Buyer</label>
                                <select class="form-select" data-control="select2" data-placeholder="Select Buyer"
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
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Startup</label>
                                <select class="form-select" data-control="select2" name="request_id"
                                    data-placeholder="Select Startup" aria-label="Select example">
                                    <option value="">-- Select Startup --</option>
                                    @foreach ($requests as $request)
                                        <option value="{{ $request->id }}"
                                            {{ old('request_id') == $request->id ? 'selected' : '' }}>
                                            {{ $request->startup->brand_name }} - {{ $request->shares }} - by
                                            {{ $request->investor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'request_id',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Shares</label>
                                <input name="shares" class="form-control mb-2 input input-number  input-number-words"
                                    placeholder="Enter Shares" tabindex="0" type="text"
                                    value="{{ old('shares') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'shares'])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
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
