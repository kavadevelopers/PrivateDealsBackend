<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('systemConfiguration.appVersionControl.create') }}
    @endsection


    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.systemConfiguration.appVersionControl.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Fill Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Title</label>
                                <input name="title" class="form-control mb-2" placeholder="Enter Title" tabindex="0"
                                    type="text" value="{{ old('title') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'title'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Is force update?</label>
                                <select class="form-select" name="force_update">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'force_update',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Description</label>
                                <textarea name="description" class="form-control mb-2"
                                    placeholder="Enter Description">{{ old('description') }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'description',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Last version code</label>
                                <input name="last_version_code" class="form-control mb-2 input-number"
                                    placeholder="Enter Last version code" tabindex="0" type="text"
                                    value="{{ old('last_version_code') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'last_version_code',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Current version code</label>
                                <input name="current_version_code" class="form-control mb-2 input-number"
                                    placeholder="Enter Current version code" tabindex="0" type="text"
                                    value="{{ old('current_version_code') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'current_version_code',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Last version</label>
                                <input name="last_version" class="form-control mb-2 input-version-number"
                                    placeholder="Enter Last version (e.g., 3.0.3)" tabindex="0" type="text"
                                    value="{{ old('last_version') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'last_version',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Current version</label>
                                <input name="current_version" class="form-control mb-2 input-version-number"
                                    placeholder="Enter Current version (e.g., 3.0.3)" tabindex="0" type="text"
                                    value="{{ old('current_version') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'current_version',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">App User Type</label>
                                <select class="form-select" name="user_type">
                                    <option value="">-- Select App User Type --</option>
                                    <option value="investor" {{ old('user_type')==='investor' ? 'selected' : '' }}>
                                        Investor</option>
                                    <option value="distributer" {{ old('user_type')==='distributer' ? 'selected' : ''
                                        }}>Distributer</option>
                                    <option value="startup" {{ old('user_type')==='startup' ? 'selected' : '' }}>Startup
                                    </option>
                                    <option value="admin" {{ old('user_type')==='admin' ? 'selected' : '' }}>Admin
                                    </option>
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'user_type',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Device Type</label>
                                <select class="form-select" name="device_type">
                                    <option value="">-- Select Device Type --</option>
                                    @foreach (App\Enums\Utills\DeviceTypeEnum::cases() as $type)
                                    <option value="{{ $type->value }}" {{ old('device_type')===$type->value ? 'selected'
                                        : '' }}>
                                        {{ ucfirst($type->value) }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'device_type',
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