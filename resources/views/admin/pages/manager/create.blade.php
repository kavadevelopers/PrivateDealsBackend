<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manager.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.manager.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Create Admin</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Role</label>
                                <select class="form-select" name="role" aria-label="Select example">
                                    <option value="">-- Select Role --</option>
                                    @foreach (App\Enums\AdminTypeEnum::cases() as $adminType)
                                        <option value="{{ $adminType }}"
                                            {{ old('role') == $adminType->value ? 'selected' : '' }}>
                                            {{ $adminType }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'role',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Name</label>
                                <input name="name" class="form-control mb-2 input" placeholder="Enter Full Name"
                                    tabindex="0" type="text" value="{{ old('name') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'name'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Username</label>
                                <input name="username" class="form-control mb-2 input" placeholder="Enter Username"
                                    tabindex="0" type="text" value="{{ old('username') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'username'])
                            </div>

                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Mobile Number</label>
                                <input name="mobile_no" class="form-control mb-2 input"
                                    placeholder="Enter Mobile Number" tabindex="0" type="text"
                                    value="{{ old('mobile_no') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'mobile_no',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Email</label>
                                <input name="email" class="form-control mb-2 input" placeholder="Enter Email"
                                    tabindex="0" type="text" value="{{ old('email') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'email'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Password</label>
                                <input name="password" class="form-control mb-2" placeholder="Enter Password"
                                    tabindex="0" type="text" value="{{ old('password') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'password',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Permissions</h2>
                        </div>
                    </div>

                    <div class="px-7 py-5">
                        <div class="mb-10">
                            <div class="d-flex flex-wrap">
                                @foreach ($permissions as $permission)
                                    <label
                                        class="form-check form-check-sm form-check-custom form-check-solid me-5 mb-5">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="{{ $permission->name }}"
                                            {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                        <span class="form-check-label">
                                            {{ ucfirst($permission->name) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.manager.list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
