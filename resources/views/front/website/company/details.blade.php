@extends('front.website.master')
@section('title')
{{ $company->brand_name }}
@endsection
@section('content')
<div class="page-section">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-12 col-lg-10">

                <div class="company-detail-card mb-5" style="background-color: #0A1E37;">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ \App\Helpers\FileUpDownHelper::get_company_logo_url($company) }}"
                                class="img-fluid rounded" style="width: 90px; height: 90px; object-fit: contain;">
                        </div>
                        <div class="col-md-7">
                            <h4 class="company-title">{{ $company->brand_name ?? $company->company_name }}</h4>
                            <div class="company-meta small">
                                <span class="me-3"><strong>Industry:</strong> {{ $company->sector->MasterIndustry->name
                                    ?? 'N/A' }}</span>
                                <span class="me-3"><strong>Sector:</strong> {{ $company->sector->name ?? 'N/A' }}</span>
                                <span><strong>Depository:</strong> {{ $company->depository ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-end position-relative">
                            @if($company->share_price)
                            <h3 class="blurred-share-price mb-2">
                                <span class="inr-label">INR</span>
                                <span class="price-value">{{ number_format((float) ($company->share_price ?? 0), 2)
                                    }}</span>
                            </h3>
                            @endif
                            <div class="download-app-dropdown">
                                <div class="download-app-btn" title="Download Our App">
                                    <i class="fas fa-download"></i>
                                </div>
                                <div class="download-dropdown-menu">
                                    <a href="https://play.google.com/store/apps/details?id=com.shuruup.investor"
                                        target="_blank" class="download-dropdown-item">
                                        <i class="fab fa-android android-icon"></i>
                                        Android App
                                    </a>
                                    <a href="https://apps.apple.com/us/app/shuru-up/id6736905561" target="_blank"
                                        class="download-dropdown-item">
                                        <i class="fab fa-apple ios-icon"></i>
                                        iOS App
                                    </a>
                                </div>
                            </div>
                            <p class="download-text">Download Our<br>App Now</p>
                        </div>
                    </div>
                </div>

                @if($company->customData && $company->customData->count() > 0)
                <div class="financial-section mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="financial-heading mb-0">Financials</h5>
                        <div class="figures-tag">figures in CR.</div>
                    </div>


                    <div class="financial-tabs-container mb-4">
                        <div class="tab-rounded-pill d-flex">
                            @foreach($company->customData as $cusKey => $cusItem)
                            <button class="tab-button {{ $cusKey == 0 ? 'active' : '' }}" data-bs-toggle="tab"
                                data-bs-target="#content-{{ $cusKey }}" type="button" role="tab"
                                aria-controls="content-{{ $cusKey }}"
                                aria-selected="{{ $cusKey == 0 ? 'true' : 'false' }}">
                                {{ ucwords(str_replace('_', ' ', $cusItem->label)) }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-content" id="financialTabsContent">
                        @foreach($company->customData as $cusKey => $cusItem)
                        <div class="tab-pane fade {{ $cusKey == 0 ? 'show active' : '' }}" id="content-{{ $cusKey }}"
                            role="tabpanel">
                            @php
                            $cusItemData = json_decode($cusItem->values, true);
                            $dataId = $cusItem->id;

                            // Debug: Check data structure
                            // dd($cusItemData); // Uncomment this to see the actual data structure
                            @endphp

                            @if($cusItemData && count($cusItemData) > 0)

                            @php
                            // Check if data is in the new format (with 'particular' and 'years' keys)
                            $isNewFormat = isset($cusItemData[0]['particular']) && isset($cusItemData[0]['years']);
                            @endphp

                            @if($isNewFormat)
                            <div class="text-end mb-2">
                                <small class="text-muted">Figures in CR.</small>
                            </div>
                            <div class="financial-table-container">
                                <div class="table-responsive">
                                    <table class="table financial-table">
                                        <thead>
                                            <tr>
                                                <th>Particulars</th>
                                                @php
                                                $years = [];
                                                foreach($cusItemData as $row) {
                                                if(isset($row['years'])) {
                                                foreach($row['years'] as $year => $value) {
                                                if(!in_array($year, $years)) {
                                                $years[] = $year;
                                                }
                                                }
                                                }
                                                }
                                                rsort($years);
                                                @endphp
                                                @foreach($years as $year)
                                                <th class="text-center">{{ $year }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cusItemData as $rowData)
                                            <tr>
                                                <td class="fw-semibold">{{ $rowData['particular'] ?? 'N/A' }}</td>
                                                @foreach($years as $year)
                                                <td class="text-center">
                                                    {{ isset($rowData['years'][$year])
                                                    ? (is_numeric($rowData['years'][$year])
                                                    ? number_format((float) $rowData['years'][$year], 2)
                                                    : $rowData['years'][$year])
                                                    : '-' }}
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @else

                            <div class="financial-table-container">
                                <div class="table-responsive">
                                    <table class="table financial-table">
                                        <thead>
                                            <tr>
                                                @if(isset($cusItemData[0]) && is_array($cusItemData[0]))
                                                @foreach($cusItemData[0] as $headerCell)
                                                <th class="{{ $loop->first ? '' : 'text-center' }}">{{ $headerCell }}
                                                </th>
                                                @endforeach
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cusItemData as $index => $rowData)
                                            @if($index > 0 && is_array($rowData))
                                            <tr>
                                                @foreach($rowData as $cellIndex => $cellData)
                                                @if($cellIndex === 0)
                                                <td class="fw-semibold">{{ $cellData }}</td>
                                                @else
                                                <td class="text-center">
                                                    {{ is_numeric($cellData) ? number_format((float) $cellData, 2) :
                                                    $cellData }}
                                                </td>
                                                @endif
                                                @endforeach
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No financial data available for {{ ucwords(str_replace('_', ' ', $cusItem->label)) }}.
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(($company->peerratio && $company->peerratio->count() > 0) || ($shareholdersData &&
                $shareholdersData->count() > 0))
                <div class="row mb-5">
                    @if($company->peerratio && $company->peerratio->count() > 0)
                    <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                        <div class="financial-section">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="financial-heading mb-0">Peer Ratio</h5>

                                <div class="dropdown">
                                    @php
                                    $peerRatioYears =
                                    $company->peerratio->pluck('year')->unique()->sortDesc()->values();
                                    $latestYear = $peerRatioYears->first();
                                    @endphp
                                    {{-- <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button"
                                        id="peerRatioYearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedPeerYear">{{ $latestYear }}</span>
                                    </button> --}}
                                    <ul class="dropdown-menu dropdown-menu-dark"
                                        aria-labelledby="peerRatioYearDropdown">
                                        @foreach($peerRatioYears as $year)
                                        <li><a class="dropdown-item peer-year-option" href="#"
                                                data-year="{{ $year }}">{{ $year }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="financial-table-container">
                                <div class="table-responsive">
                                    <table class="table financial-table">
                                        <thead>
                                            <tr>
                                                <th>Particulars (Cr)</th>
                                                <th class="text-center">P/E</th>
                                                <th class="text-center">EPS</th>
                                                <th class="text-center">Mcap</th>
                                                <th class="text-center">Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody id="peerRatioTableBody">
                                            @foreach($peerRatioYears as $year)
                                            @php
                                            $yearData = $company->peerratio->where('year', $year);
                                            @endphp
                                            <div class="peer-ratio-year-data" data-year="{{ $year }}"
                                                style="{{ $year != $latestYear ? 'display: none;' : '' }}">
                                                @foreach($yearData as $peerData)
                                                <tr class="peer-ratio-row" data-year="{{ $year }}">
                                                    <td class="fw-semibold">{{ $peerData->exchange ?? 'NSE' }}</td>
                                                    <td class="text-center">{{ $peerData->pe_ratio ?
                                                        number_format((float) $peerData->pe_ratio, 1) . 'x' : '-' }}
                                                    </td>
                                                    <td class="text-center">{{ $peerData->eps ? number_format((float)
                                                        $peerData->eps, 0) : '-' }}</td>
                                                    <td class="text-center">{{ $peerData->market_cap ?
                                                        number_format((float) $peerData->market_cap, 0) : '-' }}</td>
                                                    <td class="text-center">{{ $peerData->revenue ?
                                                        number_format((float) $peerData->revenue, 0) : '-' }}</td>

                                                </tr>
                                                @endforeach
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($shareholdersData && $shareholdersData->count() > 0)
                    <div class="col-lg-6 col-md-12">
                        <div class="financial-section h-100">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="financial-heading mb-0">Shareholding Pattern</h5>

                                <div class="dropdown">
                                    @php
                                    $shareholderYears = collect($shareholdersData->keys())->sortDesc();
                                    $latestShareholderYear = $shareholderYears->first();
                                    @endphp
                                    <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button"
                                        id="shareholderYearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="selectedShareholderYear">{{ $latestShareholderYear }}</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark"
                                        aria-labelledby="shareholderYearDropdown">
                                        @foreach($shareholderYears as $year)
                                        <li><a class="dropdown-item shareholder-year-option" href="#"
                                                data-year="{{ $year }}">{{ $year }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="shareholding-container">
                                @foreach($shareholderYears as $year)
                                <div class="shareholding-year-data" data-year="{{ $year }}"
                                    style="{{ $year != $latestShareholderYear ? 'display: none;' : '' }}">
                                    @foreach($shareholdersData[$year] as $shareholder)
                                    <div class="shareholding-item mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="shareholding-label">{{ $shareholder['name'] }}</span>
                                            <span class="shareholding-percentage">{{ number_format((float)
                                                ($shareholder['percentage'] ?? 0), 1) }}%</span>

                                        </div>
                                        <div class="progress shareholding-progress">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $shareholder['percentage'] }}%"
                                                aria-valuenow="{{ $shareholder['percentage'] }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- <div class="text-center mt-4">
                    <a href="{{ route('front.cards.preipo') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Companies
                    </a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@if($company->news && $company->news->count() > 0)
<section class="news-media-slider-vertical">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-5 col-md-12 col-sm-12">
                <h1 class="heading">News & <span class="highlight-blue">Media</span></h1>
                <p class="paragraph">
                    Get the latest startup news, market trends, company updates, and Pre-IPO investment insights with
                    PrivateDeals.
                </p>
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="news-slider-wrapper">
                    <div class="news-slider">
                        @foreach ($company->news as $newsItem)
                        <a href="{{ $newsItem->link }}" target="_blank" class="news-card">
                            <div class="image-wrap">
                                <img src="{{ FileUpDownHelper::getCompanyNewsBanner($newsItem) }}"
                                    alt="{{ $newsItem->title }}" />
                            </div>
                            <div class="info">
                                <div class="category">
                                    {{ UtillsHelper::read_more_hide($newsItem->title, 40) }}
                                </div>
                                <div class="sub">
                                    {{ UtillsHelper::read_more_hide($newsItem->description, 50) }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.peer-year-option').forEach(function(option) {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedYear = this.getAttribute('data-year');
            document.getElementById('selectedPeerYear').textContent = selectedYear;
            document.querySelectorAll('.peer-ratio-row').forEach(function(row) {
                row.style.display = 'none';
            });
            document.querySelectorAll('.peer-ratio-row[data-year="' + selectedYear + '"]').forEach(function(row) {
                row.style.display = 'table-row';
            });
        });
    });
    
    document.querySelectorAll('.shareholder-year-option').forEach(function(option) {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedYear = this.getAttribute('data-year');
            document.getElementById('selectedShareholderYear').textContent = selectedYear;
            document.querySelectorAll('.shareholding-year-data').forEach(function(data) {
                data.style.display = 'none';
            });
            document.querySelector('.shareholding-year-data[data-year="' + selectedYear + '"]').style.display = 'block';
        });
    });

    document.querySelectorAll('.tab-button').forEach((button) => {
    button.addEventListener('click', function () {
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        const target = this.getAttribute('data-bs-target');
        const pane = document.querySelector(target);
        if (pane) {
            pane.classList.add('show', 'active');
        }
    });
});

 const yearOptions = document.querySelectorAll('.shareholder-year-option');

        yearOptions.forEach(option => {
            option.addEventListener('click', function (e) {
                e.preventDefault();

                const selectedYear = this.getAttribute('data-year');
                const selectedYearSpan = document.getElementById('selectedShareholderYear');
                selectedYearSpan.textContent = selectedYear;

                document.querySelectorAll('.shareholding-year-data').forEach(block => {
                    block.style.display = 'none';
                });

                const targetBlock = document.querySelector(`.shareholding-year-data[data-year="${selectedYear}"]`);
                if (targetBlock) {
                    targetBlock.style.display = 'block';

                    const bars = targetBlock.querySelectorAll('.progress-bar');
                    bars.forEach(bar => {
                        const targetPercent = bar.getAttribute('aria-valuenow');
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = `${targetPercent}%`;
                        }, 200);
                    });
                }
            });
        });
});
</script>