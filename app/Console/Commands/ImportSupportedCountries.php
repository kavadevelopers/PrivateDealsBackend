<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\MasterSupportedCountriesModel;
use Illuminate\Http\File;
use Illuminate\Support\Facades\File as FileFacade;
use App\Helpers\FileUpDownHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportSupportedCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:supported-countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import countries from REST API and upload flags to S3';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,flags,idd');

        if (!$response->ok()) {
            $this->error('Failed to fetch countries.');
            return;
        }

        $countries = $response->json();
        $this->info('Importing countries...');

        $tmpPath = storage_path('app/tmp_flags');
        if (!FileFacade::exists($tmpPath)) {
            FileFacade::makeDirectory($tmpPath, 0755, true);
        }

        foreach ($countries as $country) {
            $name = $country['name']['common'] ?? null;
            $flagUrl = $country['flags']['png'] ?? null;
            $root = $country['idd']['root'] ?? null;
            $suffixes = $country['idd']['suffixes'] ?? [];

            if (!$name || !$root || empty($suffixes)) {
                continue;
            }

            // Skip countries with multiple suffixes
            if (count($suffixes) > 1) {
                Log::info("Skipping country with multiple suffixes: {$name} (Suffixes: " . implode(', ', $suffixes) . ")");
                continue;
            }

            // Build full calling code (only for countries with exactly one suffix)
            $callingCode = ltrim($root, '+') . $suffixes[0];

            // Avoid duplicates
            if (MasterSupportedCountriesModel::where('code', $callingCode)->where('is_deleted', '0')->exists()) {
                continue;
            }

            $model = new MasterSupportedCountriesModel();
            $model->code = $callingCode;
            $model->name = $name;

            if ($flagUrl) {
                try {
                    $fileName = uniqid() . '.png';
                    $localPath = $tmpPath . '/' . $fileName;

                    file_put_contents($localPath, file_get_contents($flagUrl));

                    $uploadedFile = new UploadedFile(
                        $localPath,
                        $fileName,
                        'image/png',
                        null,
                        true
                    );

                    $s3Path = FileUpDownHelper::master_supported_countries_flag_upload($uploadedFile);
                    if ($s3Path) {
                        $model->flag = $s3Path;
                    }
                } catch (\Exception $e) {
                    $this->warn("Failed to process flag for {$name}: " . $e->getMessage());
                }
            }

            $model->save();
            $this->info("✔ Imported: $name ($callingCode)");
        }

        FileFacade::deleteDirectory($tmpPath);
        $this->info('✅ All countries imported and temporary files cleaned up.');
    }
}
