<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{

    private function s3()
    {
        $accessKey = env('AWS_ACCESS_KEY_ID');
        $secretKey = env('AWS_SECRET_ACCESS_KEY');
        $region = env('AWS_DEFAULT_REGION');
        $awsCred = new Credentials($accessKey, $secretKey);

        $config = [
            'version' => 'latest',
            'region'  => $region,
            'credentials' => $awsCred,
            'http' => [
                'verify' => false, // Disable SSL for testing
                'timeout' => 120,
                'connect_timeout' => 60,
            ],
        ];

        return new S3Client($config);
    }

    function createMultipart(Request $request)
    {
        $accessKey = env('AWS_ACCESS_KEY_ID');
        $secretKey = env('AWS_SECRET_ACCESS_KEY');
        $region = env('AWS_DEFAULT_REGION');
        $awsCred = new Credentials($accessKey, $secretKey);

        $config = [
            'version' => 'latest',
            'region'  => $region,
            'credentials' => $awsCred,
            'http' => [
                'verify' => false, // Disable SSL for testing
                'timeout' => 120,
                'connect_timeout' => 60,
            ],
        ];
        $directory = 'dyuploads';
        $s3Client = new S3Client($config);
        $bucket = env('AWS_BUCKET');

        $fileName = $request->filename;
        $contentType = $request->contentType;
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileName = date('Ymd') . uniqid() . '.' . $extension;

        $command = $s3Client->getCommand('putObject', [
            'Bucket' => $bucket,
            'Key' => "{$directory}/{$fileName}",
            'ContentType' => $contentType,
            'Body' => '',
        ]);

        $request = $s3Client->createPresignedRequest($command, '+5 minutes');
        return response()->json(
            [
                'method' => $request->getMethod(),
                'url'      =>  $request->getUri(),
                'fields' => [],
                'headers' => [
                    'content-type' => $contentType,
                ],
            ]
        );
    }


    // private function s3()
    // {
    //     try {
    //         $accessKey = env('AWS_ACCESS_KEY_ID');
    //         $secretKey = env('AWS_SECRET_ACCESS_KEY');
    //         $region = env('AWS_DEFAULT_REGION', 'ap-south-1');

    //         // Debug log credentials (don't do this in production)
    //         Log::info('S3 Credentials Check', [
    //             'access_key_present' => !empty($accessKey),
    //             'secret_key_present' => !empty($secretKey),
    //             'region' => $region,
    //             'access_key_length' => strlen($accessKey ?? ''),
    //             'secret_key_length' => strlen($secretKey ?? ''),
    //         ]);

    //         if (empty($accessKey) || empty($secretKey)) {
    //             throw new \Exception('AWS credentials not configured properly');
    //         }

    //         $awsCred = new Credentials($accessKey, $secretKey);

    //         $config = [
    //             'version' => 'latest',
    //             'region'  => $region,
    //             'credentials' => $awsCred,
    //             'http' => [
    //                 'verify' => false, // Disable SSL for testing
    //                 'timeout' => 120,
    //                 'connect_timeout' => 60,
    //             ],
    //         ];

    //         return new S3Client($config);
    //     } catch (\Exception $e) {
    //         Log::error('S3 Client initialization failed', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);
    //         throw $e;
    //     }
    // }

    // public function createMultipart(Request $request)
    // {
    //     Log::info('=== CREATE MULTIPART UPLOAD STARTED ===');
    //     Log::info('Request data', $request->all());

    //     try {
    //         $request->validate([
    //             'fileName' => 'required|string|max:255'
    //         ]);

    //         $s3 = $this->s3();
    //         $bucket = env('AWS_BUCKET', 'techshuruup-s3-bucket');

    //         $fileName = $request->fileName;
    //         $contentType = $request->contentType ?? 'application/octet-stream';

    //         // Create safer filename
    //         $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    //         $safeName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', pathinfo($fileName, PATHINFO_FILENAME));
    //         $key = 'dyuploads/' . date('Y/m/d') . '/' . uniqid() . '_' . $safeName . '.' . $extension;

    //         Log::info('Creating multipart upload', [
    //             'bucket' => $bucket,
    //             'key' => $key,
    //             'filename' => $fileName,
    //             'content_type' => $contentType,
    //         ]);

    //         $result = $s3->createMultipartUpload([
    //             'Bucket' => $bucket,
    //             'Key'    => $key,
    //             'ACL'    => 'public-read',
    //             'ContentType' => $contentType,
    //         ]);

    //         Log::info('Multipart upload created successfully', [
    //             'upload_id' => $result['UploadId'],
    //             'key' => $result['Key'],
    //         ]);

    //         return response()->json([
    //             'uploadId' => $result['UploadId'],
    //             'key'      => $result['Key'],
    //             'bucket'   => $bucket,
    //         ]);
    //     } catch (\Aws\Exception\AwsException $e) {
    //         Log::error('AWS S3 Error in createMultipart', [
    //             'error_message' => $e->getMessage(),
    //             'error_code' => $e->getAwsErrorCode(),
    //             'error_type' => $e->getAwsErrorType(),
    //             'request_id' => $e->getAwsRequestId(),
    //             'status_code' => $e->getStatusCode(),
    //         ]);

    //         return response()->json([
    //             'error' => 'AWS S3 Error: ' . $e->getMessage(),
    //             'code' => $e->getAwsErrorCode(),
    //             'type' => $e->getAwsErrorType(),
    //         ], 500);
    //     } catch (\Exception $e) {
    //         Log::error('General Error in createMultipart', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return response()->json([
    //             'error' => 'Failed to create multipart upload: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function getPresignedUrl(Request $request)
    // {
    //     Log::info('=== GET PRESIGNED URL STARTED ===');
    //     Log::info('Request data', $request->all());

    //     try {
    //         $request->validate([
    //             'key' => 'required|string',
    //             'uploadId' => 'required|string',
    //             'partNumber' => 'required|integer|min:1|max:10000'
    //         ]);

    //         $s3 = $this->s3();
    //         $bucket = env('AWS_BUCKET', 'techshuruup-s3-bucket');

    //         Log::info('Generating presigned URL', [
    //             'bucket' => $bucket,
    //             'key' => $request->key,
    //             'upload_id' => $request->uploadId,
    //             'part_number' => $request->partNumber,
    //         ]);

    //         $cmd = $s3->getCommand('UploadPart', [
    //             'Bucket'     => $bucket,
    //             'Key'        => $request->key,
    //             'UploadId'   => $request->uploadId,
    //             'PartNumber' => $request->partNumber,
    //         ]);

    //         $requestUrl = $s3->createPresignedRequest($cmd, '+60 minutes');
    //         $url = (string) $requestUrl->getUri();

    //         Log::info('Presigned URL generated successfully', [
    //             'part_number' => $request->partNumber,
    //             'url_length' => strlen($url),
    //             'url_domain' => parse_url($url, PHP_URL_HOST),
    //         ]);

    //         // return response()->json([
    //         //     'url' => $url,
    //         //     'part_number' => $request->partNumber,
    //         // ]);
    //         return response()->json([
    //             'url' => $url // Only return the URL, no extra fields
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Error generating presigned URL', [
    //             'error' => $e->getMessage(),
    //             'key' => $request->key ?? 'N/A',
    //             'upload_id' => $request->uploadId ?? 'N/A',
    //             'part_number' => $request->partNumber ?? 'N/A',
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return response()->json([
    //             'error' => 'Failed to generate presigned URL: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function completeMultipart(Request $request)
    // {
    //     Log::info('=== COMPLETE MULTIPART UPLOAD STARTED ===');
    //     Log::info('Request data', $request->all());

    //     try {
    //         $request->validate([
    //             'key' => 'required|string',
    //             'uploadId' => 'required|string',
    //             'parts' => 'required|array',
    //             'parts.*.PartNumber' => 'required|integer',
    //             'parts.*.ETag' => 'required|string'
    //         ]);

    //         $s3 = $this->s3();
    //         $bucket = env('AWS_BUCKET', 'techshuruup-s3-bucket');

    //         $parts = [];
    //         foreach ($request->parts as $part) {
    //             $parts[] = [
    //                 'ETag' => trim($part['ETag'], '"'),
    //                 'PartNumber' => $part['PartNumber'],
    //             ];
    //         }

    //         Log::info('Completing multipart upload', [
    //             'bucket' => $bucket,
    //             'key' => $request->key,
    //             'upload_id' => $request->uploadId,
    //             'parts_count' => count($parts),
    //         ]);

    //         $result = $s3->completeMultipartUpload([
    //             'Bucket'          => $bucket,
    //             'Key'             => $request->key,
    //             'UploadId'        => $request->uploadId,
    //             'MultipartUpload' => [
    //                 'Parts' => $parts,
    //             ],
    //         ]);

    //         Log::info('Multipart upload completed successfully', [
    //             'location' => $result['Location'],
    //             'etag' => $result['ETag'] ?? 'N/A',
    //         ]);

    //         return response()->json([
    //             'location' => $result['Location'],
    //             'etag' => $result['ETag'] ?? null,
    //             'success' => true,
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Error completing multipart upload', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return response()->json([
    //             'error' => 'Failed to complete multipart upload: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function abortMultipart(Request $request)
    // {
    //     Log::info('=== ABORT MULTIPART UPLOAD STARTED ===');
    //     Log::info('Request data', $request->all());

    //     try {
    //         $request->validate([
    //             'key' => 'required|string',
    //             'uploadId' => 'required|string'
    //         ]);

    //         $s3 = $this->s3();
    //         $bucket = env('AWS_BUCKET', 'techshuruup-s3-bucket');

    //         $s3->abortMultipartUpload([
    //             'Bucket' => $bucket,
    //             'Key' => $request->key,
    //             'UploadId' => $request->uploadId,
    //         ]);

    //         Log::info('Multipart upload aborted successfully');

    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         Log::error('Error aborting multipart upload', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return response()->json([
    //             'error' => 'Failed to abort multipart upload: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
