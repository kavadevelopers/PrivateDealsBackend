<?php

namespace App\Http\Controllers\Api;

use App\Enums\AdminTypeEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\CommonHelper;
use App\Helpers\DigioHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendAadharPanNotificationJob;
use App\Models\InvestorKycPanModel;
use App\Models\InvestorModel;
use App\Models\TempAadharPanDetailsModel;
use App\Models\TempDematCmlFiles;
use App\Models\UserAdminModel;
use App\Services\DematPdfParsingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Config;
use Smalot\PdfParser\Parser;

class UploadAndParseController extends Controller
{
    // function dematPdf()
    // {
    //     $request = request();

    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'cml' => 'required|file|mimes:pdf|max:10000',
    //         ],
    //         [
    //             'cml.required' => 'The CML file is required.',
    //             'cml.file' => 'The CML must be a valid file.',
    //             'cml.mimes' => 'The CML must be a PDF file.',
    //             'cml.max' => 'The CML file may not be greater than 10 MB.',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
    //     }

    //     try {
    //         $file = $request->file('cml');
    //         $fileContent = file_get_contents($file->getRealPath());

    //         $config = new Config();
    //         $config->setHorizontalOffset("\t");

    //         $parser = new Parser([], $config);
    //         $pdf = $parser->parseContent($fileContent);

    //         $text = trim($pdf->getText());


    //         if (empty($text)) {
    //             return UtillsHelper::json(0, ['message' => 'PDF appears to be image-based or contains no extractable text.']);
    //         }

    //         $lowerText = strtolower($text);

    //         // if (
    //         //     strpos($lowerText, 'national securities depository limited') === false &&
    //         //     strpos($lowerText, 'central depository services') === false
    //         // ) {
    //         //     return UtillsHelper::json(0, ['message' => 'This PDF is not a valid NSDL or CDSL document.']);
    //         // }

    //         // Extract data using regex
    //         $dpId = $clientId = $pan = $holderName  = $accountNumber = $ifsc = $bankName  = null;

    //         if (strpos($lowerText, 'national securities depository limited') !== false) {
    //             if (preg_match('/\[([^]]+)\]/', $text, $matches)) {
    //                 $dpId = $matches[1];
    //             }
    //         } else {
    //             if (preg_match('/dp\s*id[:\s]*([0-9]{6,})/i', $text, $matches)) {
    //                 $dpId = $matches[1];
    //             }
    //         }

    //         if (preg_match('/client\s*id[^0-9]*([0-9]+)/i', $text, $matches)) {
    //             $clientId = $matches[1];
    //         }

    //         if (preg_match('/([A-Z]{5}[0-9]{4}[A-Z])/i', $text, $matches)) {
    //             $pan = $matches[1];
    //         }

    //         if (preg_match('/HUF\s*Name\s*\([^)]*Sole\s*Holder[^)]*\)\s*(?:MR\.?|MRS\.?|MS\.?|MISS\.?)?\s*([A-Z ]{3,100})\s*HUF/i', $text, $matches)) {
    //             $holderName = trim($matches[1]);
    //         } elseif (preg_match('/Sole\/First\s*Holder\s*Name\s*[:\t ]+(?:MR\.?|MRS\.?|MS\.?|MISS\.?)?\s*([A-Z ]{3,100})(?=\t|$|First|Second|Holder|client|Student|Occupation|Father|Spouse|PAN|Date)/i', $text, $matches)) {
    //             $holderName = trim($matches[1]);
    //         } elseif (preg_match('/First\s*Holder\s*Name\s*[:\t ]+(?:MR\.?|MRS\.?|MS\.?|MISS\.?)?\s*([A-Z ]{3,100}?)(?=\s*(?:First|Second|Third|Holder|client|Student|Occupation|Father|Spouse|PAN|Date|$))/i', $text, $matches)) {
    //             $holderName = trim($matches[1]);
    //         } elseif (preg_match('/First\s*Holder\s*Name\s*[:\t ]+(?:MR\.?|MRS\.?|MS\.?|MISS\.?)?\s*([A-Z ]{3,100})(?=\t|$|First|Second|Holder|client|Student|Occupation|Father|Spouse|PAN|Date)/i', $text, $matches)) {
    //             $holderName = trim($matches[1]);
    //         }
    //         $holderName = $this->fixBrokenName($holderName);


