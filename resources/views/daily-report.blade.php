<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Market Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
        }
        .company-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
            border: 1px solid #dee2e6;
        }
        .company-info {
            display: flex;
            align-items: center;
        }
        .company-name {
            font-weight: 500;
            color: #343a40;
        }
        .price-info {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .old-price {
            text-decoration: line-through;
            margin-right: 5px;
        }
        .current-price {
            font-weight: 500;
            color: #495057;
        }
        .change-up {
            color: #28a745;
            font-weight: 500;
        }
        .change-down {
            color: #dc3545;
            font-weight: 500;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #eee;
        }
        .report-date {
            color: #6c757d;
            font-size: 0.9rem;
            text-align: right;
        }
        .price-change {
            text-align: right;
        }
        .news-item {
            transition: all 0.2s ease;
            padding: 10px;
            border-radius: 5px;
        }

        .news-item:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .news-item h6 {
            font-weight: 500;
            color: #212529;
        }

        .news-item .badge {
            font-weight: 400;
            padding: 4px 8px;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Report Header -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Daily Market Report</h2>
                    <p class="text-muted">{{ now()->format('F j, Y') }}</p>
                </div>

                <!-- Gainers Section -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-arrow-up me-2"></i> Top 5 Gainers (14 Days)</span>
                        <span class="badge bg-white text-success">{{ count($data['up']) }} Companies</span>
                    </div>
                    <div class="card-body">
                        @if(count($data['up']) > 0)
                            @foreach($data['up'] as $company)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div class="company-info">
                                    <img src="{{ $company['company_logo'] ?? 'https://via.placeholder.com/40' }}" 
                                         alt="{{ $company['company_name'] }}" 
                                         class="company-logo"
                                         onerror="this.src='https://via.placeholder.com/40'">
                                    <div>
                                        <div class="company-name">{{ $company['company_name'] }}</div>
                                        <div class="price-info">
                                            <span class="old-price">₹{{ number_format($company['previous_price'], 2) }}</span>
                                            <span class="current-price">₹{{ number_format($company['current_price'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="price-change">
                                    <div class="change-up">
                                        <i class="fas fa-arrow-up"></i> {{ number_format($company['fluctuation_percentage'], 2) }}%
                                    </div>
                                    <div class="price-info">
                                        +₹{{ number_format($company['price_difference'], 2) }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-3 text-muted">
                                No significant gainers today
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Losers Section -->
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-arrow-down me-2"></i> Top 5 Losers (14 Days)</span>
                        <span class="badge bg-white text-danger">{{ count($data['down']) }} Companies</span>
                    </div>
                    <div class="card-body">
                        @if(count($data['down']) > 0)
                            @foreach($data['down'] as $company)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div class="company-info">
                                    <img src="{{ $company['company_logo'] ?? 'https://via.placeholder.com/40' }}" 
                                         alt="{{ $company['company_name'] }}" 
                                         class="company-logo"
                                         onerror="this.src='https://via.placeholder.com/40'">
                                    <div>
                                        <div class="company-name">{{ $company['company_name'] }}</div>
                                        <div class="price-info">
                                            <span class="old-price">₹{{ number_format($company['previous_price'], 2) }}</span>
                                            <span class="current-price">₹{{ number_format($company['current_price'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="price-change">
                                    <div class="change-down">
                                        <i class="fas fa-arrow-down"></i> {{ number_format(abs($company['fluctuation_percentage']), 2) }}%
                                    </div>
                                    <div class="price-info">
                                        -₹{{ number_format(abs($company['price_difference']), 2) }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-3 text-muted">
                                No significant losers today
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Add this after the Losers section -->
                {{-- <div class="card mb-4">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-newspaper me-2"></i> Related Company News (Last 14 Days)</span>
                        <span class="badge bg-white text-info">{{ count($newsData) }} News Items</span>
                    </div>
                    <div class="card-body">
                        @if(count($newsData) > 0)
                            @foreach($newsData as $news)
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="company-info">
                                        <span class="badge bg-light text-dark me-2">{{ $news['company_name'] }}</span>
                                    </div>
                                    <small class="text-muted"></small>
                                </div>
                                <h6 class="mt-2 mb-1">{{ $news['headline'] }}</h6>
                                <p class="text-muted small mb-0">{{ $news['summary'] }}</p>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-3 text-muted">
                                No recent news for these companies
                            </div>
                        @endif
                    </div>
                </div> --}}

                <!-- Add this after the Losers section -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-newspaper me-2"></i> Latest Market News</span>
                        <span class="badge bg-white text-info">Last 5 Updates</span>
                    </div>
                    <div class="card-body">
                        @if(count($newsData) > 0)
                            @foreach($newsData as $news)
                            <div class="mb-3 pb-3 border-bottom news-item">
                                @if(isset($news['company_name']))
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-light text-dark">{{ $news['company_name'] }}</span>
                                    <small class="text-muted">{{-- Add date if available --}}</small>
                                </div>
                                @endif
                                <h6 class="mb-1">{{ $news['headline'] }}</h6>
                                @if(isset($news['summary']))
                                <p class="text-muted small mb-0">{{ $news['summary'] }}</p>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-3 text-muted">
                                No recent news available
                            </div>
                        @endif
                        
                        <!-- View All News Link -->
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-book-open me-1"></i> View All News
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Report Footer -->
                <div class="report-date">
                    Generated on {{ now()->format('Y-m-d H:i:s') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>