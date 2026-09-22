<div class="d-flex flex-wrap gap-10 mb-5 percentage-item">
    <div class="fv-row w-100 flex-md-root">
        <label class="required form-label">Year</label>
        <input name="year[]" class="form-control mb-2 input-number year-input" placeholder="Enter Year" tabindex="0"
            type="text" value="{{ $item->year ?? '' }}" required>
    </div>
    <div class="fv-row w-100 flex-md-root">
        <label class="required form-label">Percentage</label>
        <input name="percentage[]" class="form-control mb-2 input-decimal-number percentage-input"
            placeholder="Enter Percentage" tabindex="0" type="text" value="{{ $item->percentage ?? '' }}" required>
    </div>
    <div class="fv-row w-100 flex-md-root justify-content-center">
        <label class="form-label"><br><br><br></label>
        <button class="btn btn-danger hover-elevate-up btn-sm me-1 btn-removePercentage" type="button">
            <i class="fa fa-trash"></i> Remove Percentage
        </button>
    </div>
</div>
