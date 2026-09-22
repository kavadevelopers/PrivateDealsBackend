<?php

namespace App\Services;

use Exception;
use Smalot\PdfParser\Config;
use Smalot\PdfParser\Parser;
use App\Models\TempDematCmlFiles;
use App\Helpers\FileUpDownHelper;

class DematPdfParsingService
{
    public function processPdf($file, $userId = null)
    {
        try {
            $fileContent = file_get_contents($file->getRealPath());

            $config = new Config();
            $config->setHorizontalOffset("\t");

            $parser = new Parser([], $config);
            $pdf = $parser->parseContent($fileContent);

            $text = trim($pdf->getText());

            if (empty($text)) {
                return [
                    'success' => false,
                    'message' => 'PDF appears to be image-based or contains no extractable text.'
                ];
            }

            $lowerText = strtolower($text);

            // Extract data using regex
            $dpId = $clientId = $pan = $holderName = $accountNumber = $ifsc = $bankName = null;

            if (strpos($lowerText, 'national securities depository limited') !== false) {
                if (preg_match('/\[([^]]+)\]/', $text, $matches)) {
                    $dpId = $matches[1];
                }
            } else {
                if (preg_match('/dp\s*id[:\s]*([0-9]{6,})/i', $text, $matches)) {
                    $dpId = $matches[1];
                }
            }

            if (preg_match('/client\s*id[^0-9]*([0-9]+)/i', $text, $matches)) {
                $clientId = $matches[1];
            }

            if (preg_match('/([A-Z]{5}[0-9]{4}[A-Z])/i', $text, $matches)) {
                $pan = $matches[1];
            }

            if (preg_match('/HUF\s*Name\s*\([^)]*Sole\s*Holder[^)]*\)\s*(?:MR\.?|MRS\.?|MS\.?|MISS\.?)?\s*([A-Z ]{3,100})\s*HUF/i', $text, $matches)) {
                $holderName = trim($matches[1]);
            } elseif (preg_match('/Sole\/First\s*Holder\s*Name\s*[:\t ]+(?:MR\.?|MRS\.?|MS\.?|MISS\.?)?\s*([A-Z ]{3,100})(?=\t|$|First|Second|Holder|client|Student|Occupation|Father|Spouse|PAN|Date)/i', $text, $matches)) {
                $holderName = trim($matches[1]);
            } elseif (preg_match('/First\s*Holder\s*Name\s*[:\t ]+(?:MR\.?|MRS\.?|MS\.?|MISS\.?)?\s*([A-Z ]{3,100}?)(?=\s*(?:First|Second|Third|Holder|client|Student|Occupation|Father|Spouse|PAN|Date|$))/i', $text, $matches)) {
                $holderName = trim($matches[1]);
            } elseif (preg_match('/First\s*Holder\s*Name\s*[:\t ]+(?:MR\.?|MRS\.?|MS\.?|MISS\.?)?\s*([A-Z ]{3,100})(?=\t|$|First|Second|Holder|client|Student|Occupation|Father|Spouse|PAN|Date)/i', $text, $matches)) {
                $holderName = trim($matches[1]);
            }

            $holderName = $this->fixBrokenName($holderName);

            if (preg_match('/bank\s*(a\/c\s*no|account\s*number|a\/c\s*number|account\s*no)[^0-9]*([0-9]{10,})/i', $text, $matches)) {
                $accountNumber = $matches[2];
            }

            if (preg_match('/Bank\s*Details\s*\t*([A-Z&. ]{3,40}?)(?=\t|Bank\s*A\/c|Bank\s*A\/c\s*Type|$)/i', $text, $matches)) {
                $bankName = trim($matches[1]);
            } elseif (preg_match('/bank\s*name\s*([A-Z&. ]{3,40}?)(?=\s+POA|DDPI|Assigned|$)/i', $text, $matches)) {
                $bankName = trim($matches[1]);
            }

            if (preg_match('/ifsc\s*code[:\s]*([A-Z]{4}[0-9]{1}[0-9A-Z]{6})/i', $text, $matches)) {
                $ifsc = $matches[1];
            }

            if (is_null($dpId) || is_null($clientId) || is_null($pan) || is_null($holderName) || is_null($accountNumber) || is_null($ifsc)) {
                // Save temp file if processing fails and userId provided
                if ($userId) {
                    $path = FileUpDownHelper::uploadTempDematCml($file);
                    if ($path) {
                        TempDematCmlFiles::create([
                            'investor_id' => $userId,
                            'file_path' => $path,
                            'original_name' => $file->getClientOriginalName(),
                            'reason' => 'This PDF is not a valid NSDL or CDSL document.',
                        ]);
                    }
                }

                return [
                    'success' => false,
                    'message' => 'This PDF is not a valid NSDL or CDSL document.'
                ];
            }

            return [
                'success' => true,
                'message' => 'PDF parsed successfully.',
                'data' => [
                    'dp_id' => $dpId,
                    'client_id' => $clientId,
                    'pan_no' => $pan,
                    'account_holder_name' => $holderName,
                    'account_number' => $accountNumber,
                    'ifsc_code' => $ifsc,
                    'bank_name' => $bankName,
                    'dob' => ''
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function fixBrokenName($name)
    {
        $parts = preg_split('/[\s\t]+/', trim($name));
        $fixedParts = [];
        $i = 0;

        while ($i < count($parts)) {
            // If next part exists and both are short (likely broken surname), merge
            if (
                isset($parts[$i + 1]) &&
                strlen($parts[$i]) <= 4 &&
                strlen($parts[$i + 1]) <= 4
            ) {
                $fixedParts[] = $parts[$i] . $parts[$i + 1];
                $i += 2; // Skip next part
            } else {
                $fixedParts[] = $parts[$i];
                $i++;
            }
        }

        return implode(' ', $fixedParts);
    }
}
