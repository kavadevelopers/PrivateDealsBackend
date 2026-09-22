<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('reports.resourceBilling.create') }}
    @endsection


    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.reports.resourceBilling.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Fill Resource Data</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row fv-plugins-icon-container col-12 col-md-6 col-lg-4">
                                <label class="form-label">Project Name</label>
                                <select class="form-select" name="project_name_id" aria-label="Select Project Name">
                                    <option value="">-- Select Project Name --</option>
                                    @foreach ($projectnames as $projectname)
                                        <option value="{{ $projectname->id }}"
                                            {{ old('project_name_id') == $projectname->id ? 'selected' : '' }}>
                                            {{ $projectname->project_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'project_name_id',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Resource Type</label>
                                <select class="form-select" name="resourece_type" aria-label="Select example">
                                    <option value="">-- Select Resource Type --</option>
                                    @foreach (App\Enums\ResoureceTypeEnum::cases() as $resourece_type)
                                        <option value="{{ $resourece_type->value }}"
                                            {{ old('resourece_type') == $resourece_type->value ? 'selected' : '' }}>
                                            {{ $resourece_type->value }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'resourece_type',
                                ])
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Company</label>
                                <input name="company" class="form-control mb-2" placeholder="Enter Company"
                                    value="{{ old('company') }}" />
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'company',
                                ])
                            </div>

                        </div>
                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Description</label>
                                <textarea name="description" class="form-control mb-2" placeholder="Enter Description">{{ old('description') }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'description',
                                ])
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Purchase Date</label>
                                <input name="purchase_date" class="form-control mb-2 input flat-datepicker"
                                    placeholder="Enter Purchase Date" tabindex="0" type="text"
                                    value="{{ old('purchase_date') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'purchase_date',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Renewal Date</label>
                                <input name="renewal_date" class="form-control mb-2 input flat-datepicker"
                                    placeholder="Enter Renewal Date" tabindex="0" type="text"
                                    value="{{ old('renewal_date') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'renewal_date',
                                ])
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Time Period(In Months)</label>
                                <input placeholder="Enter Time Period" name="time_period"
                                    value="{{ old('time_period') }}" class="form-control mb-2 input-decimal-number"
                                    tabindex="0" type="text"></input>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'time_period',
                                ])
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Billing Amount</label>
                                <input placeholder="Enter Billing Amount" name="amount" value="{{ old('amount') }}"
                                    class="form-control mb-2 input-decimal-number" tabindex="0"
                                    type="text"></input>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'amount',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Renewal Amount</label>
                                <input placeholder="Enter Renewal Amount" name="renewal_amount"
                                    value="{{ old('renewal_amount') }}" class="form-control mb-2 input-decimal-number"
                                    tabindex="0" type="text"></input>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'renewal_amount',
                                ])
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
    </div>

</x-default-layout>
