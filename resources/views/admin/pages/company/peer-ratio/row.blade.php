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
                <label class="required form-label">Particular</label>
                <input name="perticular[]" class="form-control mb-2" placeholder="Enter Particular" tabindex="0"
                    type="text" value="{{ $item->perticular ?? '' }}" required>
            </div>
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Revenue</label>
                <input name="revenue[]" class="form-control mb-2" placeholder="Enter Revenue" tabindex="0"
                    type="text" value="{{ $item->revenue ?? '' }}" required>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-10">
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">EPS</label>
                <input name="eps[]" class="form-control mb-2" placeholder="Enter EPS" tabindex="0" type="text"
                    value="{{ $item->eps ?? '' }}" required>
            </div>
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">Market Cap</label>
                <input name="market_cap[]" class="form-control mb-2" placeholder="Enter Market Cap" tabindex="0"
                    type="text" value="{{ $item->market_cap ?? '' }}" required>
            </div>
            <div class="fv-row w-100 flex-md-root">
                <label class="required form-label">P/E</label>
                <input name="pe[]" class="form-control mb-2" placeholder="Enter P/E" tabindex="0" type="text"
                    value="{{ $item->pe ?? '' }}" required>
            </div>
        </div>
    </div>
</div>
