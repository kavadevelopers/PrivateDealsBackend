<!DOCTYPE html>
<html style="background-color: #000000;">

<head>
    <meta charset="UTF-8">
    <title>Companies Report</title>
    <style>
        @page {
            margin: 0;
            background-color: #000000;
        }

        html {
            background-color: #000000 !important;
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #000000 !important;
            color: #ffffff;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .page-wrapper {
            background-color: #000000;
            min-height: 100vh;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .content-wrapper {
            background-color: #000000;
            padding: 20px;
            min-height: calc(100vh - 40px);
        }

        .header-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
            background-color: #000000;
        }

        .header-table td {
            padding: 10px;
            vertical-align: middle;
            background-color: #000000;
        }

        .logo-cell {
            width: 40%;
            text-align: left;
        }

        .logo-img {
            width: 100px;
            height: auto;
        }

        .title-cell {
            width: 60%;
            text-align: right;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
        }

        .date-info {
            font-size: 12px;
            color: #CCCCCC;
            margin-top: 5px;
        }

        /* Price heading section - Using table for better spacing */
        .price-header {
            width: 100%;
            margin-bottom: 30px;
            text-align: right;
            background-color: #000000;
        }

        .price-header-table {
            width: 300px;
            float: right;
            border-collapse: collapse;
            background-color: #000000;
        }

        .price-header-table td {
            padding: 0 0 15px 0;
            background-color: #000000;
            border: none;
        }

        .price-header-label {
            font-size: 16px;
            color: #ffffff;
            font-weight: bold;
            text-align: right;
            width: 120px;
            padding: 0 15px;
        }

        /* Category heading with price headers on same row */
        .category-heading-row {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
            background-color: #000000;
        }

        .category-heading-row td {
            padding: 10px 0;
            background-color: #000000;
            border-bottom: 2px solid #333333;
            vertical-align: middle;
        }

        .category-title {
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            text-align: left;
        }

        .category-price-headers {
            text-align: right;
            width: 300px;
        }

        .category-price-table {
            width: 100%;
            border-collapse: collapse;
            background-color: transparent;
        }

        .category-price-table td {
            padding: 0;
            background-color: transparent;
            border: none;
            text-align: right;
            width: 120px;
            padding: 0 15px;
        }

        .category-price-label {
            font-size: 14px;
            color: #ffffff;
            font-weight: bold;
        }

        .companies-container {
            margin-top: 20px;
            background-color: #000000;
        }

        .company-row {
            background-color: #1a1a1a;
            border: 1px solid #333333;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 3px 5px;
            position: relative;
            min-height: 60px;
        }

        .sr-number {
            position: absolute;
            top: 6px;
            left: 12px;
            background-color: #333333;
            color: #cccccc;
            font-size: 8px;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: 500;
        }

        .company-content {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            background-color: transparent;
        }

        .company-content td {
            padding: 0;
            vertical-align: middle;
            border: none;
            background-color: transparent;
        }

        .logo-section {
            width: 50px;
            text-align: left;
            padding-right: 12px;
        }

        .company-logo {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            background-color: #333333;
            border: 1px solid #444444;
        }

        .logo-fallback {
            width: 100px;
            height: 40px;
            background-color: #333333;
            border-radius: 6px;
            text-align: center;
            line-height: 40px;
            font-size: 12px;
            font-weight: bold;
            color: #cccccc;
            border: 1px solid #444444;
        }

        .company-info {
            width: 60%;
            padding-left: 10px;
            padding-right: 10px;
        }

        .company-name {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 3px 0;
            line-height: 1.2;
        }

        .company-category {
            font-size: 11px;
            color: #888888;
            margin: 0;
            text-transform: capitalize;
        }

        .price-section {
            width: 300px;
            text-align: right;
            padding-left: 10px;
        }

        .price-values-table {
            width: 100%;
            border-collapse: collapse;
            background-color: transparent;
        }

        .price-values-table td {
            padding: 0;
            background-color: transparent;
            border: none;
            text-align: right;
        }

        .price-value {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            text-align: right;
            width: 120px;
            padding: 0 15px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #666666;
            border-top: 1px solid #333333;
            padding-top: 10px;
            margin-top: 30px;
            background-color: #000000;
        }

        .rupee-symbol {
            font-family: 'DejaVu Sans', sans-serif;
            font-weight: normal;
        }

        /* Force black background on all elements */
        * {
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content-wrapper">
            <!-- Header -->
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @php
                        $logoPath = public_path('core/images/white-logo.svg');
                        $logoBase64 = '';
                        if (file_exists($logoPath)) {
                        $logoData = file_get_contents($logoPath);
                        $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode($logoData);
                        }
                        @endphp
                        @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo" class="logo-img">
                        @endif
                    </td>
                    <td class="title-cell">
                        Tentative Price List
                        <div class="date-info">
                            {{ \Carbon\Carbon::now()->format('l, d F Y') }}
                        </div>
                    </td>
                </tr>
            </table>

            @if($category !== 'exclusive_liquid')
            <!-- Price Header (Only for single category) -->
            <div class="price-header">
                <table class="price-header-table" style="width: 100%;">
                    <tr>
                        <td class="price-header-label" style="width: 100%; text-align: right; padding-right: 15px;">
                            Landing Price</td>
                    </tr>
                </table>
            </div>
            @endif

            <!-- Companies Rows -->
            <div class="companies-container">
                @if($category === 'exclusive_liquid')
                @php
                $exclusiveCompanies = $companies->where('category', 'Exclusive Deals');
                $liquidCompanies = $companies->where('category', 'Liquid Stocks');
                @endphp

                {{-- Exclusive Deals Section --}}
                @if($exclusiveCompanies->count() > 0)
                <!-- Category heading with price headers on same row -->
                <table class="category-heading-row">
                    <tr>
                        <td>
                            <h3 class="category-title">Exclusive Deals</h3>
                        </td>
                        <td class="category-price-headers">
                            <table class="category-price-table" style="width: 100%;">
                                <tr>
                                    <td class="category-price-label"
                                        style="width: 100%; text-align: right; padding-right: 15px;">Landing Price</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                @foreach ($exclusiveCompanies as $index => $company)
                <div class="company-row">
                    <table class="company-content">
                        <tr>
                            <td class="logo-section">
                                @if($company->logo)
                                @php
                                $logoUrl = \App\Helpers\FileUpDownHelper::get_company_logo_url($company);
                                $logoBase64 = '';

                                // Convert to base64 for DomPDF
                                if ($logoUrl) {
                                try {
                                $logoData = file_get_contents($logoUrl);
                                if ($logoData !== false) {
                                $extension = pathinfo(parse_url($logoUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                                $mimeType = 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension);
                                $logoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($logoData);
                                }
                                } catch (Exception $e) {
                                $logoBase64 = '';
                                }
                                }
                                @endphp
                                @if($logoBase64)
                                <img src="{{ $logoBase64 }}" alt="{{ $company->brand_name }}" class="company-logo">
                                @else
                                <div class="logo-fallback">
                                    {{ strtoupper(substr($company->brand_name, 0, 2)) }}
                                </div>
                                @endif
                                @else
                                <div class="logo-fallback">
                                    {{ strtoupper(substr($company->brand_name, 0, 2)) }}
                                </div>
                                @endif
                            </td>
                            <td class="company-info">
                                <div class="company-name">{{ $company->brand_name }}</div>
                            </td>
                            <td class="price-section">
                                <table class="price-values-table" style="width: 100%;">
                                    <tr>
                                        <td class="price-value"
                                            style="width: 100%; text-align: right; padding-right: 15px;">
                                            <span class="rupee-symbol">₹</span>{{
                                            number_format((float)$company->latest_price, 2) }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                @endforeach
                @endif

                {{-- Liquid Stocks Section --}}
                @if($liquidCompanies->count() > 0)
                <!-- Category heading with price headers on same row -->
                <table class="category-heading-row" style="margin-top: 30px;">
                    <tr>
                        <td>
                            <h3 class="category-title">Liquid Stocks</h3>
                        </td>
                        <td class="category-price-headers">
                            <table class="category-price-table" style="width: 100%;">
                                <tr>
                                    <td class="category-price-label"
                                        style="width: 100%; text-align: right; padding-right: 15px;">Landing Price</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                @foreach ($liquidCompanies as $index => $company)
                <div class="company-row">
                    <table class="company-content">
                        <tr>
                            <td class="logo-section">
                                @if($company->logo)
                                @php
                                $logoUrl = \App\Helpers\FileUpDownHelper::get_company_logo_url($company);
                                $logoBase64 = '';

                                // Convert to base64 for DomPDF
                                if ($logoUrl) {
                                try {
                                $logoData = file_get_contents($logoUrl);
                                if ($logoData !== false) {
                                $extension = pathinfo(parse_url($logoUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                                $mimeType = 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension);
                                $logoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($logoData);
                                }
                                } catch (Exception $e) {
                                $logoBase64 = '';
                                }
                                }
                                @endphp
                                @if($logoBase64)
                                <img src="{{ $logoBase64 }}" alt="{{ $company->brand_name }}" class="company-logo">
                                @else
                                <div class="logo-fallback">
                                    {{ strtoupper(substr($company->brand_name, 0, 2)) }}
                                </div>
                                @endif
                                @else
                                <div class="logo-fallback">
                                    {{ strtoupper(substr($company->brand_name, 0, 2)) }}
                                </div>
                                @endif
                            </td>
                            <td class="company-info">
                                <div class="company-name">{{ $company->brand_name }}</div>
                            </td>
                            <td class="price-section">
                                <table class="price-values-table" style="width: 100%;">
                                    <tr>
                                        <td class="price-value"
                                            style="width: 100%; text-align: right; padding-right: 15px;">
                                            <span class="rupee-symbol">₹</span>{{
                                            number_format((float)$company->latest_base_price, 2) }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                @endforeach
                @endif
                @else
                {{-- Regular single category display --}}
                @foreach ($companies as $index => $company)
                <div class="company-row">
                    <table class="company-content">
                        <tr>
                            <td class="logo-section">
                                @if($company->logo)
                                @php
                                $logoUrl = \App\Helpers\FileUpDownHelper::get_company_logo_url($company);
                                $logoBase64 = '';

                                // Convert to base64 for DomPDF
                                if ($logoUrl) {
                                try {
                                $logoData = file_get_contents($logoUrl);
                                if ($logoData !== false) {
                                $extension = pathinfo(parse_url($logoUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                                $mimeType = 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension);
                                $logoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($logoData);
                                }
                                } catch (Exception $e) {
                                $logoBase64 = '';
                                }
                                }
                                @endphp
                                @if($logoBase64)
                                <img src="{{ $logoBase64 }}" alt="{{ $company->brand_name }}" class="company-logo">
                                @else
                                <div class="logo-fallback">
                                    {{ strtoupper(substr($company->brand_name, 0, 2)) }}
                                </div>
                                @endif
                                @else
                                <div class="logo-fallback">
                                    {{ strtoupper(substr($company->brand_name, 0, 2)) }}
                                </div>
                                @endif
                            </td>
                            <td class="company-info">
                                <div class="company-name">{{ $company->brand_name }}</div>
                            </td>
                            <td class="price-section">
                                @php
                                // For Exclusive Deals category, use latest_price; for others use latest_base_price
                                $displayPrice = ($category === \App\Enums\PreIpoCategoryEnum::exclusive_deals->value)
                                    ? $company->latest_price
                                    : $company->latest_base_price;
                                @endphp
                                <table class="price-values-table" style="width: 100%;">
                                    <tr>
                                        <td class="price-value"
                                            style="width: 100%; text-align: right; padding-right: 15px;">
                                            <span class="rupee-symbol">₹</span>{{
                                            number_format((float)$displayPrice, 2) }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                @endforeach
                @endif
            </div>

            <!-- Footer -->
            {{-- <div class="footer">
                Generated on {{ \Carbon\Carbon::now()->format('d M Y \a\t H:i:s') }} | PrivateDeals Investment Platform
            </div> --}}
        </div>
    </div>
</body>

</html>