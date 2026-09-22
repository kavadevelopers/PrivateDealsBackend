<?php

namespace App\Http\Controllers;

use App\Enums\DocumentTypeEnum;
use App\Enums\GenderEnum;
use App\Enums\InvestorTypeEnum;
use App\Enums\PartnerTypeEnum;
use App\Enums\PreIpoCategoryEnum;
use App\Enums\PrimaryTransactionTypeEnum;
use App\Enums\SendToUserTypeEnum;
use App\Enums\Utills\StatusEnum;
use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Jobs\broadcast\PushNotificationJob;
use App\Jobs\broadcast\Whatsapp;
use App\Jobs\TestJob;
use App\Models\ApiLogModel;
use App\Models\AppSettingsModel;
use App\Models\BroadcastNotificationModel;
use App\Models\CompanyDailySharePriceModel;
use App\Models\CompanyModel;
use App\Models\CompanyNewsModel;
use App\Models\CompanySharePriceModel;
use App\Models\DocumentsModel;
use App\Models\InvestorDematAccountModel;
use App\Models\InvestorKycModel;
use App\Models\InvestorModel;
use App\Models\MasterCityModel;
use App\Models\NotificationsModel;
use App\Models\PartnerModel;
use App\Models\PortfolioModel;
use App\Models\PreIpoModel;
use App\Models\PrimaryTransactionMgt14Model;
use App\Models\PrimaryTransactionModel;
use App\Models\PrimaryTransactionPas3Model;
use App\Models\PrimaryTransactionPaymentModel;
use App\Models\PrimaryTransactionPresentationModel;
use App\Models\ReportErrorLogModel;
use App\Models\ReportNotificationsModel;
use App\Models\SecondaryEscrowAccountModel;
use App\Models\SecondaryPaymentsModel;
use App\Models\SecondarySellRequestModel;
use App\Models\SecondaryShareTransferModel;
use App\Models\SecondaryTransactionModel;
use App\Models\StartupMisModel;
use App\Models\StartupModel;
use App\Services\FCMService;
use App\Services\PreIpoBusinessDayService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class TestController extends Controller
{

    function chunkFileUpload()
    {
        return view('test2');
    }

    public function uploadChunk(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            $file = $save->getFile();
            $filename = $this->createFilename($file);

            // Store to S3
            $disk = Storage::disk('s3');
            $path = $disk->putFileAs('chunkUpload', $file, $filename);

            // Get permanent URL
            // $url = $disk->get($path);

            // Delete temporary file
            unlink($file->getPathname());

            return response()->json([
                'success' => true,
                'path' => '',
                's3_path' => $path
            ]);
        }

        $handler = $save->handler();

        return response()->json([
            'done' => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected function createFilename($file)
    {
        $extension = $file->getClientOriginalExtension();
        // $filename = str_replace("." . $extension, "", $file->getClientOriginalName());
        $filename =  CommonHelper::generateFileName() . "." . $extension;

        return $filename;
    }


    public function sendPushNotification(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'title' => 'required|string',
            'body'  => 'required|string',
            'route' => 'nullable|string',
            // Accept either a file upload OR a plain URL string
            'image' => 'nullable',
            'image_file' => 'nullable|image|max:5120', // up to 5 MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get validated data
        $token = $request->input('token');
        $title = $request->input('title');
        $body  = $request->input('body');
        $route = $request->input('route');

        // Resolve image URL:
        //  1. If an image file was uploaded → save it publicly and build a URL
        //  2. Else if an image URL string was passed → use it directly
        //  3. Otherwise → null (FCM will show no image)
        $image = null;
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $file     = $request->file('image_file');
            $filename = uniqid('push_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('test/push-images'), $filename);
            $image = url('test/push-images/' . $filename);
        } elseif ($request->filled('image')) {
            $image = $request->input('image');
        }

        // Set default unread counter 
        $unreadCounter = 0;

        // Create notification record
        $repoNoti = new ReportNotificationsModel();
        $repoNoti->user_id = 0;
        $repoNoti->user_type = 'API';
        $repoNoti->title = $title;
        $repoNoti->body = $body;
        $repoNoti->image = null;
        $repoNoti->broadcast_id = null;
        $repoNoti->message_id = null;
        $repoNoti->response_code = 406; // No logged in devices found
        $repoNoti->save();

        // Get Firebase Auth Token
        $bearerToken = FCMService::getGoogleAuthToken();
        if (!$bearerToken) {
            return response()->json([
                'success' => false,
                'message' => 'Could not get Firebase authentication token'
            ], 500);
        }

        // Prepare the payload
        $payload = [
            "message" => [
                "token" => $token,
                "notification" => [
                    'title' => $title,
                    'body'  => $body,
                    'image' => $image,
                ],
                "data" => [
                    "unread_counter"  => (string) $unreadCounter,
                    "app_redirection" => $route ?? "",
                    "image_url"       => $image ?? "",
                    "image"           => $image ?? "",
                ],
                "android" => [
                    "notification" => [
                        "title"        => $title,
                        "body"         => $body,
                        "icon"         => "ic_notification",
                        "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                        "image"        => $image,
                    ]
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "alert" => [
                                "title" => $title,
                                "body"  => $body
                            ],
                            "sound"           => "default",
                            "mutable-content" => 1
                        ]
                    ],
                    "fcm_options" => [
                        "image" => $image,
                    ],
                ],
                "webpush" => [
                    "headers" => [
                        "Urgency" => "high"
                    ],
                    "notification" => [
                        "title"        => $title,
                        "body"         => $body,
                        "icon"         => asset('core/images/logo.png'),
                        "click_action" => $route ?? url('/')
                    ]
                ]
            ]
        ];

        // Update notification record with payload
        $repoNoti->data = json_encode($payload);
        $repoNoti->save();

        // Send notification to Firebase
        $client = new GuzzleHttpClient(['verify' => false, 'http_errors' => false]);
        $response = $client->post('https://fcm.googleapis.com/v1/projects/shuru-up-cd1c5/messages:send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $bearerToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        // Get response and update notification record
        $responseBody = $response->getBody()->getContents();
        $statusCode = $response->getStatusCode();

        $repoNoti->response_code = $statusCode;
        $repoNoti->response = $responseBody;
        $repoNoti->save();

        // Log error if any
        if ($statusCode != 200) {
            ReportErrorLogModel::create([
                'type' => 'Firebase Push',
                'subtype' => 'Sending Error',
                'description' => $responseBody
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification',
                'error' => $responseBody
            ], $statusCode);
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully',
            'data' => json_decode($responseBody)
        ]);
    }

    /**
     * Get file URL from path
     * 
     * @param string $path
     * @return string
     */
    protected function fileUrl($path)
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset($path);
    }

    function saveNews()
    {
        // exit;
        $request = request();
        $articles = $request->input('articles');

        if (!is_array($articles)) {
            return response()->json(['status' => 0, 'message' => 'Invalid data format'], 400);
        }

        $isTestMode      = (bool) $request->input('is_test_mode', false);
        $testInvestorIds = $request->input('test_investor_ids', []);

        // $investors = InvestorModel::whereIn('mobile_number', ['8460711335', '9867052562', '9978120357', '9408865299', '9898004501'])->get();
        // $partners = PartnerModel::where('is_deleted', 0)->get();
        if ($isTestMode && !empty($testInvestorIds)) {
            $investors = InvestorModel::whereIn('id', $testInvestorIds)
                ->where('is_deleted', 0)
                ->get();
        } else {
            $investors = InvestorModel::where('is_deleted', 0)
                ->where('registration_step', 3)
                ->get();
        }


        foreach ($articles as $article) {
            // ReceivedNews::create([
            //     'headline' => $article['headline'],
            //     'company_id' => $article['company_id'],
            //     ...
            // ]);
            if ($article['headline'] != null && $article['headline'] != "" && $article['subheadline'] != null && $article['subheadline'] != "") {
                $news = new CompanyNewsModel();
                $news->company_id       = $article['company_id'];
                // $news->image            = $article['image_url'];
                if (!empty($article['image_url'])) {
                    $savedImagePath = $this->downloadAndSaveImage($article['image_url']);
                    if ($savedImagePath) {
                        $news->image = $savedImagePath;
                    }
                }
                $news->title            = $article['headline'];
                $news->description      = $article['subheadline'];
                $news->link             = $article['article_url'] ?? $article['site'];
                $news->save();
                // foreach ($investors as $investor) {
                //     UtillsHelper::sendNotification($investor->id, InvestorModel::class, 'home', $news->title, $news->description);
                // }


                $broadcastNotification = new BroadcastNotificationModel();
                $broadcastNotification->title = $article['headline'];

                // $broadcastNotification->body = $article['subheadline'];
                $words = explode(' ', $article['subheadline'] ?? '');
                $broadcastNotification->body = count($words) > 100
                    ? implode(' ', array_slice($words, 0, 100)) . '...'
                    : ($article['subheadline'] ?? '');

                $broadcastNotification->send_to = SendToUserTypeEnum::user->value;

                $broadcastNotification->topic = null;

                // Set investors and partners IDs
                $investorIds = $investors->pluck('id')->toArray();
                // $partnerIds = $partners->pluck('id')->toArray();
                $broadcastNotification->investors_ids = json_encode($investorIds);
                // $broadcastNotification->partners_ids = json_encode([$partnerIds]);

                // Set redirect data to company detail page
                $data = [
                    'redirect_to' => 'home/pre-ipo/news',
                    'reference_id' => $news->id,
                    'reference_type' => 'preipo_news',
                ];
                $broadcastNotification->data = $data;

                // Set image if available
                // if (!empty($article['image_url'])) {
                //     $broadcastNotification->image = $article['image_url'];
                // }
                if (!empty($article['image_url']) && isset($savedImagePath)) {
                    $broadcastNotification->image = $savedImagePath;
                }

                // Set created/updated by admin
                // $broadcastNotification->created_by = AdminHelper::getAdmin()->id;
                // $broadcastNotification->updated_by = AdminHelper::getAdmin()->id;
                $broadcastNotification->save();

                // Log the broadcast creation
                AdminHelper::logPut('Broadcast created for news: ' . $broadcastNotification->title, BroadcastNotificationModel::class, $broadcastNotification->id);

                // Dispatch the push notification job
                PushNotificationJob::dispatch($broadcastNotification->id);
            }
        }
        return UtillsHelper::json(
            1,
            [
                'message' => "News saved successfully",
                'data'    => $articles,
            ],
            200
        );
    }


    private function downloadAndSaveImage($imageUrl): string|null
    {
        try {
            $response = Http::timeout(30)->get($imageUrl);

            if (!$response->successful()) {
                Log::warning("Failed to download image from URL: {$imageUrl}");
                return null;
            }

            $manager = new ImageManager(new Driver());

            $image = $manager->read($response->body());

            // Convert to JPEG format
            $jpegImage = $image->toJpeg(85); // 85% quality

            $fileName = CommonHelper::generateFileName() . '.jpg';

            $tempPath = sys_get_temp_dir() . '/' . $fileName;
            file_put_contents($tempPath, $jpegImage);

            // Create UploadedFile instance to use with existing upload system
            $uploadedFile = new UploadedFile(
                $tempPath,
                $fileName,
                'image/jpeg',
                null,
                true
            );

            // Use existing upload function
            $savedPath = FileUpDownHelper::master_pages_news_img_upload($uploadedFile);

            if (file_exists($tempPath)) {
                unlink($tempPath);
            }

            return $savedPath;
        } catch (\Exception $e) {
            Log::error("Error processing image from URL {$imageUrl}: " . $e->getMessage());
            return null;
        }
    }


    function getCompaniesWithId(): JsonResponse
    {
        $companies = CompanyModel::where('is_deleted', '0')->where('category', '!=', PreIpoCategoryEnum::listed->value)->get();
        $commonKeywords = optional(
            AppSettingsModel::where('key', 'pre_ipo_common_keywords')->first()
        )->value ?? '';

        return UtillsHelper::json(
            1,
            [
                'message'   => "Company List",
                'data'      => $companies,
                'common_keywords' => $commonKeywords
            ],
            200
        );
    }

    public function getCompanyNames(Request $request): JsonResponse
    {
        $priceUpdate = $request->price_update ?? 'all';

        $companies = CompanyModel::select(
            'id',
            'brand_name',
            'company_name',
            'about',
            'share_price'
        )
            ->where('is_deleted', '0')
            ->where('category', '!=', PreIpoCategoryEnum::listed->value);

        if ($priceUpdate === 'today') {
            $companies->whereHas('sharePrices', function ($q) {
                $q->whereDate('date', today());
            });
        }

        if ($priceUpdate === 'not_today') {
            $companies->where(function ($query) {
                $query->whereDoesntHave('sharePrices')
                    ->orWhereDoesntHave('sharePrices', function ($q) {
                        $q->whereDate('date', today());
                    });
            });
        }

        $companies = $companies
            ->orderBy('brand_name', 'asc')
            ->get();

        return UtillsHelper::json(
            1,
            [
                'message' => 'Company List',
                'data' => $companies->makeHidden(['id'])
            ],
            200
        );
    }

    function test()
    {

        // $investors = InvestorModel::whereNull('referral_code')->get();

        // foreach ($investors as $investor) {
        //     $investor->referral_code = UtillsHelper::generateUniqueReferralCode();
        //     $investor->save();
        // }


        // $broadcast = BroadcastNotificationModel::find(825);

        // dd(gettype($broadcast->data), $broadcast->data);
        exit;

        $fluctuationData = CompanyDailySharePriceModel::getPriceFluctuationAlert();

        $allCompanyIds = collect($fluctuationData['up'])->pluck('company_id')
            ->merge(collect($fluctuationData['down'])->pluck('company_id'))
            ->unique()
            ->toArray();

        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $newsItems = CompanyNewsModel::whereIn('company_id', $allCompanyIds)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->select('company_id', 'title', 'description') // Add 'image' or 'link' if needed
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('company_id');

        if (!empty($fluctuationData['up'])) {
            Log::info('First up company logo: ' . $fluctuationData['up'][0]['company_logo']);
        }

        $pdf = Pdf::loadView('pdf.auto.daily-share-report-a', [
            'fluctuationData' => $fluctuationData,
            'newsItems' => $newsItems,
        ])->setOption([
            'fontDir' => public_path('core/fonts/roboto'),
            'fontCache' => public_path('core/fonts/Cache'),
            'defaultFont' => 'Roboto',
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ]);

        return $pdf->stream();
        // return $pdf->download();
    }
    // {

    //     $companies = CompanyModel::where('is_deleted', '0')->get();

    //     foreach ($companies as $company) {
    //         $company->min_investment_type = 'Quantity';

    //         $price = (float) $company->share_price;

    //         if ($price > 0) {
    //             // Minimum qty to reach at least ₹14,000
    //             $minQty = (int) ceil(14000 / $price);

    //             // Possible qty options: minQty - 1, minQty, minQty + 1
    //             $options = [];

    //             // Option 1: minQty (default)
    //             $total = $minQty * $price;
    //             if ($total >= 14000) {
    //                 $options[$minQty] = abs($total - 15000);
    //             }

    //             // Option 2: minQty + 1
    //             $nextTotal = ($minQty + 1) * $price;
    //             $options[$minQty + 1] = abs($nextTotal - 15000);

    //             // Option 3: minQty - 1 (only if still ≥ 14,000)
    //             if ($minQty > 1) {
    //                 $prevTotal = ($minQty - 1) * $price;
    //                 if ($prevTotal >= 14000) {
    //                     $options[$minQty - 1] = abs($prevTotal - 15000);
    //                 }
    //             }

    //             // Pick the quantity with the closest value to ₹15,000
    //             $bestQty = array_keys($options, min($options))[0];

    //             $company->min_investment_amount = $bestQty;
    //         } else {
    //             // fallback if price is 0 or invalid
    //             $company->min_investment_amount = 0;
    //         }

    //         $company->save();
    //     }




    //     // $list = PreIpoModel::where('status', '5')->get();
    //     // $csvData = "Sr.No.,Investor,Company,Seller,Shares,PrivateDeals Price,Share Price,Investment Amount,Date\n"; // CSV Header
    //     // foreach ($list as $key => $item) {
    //     //     $csvData .= ($key + 1) . "," .
    //     //         ($item->investor->name ?? '') . "," .
    //     //         ($item->company->brand_name ?? '') . "," .
    //     //         ($item->seller->company_name ?? '') . "," .
    //     //         ($item->shares ?? '') . "," .
    //     //         ($item->shuru_price ?? '') . "," .
    //     //         ($item->share_price ?? '') . "," .
    //     //         ($item->investment_amount ?? '') . "," .
    //     //         ($item->created_at ?? '') . "\n";
    //     // }

    //     // $fileName = "preipo_data.csv";

    //     // $headers = [
    //     //     'Content-Type' => 'text/csv',
    //     //     'Content-Disposition' => "attachment; filename=\"$fileName\"",
    //     // ];

    //     // return Response::make($csvData, 200, $headers);
    //     // Whatsapp::dispatch('7');
    //     // TestJob::dispatch();

    //     // exit;
    //     // $response = Http::withoutVerifying()->withHeader('X-CSCAPI-KEY', 'QU9TZmd5d3NtUXh4dVRGUlRiYXM3dXVaN2ZObHN1MUFoc3YxaThucg==')->get('https://api.countrystatecity.in/v1/countries/IN/states/GJ/cities');

    //     // $dataArray = $response->json();
    //     // // dd($dataArray);


    //     // if (count($dataArray) > 0) {
    //     //     foreach ($dataArray as $key => $value) {
    //     //         $city = MasterCityModel::where('name', $value['name'])->where('is_deleted', '0')->first();
    //     //         if (!$city) {
    //     //             MasterCityModel::create([
    //     //                 'country_id'    => '1',
    //     //                 'state_id'      => '1',
    //     //                 'name'          => $value['name']
    //     //             ]);
    //     //         }
    //     //     }
    //     // }



    //     // UtillsHelper::tokenUrlGenerate('secondary_oppotunity_approve', ['item_id' => '1']);

    //     // $response = Http::withoutVerifying()->get('https://unlistedzone.com/shares/graph/296/1y');

    //     // CompanySharePriceModel::where('company_id', '1')->delete();
    //     // $dataArray = $response->json();
    //     // if (count($dataArray['data']) > 0) {
    //     //     foreach ($dataArray['data'] as $key => $value) {

    //     //         CompanySharePriceModel::create([
    //     //             'company_id'        => '1',
    //     //             'date'              => $value[0],
    //     //             'price'             => $value[1],
    //     //             'distributer_price' => $value[1],
    //     //         ]);
    //     //     }
    //     // }
    //     // dd($dataArray['data']);
    // }

    function test1()
    {
        $defaultPhotos = [
            GenderEnum::female->value => 'master/pages/avtar/image/1741785381.9992-VYnBAmXc0zPro9zMybMRk13ZsJwlGztULjHiI7q1H6vTR3UEFka25q4oZSWV.png',
            GenderEnum::male->value => 'master/pages/avtar/image/1741785371.7229-eTFDXuoPO5roYTsI8tAZWdXZYHKKfzBBQwtjm677kSuwd8W1gFOW93syJBLh.png',
            GenderEnum::other->value => 'master/pages/avtar/image/1744024254.0747-qf2DhgAv0cndMhfqW8JCbYLwDNdae0Q4yeYaolQh9z31aFsOtqGXkca3rMwW.png',
        ];

        $investors = InvestorModel::whereNull('profile_photo')->get();

        foreach ($investors as $investor) {
            $gender = $investor->gender ?? GenderEnum::other->value;
            $defaultPhoto = $defaultPhotos[$gender] ?? $defaultPhotos[GenderEnum::other->value];
            $investor->profile_photo = $defaultPhoto;
            $investor->save();
        }
    }

    function exportActiveInvestors()
    {
        $fileName = 'active_investors_' . date('Y-m-d') . '.csv';

        // Get demo investor IDs to exclude
        $demoInvestorIds = InvestorModel::where('is_demo', '1')->pluck('id')->toArray();

        // Get active investor IDs (from ApiLogModel)
        $activeInvestorIds = ApiLogModel::where('usertype', 'investor')
            ->whereNotIn('userid', $demoInvestorIds)
            ->where('userid', '!=', '0')
            ->distinct('userid')
            ->pluck('userid');

        // Fetch only name & mobile of active investors
        $investors = InvestorModel::where('is_deleted', '0')
            ->whereIn('id', $activeInvestorIds)
            ->select('name', 'mobile_number') // Only fetch these 2 columns
            ->orderBy('name', 'asc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($investors) {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");

            // CSV Headers (only Name & Mobile)
            fputcsv($file, ['Name', 'Mobile Number']);

            // Data rows
            foreach ($investors as $investor) {
                fputcsv($file, [
                    $investor->name,
                    $investor->mobile_number,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    function exportCSV()
    {
        // File name for the download
        $fileName = 'investors_with_partners.csv';

        // Fetch investors with their partners
        $investors = InvestorModel::where('is_deleted', '0')->with('partner')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($investors) {
            $file = fopen('php://output', 'w');

            // Add the header row
            fputcsv($file, ['Name', 'Email', 'Mobile Number', 'Partner Name']);

            // Add data rows
            foreach ($investors as $investor) {
                fputcsv($file, [
                    $investor->name,
                    $investor->email,
                    $investor->mobile_number,
                    $investor->partner->name ?? 'N/A', // Handle null partner gracefully
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    function secSellRequestSet() {}

    function syncData()
    {

        PortfolioModel::truncate();
        PrimaryTransactionModel::truncate();
        PrimaryTransactionMgt14Model::truncate();
        PrimaryTransactionPas3Model::truncate();
        PrimaryTransactionPaymentModel::truncate();
        PrimaryTransactionPresentationModel::truncate();
        DocumentsModel::truncate();
        SecondaryEscrowAccountModel::truncate();
        SecondaryPaymentsModel::truncate();
        SecondarySellRequestModel::truncate();
        SecondaryShareTransferModel::truncate();
        SecondaryTransactionModel::truncate();
        $response = Http::withOptions(['verify' => false])->get('https://www.shuruup.com/api/get-investments');

        if ($response->successful()) {
            $response = $response->json();
            foreach ($response['investors'] as $key => $value) {
                $investor = InvestorModel::where('mobile_number', $value['investor'])->first();
                if ($investor) {
                    foreach ($value['list'] as $ikey => $ivalue) {
                        $homversity = ['7069255545', '9726204972', '8969368141'];
                        if (in_array($ivalue['startup'], $homversity)) {
                            $startup = StartupModel::where('mobile_number', '7069255545')->first();
                        } else {
                            $startup = StartupModel::where('mobile_number', $ivalue['startup'])->first();
                        }
                        if ($startup) {
                            if ($ivalue['is_secondary'] == '1' && $ivalue['seller'] != NULL) {
                            } else {
                                $transaction = new PrimaryTransactionModel();
                                $transaction->round_id      = $startup->lastRounds->id ?? '0';
                                $transaction->startup_id    = $startup->id;
                                $transaction->investor_id   = $investor->id;
                                $transaction->type                  = PrimaryTransactionTypeEnum::captable;
                                $transaction->instrument            = $ivalue['instrument'];
                                $transaction->shares                = $ivalue['shares'];
                                $transaction->share_price           = $ivalue['shareprice'];
                                $transaction->investment_amount     = $ivalue['amount'];
                                $transaction->payment_mode          = 'RTGS';
                                $transaction->created_at            =  $ivalue['created_at'];
                                if ($ivalue['status'] == 1) {
                                    $transaction->status                = 10;
                                } else {
                                    if ($ivalue['is_sha'] == 2) {
                                        $transaction->status                = 10;
                                    } else if ($ivalue['is_presented'] == 2) {
                                        $transaction->status                = 10;
                                    } else if ($ivalue['is_offer'] == 2) {
                                        $transaction->status                = 6;
                                    } else if ($ivalue['is_offer'] == 1) {
                                        $transaction->status                = 5;
                                    } else if ($ivalue['is_ssa'] == 2) {
                                        $transaction->status                = 3;
                                    } else {
                                        $transaction->status                = 2;
                                    }
                                }
                                $transaction->save();
                                if ($transaction) {
                                    if ($ivalue['is_ssa'] > 0) {
                                        $document = new DocumentsModel();
                                        $document->api_id = $ivalue['ssa_id'] ?? NULL;
                                        $document->type = DocumentTypeEnum::ssa;
                                        $document->meta = [
                                            'name' => 'SSA - ' . $transaction->startup->brand_name,
                                            'sname' => 'SSA - ' . $transaction->investor->name,
                                            'investor' => [
                                                $transaction->investor->id
                                            ],
                                            'startup' => [
                                                $transaction->startup->id
                                            ],
                                            'primary_transactions' => [
                                                $transaction->id
                                            ]
                                        ];

                                        if ($ivalue['ssa'] != "") {
                                            $extension = pathinfo(parse_url($ivalue['ssa'], PHP_URL_PATH), PATHINFO_EXTENSION);
                                            $name = CommonHelper::generateFileName() . '.' . $extension;
                                            $path = 'primary_transaction/' . $name;
                                            if (Storage::disk('s3')->put($path, file_get_contents($ivalue['ssa']), 'public')) {
                                                $document->path = $path;
                                                $document->signed_path = $path;
                                                $document->status = 1;
                                            }
                                        }

                                        $document->save();
                                    }

                                    if ($ivalue['is_offer'] > 0) {
                                        $document = new DocumentsModel();
                                        $document->api_id = $ivalue['offerlater_id'] ?? NULL;
                                        $document->type = DocumentTypeEnum::offer;
                                        $document->meta = [
                                            'name' => 'Offerletter - ' . $transaction->startup->brand_name,
                                            'sname' => 'Offerletter - ' . $transaction->investor->name,
                                            'investor' => [
                                                $transaction->investor->id
                                            ],
                                            'startup' => [
                                                $transaction->startup->id
                                            ],
                                            'primary_transactions' => [
                                                $transaction->id
                                            ]
                                        ];

                                        if ($ivalue['offer'] != "") {
                                            $extension = pathinfo(parse_url($ivalue['offer'], PHP_URL_PATH), PATHINFO_EXTENSION);
                                            $name = CommonHelper::generateFileName() . '.' . $extension;
                                            $path = 'primary_transaction/' . $name;
                                            if (Storage::disk('s3')->put($path, file_get_contents($ivalue['offer']), 'public')) {
                                                $document->path = $path;
                                                $document->signed_path = $path;
                                                $document->status = 1;
                                            }
                                        }

                                        $document->save();
                                    }

                                    if ($ivalue['is_sha'] > 0) {
                                        $document = new DocumentsModel();
                                        $document->api_id = $ivalue['sha_id'] ?? NULL;
                                        $document->type = DocumentTypeEnum::sha;
                                        $document->meta = [
                                            'name' => 'SHA - ' . $transaction->startup->brand_name,
                                            'sname' => 'SHA - ' . $transaction->investor->name,
                                            'investor' => [
                                                $transaction->investor->id
                                            ],
                                            'startup' => [
                                                $transaction->startup->id
                                            ],
                                            'primary_transactions' => [
                                                $transaction->id
                                            ]
                                        ];

                                        if ($ivalue['sha'] != "") {
                                            $extension = pathinfo(parse_url($ivalue['sha'], PHP_URL_PATH), PATHINFO_EXTENSION);
                                            $name = CommonHelper::generateFileName() . '.' . $extension;
                                            $path = 'primary_transaction/' . $name;
                                            if (Storage::disk('s3')->put($path, file_get_contents($ivalue['sha']), 'public')) {
                                                $document->path = $path;
                                                $document->signed_path = $path;
                                                $document->status = 1;
                                            }
                                        }

                                        $document->save();
                                    }


                                    if ($transaction && $transaction->status == 10) {
                                        $portfolio = PortfolioModel::where('investor_id', $investor->id)->where('startup_id', $startup->id)->where('instrument', $ivalue['instrument'])->first();
                                        if ($portfolio) {
                                            $investmentAmount = $ivalue['amount'] + $portfolio->investment_amount;
                                            $shares = $ivalue['shares'] + $portfolio->shares;
                                            $portfolio->shares = $shares;
                                            $portfolio->purchase_price = $investmentAmount / $shares;
                                            $portfolio->investment_amount = $investmentAmount;
                                            $portfolio->is_share_transfered = '1';
                                            $portfolio->save();
                                        } else {
                                            $portfolio = new PortfolioModel;
                                            $portfolio->investor_id = $investor->id;
                                            $portfolio->startup_id = $startup->id;
                                            $portfolio->shares = $ivalue['shares'];
                                            $portfolio->purchase_price = $ivalue['amount'] / $ivalue['shares'];
                                            $portfolio->investment_amount = $ivalue['amount'];
                                            $portfolio->instrument = $ivalue['instrument'];
                                            $portfolio->is_share_transfered = '1';
                                            $transaction->created_at            =  $ivalue['created_at'];
                                            $portfolio->save();
                                        }

                                        $transaction->portfolio_id = $portfolio->id;
                                        $transaction->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            foreach ($response['investors'] as $key => $value) {
                $investor = InvestorModel::where('mobile_number', $value['investor'])->first();
                if ($investor) {
                    foreach ($value['list'] as $ikey => $ivalue) {
                        $homversity = ['7069255545', '9726204972', '8969368141'];
                        if (in_array($ivalue['startup'], $homversity)) {
                            $startup = StartupModel::where('mobile_number', '7069255545')->first();
                        } else {
                            $startup = StartupModel::where('mobile_number', $ivalue['startup'])->first();
                        }
                        if ($startup) {
                            if ($ivalue['is_secondary'] == '1' && $ivalue['seller'] != NULL) {
                                $seller = InvestorModel::where('mobile_number', $ivalue['seller']['mobile'])->first();
                                $transaction = new SecondaryTransactionModel();
                                $transaction->status                = 8;
                                $transaction->startup_id    = $startup->id;
                                $transaction->buyer_id      = $investor->id;
                                $transaction->seller_id     = $seller->id ?? 0;
                                $transaction->instrument            = $ivalue['instrument'];
                                $transaction->shares                = $ivalue['shares'];
                                $transaction->share_price           = $ivalue['shareprice'];
                                $transaction->investment_amount     = $ivalue['amount'];
                                $transaction->created_at            =  $ivalue['created_at'];
                                $transaction->save();

                                if ($transaction) {
                                    $portfolio = PortfolioModel::where('investor_id', $investor->id)->where('startup_id', $startup->id)->where('instrument', $ivalue['instrument'])->first();
                                    if ($portfolio) {
                                        $investmentAmount = $ivalue['amount'] + $portfolio->investment_amount;
                                        $shares = $ivalue['shares'] + $portfolio->shares;
                                        $portfolio->shares = $shares;
                                        $portfolio->purchase_price = $investmentAmount / $shares;
                                        $portfolio->investment_amount = $investmentAmount;
                                        $portfolio->is_share_transfered = '1';
                                        $portfolio->save();
                                    } else {
                                        $portfolio = new PortfolioModel;
                                        $portfolio->investor_id = $investor->id;
                                        $portfolio->startup_id = $startup->id;
                                        $portfolio->shares = $ivalue['shares'];
                                        $portfolio->purchase_price = $ivalue['amount'] / $ivalue['shares'];
                                        $portfolio->investment_amount = $ivalue['amount'];
                                        $portfolio->instrument = $ivalue['instrument'];
                                        $portfolio->is_share_transfered = '1';
                                        $transaction->created_at            =  $ivalue['created_at'];
                                        $portfolio->save();
                                    }

                                    $transaction->c_portfolio_id = $portfolio->id;
                                    $transaction->save();
                                    CommonHelper::updatePortfolioSecondary($investor, $seller, $ivalue['instrument'], $startup, $ivalue['shares'], $transaction);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            return response()->json(['error' => 'Unable to fetch data'], $response->status());
        }
        exit;


        StartupMisModel::truncate();

        $response = Http::withOptions(['verify' => false])->get('https://www.shuruup.com/api/get-mis');

        if ($response->successful()) {
            $response = $response->json();
            // dd($response['mis']);
            foreach ($response['mis'] as $key => $value) {
                // dd($value);

                $startup = StartupModel::where('mobile_number', $value['mobile'])->first();
                if ($startup) {
                    $extension = pathinfo(parse_url($value['url'], PHP_URL_PATH), PATHINFO_EXTENSION);
                    $name = CommonHelper::generateFileName() . '.' . $extension;
                    $path = 'startup/mis/' . $name;
                    $startupMIS = new StartupMisModel();
                    if (Storage::disk('s3')->put($path, file_get_contents($value['url']), 'public')) {
                        $startupMIS->document = $path;
                    }
                    $startupMIS->startup_id = $startup->id;
                    $startupMIS->title = $value['description'];
                    $startupMIS->description = $value['description'];
                    $startupMIS->status = StatusEnum::approved;
                    $startupMIS->save();
                }
            }
        } else {
            return response()->json(['error' => 'Unable to fetch data'], $response->status());
        }

        exit;





        PartnerModel::truncate();
        InvestorModel::truncate();
        InvestorKycModel::truncate();
        InvestorDematAccountModel::truncate();
        $response = Http::withOptions(['verify' => false])->get('https://www.shuruup.com/api/get-investor-startup-data');

        if ($response->successful()) {
            $response = $response->json();
            // $object = json_decode($response);

            echo 'total records - ' . $response['count'] . '<br>';
            $imported = 0;
            foreach ($response['investors'] as $key => $value) {
                // dd($value['_partner']['email']);
                $investor = new InvestorModel();
                if ($value['business_type'] == 'Private Ltd. Co.' || $value['business_type'] == 'Pvt Ltd') {
                    $investor->investor_type = InvestorTypeEnum::privatelimited;
                } else if ($value['business_type'] == 'HUF') {
                    $investor->investor_type = InvestorTypeEnum::hinduundividedfamily;
                } else if ($value['business_type'] == 'Proprietorship') {
                    $investor->investor_type = InvestorTypeEnum::proprietorship;
                } else if ($value['business_type'] == 'Partership' || $value['business_type'] == 'Partnership') {
                    $investor->investor_type = InvestorTypeEnum::partnership;
                } else if ($value['business_type'] == 'Public Ltd. Co.') {
                    $investor->investor_type = InvestorTypeEnum::publiclimited;
                } else if ($value['business_type'] == 'LLP') {
                    $investor->investor_type = InvestorTypeEnum::limitedliabilitypartnership;
                } else {
                    $investor->investor_type = InvestorTypeEnum::individual;
                }
                $investor->name = $value['name'];
                $investor->mobile_number = $value['mobile'];
                $investor->email = $value['email'];
                $investor->address = $value['address'];
                $investor->city_id = 1;
                $investor->state_id = 1;
                $investor->country_id = 1;
                $investor->registration_step = 3;
                $investor->pincode = $value['pin'];
                if ($value['is_view_approved'] == '1') {
                    $investor->is_active = 1;
                }
                if ($value['gender'] == 'Male') {
                    $investor->gender = GenderEnum::male;
                } else if ($value['gender'] == 'Female') {
                    $investor->gender = GenderEnum::female;
                } else {
                    $investor->gender = GenderEnum::other;
                }
                $investor->password = $value['password'];
                if ($value['ver_aadhar'] == '1') {
                    $investor->kyc_status = '1';
                    $investor->aadhar_verified_type = 'Manual';
                }

                $investor->partner_id = self::partnerInsert($value['_partner']);

                $investor->is_verified_mobile = '1';
                if ($investor->save()) {
                    $imported++;

                    if ($value['ver_aadhar'] == '1') {
                        $kyc = new InvestorKycModel();
                        $kyc->investor_id = $investor->id;
                        $kyc->aadhar_no = $value['aadharno'];
                        $kyc->pan_no = $value['panno'];
                        $kyc->name_as_aadhar = $value['nameasaadhar'];
                        $kyc->name_as_pan = $value['nameaspan'] != '' ? $value['nameaspan'] : $value['nameasaadhar'];
                        $kyc->dob_as_aadhar = $value['dobasaadhar'];
                        $kyc->address_as_aadhar = $value['addressasaadhar'];
                        $kyc->status = 1;
                        $kyc->save();
                    }

                    $demat = new InvestorDematAccountModel();
                    $demat->investor_id = $investor->id;
                    $demat->dp_id = $value['dp_id'];
                    $demat->client_id = $value['client_id'];
                    $demat->demat_account = $value['demat_account'];
                    $demat->save();
                }
            }

            echo 'Imported records - ' . $imported . '<br>';
        } else {
            return response()->json(['error' => 'Unable to fetch data'], $response->status());
        }

        exit;





        exit;
    }

    function partnerInsert($partner)
    {
        if ($partner != NULL) {
            $old = PartnerModel::where('mobile_number', $partner['mobile'])->first();
            if ($old) {
                return $old->id;
            } else {
                $old = new PartnerModel;
                if ($partner['role'] == '1') {
                    $old->type = PartnerTypeEnum::wealthmanager;
                } else if ($partner['role'] == '2') {
                    $old->type = PartnerTypeEnum::distributor;
                } else {
                    $old->type = PartnerTypeEnum::retailer;
                }
                $old->commission = $partner['commission'];
                $old->name = $partner['name'];
                $old->mobile_number = $partner['mobile'];
                $old->email = $partner['email'];
                $old->gender = GenderEnum::other;
                $old->password = $partner['password'];
                $old->save();

                return $old->id;
            }
        }
        return NULL;
    }


    //     use PMailerTrait, WhatsAppSendTrait, SMSSendTrait, FileUploadTrait;
    //     protected $fcmService;

    //     public function __construct(FCMService $fcmService)
    //     {
    //         $this->fcmService = $fcmService;
    //     }
    //     function index()
    //     {
    //         setPageTitle('Investor Dashboard');
    //         return view('front.investor.dashboard');
    //     }
    //     function details(): view
    //     {
    //         setPageTitle('Startup Details');
    //         addJavascriptFile('front-assets/js/custom/auth/startup/fundRaise.js');
    //         return view('front.startup.auth.register.main_startup_details');
    //     }
    //     function fundRaise(): view
    //     {
    //         setPageTitle('Startup Fund Raise');
    //         return view('front.startup.auth.register.childs.fund_raise');
    //     }
    //     function fundRaisePost(Request $request)
    //     {
    //         $validation = Validator::make($request->all(), [
    //             'company_name' => 'required|max:255',
    //             'brand_name' => 'required|max:255',
    //             'brief_description' => 'required',
    //             'registered_address' => 'required',
    //             // 'city_id' => 'required',
    //             'email' => 'required|email',
    //             // 'industry_segment' => 'required',
    //             // 'sector_id' => 'required'
    //         ], [], [
    //             'company_name' => 'Company name is required',
    //             'brand_name' => 'Brand name is required',
    //             'brief_description' => 'Brief description is required',
    //             'registered_address' => 'Registered address is required',
    //             'country_id' => 'Country is required',
    //             'state_id' => 'State is required',
    //             'country_id' => 'Country is required',
    //             'state_id' => 'State is required',
    //             // 'city_id' => 'City is required',
    //             'email' => 'Email is required',
    //             // 'industry_segment' => 'Industry is required',
    //             // 'sector_id' => 'Sector is required',
    //         ]);


    //         if ($validation->fails()) {
    //             return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
    //         }

    //         $startup = new StartupModel();
    //         $startup->company_name = $request->company_name;
    //         $startup->brand_name = $request->brand_name;
    //         $startup->brief_information = $request->brief_description;
    //         $startup->address = $request->registered_address;
    //         $startup->country_id = $request->country_id;
    //         $startup->state_id = $request->state_id;
    //         $startup->city_id = $request->city_id;
    //         $startup->email = $request->email;
    //         $startup->industry_segment = $request->industry_segment;
    //         $startup->sector_id = $request->sector_id;
    //         $startup->save();

    //         Session::put('startup_register_id', $startup->id);

    //         return UtillsHelper::json(1, ['view' => view('front.startup.auth.register.childs.fund_raise', [
    //             'form_route' => route('front.raise.auth.post.register.funddetails'),
    //         ])->render()]);
    //     }

    //     function fundDetailsPost(Request $request)
    //     {
    //         Log::info('Fund Details Post Request:', $request->all());
    //         $validation = Validator::make($request->all(), [
    //             'fund_requirement' => 'required|numeric|min:0',
    //             'committed_investors' => 'required|json',
    //             'pre_money_valuation' => 'required|numeric|min:0',
    //             'current_fund_raise' => 'required|numeric|min:0',
    //             'funds_required_from_shuru' => 'required|numeric|min:0',
    //             'min_ticket_size' => 'required|numeric|min:0',
    //             'pre_money_valuation_basis' => 'required',
    //             'instrument_and_conversion_condition' => 'required',
    //             'fund_utilisation_details' => 'required',
    //         ], [], [
    //             'fund_requirement' => 'Fund Requirement field is required',
    //             'committed_investors.json' => 'Committed Investors name is required',
    //             'fund_utilisation_details' => 'Fund Utilisation Details is required',
    //             'current_fund_raise' => 'Current Fund Raise is required',
    //             'funds_required_from_shuru' => 'Funds Required From PrivateDeals is required',
    //             'min_ticket_size' => 'Min Ticket Size is required',
    //             'pre_money_valuation_basis' => 'Pre Money Valuation Basis is required',
    //             'instrument_and_conversion_condition' => 'Instrument And Conversion Condition is required',
    //             'pre_money_valuation' => 'Pre Money Valuation is required',
    //         ]);


    //         if ($validation->fails()) {
    //             return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
    //         }

    //         $startupfund = new StartupFundRaiseModel();
    //         $startupfund->fund_requirement = $request->fund_requirement;
    //         $startupfund->committed_investors = $request->committed_investors;
    //         $startupfund->fund_utilisation_details = $request->fund_utilisation_details;
    //         $startupfund->current_fund_raise = $request->current_fund_raise;
    //         $startupfund->funds_required_from_shuru = $request->funds_required_from_shuru;
    //         $startupfund->min_ticket_size = $request->min_ticket_size;
    //         $startupfund->pre_money_valuation_basis = $request->pre_money_valuation_basis;
    //         $startupfund->instrument_and_conversion_condition = $request->instrument_and_conversion_condition;
    //         $startupfund->pre_money_valuation = $request->pre_money_valuation;
    //         $startupfund->save();

    //         // Session::put('startup_register_id', $startupfund->id);

    //         return UtillsHelper::json(1, ['view' => view('front.startup.auth.register.childs.key_metrics', [
    //             'form_route' => route('front.raise.auth.post.register.keymetrics'),
    //         ])->render()]);
    //     }

    //     function keyMetricsPost(Request $request)
    //     {
    //         Log::info('Key Metrics Post Request:', $request->all());
    //         $validation = Validator::make($request->all(), [
    //             'founder_capital_contribution' => 'required|numeric|min:0',
    //             'monthly_revenue_run_rate' => 'required|numeric|min:0',
    //             'annualized_revenue_run_rate' => 'required|numeric|min:0',
    //             'current_monthly_burn' => 'required|numeric|min:0',
    //             'current_cash_balance' => 'required|numeric|min:0',
    //             'runway_months' => 'required',
    //             'traction_metrics' => 'required',
    //             'key_usp_differentiator_entry_barrier' => 'required',
    //             'competitors' => 'required'
    //         ], [], [
    //             'founder_capital_contribution' => 'Founder Capital Contribution field is required',
    //             'monthly_revenue_run_rate' => 'Monthly Revenue Run Rate is required',
    //             'annualized_revenue_run_rate' => 'Annualized Revenue Run Rate is required',
    //             'current_monthly_burn' => 'Current Monthly Burn is required',
    //             'current_cash_balance' => 'Current Cash Balance is required',
    //             'runway_months' => 'Runway Months is required',
    //             'traction_metrics' => 'Traction Metrics is required',
    //             'key_usp_differentiator_entry_barrier' => 'Key Usp Differentiator Entry Barrier is required',
    //             'competitors' => 'Competitors is required',
    //         ]);


    //         if ($validation->fails()) {
    //             return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
    //         }

    //         $startupfund = new StartupKeyMetricsModel();
    //         $startupfund->founder_capital_contribution = $request->founder_capital_contribution;
    //         $startupfund->monthly_revenue_run_rate = $request->monthly_revenue_run_rate;
    //         $startupfund->annualized_revenue_run_rate = $request->annualized_revenue_run_rate;
    //         $startupfund->current_monthly_burn = $request->current_monthly_burn;
    //         $startupfund->current_cash_balance = $request->current_cash_balance;
    //         $startupfund->runway_months = $request->runway_months;
    //         $startupfund->traction_metrics = $request->traction_metrics;
    //         $startupfund->key_usp_differentiator_entry_barrier = $request->key_usp_differentiator_entry_barrier;
    //         $startupfund->competitors = $request->competitors;
    //         $startupfund->save();

    //         // Session::put('startup_register_id', $startupfund->id);

    //         return UtillsHelper::json(1, ['view' => view('front.startup.auth.register.childs.success')->render()]);
    //     }

    //     function keyMetrics(): view
    //     {
    //         setPageTitle('Startup Key Metrics');
    //         return view('front.startup.auth.register.childs.key_metrics');
    //     }
    //     function financialDetail(): view
    //     {
    //         setPageTitle('Financial Details');
    //         return view('front.startup.auth.register.childs.financial_details');
    //     }
    //     function otherDetail(): view
    //     {
    //         setPageTitle('Other Details');
    //         return view('front.startup.auth.register.childs.other_details');
    //     }
    //     function test()
    //     {
    //         return UtillsHelper::json(1, []);
    //         // $this->sendWpMessage(
    //         //     NotificationTypeEnum::regular,
    //         //     'incubation_session_rejected',
    //         //     WpMessageTypeEnum::text,
    //         //     'mobile_no',
    //         //     'name_of_entity',
    //         //     NULL,
    //         //     NULL,
    //         //     [
    //         //         'grant_type'
    //         //     ],
    //         //     ['session_id' => $session->id]
    //         // );
    //         // $this->sendWpMessage(
    //         //     NotificationTypeEnum::event,
    //         //     'test_static_template',
    //         //     WpMessageTypeEnum::media,
    //         //     '919898375981',
    //         //     'Mehul Kava',
    //         //     NULL,
    //         //     NULL,
    //         //     [],
    //         //     ['name' => 'Mehul P Kava']
    //         // );
    //         // $this->sendMail(NotificationTypeEnum::event, 'mehul9921@gmail.com', 'Test Email', 'Sample Body');
    //     }

    //     public function viewBladeFile(): View
    //     {
    //         // Replace 'path.to.your.blade.file' with the actual path to your Blade file
    //         setPageTitle('Startup Login');
    //         return view('startup.auth.login');
    //     }

    //     function testing()
    //     {

    //         $this->fcmService->getGoogleAuthToken();


    //         die();
    //         // if (!request()->hasCookie('xsr-device')) {
    //         //     $uniqueId = (string) Str::uuid() . '_' . microtime(true);
    //         //     cookie('xsr-device', $uniqueId, 60);
    //         //     // Set cookie for 5 years (60 minutes * 24 hours * 365 days * 5 years)
    //         //     // $cookie = cookie('_unique_device_id', $uniqueId, 60 * 24 * 365 * 5);
    //         // }


    //         // return request()->cookie('xsr-device');
    //         // Log::alert(request()->cookie('_unique_device_id'));
    //         // return request()->cookie('_unique_device_id');
    //         // CoreFirebaseDeviceTokenModel::create([
    //         //     'user_id' => '1',
    //         //     'user_type' => InvestorModel::class,
    //         //     'device'    => DeviceTypeEnum::web,
    //         //     'device_id' => 'ABC',
    //         //     'token'     => 'eFZDn5XaYcA0LLwzdZ6eP6:APA91bHUKYyzAMAb0A9jHM7lODOp8WR_UQqOoVsDgQfG4G1CbMrb1GuOb7YGJ-l0buh_KxcUkh36Vk3tBzeQ3xg-hdjnq0sIIjA3utIxpjaMbiM5VIPzzQrjM0KLIYFKk8PAKKAvjGZL',
    //         // ]);
    //         // CoreFirebaseDeviceTokenModel::create([
    //         //     'user_id' => '1',
    //         //     'user_type' => InvestorModel::class,
    //         //     'device'    => DeviceTypeEnum::web,
    //         //     'device_id' => 'ABCD',
    //         //     'token'     => 'fuYWUBsx6Masc_ZKEyisQN:APA91bF3vy5OAGTiPonLdb6FLgrjma-DlLG45BNKhW-IsmNfpaNk_SIIKO9Bx4EMeoQmVWQB9NQ9SgehhBd2wET1laQeGrTcgaQyemn1A0_Jmy3SQpcly-yvpZQQPtIHAc1rrf2CDh_J',
    //         // ]);
    //         // CoreFirebaseDeviceTokenModel::create([
    //         //     'user_id' => '1',
    //         //     'user_type' => InvestorModel::class,
    //         //     'device'    => DeviceTypeEnum::web,
    //         //     'device_id' => 'ABCDD',
    //         //     'token'     => 'cJSvo8xN2vzTmn7_cQP6Yp:APA91bG01wK1uJqdREs6DaAwlzHBw8V_VPhLFo0SomebuhJ4OOGuH4lTo2xJfmY4FouIAvf1BXwyctCkEg5FmY3QoEq5EFzxCRC8Cm10I5yq9V1548-o_kQ9PorRhLXmmRFIgsayq40v',
    //         // ]);
    //         // CoreFirebaseDeviceTokenModel::create([
    //         //     'user_id' => '1',
    //         //     'user_type' => InvestorModel::class,
    //         //     'device'    => DeviceTypeEnum::android,
    //         //     'device_id' => 'ABCDDE',
    //         //     'token'     => 'ddv66FBETaS51Nv5GVOVXb:APA91bFNaKpsqaJSCY0jGEl0kSj3FArtXEfKQ8mU80hGdDkJjyrcL-A5bhuny5uJPyV-oEQMwWd21bTPNCoz5yWYhkWpHXhqqKh4oFcpvGkB87VgAWeDexQx25Wn7UrWu-U7_sa4-MVc',
    //         // ]);

    //         // $notification = NotificationsModel::create([
    //         //     'user_id'   => '1',
    //         //     'user_type' => InvestorModel::class,
    //         //     'url'       => '/',
    //         //     'title'     => 'Test notification',
    //         //     'body'      => 'This is body text'
    //         // ]);
    //         FirebasePushNotificationSendJob::dispatch(1);

    //         // $this->fcmService->sendPushNotification();
    //         // $this->sendNotification();

    //         // Session::flash('sample', 'error');
    //         // return redirect()->route('');
    //         // return view('front.test');
    //         // $this->sendNotification();


    //         // $keyFilePath = public_path('core/firebase/pkey.json');
    //         // $client = new Client();
    //         // $client->setAuthConfig($keyFilePath);
    //         // $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    //         // $guzzleClient = new GuzzleHttpClient();
    //         // $client->setHttpClient($guzzleClient);

    //         // $token = $client->fetchAccessTokenWithAssertion();
    //         // return $token;
    //         // // Create ServiceAccountCredentials
    //         // $credentials = new ServiceAccountCredentials(
    //         //     "https://www.googleapis.com/auth/firebase.messaging",
    //         //     json_decode(file_get_contents($keyFilePath), true)
    //         // );

    //         // // Fetch the auth token
    //         // $token = $credentials->fetchAuthToken(HttpHandlerFactory::build());
    //     }

    public function showDailyReport()
    {
        // Get market data
        // $data = CompanyDailySharePriceModel::getPriceFluctuationAlert();

        // // Get all unique company names from gainers and losers
        // $companyNames = collect($data['up'])
        //     ->merge($data['down'])
        //     ->pluck('company_name')
        //     ->unique()
        //     ->implode(',');

        // try {
        //     // First try to get company-specific news
        //     $newsResponse = Http::get('http://www.shuruup.com/api/get-companies-news', [
        //         'companies' => $companyNames,
        //         'limit' => 5,
        //         'days' => 30
        //     ]);

        //     $newsData = [];

        //     if ($newsResponse->successful()) {
        //         $newsData = $newsResponse->json()['data'] ?? [];
        //     }

        //     // If no company-specific news, get general news
        //     if (empty($newsData)) {
        //         $newsResponse = Http::get('http://www.shuruup.com/api/get-companies-news', [
        //             'limit' => 5
        //         ]);

        //         if ($newsResponse->successful()) {
        //             $newsData = $newsResponse->json()['data'] ?? [];
        //         }
        //     }
        // } catch (\Exception $e) {
        //     $newsData = [];
        //     Log::error("Failed to fetch news: " . $e->getMessage());
        // }

        // return view('daily-report', [
        //     'data' => $data,
        //     'newsData' => $newsData
        // ]);

        return view('front.website.about-test');
    }
}
