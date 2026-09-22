<!DOCTYPE html>
<html>

<head>
    {{--
    <meta charset="utf-8"> --}}
    <title>Daily Share Report</title>
    @include('pdf.master.style')
    <style>
        /* new css */
        body {
            background: #100d04;
            color: #fff;
        }

        .main-title-cell {
            width: 50%;
            text-align: right
        }

        table {
            width: 100%;
        }

        table td {
            padding: 5px;
            color: #CCCCCC;
        }

        .logo-cell {
            width: 60%;
        }

        .logo-img {
            width: 50%;
            max-width: 100px;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
        }

        .gain-loose-table {
            width: 100%;
            margin-top: 10px;
        }



        .gain-loose-table td {
            padding: 0;
            vertical-align: middle;
        }

        .gain-loose-table .title-cell .title {
            padding-top: 2px;
            margin-left: 10px;
        }

        /* .card-body-left {
            padding-right: 10px !important;
        }

        .card-body-right {
            padding-left: 10px !important;
        } */

        .share-card {
            padding: 0px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .share-card p {
            margin: 0;
        }

        .share-card .left {
            width: 13%;
            padding: 2px;
        }

        .share-card .left img {
            width: 72%;
            max-width: 120px;
        }

        .share-card .center {
            padding: 4px;
            width: 60%;
        }

        .share-card .center .title {
            padding-top: 2px;
            margin-bottom: 2px;
            font-size: 34px;
            font-weight: 600;
        }

        .share-card .right {
            padding: 4px;
            width: 27%;
            text-align: right;
        }

        .share-card .right .percentage {
            font-size: 34px;
            font-weight: 600;
            margin: 0;
            padding-bottom: 12px;
        }

        .share-card .right .amount {
            font-size: 34px;
            font-weight: 600;
            margin: 0;
        }

        .share-card .current-price {
            margin: 0;
            font-weight: 600;
            font-size: 20px;
            margin-top: 5px;
            color: #E0E0E0;
        }

        .title-cell table td {
            /* border: 1px solid #fff; */
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('core/images/white-logo.svg') }}" alt="Logo" class="logo-img">
            </td>
            <td class="main-title-cell" style="width: 50%; text-align: right;">
                <div style="font-size: 18px; font-weight: 700; color: #ffffff;">PrivateDeals Market Pulse</div>
                <div style="font-size: 13px; color: #bbbbbb; margin-top: 4px;">
                    Tracking the day’s biggest market movers with precision.
                </div>
            </td>

        </tr>
    </table>

    {{-- <table class="gain-loose-table">
        <tr>
            <td class="title-cell">
                <table style="vertical-align: middle;">
                    <tr>
                        <td style="width: 8%; text-align: right;">
                            <img style="width: 20px;" src="{{ public_path('core/images/icons/gainer.png') }}">
                        </td>
                        <td>
                            <h5 class="title color-green">Top Gainers</h5>
                        </td>
                    </tr>
                </table>
            </td>
            <td></td>
            <td class="title-cell">
                <table style="vertical-align: middle;">
                    <tr>
                        <td style="width: 8%; text-align: right;">
                            <img style="width: 20px;" src="{{ public_path('core/images/icons/loser.png') }}">
                        </td>
                        <td>
                            <h5 class="title color-red">Top Losers</h5>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 48%;" class="card-body-left">
                @forelse(array_slice($fluctuationData['up'], 0, 5) as $item)
                <table class="share-card">
                    <tr>
                        <td class="left">
                            @if(!empty($item['company_logo']))
                            <img src="{{ $item['company_logo'] }}">
                            @endif
                        </td>
                        <td class="center">
                            <p class="title">{{ $item['company_name'] }}</p>
                            <p class="current-price">₹{{ number_format($item['current_price'], 2) }}</p>
                        </td>
                        <td class="right">
                            <p class="percentage color-green">+{{ number_format($item['fluctuation_percentage'], 2) }}%
                            </p>
                            <p class="amount white-90">+₹{{ number_format($item['price_difference'], 2) }}</p>
                        </td>
                    </tr>
                </table>
                @empty
                <p style="color: #ccc; font-size: 12px;">No gainers available</p>
                @endforelse
            </td>

            <td style="width:4%;"></td>

            <td style="width: 48%;" class="card-body-right">
                @forelse(array_slice($fluctuationData['down'], 0, 5) as $item)
                <table class="share-card">
                    <tr>
                        <td class="left">
                            @if(!empty($item['company_logo']))
                            <img src="{{ $item['company_logo'] }}">
                            @endif
                        </td>
                        <td class="center">
                            <p class="title">{{ $item['company_name'] }}</p>
                            <p class="current-price">₹{{ number_format($item['current_price'], 2) }}</p>
                        </td>
                        <td class="right">
                            <p class="percentage color-red">-{{ number_format(abs($item['fluctuation_percentage']), 2)
                                }}%</p>
                            <p class="amount white-90">-₹{{ number_format(abs($item['price_difference']), 2) }}</p>
                        </td>
                    </tr>
                </table>
                @empty
                <p style="color: #ccc; font-size: 12px;">No losers available</p>
                @endforelse
            </td>
        </tr>
    </table> --}}
    <table class="gain-loose-table">
        <tr>
            <td class="title-cell" colspan="3" style="padding-bottom: 8px;">
                <table style="vertical-align: middle;">
                    <tr>
                        <td style="width: 5%; text-align: right;">
                            <img style="width: 24px;" src="{{ public_path('core/images/icons/gainer.png') }}">
                        </td>
                        <td>
                            <h4 class="title color-green" style="font-size: 22px; margin-left: 10px;">Top Gainers</h4>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                @forelse(array_slice($fluctuationData['up'], 0, 5) as $item)
                <table class="share-card">
                    <tr>
                        <td class="left">
                            @if(!empty($item['company_logo']))
                            <img src="{{ $item['company_logo'] }}">
                            @endif
                        </td>
                        <td class="center">
                            <p class="title" style="font-size: 22px;">{{ $item['company_name'] }}</p>
                            <p class="current-price" style="font-size: 18px;">₹{{ number_format($item['current_price'],
                                2) }}</p>
                        </td>
                        <td class="right">
                            <p class="percentage color-green" style="font-size: 18px;">+{{
                                number_format($item['fluctuation_percentage'], 2) }}%</p>
                            <p class="amount white-90" style="font-size: 17px;">+₹{{
                                number_format($item['price_difference'], 2) }}</p>
                        </td>
                    </tr>
                </table>
                @empty
                <p style="color: #ccc; font-size: 13px;">No gainers available</p>
                @endforelse
            </td>
        </tr>

        <!-- TOP LOSERS -->
        <tr>
            <td class="title-cell" colspan="3" style="padding-top: 20px; padding-bottom: 8px;">
                <table style="vertical-align: middle;">
                    <tr>
                        <td style="width: 5%; text-align: right;">
                            <img style="width: 24px;" src="{{ public_path('core/images/icons/loser.png') }}">
                        </td>
                        <td>
                            <h4 class="title color-red" style="font-size: 22px; margin-left: 10px;">Top Losers</h4>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                @forelse(array_slice($fluctuationData['down'], 0, 5) as $item)
                <table class="share-card">
                    <tr>
                        <td class="left">
                            @if(!empty($item['company_logo']))
                            <img src="{{ $item['company_logo'] }}">
                            @endif
                        </td>
                        <td class="center">
                            <p class="title" style="font-size: 22px;">{{ $item['company_name'] }}</p>
                            <p class="current-price" style="font-size: 18px;">₹{{ number_format($item['current_price'],
                                2) }}</p>
                        </td>
                        <td class="right">
                            <p class="percentage color-red" style="font-size: 18px;">-{{
                                number_format(abs($item['fluctuation_percentage']), 2) }}%</p>
                            <p class="amount white-90" style="font-size: 17px;">-₹{{
                                number_format(abs($item['price_difference']), 2) }}</p>
                        </td>
                    </tr>
                </table>
                @empty
                <p style="color: #ccc; font-size: 13px;">No losers available</p>
                @endforelse
            </td>
        </tr>
    </table>


    @if($newsItems->isNotEmpty())
    <div style="margin-top: 40px;">
        <table style="vertical-align: left;">
            <tr>
                <td style="width: 5%;">
                    <img style="width: 22px;" src="{{ public_path('core/images/icons/news.png') }}">
                </td>
                <td>
                    <h5 class="title">Company News</h5>
                </td>
            </tr>
        </table>
        <div style="padding: 20px; background: #1a1a1a; border-radius: 8px;">
            @foreach ($newsItems as $companyId => $companyNewsList)
            @php
            $company = collect($fluctuationData['up'])
            ->merge($fluctuationData['down'])
            ->firstWhere('company_id', $companyId);
            @endphp

            @foreach ($companyNewsList as $news)
            <div style="margin-bottom: 15px;">
                <div style="font-size: 14px; font-weight: 600; margin-bottom: 5px;">
                    <span style="color: #e67e22;">{{ $company['company_name'] ?? 'Unknown' }}:</span> {{ $news->title }}
                </div>
                <div style="font-size: 12px; color: #cccccc; line-height: 1.4;">
                    {{ $news->description }}
                </div>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
    @endif




    <!-- Footer -->
    <div class="footer" style="margin-top: 40px; text-align: center; font-size: 12px; color: #999; padding-top: 10px;">
        Report generated on <strong>{{ now()->format('d M Y \a\t H:i:s') }}</strong><br>
        Powered by <span style="color: #f39c12; font-weight: 600;">PrivateDeals</span> Investment Intelligence Platform
    </div>

</body>

</html>