<?php

namespace App\View\Components;

use Illuminate\Support\Facades\File;
use Illuminate\View\Component;
use Illuminate\View\View;

class OptimizedImage extends Component
{
    public function __construct(
        public string $path,
        public string $alt = '',
        public ?string $width = null,
        public ?string $height = null,
        public string $loading = 'lazy',
        public ?string $fetchpriority = null,
    ) {}

    public function webpPath(): ?string
    {
        if (! preg_match('/\.(png|jpe?g)$/i', $this->path)) {
            return null;
        }

        $webp = preg_replace('/\.(png|jpe?g)$/i', '.webp', $this->path);

        return File::exists(public_path($webp)) ? $webp : null;
    }

    public function render(): View
    {
        return view('marketing.components.optimized-image');
    }
}
