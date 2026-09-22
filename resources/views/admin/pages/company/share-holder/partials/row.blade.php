<div class="card card-flush py-4 mb-5">
    <div class="card-body pt-0">
        <div class="d-flex flex-wrap gap-10 justify-content-end">
            <button class="btn btn-danger hover-elevate-up btn-sm me-1 btn-removeTeam" type="button">
                <i class="fa fa-trash"></i> Remove Share holder
            </button>
        </div>
        <div class="d-flex flex-wrap gap-10 mb-5">
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Share Holder Name</label>
                <input name="name[]" class="form-control mb-2 name-input" placeholder="Enter Share Holder Name"
                    tabindex="0" type="text" value="{{ $item->name ?? '' }}" required>
            </div>
        </div>
        <div class="percentage-list">
            @if ($item && $item->sharePercentage)
                @foreach ($item->sharePercentage as $per)
                    @include('admin.pages.company.share-holder.partials.percentage', [
                        'item' => $per,
                    ])
                @endforeach
            @else
                <div class="d-flex flex-wrap gap-10 mb-5 percentage-item">
                    <div class="fv-row w-100 flex-md-root">
                        <label class="required form-label">Year</label>
                        <input name="year[]" class="form-control mb-2 input-number year-input" placeholder="Enter Year"
                            tabindex="0" type="text" value="" required>
                    </div>
                    <div class="fv-row w-100 flex-md-root">
                        <label class="required form-label">Percentage</label>
                        <input name="percentage[]" class="form-control mb-2 input-decimal-number percentage-input"
                            placeholder="Enter Percentage" tabindex="0" type="text" value="" required>
                    </div>
                    <div class="fv-row w-100 flex-md-root justify-content-center">

                    </div>
                </div>
            @endif

        </div>
        <div class="d-flex flex-wrap gap-10 justify-content-end">
            <button class="btn btn-info hover-elevate-up btn-sm me-1 btn-add-percentage" type="button">
                <i class="fa fa-plus"></i> Add percentage
            </button>
        </div>
    </div>
</div>
