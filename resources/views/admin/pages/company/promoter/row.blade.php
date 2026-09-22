<div class="card card-flush py-4 mb-5">
    <div class="card-body pt-0">
        <div class="d-flex flex-wrap gap-10 justify-content-end">
            <button class="btn btn-danger hover-elevate-up btn-sm me-1 btn-removeTeam" type="button">
                <i class="fa fa-trash"></i> Remove
            </button>
        </div>
        <div class="d-flex flex-wrap gap-10 mb-5">
            <input type="hidden" name="old[]" value="{{ $item->id ?? '' }}">
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Name</label>
                <input name="name[]" class="form-control mb-2" placeholder="Enter Name" tabindex="0" type="text"
                    value="{{ $item->name ?? '' }}" required>
            </div>
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Designation</label>
                <input name="designation[]" class="form-control mb-2" placeholder="Enter Designation" tabindex="0"
                    type="text" value="{{ $item->designation ?? '' }}" required>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-10">
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Experience</label>
                <input name="experience[]" class="form-control mb-2" placeholder="Enter Experience" tabindex="0"
                    type="text" value="{{ $item->experience ?? '' }}" required>
            </div>
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Linked In Url</label>
                <input name="url[]" class="form-control mb-2" placeholder="Enter Linked In Url" tabindex="0"
                    type="text" value="{{ $item->url ?? '' }}" required>
            </div>
        </div>
    </div>
</div>
