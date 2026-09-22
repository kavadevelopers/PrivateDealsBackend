<?php

namespace App\Traits;

use App\Models\ReportErrorLogModel;
use Aws\S3\Exception\S3Exception;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    static function uploadFile(string $filePath, $file, $visibility = 'private', $base64 = false): bool
    {
        if (config('filesystems.default') == 's3') {
            try {
                if ($base64) {
                    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
                    if (Storage::disk('s3')->put($filePath, $image, $visibility)) {
                        $state = true;
                    } else {
                        $state = false;
                    }
                } else {
                    if (Storage::disk('s3')->put($filePath, file_get_contents($file), $visibility)) {
                        $state = true;
                    } else {
                        $state = false;
                    }
                }
            } catch (S3Exception $e) {
                $state = false;
                ReportErrorLogModel::create([
                    'type'          => 'Aws S3',
                    'sub_type'      => 'Upload',
                    'description'   => $e->getMessage()
                ]);
            }
        } else {
            try {
                if ($base64) {
                    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
                    if (Storage::disk('local')->put($filePath, $image, $visibility)) {
                        $state = $filePath;
                    } else {
                        $state = false;
                    }
                } else {
                    if (Storage::disk('local')->put($filePath, file_get_contents($file), $visibility)) {
                        $state = $filePath;
                    } else {
                        $state = false;
                    }
                }
            } catch (Exception $e) {
                $state = false;
                ReportErrorLogModel::create([
                    'type'          => 'Aws S3',
                    'sub_type'      => 'Upload',
                    'description'   => $e->getMessage()
                ]);
            }
        }

        return $state;
    }

    function deleteFile($filePath): bool
    {
        if ($filePath != NULL && $filePath != '') {
            if (config('filesystems.default') == 's3') {
                try {
                    if (Storage::disk('s3')->delete($filePath)) {
                        $state = true;
                    } else {
                        $state = false;
                    }
                } catch (S3Exception $e) {
                    $state = false;
                    ReportErrorLogModel::create([
                        'type'          => 'Aws S3',
                        'sub_type'      => 'Delete',
                        'description'   => $e->getMessage()
                    ]);
                }
            } else {
                try {
                    if (Storage::disk('local')->delete($filePath)) {
                        $state = true;
                    } else {
                        $state = false;
                    }
                } catch (Exception $e) {
                    $state = false;
                    ReportErrorLogModel::create([
                        'type'          => 'Aws S3',
                        'sub_type'      => 'Delete',
                        'description'   => $e->getMessage()
                    ]);
                }
            }
            return $state;
        }
        return false;
    }

    function isFileExists(string $filePath): bool
    {
        return Storage::has($filePath);
    }

    function tempUrl(string $filePath, int $minuutes = 1): string
    {
        return Storage::temporaryUrl($filePath, now()->addMinutes($minuutes));
    }

    static function fileUrl(string $filePath): string
    {
        if (config('filesystems.default') == 's3') {
            return Storage::url($filePath);
        } else {
            return asset($filePath);
        }
    }
}
