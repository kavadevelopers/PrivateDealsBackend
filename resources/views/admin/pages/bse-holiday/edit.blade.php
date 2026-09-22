<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('bse-holiday.edit') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.bse-holiday.update', ['uuid' => $item->uuid]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Holiday Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Holiday Date</label>
                                <input placeholder="Select Date" name="holiday_date"
                                    value="{{ old('holiday_date', $item->holiday_date->format('Y-m-d')) }}"
                                    class="form-control mb-2 input" tabindex="0" type="date" required>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'holiday_date',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Holiday Name</label>
                                <input placeholder="e.g., Republic Day" name="holiday_name"
                                    value="{{ old('holiday_name', $item->holiday_name) }}"
                                    class="form-control mb-2 input" tabindex="0" type="text" required>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'holiday_name',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Holiday Type</label>
                                <select class="form-select" name="holiday_type" required>
                                    <option value="">-- Select Type --</option>
                                    @foreach (App\Enums\HolidayTypeEnum::cases() as $type)
                                    <option value="{{ $type->value }}" {{ old('holiday_type', $item->holiday_type) ==
                                        $type->value ? 'selected' : '' }}>
                                        {{ $type->value }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'holiday_type',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <label class="form-label required">Image</label>
                                @if ($item->holiday_img)
                                <div class="mb-3">
                                    <img src="{{ FileUpDownHelper::get_holiday_img_url($item) }}" alt="Holiday Image"
                                        class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                                </div>
                                @endif
                                <input name="holiday_img" class="form-control mb-2 input" placeholder="Enter Image"
                                    tabindex="0" type="file">
                                <div class="text-muted fs-7">Set the image of the holiday. size must be (2560w x
                                    891h)</div>

                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control mb-2 input"
                                    placeholder="Enter Title" tabindex="0" value="{{ old('title', $item->title) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'title',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Notes</label>
                                <textarea placeholder="Add any additional notes about this holiday" name="notes"
                                    class="form-control mb-2 input" tabindex="0"
                                    rows="3">{{ old('notes', $item->notes) }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'notes',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.bse-holiday.index') }}" class="btn btn-light me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

</x-default-layout>