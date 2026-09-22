@php
    $webp = $webpPath();
@endphp
<picture>
    @if ($webp)
        <source srcset="{{ asset($webp) }}" type="image/webp">
    @endif
    <img
        src="{{ asset($path) }}"
        alt="{{ $alt }}"
        @if ($width) width="{{ $width }}" @endif
        @if ($height) height="{{ $height }}" @endif
        loading="{{ $loading }}"
        @if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
        {{ $attributes }}
    />
</picture>
