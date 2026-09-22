<div class="d-flex flex-wrap gap-10 mb-5">
    <!-- Startup Dropdown -->
    <div class="fv-row w-100 flex-md-root">
        <label class="{{ !$isOptional ? 'required' : '' }} form-label">Startup</label>
        <select wire:model.live="selectedStartup" class="form-select mb-2" id="startup_id" name="startup_id">
            <option value="">-- Select Startup --</option>
            @foreach ($startups as $startup)
                <option value="{{ $startup['id'] }}">{{ $startup['brand_name'] }}</option>
            @endforeach
        </select>
        @include('admin.partials.form.input-error-message', ['key' => 'startup_id'])
    </div>

    <!-- Round Dropdown -->
    @if (!empty($rounds))
        <div class="fv-row w-100 flex-md-root">
            <label class="{{ !$isOptional ? 'required' : '' }} form-label">Round</label>
            <select wire:model="selectedRound" class="form-select mb-2" id="round_id" name="round_id">
                <option value="">-- Select Round --</option>
                @foreach ($rounds as $round)
                    <option value="{{ $round['id'] }}">
                        {{ $round['name'] . ', ' . $round['instrument'] . ', ' . DateTimeHelper::viewDate($round['created_at']) }}
                    </option>
                @endforeach
            </select>
            @include('admin.partials.form.input-error-message', ['key' => 'round_id'])
        </div>
    @endif
</div>
