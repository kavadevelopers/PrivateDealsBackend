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
                <label class="required form-label">Date</label>
                <input name="date[]" class="form-control mb-2 flat-datepicker" placeholder="Select Date" tabindex="0"
                    type="text"
                    value="{{ $item && $item->date ? \Carbon\Carbon::parse($item->date)->format('d-m-Y') : '' }}"
                    required>
            </div>
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Price</label>
                <input name="price[]" class="form-control mb-2 input-decimal-number" placeholder="Enter Price"
                    tabindex="0" type="text" value="{{ $item->price ?? '' }}" required>
            </div>
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Distributer Price</label>
                <input name="distributer_price[]" class="form-control mb-2 input-decimal-number"
                    placeholder="Enter Distributer Price" tabindex="0" type="text"
                    value="{{ $item->distributer_price ?? '' }}" required>
            </div>
        </div>
    </div>
</div>