    //         if (preg_match('/bank\s*(a\/c\s*no|account\s*number|a\/c\s*number|account\s*no)[^0-9]*([0-9]{10,})/i', $text, $matches)) {
    //             $accountNumber = $matches[2];
    //         }

    //         if (preg_match('/Bank\s*Details\s*\t*([A-Z&. ]{3,40}?)(?=\t|Bank\s*A\/c|Bank\s*A\/c\s*Type|$)/i', $text, $matches)) {
    //             $bankName = trim($matches[1]);
    //         } elseif (preg_match('/bank\s*name\s*([A-Z&. ]{3,40}?)(?=\s+POA|DDPI|Assigned|$)/i', $text, $matches)) {
    //             $bankName = trim($matches[1]);
    //         }

    //         // if (preg_match('/Bank\s*A\/c\s*Type\s*\t*([A-Za-z ]+)/i', $text, $matches)) {
    //         //     $accountType = trim($matches[1]);
    //         // } elseif (preg_match('/([A-Za-z]+)\s*bank\s*account\s*type/i', $text, $matches)) {
    //         //     $accountType = trim($matches[1]);
    //         // }

    //         if (preg_match('/ifsc\s*code[:\s]*([A-Z]{4}[0-9]{1}[0-9A-Z]{6})/i', $text, $matches)) {
    //             $ifsc = $matches[1];
    //         }

    //         // if (preg_match('/[a-z0-9_.+-]+@[a-z0-9-]+\.[a-z.]{2,6}/i', $text, $matches)) {
    //         //     $email = $matches[0];
    //         // }

    //         if (is_null($dpId) || is_null($clientId) || is_null($pan) || is_null($holderName) || is_null($accountNumber) || is_null($ifsc)) {
    //             $path = FileUpDownHelper::uploadTempDematCml($file);

    //             if ($path) {
    //                 TempDematCmlFiles::create([
    //                     'investor_id' => $request->user()?->id,
    //                     'file_path' => $path,
    //                     'original_name' => $file->getClientOriginalName(),
    //                     'reason' => 'This PDF is not a valid NSDL or CDSL document.',
    //                 ]);
    //             }
    //             return UtillsHelper::json(0, [
    //                 'message' => 'This PDF is not a valid NSDL or CDSL document.',
    //             ]);
    //         }

    //         return UtillsHelper::json(1, [
    //             'message' => 'PDF parsed successfully.',
    //             'data' => [
    //                 'dp_id' => $dpId,
    //                 'client_id' => $clientId,
    //                 'pan_no' => $pan,
    //                 'account_holder_name' => $holderName,
    //                 'account_number' => $accountNumber,
    //                 'ifsc_code' => $ifsc,
    //                 'bank_name' => $bankName,
    //                 'dob' => ''
    //             ],
    //         ]);
    //     } catch (Exception $e) {
    //         return UtillsHelper::json(0, ['message' =>  $e->getMessage()]);
    //     }
    // }

    // function fixBrokenName($name)
    // {
    //     $parts = preg_split('/[\s\t]+/', trim($name));
    //     $fixedParts = [];
    //     $i = 0;

    //     while ($i < count($parts)) {
    //         // If next part exists and both are short (likely broken surname), merge
    //         if (
    //             isset($parts[$i + 1]) &&
    //             strlen($parts[$i]) <= 4 &&
    //             strlen($parts[$i + 1]) <= 4
    //         ) {
    //             $fixedParts[] = $parts[$i] . $parts[$i + 1];
    //             $i += 2; // Skip next part
    //         } else {
    //             $fixedParts[] = $parts[$i];
    //             $i++;
    //         }
    //     }

    //     return implode(' ', $fixedParts);
    // }

