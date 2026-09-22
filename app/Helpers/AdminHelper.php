<?php

namespace App\Helpers;

use App\Models\AdminTrackingRecordsModel;
use App\Models\ApiLogModel;
use App\Models\CompanyDailySharePriceModel;
use App\Models\CompanyModel;
use App\Models\CompanySharePriceModel;
use App\Models\InvestorModel;
use App\Models\MasterBlogModel;
use App\Models\MasterSectorsModel;
use App\Models\StartupModel;
use App\Models\UserAdminModel;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminHelper
{

    static function hasPermission($permissions = [], $adminId = false): bool
    {
        // Log::debug('User ID: ' . $adminId);
        if ($adminId) {
            $admin = UserAdminModel::where('id', $adminId)->first();
            if ($admin) {
                if ($admin->hasAnyPermission($permissions)) {
                    return true;
                }
            }
        } else {
            if (self::getAdmin()->role == 'admin') {
                return true;
            }

            if (self::getAdmin()->hasAnyPermission($permissions)) {
                return true;
            }
        }
        return false;
    }

    static function getAdmin(): ?UserAdminModel
    {
        return Auth::guard('admin')->user();
    }

    static function url($suffix): string
    {
        return 'admin/' . $suffix;
    }

    static function sectorSlug($name, $id = false): string
    {
        if ($id) {
            $exists = MasterSectorsModel::where('url_slug', $slug = Str::slug($name))->where('id', '!=', $id)->exists();
        } else {
            $exists = MasterSectorsModel::where('url_slug', $slug = Str::slug($name))->exists();
        }
        if ($exists) {
            $max = MasterSectorsModel::where('name', $name)->latest('id')->skip(1)->value('url_slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    static function startupSlug($name, $id = false)
    {
        if ($id) {
            $exists = StartupModel::where('url_slug', $slug = Str::slug($name))->where('id', '!=', $id)->exists();
        } else {
            $exists = StartupModel::where('url_slug', $slug = Str::slug($name))->exists();
        }
        if ($exists) {
            $max = StartupModel::where('brand_name', $name)->latest('id')->skip(1)->value('url_slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    static function companySlug($name, $id = false): string
    {
        if ($id) {
            $exists = CompanyModel::where('slug', $slug = Str::slug($name))->where('id', '!=', $id)->exists();
        } else {
            $exists = CompanyModel::where('slug', $slug = Str::slug($name))->exists();
        }
        if ($exists) {
            $max = CompanyModel::where('brand_name', $name)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    static function blogSlug($name, $id = false)
    {
        if ($id) {
            $exists = MasterBlogModel::where('url_slug', $slug = Str::slug($name))->where('id', '!=', $id)->exists();
        } else {
            $exists = MasterBlogModel::where('url_slug', $slug = Str::slug($name))->exists();
        }
        if ($exists) {
            $max = MasterBlogModel::where('title', $name)->latest('id')->skip(1)->value('url_slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    static function logPut($description, $type, $type_id): void
    {
        if (Auth::guard('admin')->check()) {
            $log = new AdminTrackingRecordsModel;
            $log->user_id = Auth::guard('admin')->user()->id;
            $log->type_id = $type_id;
            $log->type = $type;
            $log->description = $description;
            $log->save();
        }
    }

    static function investorRedirectToReleted(InvestorModel $investor, string $message): RedirectResponse
    {
        if ($investor->is_demo == '1') {
            return redirect()->route('admin.investor.demo')->with('success', $message);
        } else if ($investor->preipo_kyc_status == 0) {
            return redirect()->route('admin.investor.pendingkyc')->with('success', $message);
        } else if ($investor->is_active == '1') {
            return redirect()->route('admin.investor.active')->with('success', $message);
        } else if ($investor->is_active == '2') {
            return redirect()->route('admin.investor.rejected')->with('success', $message);
        } else if ($investor->is_active == '0') {
            return redirect()->route('admin.investor.inactive')->with('success', $message);
        }
        return redirect()->route('admin.investor.active')->with('success', $message);
    }

    public static function apiLogsToScreenName($logs): array
    {
        $journey = [];
        $previousScreen = null;
        $previousTimestamp = null;
        $lastConfigTimestamp = null;
        $lastActiveScreen = null;
        $lastActiveTimestamp = null;

        static $primaryHomeTracker = [
            'get-home' => false,
            'master/get-sector' => false,
            'master/get-blog' => false,
            'timestamp' => null,
        ];

        static $secondaryHomeTracker = [
            'secondary-invest/market' => false,
            'master/get-sector' => false,
            'timestamp' => null,
        ];

        foreach ($logs as $index => $log) {
            $url = UtillsHelper::getProperFunctionForAppLogs($log->url);
            $params = json_decode($log->params, true);
            $currentScreen = null;
            $currentTimestamp = Carbon::parse($log->created_at);

            // Check if the app was closed due to inactivity
            if ($lastActiveTimestamp && $currentTimestamp->diffInMinutes($lastActiveTimestamp) >= 5) {
                $journey[] = [
                    'screen_name' => '',
                    'description' => 'User closed app from ' . strtolower($lastActiveScreen['name']),
                    'time_spent' => '',
                    'start_time' => $lastActiveTimestamp->toDateTimeString(),
                ];
                $lastActiveScreen = null;
                $lastActiveTimestamp = null;
            }

            // Process get-config
            if ($url === 'get-config') {
                if ($lastActiveScreen) {
                    $journey[] = [
                        'screen_name' => '',
                        'description' => 'User closed app from ' . strtolower($lastActiveScreen['name']),
                        'time_spent' => '',
                        'start_time' => $lastActiveTimestamp->toDateTimeString(),
                    ];
                    $lastActiveScreen = null;
                    $lastActiveTimestamp = null;
                }

                $currentScreen = [
                    'name' => 'App Opens',
                    'description' => 'User started the app'
                ];
                $journey[] = [
                    'screen_name' => $currentScreen['name'],
                    'description' => $currentScreen['description'],
                    'time_spent' => 0,
                    'start_time' => $currentTimestamp->toDateTimeString(),
                ];
                $lastConfigTimestamp = $currentTimestamp;
                continue;
            }

            if (in_array($url, ['get-home', 'master/get-sector', 'master/get-blog'])) {
                // Mark sector API
                if ($url === 'master/get-sector') {
                    if (!$primaryHomeTracker['timestamp']) {
                        $primaryHomeTracker['timestamp'] = $currentTimestamp;
                    }
                    $primaryHomeTracker['master/get-sector'] = true;
                }

                // Mark get-home API
                if ($url === 'get-home') {
                    if (!$primaryHomeTracker['timestamp']) {
                        $primaryHomeTracker['timestamp'] = $currentTimestamp;
                    }
                    $primaryHomeTracker['get-home'] = true;
                }

                // Mark blog API
                if ($url === 'master/get-blog') {
                    if (!$primaryHomeTracker['timestamp']) {
                        $primaryHomeTracker['timestamp'] = $currentTimestamp;
                    }
                    $primaryHomeTracker['master/get-blog'] = true;
                }

                // Check if all primary home APIs have been triggered
                if (
                    $primaryHomeTracker['get-home'] &&
                    $primaryHomeTracker['master/get-sector'] &&
                    $primaryHomeTracker['master/get-blog'] &&
                    $primaryHomeTracker['timestamp']
                ) {

                    $currentScreen = [
                        'name' => 'Primary Home Screen',
                        'description' => 'User viewed primary home screen'
                    ];

                    // Reset primary home tracker after logging the screen
                    $primaryHomeTracker = [
                        'get-home' => false,
                        'master/get-sector' => false,
                        'master/get-blog' => false,
                        'timestamp' => null,
                    ];
                }
            }

            // Handle secondary home screen APIs
            if (in_array($url, ['secondary-invest/market', 'master/get-sector'])) {
                // Mark sector API
                if ($url === 'master/get-sector') {
                    if (!$secondaryHomeTracker['timestamp']) {
                        $secondaryHomeTracker['timestamp'] = $currentTimestamp;
                    }
                    $secondaryHomeTracker['master/get-sector'] = true;
                }

                // Mark secondary-invest/market API
                if ($url === 'secondary-invest/market') {
                    if (!$secondaryHomeTracker['timestamp']) {
                        $secondaryHomeTracker['timestamp'] = $currentTimestamp;
                    }
                    $secondaryHomeTracker['secondary-invest/market'] = true;
                }

                // Check if both secondary home APIs have been triggered
                if (
                    $secondaryHomeTracker['secondary-invest/market'] &&
                    $secondaryHomeTracker['master/get-sector'] &&
                    $secondaryHomeTracker['timestamp']
                ) {

                    $currentScreen = [
                        'name' => 'Secondary Home Screen',
                        'description' => 'User viewed secondary home screen'
                    ];

                    // Reset secondary home tracker after logging the screen
                    $secondaryHomeTracker = [
                        'secondary-invest/market' => false,
                        'master/get-sector' => false,
                        'timestamp' => null,
                    ];
                }
            }


            // Process profile
            if ($url === 'profile/get' || $url === 'profile') {
                $currentScreen = [
                    'name' => 'Profile',
                    'description' => 'User viewed profile'
                ];

                if ($lastConfigTimestamp && $currentTimestamp->diffInSeconds($lastConfigTimestamp) <= 5) {
                    $lastIndex = count($journey) - 1;
                    if ($lastIndex >= 0 && $journey[$lastIndex]['screen_name'] === 'App Opens') {
                        $journey[$lastIndex]['description'] = 'User started the app and viewed profile';
                        continue;
                    }
                }
            }

            if ($url === 'company/detail') {
                // Fetch the company details using the provided company_id in params
                $company = isset($params['company_id']) ? CompanyModel::find($params['company_id']) : null;

                // Define the current screen based on whether the company exists
                $currentScreen = [
                    'name' => 'Private Equity Profile Page',
                    'description' => $company
                        ? "Viewing `{$company->brand_name}` company"
                        : 'Company details not found'
                ];
            }

            if ($url === 'get-startup') {
                // Fetch the company details using the provided company_id in params
                $startup = isset($params['startup_id']) ? StartupModel::find($params['startup_id']) : null;

                // Define the current screen based on whether the company exists
                $currentScreen = [
                    'name' => 'Startup Profile Page',
                    'description' => $startup
                        ? "Viewing `{$startup->brand_name}` Startup"
                        : 'Startup details not found'
                ];
            }

            if ($url === 'company/market') {
                $currentScreen = [
                    'name' => 'Private Equity Home Screen',
                    'description' => 'User viewed the Private Equity Home Screen'
                ];
            }

            if ($url === 'master/get-blog') {
                // Fetch the company details using the provided company_id in params
                $blog = isset($params['blog_id']) ? MasterBlogModel::find($params['blog_id']) : null;

                if ($blog) {
                    // Define the current screen based on whether the company exists
                    $currentScreen = [
                        'name' => 'Blog Detail',
                        'description' => $blog
                            ? "Viewing `{$blog->title}` Blog"
                            : 'Blog details not found'
                    ];
                }
            }

            if ($url === 'get-startup-list') {
                $currentScreen = [
                    'name' => 'View all startup',
                    'description' => 'User viewed the startup list'
                ];
            }

            if ($url === 'dashboard') {
                $currentScreen = [
                    'name' => 'Dashboard',
                    'description' => 'User viewed dashboard'
                ];
            }

            if ($url === 'favorite') {
                $currentScreen = [
                    'name' => 'Favorite',
                    'description' => 'User viewed favorite startups'
                ];
            }

            if ($url === 'primary-transaction-list' || $url === 'primary-transactions') {
                $currentScreen = [
                    'name' => 'Primary Transaction Screen',
                    'description' => 'User viewed primary transaction'
                ];
            }

            if ($url === 'secondary-invest/transactions/list') {
                $currentScreen = [
                    'name' => 'Secondary Transaction Screen',
                    'description' => 'User viewed secondary transaction'
                ];
            }

            if ($url === 'pre-ipo/transaction') {
                $currentScreen = [
                    'name' => 'Private Equity Transaction Screen',
                    'description' => 'User viewed Private Equity transaction'
                ];
            }

            if ($url === 'portfolio') {
                $subParam = isset($params['type']) ? $params['type'] : '';
                $currentScreen = [
                    'name' => 'Portfolio Screen',
                    'description' => "User viewed `{$subParam}` Portfolio"
                ];
            }

            if ($url === 'mis') {
                $currentScreen = [
                    'name' => 'MIS Screen',
                    'description' => 'User viewed MIS'
                ];
            }

            if ($url === 'pitch') {
                $subParam = isset($params['type']) ? $params['type'] : '';
                $currentScreen = [
                    'name' => 'Pitch Screen',
                    'description' => "User viewed `{$subParam}` Pitch"
                ];
            }

            if ($url === 'family') {
                $currentScreen = [
                    'name' => 'My Family Screen',
                    'description' => "User viewed Family Screen"
                ];
            }

            if ($url === 'document') {
                $currentScreen = [
                    'name' => 'Documents Screen',
                    'description' => "User viewed documents screen"
                ];
            }

            if ($url === 'add-portfolio') {
                $currentScreen = [
                    'name' => 'Upload Portfolio',
                    'description' => "User Uploaded Portfolio"
                ];
            }


            // if(!$currentScreen){
            //     $currentScreen = [
            //         'name' => $url,
            //         'description' => 'NA',
            //         'time_spent' => '',
            //         'start_time' => '',
            //     ];
            // }

            // Add screen entry if we have one
            if ($currentScreen) {
                $timeSpent = 0;
                if ($previousTimestamp) {
                    $timeDifference = abs($currentTimestamp->diffInSeconds($previousTimestamp));
                    $timeSpent = min($timeDifference, 3600);
                }

                $journey[] = [
                    'screen_name' => $currentScreen['name'],
                    'description' => $currentScreen['description'],
                    'time_spent' => $timeSpent,
                    'start_time' => $currentTimestamp->toDateTimeString(),
                ];

                $lastActiveScreen = $currentScreen;
                $lastActiveTimestamp = $currentTimestamp;
                $previousTimestamp = $currentTimestamp;
                $previousScreen = $currentScreen;
            }
        }

        // Handle app closure at the end of the logs
        // if ($lastActiveScreen) {
        //     $journey[] = [
        //         'screen_name' => '',
        //         'description' => 'User closed app from ' . strtolower($lastActiveScreen['name']),
        //         'time_spent' => '',
        //         'start_time' => $lastActiveTimestamp->toDateTimeString(),
        //     ];
        // }

        foreach ($journey as $key => $value) {
            // Check if the current record is NOT the last one
            if ($key < count($journey) - 1) {
                $lastScreenTime = Carbon::parse($journey[$key]['start_time']);
                $currentScreenTime = Carbon::parse($journey[$key + 1]['start_time']);
                $diffInSeconds = $lastScreenTime->diffInSeconds($currentScreenTime);
                $journey[$key]['time_spent'] = $diffInSeconds;
            } else {
                // Handle the last record if necessary
                $journey[$key]['time_spent'] = 0; // Set to 0 or a default value
            }
        }
        return array_reverse($journey);
    }
}
