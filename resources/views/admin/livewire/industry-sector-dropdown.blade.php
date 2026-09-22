<div class="d-flex flex-wrap gap-10 mb-5">
    <div class="fv-row w-100 flex-md-root">
        <label class="required form-label">Industry</label>
        <select wire:model.live="selectedIndustry" class="form-select mb-2" name="industry_id" aria-label="Select example">
            <option value="">-- Select Industry --</option>
            @foreach ($industries as $industry)
                <option value="{{ $industry->id }}">
                    {{ ucfirst($industry->name) }}
                </option>
            @endforeach
        </select>
        @include('admin.partials.form.input-error-message', ['key' => 'industry_id'])
    </div>

    @if (!is_null($selectedIndustry) && $selectedIndustry != '')
        <div class="fv-row w-100 flex-md-root">
            <label class="required form-label">Sector</label>
            <select wire:model.live="selectedSector" class="form-select mb-2" name="sector_id"
                aria-label="Select example">
                <option value="">-- Select Sector --</option>
                @foreach ($sectors as $sector)
                    <option value="{{ $sector->id }}">
                        {{ ucfirst($sector->name) }}
                    </option>
                @endforeach
            </select>
            @include('admin.partials.form.input-error-message', ['key' => 'sector_id'])
        </div>
    @endif
</div>