    function dematPdf()
    {
        $request = request();

        $validator = Validator::make(
            $request->all(),
            [
                'cml' => 'required|file|mimes:pdf|max:10000',
            ],
            [
                'cml.required' => 'The CML file is required.',
                'cml.file' => 'The CML must be a valid file.',
                'cml.mimes' => 'The CML must be a PDF file.',
                'cml.max' => 'The CML file may not be greater than 10 MB.',
            ]
        );

        if ($validator->fails()) {
            return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
        }

        $file = $request->file('cml');
        $userId = $request->user()?->id;

        $pdfParsingService = new DematPdfParsingService();
        $result = $pdfParsingService->processPdf($file, $userId);

        if ($result['success']) {
            return UtillsHelper::json(1, [
                'message' => $result['message'],
                'data' => $result['data']
            ]);
        } else {
            return UtillsHelper::json(0, ['message' => $result['message']]);
        }
    }


    // function aadharPan()
    // {
    //     $request = request();

    //     $validator = Validator::make($request->all(), [
    //         'aadhar_front'      => [
    //             'required',
    //             'mimes:' . CommonHelper::appSettings('file_image_extensions_allowed'),
    //             'max:' . UtillsHelper::maxFileImageSizeInKB(),
    //         ],
    //         'aadhar_back'       => [
    //             'required',
    //             'mimes:' . CommonHelper::appSettings('file_image_extensions_allowed'),
    //             'max:' . UtillsHelper::maxFileImageSizeInKB(),
    //         ],

    //         'pan'          => [
    //             'required',
    //             'mimes:' . CommonHelper::appSettings('file_image_extensions_allowed'),
    //             'max:' . UtillsHelper::maxFileImageSizeInKB(),
    //         ],

    //     ]);

    //     if ($validator->fails()) {
    //         return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
    //     }


    //     $aadhar_front_path = FileUpDownHelper::aadhar_front_img_upload($request->file('aadhar_front'));
    //     $aadhar_back_path  = FileUpDownHelper::aadhar_back_img_upload($request->file('aadhar_back'));
    //     $pan_path          = FileUpDownHelper::pan_front_img_upload($request->file('pan'));

    //     $dob             = '01-01-2025';
    //     $aadhar_name     = 'Will be fetched from api';
    //     $pan_name        = 'Will be fetched from api';
    //     $panNo           = 'ABCDE1234F';
    //     $aadharNo        = '1234 5678 9012';
    //     $address         = 'London Street, London, UK';
    //     TempAadharPanDetailsModel::updateOrCreate(
    //         ['investor_id' => $request->user()->id],
    //         [
    //             'aadhar_front'  => $aadhar_front_path,
    //             'aadhar_back'   => $aadhar_back_path,
    //             'pan'           => $pan_path,
    //             'aadhar_no'     => $aadharNo,
    //             'pan_no'        => $panNo,
    //             'aadhar_name'   => $aadhar_name,
    //             'pan_name'      => $pan_name,
    //             'dob'           => $dob,
    //             'address'       => $address,
    //         ]
    //     );

    //     $investor = $request->user();
    //     SendAadharPanNotificationJob::dispatch($investor->name);

    //     return UtillsHelper::json(0, [
    //         'message' => 'Aadhaar and PAN details received. KYC is under review and will be updated within 2 working days.',
    //         'data' => [
    //             'dob'               => $dob,
    //             'aadhar_no'         => $aadharNo,
    //             'aadhar_name'       => $aadhar_name,
    //             'pan_no'            => $panNo,
    //             'pan_name'          => $pan_name,
    //             'address'           => $address,
    //         ]
    //     ]);
    // }

