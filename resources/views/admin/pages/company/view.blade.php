<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection
    @section('breadcrumbs')
    {{ Breadcrumbs::render('company.create') }}
    @endsection
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img class="shimmer lazy" data-src="{{ FileUpDownHelper::get_company_logo_url($item) }}" />
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                        </div>
                    </div>
                </div>
                <!--end::Pic-->

                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $item->brand_name
                                    }}</a>
                                <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span
                                            class="path1"></span><span class="path2"></span></i></a>
                            </div>
                            <!--end::Name-->
                        </div>
                        <!--end::User-->

                        <!--begin::Actions-->
                        <div class="d-flex my-4">

                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home">
                        Basic Details </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home2">
                        Fundamentals </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home3">
                        Share Prices </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home4">
                        Promoters </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home5">
                        Events </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home6">
                        Peer Ratio </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home7">
                        Share Holders </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home8">
                        Financials </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home9">
                        News </a>
                </li>

                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-bonus">
                        Bonus/Split </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">

                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <label class="col-lg-2 fw-semibold text-muted">Brand Name</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $item->brand_name }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-2 fw-semibold text-muted">Legal Name</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $item->company_name }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-2 fw-semibold text-muted">About</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{!! nl2br($item->about) !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-home2" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Fundamentals</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <div class="col-lg-6">
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">Lot Size</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->lot_size }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">52W High</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->fifty_two_week_high
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">52W Low</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->fifty_two_week_low
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">Depository</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->depository
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">PAN </label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->pan_number
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">ISIN</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->isin_number
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">CIN</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->cin_number
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">RTA</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->rta }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">Market Cap.(in Cr.)</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->market_cap
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">P/E ratio</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->pe_ratio }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">P/B ratio</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->pb_ratio }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">Debt to Equity</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->debt_to_equity
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">ROE</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->roe }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">Book Value</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->book_value
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">Face Value</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->face_value
                                        }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-3 fw-semibold text-muted">Total Shares</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $item->fundamentals->total_shares
                                        }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-home3" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Share Prices</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    <table class="table table-bordered table-mini">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Distributer Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($item->sharePrices)
                            @foreach ($item->sharePrices()->orderBy('date', 'desc')->limit(100)->get() as $price)
                            <tr>
                                <td>{{ DateTimeHelper::viewDate($price->date) }}</td>
                                <td>{{ $price->price }}</td>
                                <td>{{ $price->distributer_price }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-home4" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Promoters</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    <table class="table table-bordered table-mini">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Experience</th>
                                <th>Linked In URL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($item->promoters)
                            @foreach ($item->promoters as $promoter)
                            <tr>
                                <td>{{ $promoter->name }}</td>
                                <td>{{ $promoter->designation }}</td>
                                <td>{{ $promoter->experience }}</td>
                                <td>
                                    <a href="{{ $promoter->url }}" target="_blank"
                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary show">
                                        {!! getIcon('send', 'fs-6') !!}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-home5" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Events</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    <table class="table table-bordered table-mini">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="text-center">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($item->events)
                            @foreach ($item->events as $event)
                            <tr>
                                <td class="text-center">{{ DateTimeHelper::viewDate($event->date) }}</td>
                                <td>{{ $event->title }}</td>
                                <td>{!! nl2br($event->description) !!}</td>
                                <td class="text-center">
                                    @if ($event->file)
                                    <a href="{{ route('download.web', ['path' => $event->file, 'name' => 'File of ' . $item->brand_name . ' - Event ' . $event->title]) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary show">
                                        {!! getIcon('cloud-download', 'fs-6') !!}
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-home6" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Peer Ratio</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    <table class="table table-bordered table-mini">
                        <thead>
                            <tr>
                                <th>Particular</th>
                                <th>Revenue</th>
                                <th>EPS</th>
                                <th>Market Cap</th>
                                <th>P/E</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($item->peerratio)
                            @foreach ($item->peerratio as $event)
                            <tr>
                                <td>{{ $event->perticular }}</td>
                                <td>{{ $event->revenue }}</td>
                                <td>{{ $event->eps }}</td>
                                <td>{{ $event->market_cap }}</td>
                                <td>{{ $event->pe }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-home7" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Share Holders</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    @if ($shareholdersData)
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                        @foreach ($shareholdersData as $year => $shareholders)
                        <li class="nav-item">
                            <a class="nav-link @if ($loop->first) active @endif" data-bs-toggle="tab"
                                href="#year_{{ $year }}">
                                {{ $year }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="myTabContent">
                        @foreach ($shareholdersData as $year => $shareholders)
                        <div class="tab-pane fade @if ($loop->first) show active @endif" id="year_{{ $year }}"
                            role="tabpanel">
                            <ul>
                                @foreach ($shareholders as $shareholder)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <span>{{ $shareholder['name'] }}</span>
                                        <span>{{ $shareholder['percentage'] }}%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $shareholder['percentage'] }}%;"
                                            aria-valuenow="{{ $shareholder['percentage'] }}" aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ $shareholder['percentage'] }}%
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-home8" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Financials</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    @if ($item->customData()->count() > 0)
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                        @foreach ($item->customData as $cusKey => $cusItem)
                        <li class="nav-item">
                            <a class="nav-link {{ $cusKey == 0 ? 'active' : '' }}" data-bs-toggle="tab"
                                href="#kt_tab_pane_{{ $cusKey + 1 }}">
                                {{ ucwords(str_replace('_', ' ', $cusItem->label)) }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        @foreach ($item->customData as $cusKey => $cusItem)
                        <div class="tab-pane fade {{ $cusKey == 0 ? 'show active' : '' }}"
                            id="kt_tab_pane_{{ $cusKey + 1 }}" role="tabpanel">
                            @php
                            $cusItemData = json_decode($cusItem->values);
                            $dataId = $cusItem->id;
                            @endphp
                            @if (is_array($cusItemData))
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-sm btn-primary me-2"
                                    onclick="openEditModal('{{ $dataId }}', '{{ $cusItem->label }}')">
                                    <i class="fas fa-edit"></i> Edit Data
                                </button>
                                <button type="button" class="btn btn-sm btn-success"
                                    onclick="openAddYearModal('{{ $dataId }}', '{{ $cusItem->label }}')">
                                    <i class="fas fa-plus"></i> Add Year
                                </button>
                            </div>
                            <table class="table table-bordered table-mini">
                                <thead>
                                    <tr>
                                        @foreach ($cusItemData[0] as $headerCell)
                                        <th>{{ $headerCell }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cusItemData as $index => $rowData)
                                    @if ($index > 0)
                                    <tr>
                                        @foreach ($rowData as $cellIndex => $cellData)
                                        @if ($cellIndex === 0)
                                        <th>{{ $cellData }}</th>
                                        @else
                                        <td>{{ $cellData }}</td>
                                        @endif
                                        @endforeach
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-home9" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">News</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <div class="card-body p-9">
                    <table class="table table-bordered table-mini">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="text-center">Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($item->news)
                            @foreach ($item->news as $news)
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px symbol-2by3">
                                        <img src="{{ FileUpDownHelper::getCompanyNewsBanner($news) }}" alt="" />
                                    </div>
                                </td>
                                <td>{{ $news->title }}</td>
                                <td>{!! nl2br($news->description) !!}</td>
                                <td class="text-center">
                                    <a href="{{ $news->link }}" target="_blank"
                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary show">
                                        {!! getIcon('send', 'fs-6') !!}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Bonus/Split Tab -->
        <div class="tab-pane fade" id="pills-bonus" role="tabpanel" aria-labelledby="pills-bonus-tab">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Stock Split / Bonus Shares</h3>
                    </div>
                </div>
                <div class="card-body p-9">
                    <!-- Current Status -->
                    @if($item->current_split_ratio)
                    <div class="alert alert-info d-flex align-items-center mb-7">
                        <div class="flex-grow-1">
                            <div class="fw-bold">Current Split Status</div>
                            <div class="text-muted">
                                Split Ratio: <strong>{{ $item->current_split_ratio }}</strong> |
                                Applied on: <strong>{{ $item->last_split_date }}</strong>
                            </div>
                        </div>
                        <button class="btn btn-warning btn-sm" id="revertLastSplit">
                            <i class="ki-duotone ki-arrows-circle fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Revert Split
                        </button>
                    </div>
                    @endif

                    <!-- Apply New Split Form -->
                    <div class="card border border-dashed border-primary">
                        <div class="card-header bg-light-primary">
                            <div class="card-title">
                                <h5 class="text-primary mb-0">Apply New Split</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Current Values Display -->
                            <div class="row mb-7 bg-light-info p-4 rounded">
                                <div class="col-lg-3">
                                    <label class="fw-semibold text-muted">Current Share Price</label>
                                    <div class="fw-bold fs-5 text-gray-800">₹{{ number_format($item->share_price, 2) }}
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="fw-semibold text-muted">Current Face Value</label>
                                    <div class="fw-bold fs-5 text-gray-800">₹{{
                                        number_format($item->fundamentals->face_value ?? 0, 2) }}</div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="fw-semibold text-muted">Total Shares</label>
                                    <div class="fw-bold fs-5 text-gray-800">{{
                                        number_format($item->fundamentals->total_shares ?? 0) }}</div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="fw-semibold text-muted">Base Price</label>
                                    <div class="fw-bold fs-5 text-gray-800">₹{{ number_format($item->base_price, 2) }}
                                    </div>
                                </div>
                            </div>

                            <!-- In the Bonus/Split Tab section, update the form part: -->

                            <form id="splitForm">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-7">
                                            <label class="required fw-semibold fs-6 mb-2">Bonus/Split Ratio</label>
                                            <input type="text" class="form-control form-control-solid"
                                                name="split_ratio" placeholder="1:1" pattern="^\d+:\d+$"
                                                title="Format: 1:1" required>
                                            <div class="text-muted fs-7 mt-1">
                                                <strong>Bonus Format:</strong> existing:additional<br>
                                                <strong>1:1</strong> = 1 existing share gets 1 additional share (total
                                                becomes 2)<br>
                                                <strong>1:2</strong> = 1 existing share gets 2 additional shares (total
                                                becomes 3)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-7">
                                            <label class="required fw-semibold fs-6 mb-2">Split Date</label>
                                            <input type="date" class="form-control form-control-solid" name="split_date"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-7">
                                            <label class="fw-semibold fs-6 mb-2">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary d-block w-100">
                                                <i class="ki-duotone ki-cheque fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                    <span class="path6"></span>
                                                    <span class="path7"></span>
                                                </i>
                                                Apply Bonus/Split
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- Split History -->
                    <div class="card border border-dashed border-gray-300 mt-7">
                        <div class="card-header">
                            <div class="card-title">
                                <h6 class="mb-0">Split History</h6>
                            </div>
                            <div class="card-toolbar">
                                <button class="btn btn-sm btn-light-primary" id="refreshHistory">
                                    <i class="ki-duotone ki-arrows-circle fs-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="splitHistory">
                                <div class="text-center py-5">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                    <span class="text-muted ms-2">Loading history...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="tab-pane fade" id="pills-home4" role="tabpanel" aria-labelledby="pills-contact-tab">
        @include('admin.pages.startup.child.financial-details')
    </div>
    <div class="tab-pane fade" id="pills-home5" role="tabpanel" aria-labelledby="pills-contact-tab">
        @include('admin.pages.startup.child.other-details')
    </div>
    <div class="tab-pane fade" id="pills-home6" role="tabpanel" aria-labelledby="pills-contact-tab">
        @include('admin.pages.startup.child.document-details')
    </div>
    <div class="tab-pane fade" id="pills-home7" role="tabpanel" aria-labelledby="pills-contact-tab">
        @include('admin.pages.startup.child.team-details')
    </div> --}}
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editFinancialDataModal" tabindex="-1" aria-labelledby="editFinancialDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFinancialDataModalLabel">Edit Financial Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editFinancialDataForm" action="{{ route('admin.company.update-financial-data') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="data_id" id="edit_data_id">
                    <input type="hidden" name="company_id" value="{{ $item->id }}">

                    <div class="modal-body" id="editFinancialDataBody">
                        <!-- Data will be loaded dynamically -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="addRowBtn">Add New Row</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addYearModal" tabindex="-1" aria-labelledby="addYearModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addYearModalLabel">Add New Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addYearForm" action="{{ route('admin.company.add-financial-year') }}" method="POST">
                    @csrf
                    <input type="hidden" name="data_id" id="add_year_data_id">
                    <input type="hidden" name="company_id" value="{{ $item->id }}">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new_year" class="form-label">New Year</label>
                            <input type="number" class="form-control" id="new_year" name="new_year"
                                value="{{ date('Y') }}" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Year</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function openEditModal(dataId, label) {
        document.getElementById('edit_data_id').value = dataId;
        document.getElementById('editFinancialDataModalLabel').textContent = 'Edit ' + label.replace('_', ' ');
        
        // Show loader
        document.getElementById('editFinancialDataBody').innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        // Open modal
        var editModal = new bootstrap.Modal(document.getElementById('editFinancialDataModal'));
        editModal.show();
        
        // Fetch data
        fetch('{{ route("admin.company.get-financial-data") }}?data_id=' + dataId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderEditForm(data.data);
                } else {
                    document.getElementById('editFinancialDataBody').innerHTML = '<div class="alert alert-danger">Error loading data</div>';
                }
            })
            .catch(error => {
                document.getElementById('editFinancialDataBody').innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
            });
    }

    function renderEditForm(data) {
        let html = '';
        let values = JSON.parse(data.values);
        
        if (!Array.isArray(values) || values.length === 0) {
            html = '<div class="alert alert-warning">No data available</div>';
        } else {
            // Add CSS for drag handle
            html = `
            <style>
                .drag-handle {
                    cursor: move;
                    color: #aaa;
                    padding: 5px;
                }
                .drag-handle:hover {
                    color: #666;
                }
                tr.dragging {
                    opacity: 0.5;
                    background-color: #f8f9fa;
                }
                .delete-row {
                    color: #dc3545;
                    cursor: pointer;
                    padding: 5px;
                }
                .delete-row:hover {
                    color: #b02a37;
                }
            </style>`;
            
            html += '<div class="table-responsive"><table class="table table-bordered" id="financialDataTable">';
            
            // Headers (first row)
            html += '<thead><tr>';
            html += '<th width="40px"></th>'; // For drag handle
            values[0].forEach((header, index) => {
                html += `<th>${header}</th>`;
            });
            html += '<th width="60px">Action</th>'; // For delete button
            html += '</tr></thead><tbody id="financialDataTableBody">';
            
            // Data rows
            for (let rowIndex = 1; rowIndex < values.length; rowIndex++) {
                html += `<tr data-row-index="${rowIndex}" class="sortable-row">`;
                
                // Drag handle
                html += `<td><i class="fas fa-grip-vertical drag-handle"></i></td>`;
                
                values[rowIndex].forEach((cell, colIndex) => {
                    if (colIndex === 0) {
                        // First column is label/name (editable now)
                        html += `<td><input type="text" class="form-control" name="data[${rowIndex}][${colIndex}]" value="${cell}"></td>`;
                    } else {
                        // Other columns are editable
                        html += `<td><input type="text" class="form-control" name="data[${rowIndex}][${colIndex}]" value="${cell}"></td>`;
                    }
                });
                
                // Delete button
                html += `<td><i class="fas fa-trash delete-row" onclick="deleteRow(this)"></i></td>`;
                
                html += '</tr>';
            }
            
            html += '</tbody></table></div>';
            
            // Store original data for add row function
            html += `<input type="hidden" id="originalData" value='${JSON.stringify(values)}'>`;
        }
        
        document.getElementById('editFinancialDataBody').innerHTML = html;
        
        // Initialize drag and drop
        initializeDragAndDrop();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Use event delegation to handle the Add Row button click
        document.addEventListener('click', function(event) {
            if (event.target && event.target.id === 'addRowBtn') {
                addNewRow();
            }
        });
    });

    function addNewRow() {
        const table = document.getElementById('financialDataTable');
        const tbody = table.querySelector('tbody');
        const originalData = JSON.parse(document.getElementById('originalData').value);
        const columnCount = originalData[0].length;
        
        // Current row count (including header)
        const currentRowIndex = tbody.rows.length + 1;
        
        // Create new row
        const newRow = document.createElement('tr');
        newRow.setAttribute('data-row-index', currentRowIndex);
        newRow.className = 'sortable-row';
        
        // Add drag handle
        let cell = document.createElement('td');
        cell.innerHTML = '<i class="fas fa-grip-vertical drag-handle"></i>';
        newRow.appendChild(cell);
        
        // Add cells to the row
        for (let colIndex = 0; colIndex < columnCount; colIndex++) {
            cell = document.createElement('td');
            const input = document.createElement('input');
            
            input.type = 'text';
            input.className = 'form-control';
            input.name = `data[${currentRowIndex}][${colIndex}]`;
            
            // Default value
            if (colIndex === 0) {
                input.placeholder = 'Enter label';
            } else {
                input.value = '0';
            }
            
            cell.appendChild(input);
            newRow.appendChild(cell);
        }
        
        // Add delete button
        cell = document.createElement('td');
        cell.innerHTML = '<i class="fas fa-trash delete-row" onclick="deleteRow(this)"></i>';
        newRow.appendChild(cell);
        
        // Add the new row to the table
        tbody.appendChild(newRow);
        
        // Reinitialize drag and drop
        initializeDragAndDrop();
    }

    function deleteRow(element) {
        if (confirm('Are you sure you want to delete this row?')) {
            const row = element.closest('tr');
            row.remove();
            
            // Renumber remaining rows
            renumberRows();
        }
    }

    function renumberRows() {
        const rows = document.querySelectorAll('#financialDataTableBody tr.sortable-row');
        rows.forEach((row, index) => {
            row.setAttribute('data-row-index', index + 1);
            
            // Update input names
            const inputs = row.querySelectorAll('input');
            inputs.forEach((input, colIndex) => {
                input.name = `data[${index + 1}][${colIndex}]`;
            });
        });
    }

    function initializeDragAndDrop() {
        // Check if Sortable library is loaded
        if (typeof Sortable !== 'undefined') {
            const tableBody = document.getElementById('financialDataTableBody');
            
            if (tableBody) {
                new Sortable(tableBody, {
                    handle: '.drag-handle',
                    animation: 150,
                    onStart: function(evt) {
                        evt.item.classList.add('dragging');
                    },
                    onEnd: function(evt) {
                        evt.item.classList.remove('dragging');
                        renumberRows();
                    }
                });
            }
        } else {
            // Fallback message if Sortable library is not available
            console.warn('Sortable library not loaded. Please include it for drag & drop functionality.');
            
            // Add a message to the user
            const note = document.createElement('div');
            note.className = 'alert alert-warning mt-3';
            note.innerHTML = 'Drag & drop functionality requires the Sortable.js library. Please include it in your project.';
            document.getElementById('editFinancialDataBody').appendChild(note);
        }
    }

    function openAddYearModal(dataId, label) {
        document.getElementById('add_year_data_id').value = dataId;
        document.getElementById('addYearModalLabel').textContent = 'Add Year to ' + label.replace('_', ' ');
        
        var addYearModal = new bootstrap.Modal(document.getElementById('addYearModal'));
        addYearModal.show();
    }
        document.addEventListener("DOMContentLoaded", function () {
            // Store the last active tab in localStorage
            const tabLinks = document.querySelectorAll('[data-bs-toggle="pill"]');
            tabLinks.forEach(function (link) {
                link.addEventListener("shown.bs.tab", function (event) {
                    localStorage.setItem("activeTab", event.target.getAttribute("data-bs-target"));
                });
            });

            // On page load, check if there's an active tab stored
            const activeTab = localStorage.getItem("activeTab");
            if (activeTab) {
                const someTabTriggerEl = document.querySelector('[data-bs-target="' + activeTab + '"]');
                if (someTabTriggerEl) {
                    new bootstrap.Tab(someTabTriggerEl).show();
                }
            }
        });

        $(document).ready(function() {
            loadSplitHistory();
            
            // Calculate preview on ratio input
            $('input[name="split_ratio"]').on('input', function() {
                calculatePreview();
            });
            
            // Apply Split Form
            $('#splitForm').on('submit', function(e) {
                e.preventDefault();
                
                const ratio = $('input[name="split_ratio"]').val();
                const date = $('input[name="split_date"]').val();
                
                if (!ratio || !date) {
                    Swal.fire('Error', 'Please fill all required fields', 'error');
                    return;
                }
                
                Swal.fire({
                    title: 'Confirm Split',
                    html: `
                        <p>Are you sure you want to apply <strong>${ratio}</strong> split?</p>
                        <p class="text-warning">This will affect all investor portfolios and cannot be easily undone.</p>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Apply Split',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        applySplit();
                    }
                });
            });
            
            // Revert Split
            $('#revertLastSplit').on('click', function() {
                Swal.fire({
                    title: 'Revert Split?',
                    text: 'This will restore all data to the previous state before the split.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Revert',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        revertSplit();
                    }
                });
            });
            
            $('#refreshHistory').on('click', function() {
                loadSplitHistory();
            });
            
            function calculatePreview() {
                const ratio = $('input[name="split_ratio"]').val();
                
                if (!ratio || !ratio.includes(':')) {
                    $('#splitPreview').addClass('d-none');
                    return;
                }
                
                const [existingRatio, additionalRatio] = ratio.split(':').map(Number);
                
                if (!existingRatio || !additionalRatio) {
                    $('#splitPreview').addClass('d-none');
                    return;
                }
                
                // For bonus shares: existing + additional = total
                // 1:1 means 1 existing + 1 additional = 2 total shares
                // 1:2 means 1 existing + 2 additional = 3 total shares
                const totalSharesAfterBonus = existingRatio + additionalRatio;
                const multiplier = totalSharesAfterBonus / existingRatio;
                
                const currentSharePrice = {{ $item->share_price }};
                const currentFaceValue = {{ $item->fundamentals->face_value ?? 0 }};
                const currentTotalShares = {{ $item->fundamentals->total_shares ?? 0 }};
                const currentBasePrice = {{ $item->base_price }};
                
                // Share price gets divided by multiplier
                // Share quantity gets multiplied by multiplier
                $('#newSharePrice').text('₹' + (currentSharePrice / multiplier).toFixed(2));
                $('#newFaceValue').text('₹' + (currentFaceValue / multiplier).toFixed(2));
                $('#newTotalShares').text((currentTotalShares * multiplier).toLocaleString());
                $('#newBasePrice').text('₹' + (currentBasePrice / multiplier).toFixed(2));
                
                // Show example calculation
                $('#splitExample').html(`
                    <div class="alert alert-light-info mt-3">
                        <strong>Example:</strong> If investor has 10 shares at ₹${currentSharePrice}/share<br>
                        After ${ratio} bonus: ${10 * multiplier} shares at ₹${(currentSharePrice / multiplier).toFixed(2)}/share<br>
                        <em>Total investment value remains same: ₹${(10 * currentSharePrice).toFixed(2)}</em>
                    </div>
                `);
                
                $('#splitPreview').removeClass('d-none');
            }

            
            function applySplit() {
                $.ajax({
                    url: `/admin/company/{{ $item->id }}/apply-split`,
                    method: 'POST',
                    data: $('#splitForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON.message, 'error');
                    }
                });
            }
            
            function revertSplit() {
                $.ajax({
                    url: `/admin/company/{{ $item->id }}/revert-split`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON.message, 'error');
                    }
                });
            }
            
            function loadSplitHistory() {
                $.ajax({
                    url: `/admin/company/{{ $item->id }}/split-history`,
                    method: 'GET',
                    success: function(response) {
                        displayHistory(response.history);
                    },
                    error: function() {
                        $('#splitHistory').html('<p class="text-muted">Error loading history</p>');
                    }
                });
            }
            
            function displayHistory(history) {
                let html = '';
                
                if (!history || history.length === 0) {
                    html = `
                        <div class="text-center py-5">
                            <i class="ki-duotone ki-information-2 fs-3x text-muted mb-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <p class="text-muted">No split history found</p>
                        </div>
                    `;
                } else {
                    html = `
                        <div class="table-responsive">
                            <table class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>Split Date</th>
                                        <th>Ratio</th>
                                        <th>Before Split</th>
                                        <th>After Split</th>
                                        <th>Applied At</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    history.reverse().forEach(function(split, index) {
                        html += `
                            <tr>
                                <td>${split.split_date}</td>
                                <td><span class="badge badge-primary">${split.split_ratio}</span></td>
                                <td>₹${split.before_split.share_price}</td>
                                <td>₹${split.after_split.share_price}</td>
                                <td>${new Date(split.applied_at).toLocaleString()}</td>
                            </tr>
                        `;
                    });
                    
                    html += '</tbody></table></div>';
                }
                
                $('#splitHistory').html(html);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    @endpush
</x-default-layout>