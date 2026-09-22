<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $startupData['brand_name'] ?? $startupData['company_name'] ?? 'Startup Details' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Section */
        .header-section {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }

        .banner-container {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .banner-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: white;
            font-size: 64px;
            font-weight: bold;
        }

        .startup-header {
            padding: 24px;
            position: relative;
        }

        .logo-container {
            position: absolute;
            top: -40px;
            left: 24px;
            width: 80px;
            height: 80px;
            border-radius: 16px;
            background: white;
            border: 4px solid white;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            background: #000;
        }

        .logo-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 32px;
            font-weight: bold;
        }

        .header-content {
            margin-left: 100px;
            padding-top: 16px;
        }

        .startup-title {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .startup-oneliner {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 20px;
            font-style: italic;
        }

        .highlights-section {
            margin-top: 20px;
        }

        .highlights-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
        }

        .highlights-text {
            font-size: 16px;
            color: #495057;
            line-height: 1.6;
        }

        /* Tab Navigation */
        .tab-navigation {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .tab-header {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            overflow-x: auto;
        }

        .tab-button {
            padding: 16px 24px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #6c757d;
            white-space: nowrap;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .tab-button.active {
            color: #667eea;
            border-bottom-color: #667eea;
            background: white;
        }

        .tab-button:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .tab-content {
            padding: 24px;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Cards Container */
        .cards-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .info-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
            padding-left: 12px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 14px;
            color: #6c757d;
            font-weight: 500;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
        }

        .team-grid {
            display: grid;
            grid-template-columns: 1fr;
            /* Single column - full width */
            gap: 20px;
        }

        .team-member {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 16px;
            width: 100%;
            /* Full width */
        }

        .team-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            flex-shrink: 0;
            /* Prevent photo from shrinking */
        }

        .team-photo-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            flex-shrink: 0;
            /* Prevent placeholder from shrinking */
        }

        .team-info {
            flex: 1;
            /* Take up remaining space */
        }

        .team-info h4 {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 4px;
        }

        .team-info p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .team-experience {
            font-size: 12px;
            color: #95a5a6;
            margin-bottom: 8px;
        }

        /* Style LinkedIn link */
        .team-member a {
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .team-member a:hover {
            color: #0077b5;
            /* LinkedIn blue */
            text-decoration: underline;
        }

        /* Responsive design for mobile */
        @media (max-width: 768px) {
            .team-member {
                flex-direction: column;
                text-align: center;
                padding: 16px;
            }

            .team-photo,
            .team-photo-placeholder {
                margin-bottom: 12px;
            }
        }

        /* Documents */
        .document-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .document-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            min-height: 60px;
            transition: all 0.3s ease;
        }

        .document-item:hover {
            background: #fff;
            border-color: #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        .document-label {
            font-weight: 600;
            color: #2c3e50;
            flex: 1;
            display: flex;
            align-items: center;
        }

        .document-download {
            flex-shrink: 0;
            margin-left: 16px;
        }

        .document-item span:last-child {
            flex-shrink: 0;
            margin-left: 16px;
        }

        .document-download.document-link,
        .document-download .document-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 12px;
            border: 1px solid #667eea;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            cursor: pointer;
        }

        .document-download.document-link:hover,
        .document-download .document-link:hover {
            background: #667eea;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .document-download .fas.fa-download {
            font-size: 16px;
        }

        .not-available {
            color: #6c757d;
            font-style: italic;
            font-size: 12px;
        }

        /* Style the helper function output to match your design */
        .helper-link-wrapper a {
            color: #667eea !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            padding: 8px 12px !important;
            border: 1px solid #667eea !important;
            border-radius: 6px !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 40px !important;
            height: 40px !important;
            cursor: pointer !important;
            background: none !important;
        }

        .helper-link-wrapper a:hover {
            background: #667eea !important;
            color: white !important;
            text-decoration: none !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3) !important;
        }

        /* Hide any text in the helper function link but keep existing icons */
        .helper-link-wrapper a {
            font-size: 0 !important;
            /* Hide text */
        }

        /* Show existing icons from helper function */
        .helper-link-wrapper a i,
        .helper-link-wrapper a .fa,
        .helper-link-wrapper a .fas {
            font-size: 16px !important;
            display: inline-block !important;
        }

        /* If helper function has text but no icon, show download icon */
        .helper-link-wrapper a:not(:has(i)):not(:has(.fa)):not(:has(.fas))::after {
            content: "\f019";
            /* FontAwesome download icon */
            font-family: "Font Awesome 5 Free", "Font Awesome 6 Free", "FontAwesome";
            font-weight: 900;
            font-size: 16px !important;
            display: inline-block;
        }

        /* Hide any text spans but keep icons */
        .helper-link-wrapper a span:not([class*="fa"]):not([class*="icon"]) {
            display: none;
        }

        /* FAQ */
        .faq-item {
            background: white;
            border-radius: 8px;
            margin-bottom: 12px;
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .faq-question {
            padding: 16px;
            background: #f8f9fa;
            cursor: pointer;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 1px solid #e9ecef;
        }

        .faq-answer {
            padding: 16px;
            color: #495057;
            line-height: 1.6;
        }

        /* Social Media */
        .social-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .social-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        /* Back Button */
        .back-button {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header-content {
                margin-left: 0;
                padding-top: 60px;
            }

            .logo-container {
                position: relative;
                top: 0;
                left: 0;
                margin: 0 auto 16px auto;
            }

            .startup-title {
                font-size: 24px;
                text-align: center;
            }

            .startup-oneliner {
                text-align: center;
            }

            .cards-container {
                grid-template-columns: 1fr;
            }

            .tab-header {
                flex-wrap: wrap;
            }

            .team-member {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Back Button -->
        <a href="javascript:history.back()" class="back-button">← Back to Startups</a>

        <!-- Header Section -->
        <div class="header-section">
            <!-- Banner -->
            <div class="banner-container">
                @if(!empty($startupData['banner_url']))
                <img src="{{ $startupData['banner_url'] }}" alt="Banner" class="banner-image"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="banner-placeholder" style="display: none;">
                    {{ substr($startupData['brand_name'] ?? $startupData['company_name'] ?? 'S', 0, 1) }}
                </div>
                @else
                <div class="banner-placeholder">
                    {{ substr($startupData['brand_name'] ?? $startupData['company_name'] ?? 'S', 0, 1) }}
                </div>
                @endif
            </div>

            <!-- Header Info -->
            <div class="startup-header">
                <!-- Logo -->
                <div class="logo-container">
                    @if(!empty($startupData['logo_url']))
                    <img src="{{ $startupData['logo_url'] }}" alt="Logo" class="logo-image"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="logo-placeholder" style="display: none;">
                        {{ substr($startupData['brand_name'] ?? $startupData['company_name'] ?? 'S', 0, 1) }}
                    </div>
                    @else
                    <div class="logo-placeholder">
                        {{ substr($startupData['brand_name'] ?? $startupData['company_name'] ?? 'S', 0, 1) }}
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="header-content">
                    <h1 class="startup-title">{{ $startupData['brand_name'] ?? $startupData['company_name'] ?? 'Unnamed
                        Startup' }}</h1>

                    <!-- One Liner from CMS -->
                    @if(!empty($startupData['cms']['one_liner']))
                    <p class="startup-oneliner">{{ $startupData['cms']['one_liner'] }}</p>
                    @endif

                    <!-- Highlights Section from CMS -->
                    @if(!empty($startupData['cms']['highlights']))
                    <div class="highlights-section">
                        <h3 class="highlights-title">Startup Highlights</h3>
                        <div class="highlights-text">{{ $startupData['cms']['highlights'] }}</div>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Quick Info Cards -->
        <div class="cards-container">
            <!-- Basic Details Card -->
            <div class="info-card">
                <h2 class="card-title">Startup Overview</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-map-marker-alt" style="margin-right: 6px; color: #667eea;"></i>
                            Location
                        </span>
                        <span class="info-value">{{ $startupData['location'] ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-globe" style="margin-right: 6px; color: #667eea;"></i>
                            Website
                        </span>
                        <span class="info-value">
                            @if(!empty($startupData['cms']['website']))
                            <a href="{{ $startupData['cms']['website'] }}" target="_blank"
                                style="color: #667eea; text-decoration: none;">
                                {{ $startupData['cms']['website'] }}
                            </a>
                            @else
                            Not specified
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-building" style="margin-right: 6px; color: #667eea;"></i>
                            Company Number
                        </span>
                        <span class="info-value">{{ $startupData['legal_info']['cin'] ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-calendar-alt" style="margin-right: 6px; color: #667eea;"></i>
                            Incorporation Date
                        </span>
                        <span class="info-value">
                            {{ $startupData['legal_info']['incorporation_date'] ?? 'Not specified' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Investment Summary Card -->
            <div class="info-card">
                <h2 class="card-title">Investment Summary</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Type</span>
                        <span class="info-value">{{ $startupData['round_type'] ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Equity Offered</span>
                        <span class="info-value">{{ $startupData['equity_offered'] ?? 'Not specified' }}%</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-arrow-up" style="margin-right: 6px; color: #667eea;"></i>
                            Floor
                        </span>
                        <span class="info-value">
                            @if(!empty($startupData['floor']) && is_numeric($startupData['floor']))
                            {{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($startupData['floor']) }}
                            @else
                            Not set
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-arrow-down" style="margin-right: 6px; color: #667eea;"></i>
                            Cap
                        </span>
                        <span class="info-value">
                            @if(!empty($startupData['cap']) && is_numeric($startupData['cap']))
                            {{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($startupData['cap']) }}
                            @else
                            Not set
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <div class="tab-header">
                <button class="tab-button active" data-tab="idea">Idea</button>
                <button class="tab-button" data-tab="key-info">Key Information</button>
                <button class="tab-button" data-tab="teams">Teams</button>
                {{-- <button class="tab-button" data-tab="investors">Investors</button> --}}
                <button class="tab-button" data-tab="faq">FAQ</button>
                <button class="tab-button" data-tab="documents">Documents</button>
                <button class="tab-button" data-tab="social-media">Social Media</button>
            </div>

            <!-- Idea Tab Content -->
            <div class="tab-content active" id="idea">
                @if(!empty($startupData['cms']['idea']))
                <div class="idea-content">
                    {!! $startupData['cms']['idea'] !!}
                </div>
                @else
                <p style="color: #6c757d;">No idea description available.</p>
                @endif
            </div>

            <!-- Key Information Tab Content -->
            <div class="tab-content" id="key-info">
                @if(!empty($startupData['cms']['key_information']))
                <div class="key-info-content">
                    {!! $startupData['cms']['key_information'] !!}
                </div>
                @else
                <p style="color: #6c757d;">No key information available.</p>
                @endif
            </div>

            <!-- Teams Tab -->
            <div class="tab-content" id="teams">
                <h3 style="margin-bottom: 20px; color: #2c3e50;">Team Members</h3>
                <div class="team-grid">
                    @if(!empty($startupData['team_members']))
                    @foreach($startupData['team_members'] as $member)
                    <div class="team-member">
                        @if(!empty($member['profile_photo']))
                        <img src="{{ FileUpDownHelper::get_startup_team_profile_photo_url($member['profile_photo']) }}"
                            alt="{{ $member['name'] }}" class="team-photo"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="team-photo-placeholder" style="display: none;">
                            {{ substr($member['name'] ?? 'U', 0, 1) }}
                        </div>
                        @else
                        <div class="team-photo-placeholder">
                            {{ substr($member['name'] ?? 'U', 0, 1) }}
                        </div>
                        @endif
                        <div class="team-info">
                            <h4>{{ $member['name'] ?? 'Unknown' }}</h4>
                            <p><strong>{{ $member['designation'] ?? 'Position not specified' }}</strong></p>
                            <p>{{ $member['brief_information'] ?? 'No description available.' }}</p>
                            <div class="team-experience">{{ $member['experience'] ?? 'Experience not listed' }}</div>
                            @if(!empty($member['linkedin_url']))
                            <a href="{{ $member['linkedin_url'] }}" target="_blank"
                                style="color: #667eea; font-size: 12px;">LinkedIn Profile</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p style="color: #6c757d;">No team information available.</p>
                    @endif
                </div>
            </div>

            <!-- Investors Tab -->
            {{-- <div class="tab-content" id="investors">
                <h3 style="margin-bottom: 20px; color: #2c3e50;">Investors</h3>
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
                    <div style="font-size: 48px; font-weight: bold; color: #667eea; margin-bottom: 12px;">
                        {{ $startupData['total_investors'] ?? 0 }}
                    </div>
                    <p style="color: #6c757d;">Total Investors</p>
                </div>
            </div> --}}

            <!-- FAQ Tab -->
            <div class="tab-content" id="faq">
                <h3 style="margin-bottom: 20px; color: #2c3e50;">Frequently Asked Questions</h3>
                @if(!empty($startupData['faqs']))
                @foreach($startupData['faqs'] as $faq)
                <div class="faq-item">
                    <div class="faq-question">{{ $faq['question'] ?? 'Question not available' }}</div>
                    <div class="faq-answer">{{ $faq['answer'] ?? 'Answer not available' }}</div>
                </div>
                @endforeach
                @else
                <p style="color: #6c757d;">No FAQs available.</p>
                @endif
            </div>

            <!-- Documents Tab with Download Links -->
            <div class="tab-content" id="documents">
                <h3 style="margin-bottom: 20px; color: #2c3e50;">Documents</h3>
                <div class="document-grid">
                    @php
                    $documents = [
                    'pitch_deck' => 'Pitch Deck',
                    'financial_projection' => 'Financial Projection',
                    'dd_report' => 'DD Report',
                    'dpiit_report' => 'DPIIT Certificate',
                    'shuruup_research_report' => 'PrivateDeals Research Report',
                    'valuation_report' => 'Valuation Report',
                    'pitch_video' => 'Pitch Video',
                    'product_video' => 'Product Video'
                    ];

                    $availableDocuments = [];
                    $cmsData = $startup->cms;

                    // Filter only available documents
                    foreach($documents as $docType => $docLabel) {
                    if ($cmsData && !empty($cmsData->$docType)) {
                    $availableDocuments[$docType] = $docLabel;
                    }
                    }
                    @endphp

                    @if(count($availableDocuments) > 0)
                    @foreach($availableDocuments as $docType => $docLabel)
                    @php
                    // Debug: output current model and cms
                    \Log::info('startup id: ' . ($startup->id ?? 'no id'));
                    \Log::info('cms object: ' . print_r($startup->cms, true));
                    \Log::info('Trying docType: ' . $docType . ' Value: ' . ($startup->cms->$docType ?? 'empty'));

                    $downloadLink = FileUpDownHelper::get_startup_document_download_link($startup, $docType);
                    \Log::info('Download link returned for ' . $docType . ': ' . $downloadLink);
                    @endphp
                    @endforeach
                    @else
                    <div style="text-align: center; padding: 40px; color: #6c757d;">
                        <i class="fas fa-folder-open" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                        <p>No documents are currently available for download.</p>
                    </div>
                    @endif
                </div>
            </div>


            <!-- Social Media Tab -->
            <div class="tab-content" id="social-media">
                <h3 style="margin-bottom: 20px; color: #2c3e50;">Social Media Links</h3>
                <div class="social-links">
                    @if(!empty($startupData['social_media_links']))
                    @foreach($startupData['social_media_links'] as $social)
                    <div class="social-item">
                        <span style="font-weight: 600; display: flex; align-items: center; gap: 8px;"
                            data-platform="{{ $social['platform'] ?? $social['link'] ?? '' }}">
                            <i class="fas fa-share-alt" style="font-size: 18px; color: #667eea;"></i>
                            {{ $social['platform'] ?? 'Social Media' }}
                        </span>
                        @if(!empty($social['link']))
                        <a href="{{ $social['link'] }}" target="_blank" class="document-link">Visit</a>
                        @else
                        <span style="color: #6c757d;">Not Available</span>
                        @endif
                    </div>
                    @endforeach
                    @else
                    <p style="color: #6c757d;">No social media links available.</p>
                    @endif
                </div>
            </div>


        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTab = button.getAttribute('data-tab');

                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked button and corresponding content
                    button.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });
        });

       document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');

            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Add active class to clicked button and corresponding content
            button.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });

    // Social Media functionality
    function getSocialMediaInfo(platformOrUrl) {
        const platform = platformOrUrl.toLowerCase();
        
        const socialMap = {
            facebook: { name: 'Facebook', icon: 'fab fa-facebook', color: '#1877f2' },
            twitter: { name: 'Twitter / X', icon: 'fab fa-x-twitter', color: '#000000' },
            instagram: { name: 'Instagram', icon: 'fab fa-instagram', color: '#E4405F' },
            linkedin: { name: 'LinkedIn', icon: 'fab fa-linkedin', color: '#0077b5' },
            youtube: { name: 'YouTube', icon: 'fab fa-youtube', color: '#FF0000' },
            tiktok: { name: 'TikTok', icon: 'fab fa-tiktok', color: '#000000' },
            snapchat: { name: 'Snapchat', icon: 'fab fa-snapchat', color: '#FFFC00' },
            pinterest: { name: 'Pinterest', icon: 'fab fa-pinterest', color: '#BD081C' },
            telegram: { name: 'Telegram', icon: 'fab fa-telegram', color: '#0088cc' },
            whatsapp: { name: 'WhatsApp', icon: 'fab fa-whatsapp', color: '#25D366' },
            discord: { name: 'Discord', icon: 'fab fa-discord', color: '#5865F2' },
            reddit: { name: 'Reddit', icon: 'fab fa-reddit', color: '#FF4500' }
        };
        
        // Check URL patterns
        if (platform.includes('facebook.com') || platform.includes('fb.com')) return socialMap.facebook;
        if (platform.includes('twitter.com') || platform.includes('x.com')) return socialMap.twitter;
        if (platform.includes('instagram.com')) return socialMap.instagram;
        if (platform.includes('linkedin.com')) return socialMap.linkedin;
        if (platform.includes('youtube.com') || platform.includes('youtu.be')) return socialMap.youtube;
        if (platform.includes('tiktok.com')) return socialMap.tiktok;
        if (platform.includes('snapchat.com')) return socialMap.snapchat;
        if (platform.includes('pinterest.com')) return socialMap.pinterest;
        if (platform.includes('telegram.org') || platform.includes('t.me')) return socialMap.telegram;
        if (platform.includes('whatsapp.com') || platform.includes('wa.me')) return socialMap.whatsapp;
        if (platform.includes('discord.com') || platform.includes('discord.gg')) return socialMap.discord;
        if (platform.includes('reddit.com')) return socialMap.reddit;
        
        // Check direct platform names
        return socialMap[platform] || { name: 'Website', icon: 'fas fa-globe', color: '#667eea' };
    }

    // Update social media items on page load
    const socialItems = document.querySelectorAll('.social-item');
    socialItems.forEach(item => {
        const platformSpan = item.querySelector('span[data-platform]');
        if (platformSpan) {
            const platformData = platformSpan.getAttribute('data-platform');
            const socialInfo = getSocialMediaInfo(platformData);
            
            platformSpan.innerHTML = `
                <i class="${socialInfo.icon}" style="font-size: 18px; color: ${socialInfo.color}; margin-right: 8px;"></i>
                ${socialInfo.name}
            `;
            platformSpan.style.display = 'flex';
            platformSpan.style.alignItems = 'center';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Existing tab and social media functionality...
    
    // Handle document downloads
    const documentDownloads = document.querySelectorAll('.document-download[data-original-link]');
    documentDownloads.forEach(download => {
        download.addEventListener('click', function() {
            const originalLink = this.getAttribute('data-original-link');
            
            // Create a temporary div to parse the HTML link
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = originalLink;
            
            // Find the actual link element
            const linkElement = tempDiv.querySelector('a');
            if (linkElement) {
                const href = linkElement.getAttribute('href');
                const target = linkElement.getAttribute('target') || '_blank';
                
                // Open the link
                window.open(href, target);
            }
        });
        
        // Style it as clickable
        download.style.cursor = 'pointer';
        download.classList.add('document-link');
    });
});
        </script>
</body>

</html>