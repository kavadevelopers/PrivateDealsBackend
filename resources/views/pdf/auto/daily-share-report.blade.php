<!DOCTYPE html>
<html>

<head>
    <title>Daily Share Report</title>
    <style>
        @page {
            margin: 0;
            background-color: #000000;
        }

        body {
            background-color: #000000;
            color: #ffffff;
            margin: 0;
            padding: 30px;
            font-family: DejaVu Sans, sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .header-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo-cell {
            width: 100px;
            max-width: 100px;
        }
        .logo-img {
            width: 100%;
            max-width: 100px;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
        }

        .company-logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
            border-radius: 4px;
            margin-right: 8px;
            vertical-align: middle;
        }

        .positive {
            color: #27ae60;
        }

        .negative {
            color: #e74c3c;
        }

        .stock-table th,
        .stock-table td {
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #ffffff;
            border-left: 4px solid #3498db;
            padding-left: 10px;
        }

        .company-cell {
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #bdc3c7;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('core/images/red-logo.png') }}" alt="Logo" class="logo-img">
            </td>
            <td class="title-cell">
                SHURU-UP Daily Share Report<br>
                <small>{{ now()->format('l, d F Y') }}</small>
            </td>
        </tr>
    </table>

    <table class="main-table" style="width: 100%; border-collapse: collapse; table-layout: fixed;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding-right: 10px; border-right: 1px solid #7f8c8d;">
                <div class="section-title">📈 Top Gainers</div>
                <table class="stock-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>14d Ago</th>
                            <th>Current</th>
                            <th>+₹</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(array_slice($fluctuationData['up'], 0, 5) as $item)
                            <tr>
                                <td>
                                    @if(!empty($item['company_logo']))
                                        <img src="{{ $item['company_logo'] }}" alt="{{ $item['company_name'] }}" class="company-logo">
                                    @endif
                                    {{ $item['company_name'] }}
                                </td>
                                <td>₹{{ number_format($item['previous_price'], 2) }}</td>
                                <td>₹{{ number_format($item['current_price'], 2) }}</td>
                                <td class="positive">+₹{{ number_format($item['price_difference'], 2) }}</td>
                                <td class="positive">{{ number_format($item['fluctuation_percentage'], 2) }}%</td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No gainers available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </td>

            <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                <div class="section-title">📉 Top Losers</div>
                <table class="stock-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>14d Ago</th>
                            <th>Current</th>
                            <th>-₹</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(array_slice($fluctuationData['down'], 0, 5) as $item)
                            <tr>
                                <td>
                                    @if(!empty($item['company_logo']))
                                        <img src="{{ $item['company_logo'] }}" alt="{{ $item['company_name'] }}" class="company-logo">
                                    @endif
                                    {{ $item['company_name'] }}
                                </td>
                                <td>₹{{ number_format($item['previous_price'], 2) }}</td>
                                <td>₹{{ number_format($item['current_price'], 2) }}</td>
                                <td class="negative">-₹{{ number_format(abs($item['price_difference']), 2) }}</td>
                                <td class="negative">{{ number_format(abs($item['fluctuation_percentage']), 2) }}%</td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No losers available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('d M Y \a\t H:i:s') }} | SHURU-UP Investment Platform
    </div>
</body>

</html>