    public function aadharPan()
    {
        $request = request();

        // Log file details for debugging
        // Log::info('Aadhaar Front File', [
        //     'originalName' => $request->file('aadhar_front')->getClientOriginalName(),
        //     'realPath' => $request->file('aadhar_front')->getRealPath(),
        //     'isValid' => $request->file('aadhar_front')->isValid(),
        //     'size' => $request->file('aadhar_front')->getSize(),
        //     'mimeType' => $request->file('aadhar_front')->getMimeType(),
        // ]);

        // Validate file uploads
        $validator = Validator::make($request->all(), [
            'aadhar_front' => [
                'required',
                'mimes:' . CommonHelper::appSettings('file_image_extensions_allowed'),
                'max:' . UtillsHelper::maxFileImageSizeInKB(),
            ],
            'aadhar_back' => [
                'required',
                'mimes:' . CommonHelper::appSettings('file_image_extensions_allowed'),
                'max:' . UtillsHelper::maxFileImageSizeInKB(),
            ],
            'pan' => [
                'required',
                'mimes:' . CommonHelper::appSettings('file_image_extensions_allowed'),
                'max:' . UtillsHelper::maxFileImageSizeInKB(),
            ],
        ]);

        if ($validator->fails()) {
            return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
        }

        // Analyze documents using DigioHelper
        $aadharData = DigioHelper::analyzeIdCard($request->file('aadhar_front'), 'aadhaar', $request->file('aadhar_back'));
        $panData = DigioHelper::analyzeIdCard($request->file('pan'), 'pan');

        // Check if analysis was successful
        if (!$aadharData || !$panData) {
            return UtillsHelper::json(0, ['message' => 'Failed to analyze documents. Please try again.']);
        }

        // Check for API errors
        if (isset($aadharData['code']) && $aadharData['code'] === 'BAD_REQUEST') {
            Log::error('Aadhaar analysis failed: ' . ($aadharData['message'] ?? 'Unknown error'));
            return UtillsHelper::json(0, ['message' => 'Aadhaar document analysis failed: ' . ($aadharData['message'] ?? 'Unknown error')]);
        }

        if (isset($panData['code']) && $panData['code'] === 'BAD_REQUEST') {
            Log::error('PAN analysis failed: ' . ($panData['message'] ?? 'Unknown error'));
            return UtillsHelper::json(0, ['message' => 'PAN document analysis failed: ' . ($panData['message'] ?? 'Unknown error')]);
        }

        // Extract detections
        $aadhaarDetections = $aadharData['detections'] ?? [];
        $panDetections = $panData['detections'] ?? [];

        if (empty($aadhaarDetections)) {
            // Try to extract image check results manually from full response (sometimes detection array is empty but checks are present)
            $aadhaarFrontChecks = $aadharData['front_image_checks_result'] ?? [];
            $aadhaarBackChecks = $aadharData['back_image_checks_result'] ?? [];

            if (!$this->isImageQualityValid($aadhaarFrontChecks, 0.4, true) && !$this->isImageQualityValid($aadhaarBackChecks, 0.4, true)) {
                return UtillsHelper::json(0, ['message' => 'Aadhaar front and back image quality are not acceptable. Please upload clear, colored images.']);
            }

            if (!$this->isImageQualityValid($aadhaarFrontChecks, 0.4, true)) {
                return UtillsHelper::json(0, ['message' => 'Aadhaar front image quality is not acceptable. Please upload a clear, colored Aadhaar front image.']);
            }

            if (!$this->isImageQualityValid($aadhaarBackChecks, 0.4, true)) {
                return UtillsHelper::json(0, ['message' => 'Aadhaar back image quality is not acceptable. Please upload a clear, colored Aadhaar back image.']);
            }

            return UtillsHelper::json(0, ['message' => 'Aadhaar front and back images are not acceptable. Please upload clear, colored images.']);
        }

        if (empty($panDetections)) {
            $panFrontChecks = $panData['front_image_checks_result'] ?? [];

            if (!$this->isImageQualityValid($panFrontChecks, 0.4, true)) {
                return UtillsHelper::json(0, ['message' => 'PAN image quality is not acceptable. Please upload a clear, colored PAN card image.']);
            }

            return UtillsHelper::json(0, ['message' => 'Unable to process PAN image. Please upload a valid image.']);
        }

        // Get first detection (should contain both front and back for Aadhaar)
        $aadhaarDetection = $aadhaarDetections[0];
        $panDetection = $panDetections[0];

        // Aadhaar FRONT image quality check
        $aadhaarFrontChecks = $aadhaarDetection['front_image_checks_result'] ?? [];
        if (!$this->isImageQualityValid($aadhaarFrontChecks, 0.4, true)) {
            return UtillsHelper::json(0, ['message' => 'Aadhaar front image quality is not acceptable. Please upload a clear, colored Aadhaar front image.']);
        }

        // Aadhaar BACK image quality check (only if back image is detected)
        $aadhaarBackChecks = $aadhaarDetection['back_image_checks_result'] ?? [];
        if (empty($aadhaarBackChecks)) {
            return UtillsHelper::json(0, ['message' => 'Aadhaar back image not detected. Please upload a clear Aadhaar back image.']);
        }
        if (!$this->isImageQualityValid($aadhaarBackChecks, 0.4, true)) {
            return UtillsHelper::json(0, ['message' => 'Aadhaar back image quality is not acceptable. Please upload a clear, colored Aadhaar back image.']);
        }


        // PAN image quality check
        $panFrontChecks = $panDetection['front_image_checks_result'] ?? [];
        if (!$this->isImageQualityValid($panFrontChecks, 0.4, true)) {
            return UtillsHelper::json(0, ['message' => 'PAN image quality is not acceptable. Please upload a clear, colored PAN card image.']);
        }


        // Extract attributes
        $aadhaarAttributes = $aadhaarDetection['id_attributes'] ?? [];
        $panAttributes = $panDetection['id_attributes'] ?? [];

        // Validate required Aadhaar attributes
        $aadhaarNameMissing = empty($aadhaarAttributes['name']);
        $aadhaarIdMissing = empty($aadhaarAttributes['id_no']);
        $aadhaarAddressMissing = empty($aadhaarAttributes['address'] ?? null);

        if ($aadhaarNameMissing && $aadhaarIdMissing && $aadhaarAddressMissing) {
            return UtillsHelper::json(0, ['message' => 'Unable to extract Aadhaar details from both front and back images. Please upload clear, valid images.']);
        }

        if ($aadhaarNameMissing || $aadhaarIdMissing) {
            return UtillsHelper::json(0, ['message' => 'Unable to extract Aadhaar name or number from front image. Please upload a clear Aadhaar front image.']);
        }

        if ($aadhaarAddressMissing) {
            return UtillsHelper::json(0, ['message' => 'Unable to extract address from Aadhaar back image. Please upload a clear Aadhaar back image.']);
        }


        // Validate required PAN attributes
        if (empty($panAttributes['name']) || empty($panAttributes['id_no'])) {
            return UtillsHelper::json(0, ['message' => 'Unable to extract PAN details. Please ensure the image is clear and valid.']);
        }

        // Extract data for comparison and storage
        $aadharNo = $aadhaarAttributes['id_no'];
        $aadharName = $aadhaarAttributes['name'];
        $panNo = $panAttributes['id_no'];
        $panName = $panAttributes['name'];
        $dob = $panAttributes['dob'] ?? $aadhaarAttributes['dob'] ?? 'N/A';
        $address = $aadhaarAttributes['address'] ?? 'N/A';

        // Check if PAN number matches existing record
        // $panRecord = InvestorKycPanModel::where('investor_id', $request->user()->id)->first();
        // if ($panRecord && strtoupper($panRecord->pan_no) !== strtoupper($panNo)) {
        //     return UtillsHelper::json(0, ['message' => 'Uploaded PAN number does not match registered PAN.']);
        // }

        // Validate name matching between Aadhaar and PAN
        if (!$this->cosineMatch($aadharName, $panName)) {
            return UtillsHelper::json(0, ['message' => 'Aadhaar and PAN names do not appear to match. Please upload valid documents of the same person.']);
        }

        // Upload files
        $aadharFrontPath = FileUpDownHelper::aadhar_front_img_upload($request->file('aadhar_front'));
        $aadharBackPath = FileUpDownHelper::aadhar_back_img_upload($request->file('aadhar_back'));
        $panPath = FileUpDownHelper::pan_front_img_upload($request->file('pan'));

        // Store temporary data
        TempAadharPanDetailsModel::updateOrCreate(
            ['investor_id' => $request->user()->id],
            [
                'aadhar_front' => $aadharFrontPath,
                'aadhar_back' => $aadharBackPath,
                'pan' => $panPath,
                'aadhar_no' => $aadharNo,
                'pan_no' => $panNo,
                'aadhar_name' => $aadharName,
                'pan_name' => $panName,
                'dob' => $dob,
                'address' => $address,
            ]
        );

        // Dispatch notification job
        // SendAadharPanNotificationJob::dispatch($request->user()->name);

        return UtillsHelper::json(1, [
            'message' => 'Aadhaar and PAN details received. KYC is under review and will be updated within 2 working days.',
            'is_manual' => false,
            'data' => [
                'dob' => $dob,
                'aadhar_no' => $aadharNo,
                'aadhar_name' => $aadharName,
                'pan_no' => $panNo,
                'pan_name' => $panName,
                'address' => $address,
            ]
        ]);
    }

