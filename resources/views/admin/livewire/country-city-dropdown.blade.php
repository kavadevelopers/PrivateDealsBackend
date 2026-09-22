<div class="d-flex flex-wrap gap-10 mb-5">
    <div class="fv-row w-100 flex-md-root">
        <label class="{{ !$isOptional ? 'required' : '' }} form-label">Country</label>
        <select wire:model.live="selectedCountry" class="form-select mb-2" id="country_id" name="country_id"
            aria-label="Select example">
            <option value="">-- Select Country --</option>
            @foreach ($countries as $country)
                <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
            @endforeach
        </select>
        @include('admin.partials.form.input-error-message', ['key' => 'country_id'])
    </div>

    @if (count($states) > 0)
        <div class="fv-row w-100 flex-md-root">
            <label class="{{ !$isOptional ? 'required' : '' }} form-label">State</label>
            <select wire:model.live="selectedState" class="form-select mb-2" id="state_id" name="state_id"
                aria-label="Select example">
                <option value="">-- Select State --</option>
                @foreach ($states as $state)
                    <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                @endforeach
            </select>
            @include('admin.partials.form.input-error-message', ['key' => 'state_id'])
        </div>
    @endif

    @if (count($cities) > 0)
        <div class="fv-row w-100 flex-md-root">
            <label class="{{ !$isOptional ? 'required' : '' }} form-label">City</label>
            <select wire:model.live="selectedCity" class="form-select mb-2" id="city_id" name="city_id"
                aria-label="Select example">
                <option value="">-- Select City --</option>
                @foreach ($cities as $city)
                    <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                @endforeach
            </select>
            @include('admin.partials.form.input-error-message', ['key' => 'city_id'])
        </div>
    @endif
</div>
