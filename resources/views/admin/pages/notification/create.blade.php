<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('notification.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.notification.investor.store') }}"
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
                                <select class="form-select" name="investor_id" aria-label="Select example">
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
                                <label class="required form-label">Title</label>
                                <input name="title" class="form-control mb-2" placeholder="Enter Title" tabindex="0"
                                    type="text" value="{{ old('title') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'title'])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Body</label>
                                <textarea name="body" class="form-control mb-2" placeholder="Enter Description" tabindex="0" type="text">{{ old('body') }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'body',
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