    /**
     * Validate image quality for Aadhaar or PAN
     *
     * @param array $detection Detection data from API
     * @param string $documentType Document type (Aadhaar/PAN)
     * @return bool|JsonResponse True if valid, JsonResponse if invalid
     */
    private function validateImageQuality($detection, $documentType)
    {
        // Define quality thresholds - relaxed based on your API response
        $blurThreshold = 0.4; // Lowered from 0.55 to be less strict
        $requireColorImages = true; // Set to false if B&W images should be allowed

        // For Aadhaar, check both front and back image quality
        if ($documentType === 'Aadhaar') {
            // Check front image quality
            $frontChecks = $detection['front_image_checks_result'] ?? [];
            if (!$this->isImageQualityValid($frontChecks, $blurThreshold, $requireColorImages)) {
                return UtillsHelper::json(0, ['message' => 'Aadhaar front image quality is not acceptable. Please upload a clear, colored image.']);
            }

            // Check back image quality if available
            $backChecks = $detection['back_image_checks_result'] ?? [];
            if (!empty($backChecks) && !$this->isImageQualityValid($backChecks, $blurThreshold, $requireColorImages)) {
                return UtillsHelper::json(0, ['message' => 'Aadhaar back image quality is not acceptable. Please upload a clear, colored image.']);
            }
        }

        // For PAN, check front image quality
        if ($documentType === 'PAN') {
            $frontChecks = $detection['front_image_checks_result'] ?? [];
            if (!$this->isImageQualityValid($frontChecks, $blurThreshold, $requireColorImages)) {
                return UtillsHelper::json(0, ['message' => 'PAN image quality is not acceptable. Please upload a clear, colored image.']);
            }
        }

        return true;
    }

