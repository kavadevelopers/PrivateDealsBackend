<?php

namespace App\Console\Commands;

use App\Helpers\AdminHelper;
use App\Models\CompanyModel;
use App\Models\StartupModel;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSlugs extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'seo:generate-slugs {--force : Force regeneration of slugs}';

    /**
     * The console command description.
     */
    protected $description = 'Generate URL slugs for companies and startups based on their names';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $force = $this->option('force');

        $this->info('Generating slugs for companies...');
        $this->generateCompanySlugs($force);

        $this->info('Generating slugs for startups...');
        $this->generateStartupSlugs($force);

        $this->info('✅ Slug generation completed!');
        return 0;
    }

    /**
     * Generate slugs for companies
     */
    private function generateCompanySlugs(bool $force = false): void
    {
        $query = CompanyModel::where('is_deleted', 0);

        if (!$force) {
            $query->whereNull('slug');
        }

        $companies = $query->get();
        $count = 0;

        foreach ($companies as $company) {
            $name = $company->brand_name ?? $company->company_name ?? '';
            if ($name === '') {
                $this->warn("   skipped company id {$company->id} (no name)");
                continue;
            }

            // Bypass model saving hook uniqueness path; set explicitly for backfill/force
            $company->slug = AdminHelper::companySlug($name, $company->id);
            $company->saveQuietly();
            $count++;
        }

        $this->info("   ✓ Generated/updated $count company slugs");
    }

    /**
     * Generate url_slug for startups
     */
    private function generateStartupSlugs(bool $force = false): void
    {
        $query = StartupModel::where('is_deleted', 0);

        if (!$force) {
            $query->where(function ($q) {
                $q->whereNull('url_slug')->orWhere('url_slug', '');
            });
        }

        $startups = $query->get();
        $count = 0;

        foreach ($startups as $startup) {
            $name = $startup->brand_name ?: $startup->company_name;
            if (!$name) {
                $this->warn("   skipped startup id {$startup->id} (no brand/company name)");
                continue;
            }

            $slug = $this->generateUniqueSlug($name, StartupModel::class, $startup->id, 'url_slug');
            $startup->update(['url_slug' => $slug]);
            $count++;
        }

        $this->info("   ✓ Generated/updated $count startup slugs");
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug(string $name, string $model, int $excludeId, string $column = 'slug'): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while ($model::where($column, $slug)
            ->where('id', '!=', $excludeId)
            ->exists()
        ) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
