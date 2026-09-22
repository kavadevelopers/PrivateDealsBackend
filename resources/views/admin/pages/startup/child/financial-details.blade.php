<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expandable and Collapsible Divs</title>
    <style>
        .collapsible-header {
            cursor: pointer;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            /* border-radius: 5px; */
            /* margin-bottom: 10px; */
        }

        .collapsible-content {
            display: none;
            padding: 10px;
            border: 1px solid #ddd;
            /* border-radius: 5px; */
            /* background-color: #fff; */
        }

        .collapsible-content.show {
            display: block;
        }

        /* .card-header {
            cursor: pointer;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .card-body {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        } */
    </style>
</head>

<body>
    <div class="container">
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card-header" id="header-financialDetails">
                <h3 class="fw-bold m-0">Financial Details</h3>
            </div>
            <div class="card-body p-9">
                @php
                    $postFundRaise = [];
                    $financialDetails = [];
                @endphp

                @foreach ($startup->StartupFinance as $finance)
                    @if (
                        $finance->revenue_expected ||
                            $finance->current_fy_closing_ebitda ||
                            $finance->current_fy_closing_pat ||
                            $finance->next_fy_revenue ||
                            $finance->next_fy_ebitda ||
                            $finance->next_fy_pat)
                        @php $postFundRaise[] = $finance; @endphp
                    @else
                        @php $financialDetails[] = $finance; @endphp
                    @endif
                @endforeach

                @if (count($postFundRaise) > 0)
                    <div class="collapsible-header" id="toggle-postFundRaise">
                        <h4 class="fw-bold m-0">Post Fund Raise</h4>
                    </div>
                    <div class="collapsible-content" id="postFundRaiseDetails">
                        @foreach ($postFundRaise as $finance)
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Year: {{ $finance->year }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>Revenue Expected:</strong>
                                                    <p>{{ $finance->revenue_expected }}</p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Current FY Closing EBITDA:</strong>
                                                    <p>{{ $finance->current_fy_closing_ebitda }}</p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Current FY Closing PAT:</strong>
                                                    <p>{{ $finance->current_fy_closing_pat }}</p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Next FY Revenue:</strong>
                                                    <p>{{ $finance->next_fy_revenue }}</p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Next FY EBITDA:</strong>
                                                    <p>{{ $finance->next_fy_ebitda }}</p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Next FY PAT:</strong>
                                                    <p>{{ $finance->next_fy_pat }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (count($financialDetails) > 0)
                    <div class="collapsible-header" id="toggle-financialDetails">
                        <h4 class="fw-bold m-0">Financial Details</h4>
                    </div>
                    <div class="collapsible-content" id="financialDetails">
                        @foreach ($financialDetails as $finance)
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Year: {{ $finance->year }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <strong>Net Revenue:</strong>
                                                    <p>{{ $finance->net_revenue }}</p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>EBITDA:</strong>
                                                    <p>{{ $finance->ebitda }}</p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>PAT:</strong>
                                                    <p>{{ $finance->pat }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript for toggling content -->
    <script>
        document.getElementById('toggle-postFundRaise').addEventListener('click', function() {
            var content = document.getElementById('postFundRaiseDetails');
            content.classList.toggle('show');
        });

        document.getElementById('toggle-financialDetails').addEventListener('click', function() {
            var content = document.getElementById('financialDetails');
            content.classList.toggle('show');
        });
    </script>
</body>

</html>