    /**
     * Check if individual image quality checks pass
     *
     * @param array $checks Image quality checks from API
     * @param float $blurThreshold Minimum blur score required
     * @param bool $requireColor Whether to require colored images
     * @return bool
     */
    private function isImageQualityValid($checks, $blurThreshold, $requireColor)
    {
        // Check blur score
        $blurScore = $checks['BLUR_IMAGE']['score'] ?? 1.0;
        if ($blurScore < $blurThreshold) {
            Log::warning('Image failed blur check', ['score' => $blurScore, 'threshold' => $blurThreshold]);
            return false;
        }

        // Check if image is colored (if required)
        if ($requireColor) {
            $bwResult = $checks['BLACK_AND_WHITE_IMAGE']['result'] ?? 'PASS';
            if ($bwResult === 'FAIL') {
                Log::warning('Image failed color check', ['result' => $bwResult]);
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate cosine similarity between two names
     *
     * @param string $name1 First name
     * @param string $name2 Second name
     * @param float $threshold Similarity threshold (0-1)
     * @return bool
     */
    private function cosineMatch($name1, $name2, $threshold = 0.5)
    {
        $cleanName1 = strtolower(preg_replace('/[^a-z ]/', '', trim($name1)));
        $cleanName2 = strtolower(preg_replace('/[^a-z ]/', '', trim($name2)));

        if (empty($cleanName1) || empty($cleanName2)) return false;

        $tokens1 = array_filter(explode(' ', $cleanName1));
        $tokens2 = array_filter(explode(' ', $cleanName2));

        sort($tokens1);
        sort($tokens2);

        // Fuzzy token matching
        $matchedCount = 0;
        foreach ($tokens1 as $word1) {
            foreach ($tokens2 as $word2) {
                similar_text($word1, $word2, $percent);
                if ($percent >= 85) { // fuzzy match
                    $matchedCount++;
                    break;
                }
            }
        }

        $totalTokens = max(count($tokens1), count($tokens2));
        $fuzzySimilarity = $matchedCount / $totalTokens;

        Log::info('Fuzzy name similarity', [
            'tokens1' => $tokens1,
            'tokens2' => $tokens2,
            'fuzzy_matched_count' => $matchedCount,
            'total_tokens' => $totalTokens,
            'fuzzy_similarity' => $fuzzySimilarity,
            'threshold' => $threshold
        ]);

        return $fuzzySimilarity >= $threshold;
    }
}
