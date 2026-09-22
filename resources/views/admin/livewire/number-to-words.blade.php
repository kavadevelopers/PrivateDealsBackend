<div class="field_group">
    <label>{{ $label }}<span class="required">*</span></label>
    <input class="field input-number" type="text" wire:model.live="number" name="{{ $name }}"
        placeholder="{{ $placeholder }}">
    <i class="fa-solid fa-building input_icon"></i>
    @if ($words)
        <div class="suggestion">{{ $words }}</div>
    @endif
</div>
