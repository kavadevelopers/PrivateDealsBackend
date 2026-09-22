<?php

namespace App\Services\AiAutowork;

use App\Enums\CompanyTypeEnum;
use App\Enums\TempCompanyIntentEnum;
use App\Enums\TempCompanyStatusEnum;
use App\Helpers\CommonHelper;
use App\Models\CompanyModel;
use App\Models\MasterSectorsModel;
use App\Models\TempCompanyModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AiCompanyIngestService
{
    public const ACCEPTED_TOP_KEYS = [
        'external_ref',
        'company',
        'fundamentals',
        'promoters',
        'shareholders',
        'events',
        'financials',
    ];

    public const COMPANY_FIELDS = [
        'cin',
        'brand_name',
        'company_name',
        'about',
        'logo_url',
        'keywords',
        'negative_keywords',
        'alternative_names',
        'type',
        'is_drhp',
        'sector',
        'min_investment_amount',
        'commission',
        'processing_fee_percentage',
    ];

    public function schema(): array
    {
        return [
            'job' => 'company_ingest',
            'auth' => [
                'header' => 'X-AUTH-TOKEN',
                'secret_name' => 'SHURUUP_API_TOKEN',
                'allowed_domains' => '*',
                'client_type' => 'AI AutoWork (is_ai=1)',
            ],
            'routes' => [
                'GET /api/sandbox/ai/schema',
                'POST /api/sandbox/ai/companies',
                'PATCH /api/sandbox/ai/companies/{uuid}',
                'GET /api/sandbox/ai/companies/{uuid}',
            ],
            'note' => 'Use secret SHURUUP_API_TOKEN. Read full About, logo image URL, Leadership/Management as promoters, DRHP Filed badge as is_drhp, ALL Shareholders year tabs, ALL Financials tabs, and latest 5 events only (with file links).',
            'ingest_required' => 'cin OR (brand_name AND company_name)',
            'not_accepted' => ['news', 'share_prices', 'peer_ratios', 'deals', 'enquiries'],
            'events_limit' => 5,
            'sections' => [
                'external_ref' => ['type' => 'string', 'optional' => true],
                'company' => [
                    'type' => 'object',
                    'fields' => self::COMPANY_FIELDS,
                    'type_enum' => [CompanyTypeEnum::unlisted->value, CompanyTypeEnum::secondary->value],
                    'is_drhp' => 'boolean — true if page shows badge/tag "DRHP Filed", "DRHP", or similar',
                    'logo_url' => 'absolute https URL of the company logo image (prefer og:image / header logo src)',
                ],
                'fundamentals' => [
                    'type' => 'object',
                    'fields' => [
                        'lot_size',
                        'fifty_two_week_high',
                        'fifty_two_week_low',
                        'depository',
                        'pan_number',
                        'isin_number',
                        'cin_number',
                        'rta',
                        'market_cap',
                        'pe_ratio',
                        'pb_ratio',
                        'debt_to_equity',
                        'roe',
                        'book_value',
                        'face_value',
                        'total_shares',
                    ],
                ],
                'promoters' => [
                    'type' => 'array',
                    'source_label_on_page' => 'Leadership / Management',
                    'item' => ['name', 'designation', 'experience', 'url'],
                    'note' => 'Include EVERY person shown. url = LinkedIn / profile link when present. experience must not be skipped.',
                ],
                'shareholders' => [
                    'type' => 'array|object',
                    'source_label_on_page' => 'Shareholders / Shareholding pattern (often multi-year tabs)',
                    'formats' => [
                        'preferred_year_tabs' => '{ "FY24": [{"name":"...","percentage":55.5}], "FY23": [{"name":"...","percentage":54}] }',
                        'flat' => '[{ "name":"...", "percentages":[{"year":"FY24","percentage":55.5}] }]',
                    ],
                    'note' => 'Open EVERY year/tab under Shareholders and extract name + % for each tab. Do not stop at the default tab.',
                ],
                'events' => [
                    'type' => 'array',
                    'max_items' => 5,
                    'item' => ['title', 'description', 'date', 'file'],
                    'note' => 'If more than 5 events, keep only the latest 5 by date.',
                ],
                'financials' => [
                    'type' => 'array',
                    'item' => ['label', 'values'],
                    'labels' => ['pl_statement', 'balance_sheet', 'cashflow', 'financial_ratios'],
                ],
            ],
            'statuses' => ['pending', 'rejected', 'approved'],
            'upsert' => 'Same normalized CIN while status=pending updates the same ingest row. After status leaves pending, a new POST opens a new row.',
            'example_body' => [
                'external_ref' => 'ai-source-1',
                'company' => [
                    'cin' => 'U12345MH2010PTC000000',
                    'brand_name' => 'Acme',
                    'company_name' => 'Acme Private Limited',
                    'about' => 'Full about text from the page — complete, not truncated...',
                    'type' => 'unlisted',
                    'is_drhp' => true,
                    'sector' => 'Technology',
                    'logo_url' => 'https://example.com/logo.png',
                ],
                'fundamentals' => [
                    'isin_number' => 'INE000000000',
                    'pan_number' => 'ABCDE1234F',
                    'depository' => 'NSDL',
                    'rta' => 'Example RTA',
                    'market_cap' => 0,
                    'pe_ratio' => 0,
                    'pb_ratio' => 0,
                    'lot_size' => 1,
                    'fifty_two_week_high' => 0,
                    'fifty_two_week_low' => 0,
                    'debt_to_equity' => 0,
                    'roe' => 0,
                    'book_value' => 0,
                    'face_value' => 10,
                    'total_shares' => 0,
                ],
                'promoters' => [
                    [
                        'name' => 'Person A',
                        'designation' => 'CEO',
                        'experience' => '15 years...',
                        'url' => 'https://linkedin.com/in/person-a',
                    ],
                    [
                        'name' => 'Person B',
                        'designation' => 'CFO',
                        'experience' => '10 years...',
                        'url' => '',
                    ],
                    [
                        'name' => 'Person C',
                        'designation' => 'Director',
                        'experience' => '8 years...',
                        'url' => 'https://linkedin.com/in/person-c',
                    ],
                ],
                'shareholders' => [
                    'FY24' => [
                        ['name' => 'Promoter Group', 'percentage' => 55.5],
                        ['name' => 'Public', 'percentage' => 44.5],
                    ],
                    'FY23' => [
                        ['name' => 'Promoter Group', 'percentage' => 54.0],
                        ['name' => 'Public', 'percentage' => 46.0],
                    ],
                ],
                'events' => [
                    [
                        'title' => 'Board Meeting',
                        'description' => 'Outcome summary...',
                        'date' => '2026-01-01',
                        'file' => 'https://example.com/doc.pdf',
                    ],
                ],
                'financials' => [
                    [
                        'label' => 'pl_statement',
                        'values' => [
                            'FY23' => [
                                'interest_earned' => 4828,
                                'interest_expended' => 2233,
                                'other_income' => 323,
                                'operating_expenses' => 1758,
                                'provisions_and_contingencies' => 288,
                                'pbt' => 872,
                                'tax' => 226,
                                'pat' => 646,
                                'eps' => 33.35,
                            ],
                            'FY24' => [
                                'interest_earned' => 5973,
                                'interest_expended' => 2811,
                                'other_income' => 581,
                                'operating_expenses' => 2126,
                                'provisions_and_contingencies' => 201,
                                'pbt' => 1416,
                                'tax' => 368,
                                'pat' => 1048,
                                'eps' => 54.1,
                            ],
                        ],
                    ],
                    [
                        'label' => 'balance_sheet',
                        'values' => [
                            'FY23' => ['total_assets' => 1000, 'total_liabilities' => 600],
                            'FY24' => ['total_assets' => 1200, 'total_liabilities' => 650],
                        ],
                    ],
                    [
                        'label' => 'cashflow',
                        'values' => [
                            'FY23' => ['operating' => 50, 'investing' => -20, 'financing' => 10],
                            'FY24' => ['operating' => 70, 'investing' => -25, 'financing' => 5],
                        ],
                    ],
                    [
                        'label' => 'financial_ratios',
                        'values' => [
                            'FY23' => ['roe' => 12, 'roa' => 2.1],
                            'FY24' => ['roe' => 14, 'roa' => 2.4],
                        ],
                    ],
                ],
            ],
            'financials_values_formats' => [
                'year_keyed_object' => '{ "FY23": { "metric": 123 }, "FY24": { "metric": 456 } }',
                'table_matrix' => '[["Particulars","FY23","FY24"],["Revenue",100,120]]',
                'note' => 'Both formats are accepted. Prefer year_keyed_object when scraping tabbed financial pages.',
            ],
        ];
    }

    /**
     * @return array{temp: TempCompanyModel, accepted_keys: list<string>, ignored_keys: list<string>}
     */
    public function ingest(array $payload, ?int $apiClientId, ?TempCompanyModel $existing = null): array
    {
        [$accepted, $ignored] = $this->splitKeys($payload);

        $companyData = is_array($payload['company'] ?? null) ? $payload['company'] : [];
        $cin = TempCompanyModel::normalizeCin($companyData['cin'] ?? ($existing?->cin));

        $brandName = $companyData['brand_name'] ?? $existing?->brand_name;
        $companyName = $companyData['company_name'] ?? $existing?->company_name;

        if (!$cin && !(filled($brandName) && filled($companyName))) {
            throw new \InvalidArgumentException('Provide cin or both brand_name and company_name.');
        }

        $matched = null;
        if ($cin) {
            $matched = CompanyModel::where('is_deleted', 0)
                ->whereRaw('UPPER(REPLACE(cin, " ", "")) = ?', [$cin])
                ->first();
        }

        if ($existing) {
            $temp = $existing;
            if ($temp->status !== TempCompanyStatusEnum::pending) {
                throw new \InvalidArgumentException('Only pending records can be updated via ingest.');
            }
        } else {
            $temp = null;
            if ($cin) {
                $temp = TempCompanyModel::where('status', TempCompanyStatusEnum::pending)
                    ->where('cin', $cin)
                    ->first();
            }
            if (!$temp) {
                $temp = new TempCompanyModel();
            }
        }

        $temp->api_client_id = $apiClientId ?? $temp->api_client_id;
        if (array_key_exists('external_ref', $payload)) {
            $temp->external_ref = $payload['external_ref'];
        }

        $temp->status = TempCompanyStatusEnum::pending;
        $temp->cin = $cin ?? $temp->cin;
        $temp->matched_company_id = $matched?->id;
        $temp->intent = $matched
            ? TempCompanyIntentEnum::update
            : TempCompanyIntentEnum::create;

        if (!empty($companyData)) {
            $this->applyCompanyFields($temp, $companyData);
        }

        foreach (['fundamentals', 'financials'] as $section) {
            if (array_key_exists($section, $payload)) {
                $temp->{$section} = $payload[$section];
            }
        }

        if (array_key_exists('promoters', $payload)) {
            $temp->promoters = $this->normalizePromoters($payload['promoters']);
        }

        if (array_key_exists('shareholders', $payload)) {
            $temp->shareholders = $this->normalizeShareholders($payload['shareholders']);
        }

        if (array_key_exists('events', $payload)) {
            $temp->events = $this->limitLatestEvents($payload['events']);
        }

        $previousRaw = is_array($temp->raw_payload) ? $temp->raw_payload : [];
        $temp->raw_payload = array_merge($previousRaw, ['_last' => $payload, 'at' => now()->toIso8601String()]);

        $temp->save();

        return [
            'temp' => $temp->fresh(),
            'accepted_keys' => $accepted,
            'ignored_keys' => $ignored,
        ];
    }

    /**
     * Normalize Leadership/Management people into promoters shape.
     * Maps common aliases (linkedin_url, role, bio, etc.) so partial AI payloads still land correctly.
     *
     * @param  mixed  $promoters
     * @return list<array{name: ?string, designation: ?string, experience: ?string, url: ?string}>|null
     */
    protected function normalizePromoters(mixed $promoters): ?array
    {
        if (!is_array($promoters)) {
            return null;
        }

        $rows = [];
        foreach ($promoters as $row) {
            if (!is_array($row)) {
                continue;
            }

            $name = $row['name'] ?? $row['full_name'] ?? $row['person_name'] ?? null;
            $designation = $row['designation'] ?? $row['role'] ?? $row['title'] ?? $row['position'] ?? null;
            $experience = $row['experience'] ?? $row['bio'] ?? $row['about'] ?? $row['description'] ?? $row['years_of_experience'] ?? null;
            $url = $row['url']
                ?? $row['linkedin']
                ?? $row['linkedin_url']
                ?? $row['linkedin_link']
                ?? $row['profile_url']
                ?? $row['profile']
                ?? null;

            if ($experience !== null && !is_string($experience)) {
                $experience = is_numeric($experience) ? (string) $experience . ' years' : (string) $experience;
            }

            if ($url !== null && is_string($url)) {
                $url = trim($url);
                if ($url === '' || strcasecmp($url, 'null') === 0 || $url === '#') {
                    $url = null;
                }
            }

            if (empty($name) && empty($designation) && empty($experience) && empty($url)) {
                continue;
            }

            $rows[] = [
                'name' => is_string($name) ? trim($name) : $name,
                'designation' => is_string($designation) ? trim($designation) : $designation,
                'experience' => is_string($experience) ? trim($experience) : $experience,
                'url' => is_string($url) ? $url : $url,
            ];
        }

        return $rows === [] ? null : $rows;
    }

    /**
     * Keep only the latest 5 events by date when more are provided.
     *
     * @param  mixed  $events
     * @return list<array<string, mixed>>|null
     */
    protected function limitLatestEvents(mixed $events): ?array
    {
        if (!is_array($events)) {
            return null;
        }

        $normalized = [];
        foreach ($events as $event) {
            if (!is_array($event)) {
                continue;
            }
            if (empty($event['title']) && empty($event['description']) && empty($event['date']) && empty($event['file'])) {
                continue;
            }
            $normalized[] = $event;
        }

        usort($normalized, function ($a, $b) {
            $da = strtotime((string) ($a['date'] ?? '')) ?: 0;
            $db = strtotime((string) ($b['date'] ?? '')) ?: 0;

            return $db <=> $da;
        });

        return array_slice($normalized, 0, 5);
    }

    /**
     * @return array{0: list<string>, 1: list<string>}
     */
    public function splitKeys(array $payload): array
    {
        $accepted = [];
        $ignored = [];
        foreach (array_keys($payload) as $key) {
            if (in_array($key, self::ACCEPTED_TOP_KEYS, true)) {
                $accepted[] = $key;
            } else {
                $ignored[] = $key;
            }
        }

        return [$accepted, $ignored];
    }

    protected function applyCompanyFields(TempCompanyModel $temp, array $companyData): void
    {
        $map = [
            'brand_name' => 'brand_name',
            'company_name' => 'company_name',
            'about' => 'about',
            'keywords' => 'keywords',
            'negative_keywords' => 'negative_keywords',
            'alternative_names' => 'alternative_names',
            'type' => 'type',
            'min_investment_amount' => 'min_investment_amount',
            'commission' => 'commission',
            'processing_fee_percentage' => 'processing_fee_percentage',
        ];

        foreach ($map as $from => $to) {
            if (array_key_exists($from, $companyData)) {
                $value = $companyData[$from];
                if (in_array($from, ['keywords', 'negative_keywords', 'alternative_names'], true) && is_string($value)) {
                    $value = collect(explode(',', strtolower($value)))
                        ->map(fn ($k) => trim($k))
                        ->filter()
                        ->implode(',');
                }
                $temp->{$to} = $value;
            }
        }

        if (array_key_exists('is_drhp', $companyData)
            || array_key_exists('drhp', $companyData)
            || array_key_exists('drhp_filed', $companyData)
            || array_key_exists('is_drhp_filed', $companyData)
            || array_key_exists('tags', $companyData)
            || array_key_exists('badges', $companyData)
        ) {
            $temp->is_drhp = $this->resolveIsDrhp($companyData);
        }

        if (array_key_exists('cin', $companyData)) {
            $temp->cin = TempCompanyModel::normalizeCin($companyData['cin']);
        }

        if (array_key_exists('sector', $companyData)) {
            $sectorName = is_string($companyData['sector']) ? trim($companyData['sector']) : null;
            $temp->sector_name = $sectorName;
            if ($sectorName) {
                $sector = MasterSectorsModel::where('is_deleted', 0)
                    ->whereRaw('LOWER(name) = ?', [strtolower($sectorName)])
                    ->first();
                $temp->sector_id = $sector?->id;
            }
        }

        $logoUrl = $companyData['logo_url']
            ?? $companyData['logo']
            ?? $companyData['image']
            ?? $companyData['image_url']
            ?? null;
        if (is_string($logoUrl) && filled(trim($logoUrl))) {
            $logoUrl = trim($logoUrl);
            // skip obvious non-URL path-only values unless absolute
            if (preg_match('#^https?://#i', $logoUrl) || str_starts_with($logoUrl, '//')) {
                if (str_starts_with($logoUrl, '//')) {
                    $logoUrl = 'https:' . $logoUrl;
                }
                $temp->logo_url = $logoUrl;
                $downloaded = $this->downloadLogo($logoUrl);
                if ($downloaded) {
                    $temp->logo = $downloaded;
                }
            }
        }
    }

    /**
     * @param  array<string, mixed>  $companyData
     */
    protected function resolveIsDrhp(array $companyData): bool
    {
        foreach (['is_drhp', 'drhp', 'drhp_filed', 'is_drhp_filed'] as $key) {
            if (!array_key_exists($key, $companyData)) {
                continue;
            }
            if ($this->truthyDrhp($companyData[$key])) {
                return true;
            }
        }

        foreach (['tags', 'badges', 'labels', 'status_tags'] as $listKey) {
            $list = $companyData[$listKey] ?? null;
            if (is_string($list)) {
                $list = preg_split('/[,|]/', $list) ?: [];
            }
            if (!is_array($list)) {
                continue;
            }
            foreach ($list as $tag) {
                if ($this->truthyDrhp($tag)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function truthyDrhp(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_int($value) || is_float($value)) {
            return (int) $value === 1;
        }
        if (!is_string($value)) {
            return false;
        }
        $normalized = strtolower(trim($value));
        if (in_array($normalized, ['1', 'true', 'yes', 'y', 'drhp', 'drhp filed', 'drhp_filed', 'filed'], true)) {
            return true;
        }

        return str_contains($normalized, 'drhp');
    }

    /**
     * Accept flat shareholders or year-tab objects from multi-tab scrape pages.
     *
     * @return list<array{name: string, percentages: list<array{year: mixed, percentage: mixed}>}>|null
     */
    public function normalizeShareholders(mixed $shareholders): ?array
    {
        if (!is_array($shareholders) || $shareholders === []) {
            return null;
        }

        $byName = [];

        $add = function (string $name, mixed $year, mixed $percentage) use (&$byName): void {
            $name = trim($name);
            if ($name === '') {
                return;
            }
            if (!isset($byName[$name])) {
                $byName[$name] = ['name' => $name, 'percentages' => []];
            }
            if ($year === null || $year === '' || $percentage === null || $percentage === '') {
                return;
            }
            $byName[$name]['percentages'][] = [
                'year' => is_string($year) ? trim($year) : $year,
                'percentage' => $percentage,
            ];
        };

        // Year-keyed tabs: { "FY24": [{name, percentage}], "FY23": [...] }
        $looksYearKeyed = !array_is_list($shareholders);
        if ($looksYearKeyed) {
            foreach ($shareholders as $year => $holders) {
                if (!is_array($holders)) {
                    continue;
                }
                foreach ($holders as $holder) {
                    if (!is_array($holder)) {
                        continue;
                    }
                    $name = (string) ($holder['name'] ?? $holder['shareholder'] ?? $holder['holder'] ?? '');
                    $pct = $holder['percentage'] ?? $holder['percent'] ?? $holder['share'] ?? null;
                    $add($name, $year, $pct);
                }
            }
        } else {
            foreach ($shareholders as $row) {
                if (!is_array($row)) {
                    continue;
                }

                // { year: "FY24", holders: [...] } or { year, shareholders: [...] }
                if (isset($row['year']) && (isset($row['holders']) || isset($row['shareholders']) || isset($row['items']))) {
                    $year = $row['year'];
                    $holders = $row['holders'] ?? $row['shareholders'] ?? $row['items'] ?? [];
                    if (!is_array($holders)) {
                        continue;
                    }
                    foreach ($holders as $holder) {
                        if (!is_array($holder)) {
                            continue;
                        }
                        $name = (string) ($holder['name'] ?? '');
                        $pct = $holder['percentage'] ?? $holder['percent'] ?? null;
                        $add($name, $year, $pct);
                    }
                    continue;
                }

                $name = (string) ($row['name'] ?? '');
                if ($name === '') {
                    continue;
                }
                if (!empty($row['percentages']) && is_array($row['percentages'])) {
                    foreach ($row['percentages'] as $pct) {
                        if (!is_array($pct)) {
                            continue;
                        }
                        $add(
                            $name,
                            $pct['year'] ?? null,
                            $pct['percentage'] ?? $pct['percent'] ?? null
                        );
                    }
                } elseif (isset($row['percentage']) || isset($row['percent'])) {
                    $add($name, $row['year'] ?? null, $row['percentage'] ?? $row['percent'] ?? null);
                } else {
                    $add($name, null, null);
                }
            }
        }

        $rows = array_values($byName);

        return $rows === [] ? null : $rows;
    }

    /**
     * Public wrapper so admin save can re-download a logo from URL.
     */
    public function downloadLogoPublic(string $url): ?string
    {
        $url = trim($url);
        if ($url === '') {
            return null;
        }
        if (str_starts_with($url, '//')) {
            $url = 'https:' . $url;
        }
        if (!preg_match('#^https?://#i', $url)) {
            return null;
        }

        return $this->downloadLogo($url);
    }

    protected function downloadLogo(string $url): ?string
    {
        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; ShuruUpBot/1.0)',
                    'Accept' => 'image/avif,image/webp,image/apng,image/*,*/*;q=0.8',
                ])
                ->withOptions(['allow_redirects' => true])
                ->get($url);

            if (!$response->successful()) {
                return null;
            }

            $body = $response->body();
            if ($body === '' || strlen($body) < 32) {
                return null;
            }

            $ext = pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: '';
            $ext = strtolower(preg_replace('/[^a-z0-9]/i', '', $ext) ?: '');
            if ($ext === '' || strlen($ext) > 5) {
                $contentType = strtolower((string) $response->header('Content-Type'));
                $ext = match (true) {
                    str_contains($contentType, 'jpeg'), str_contains($contentType, 'jpg') => 'jpg',
                    str_contains($contentType, 'webp') => 'webp',
                    str_contains($contentType, 'gif') => 'gif',
                    str_contains($contentType, 'svg') => 'svg',
                    default => 'png',
                };
            }

            $path = 'company/logo/temp/' . CommonHelper::generateFileName() . '.' . $ext;
            Storage::disk('public')->put($path, $body);

            return $path;
        } catch (\Throwable) {
            return null;
        }
    }
}
