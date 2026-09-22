<?php

namespace App\Support;

class Nav
{
    public static function isActive(string $path): bool
    {
        if ($path === '/') {
            $current = request()->path();

            return $current === '/' || $current === '';
        }

        $normalized = ltrim($path, '/');

        return request()->is($normalized) || request()->is($normalized . '/*');
    }

    public static function navLinkClass(bool $active): string
    {
        $base = 'hover:border-stroke-2 dark:hover:border-stroke-7 text-tagline-1 dark:text-accent hover:text-secondary dark:hover:text-accent flex items-center gap-1 rounded-full border border-transparent px-4 py-2 font-normal transition-all duration-200';

        return $active
            ? $base . ' text-secondary'
            : $base . ' text-secondary/60 dark:text-accent/60';
    }

    public static function mobileNavLinkClass(bool $active): string
    {
        $base = 'text-tagline-1 ml-0 block py-2.5 text-left font-normal transition-all duration-200';

        return $active
            ? $base . ' text-secondary dark:text-accent'
            : $base . ' text-secondary/60 dark:text-accent/60';
    }
}
