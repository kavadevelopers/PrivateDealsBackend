<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('broadcast.create') }}
    @endsection

    <div class="row g-5 g-xl-8">
        <div class="col-xl-2">
            <!--begin: Statistics Widget 6-->
            <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bold text-warning fs-5 mb-3 d-block">
                        Pending </a>
                    @php
                        $percentage = UtillsHelper::percentageCalculator($item->recipients_count, $item->pending_count);
                    @endphp
                    <div class="py-1">
                        <span class="text-gray-900 fs-1 fw-bold me-2">{{ $percentage }}%</span>

                    </div>
                    <span class="fw-semibold text-muted fs-7">
                        {{ $item->pending_count }}/{{ $item->recipients_count }} Pending</span>

                    <div class="progress h-7px bg-warning bg-opacity-50 mt-7">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-2">
            <!--begin: Statistics Widget 6-->
            <div class="card bg-light-primary card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bold text-primary fs-5 mb-3 d-block">
                        Sent </a>
                    @php
                        $percentage = UtillsHelper::percentageCalculator($item->recipients_count, $item->sent_count);
                    @endphp
                    <div class="py-1">
                        <span class="text-gray-900 fs-1 fw-bold me-2">{{ $percentage }}%</span>

                    </div>
                    <span class="fw-semibold text-muted fs-7">{{ $item->sent_count }}/{{ $item->recipients_count }}
                        Sent</span>

                    <div class="progress h-7px bg-primary bg-opacity-50 mt-7">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-2">
            <!--begin: Statistics Widget 6-->
            <div class="card bg-light-success card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bold text-success fs-5 mb-3 d-block">
                        Delivered </a>
                    @php
                        $percentage = UtillsHelper::percentageCalculator(
                            $item->recipients_count,
                            $item->delivered_count,
                        );
                    @endphp
                    <div class="py-1">
                        <span class="text-gray-900 fs-1 fw-bold me-2">{{ $percentage }}%</span>
                    </div>
                    <span
                        class="fw-semibold text-muted fs-7">{{ $item->delivered_count }}/{{ $item->recipients_count }}
                        Delivered</span>

                    <div class="progress h-7px bg-success bg-opacity-50 mt-7">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-2">
            <!--begin: Statistics Widget 6-->
            <div class="card bg-light-info card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bold text-info fs-5 mb-3 d-block">
                        Seen </a>
                    @php
                        $percentage = UtillsHelper::percentageCalculator($item->recipients_count, $item->seen_count);
                    @endphp
                    <div class="py-1">
                        <span class="text-gray-900 fs-1 fw-bold me-2">{{ $percentage }}%</span>

                    </div>
                    <span class="fw-semibold text-muted fs-7">{{ $item->seen_count }}/{{ $item->recipients_count }}
                        Seen</span>

                    <div class="progress h-7px bg-info bg-opacity-50 mt-7">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-2">
            <!--begin: Statistics Widget 6-->
            <div class="card bg-light-danger card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bold text-danger fs-5 mb-3 d-block">
                        Failed </a>
                    @php
                        $percentage = UtillsHelper::percentageCalculator($item->recipients_count, $item->failed_count);
                    @endphp
                    <div class="py-1">
                        <span class="text-gray-900 fs-1 fw-bold me-2">{{ $percentage }}%</span>

                    </div>
                    <span class="fw-semibold text-muted fs-7">{{ $item->failed_count }}/{{ $item->recipients_count }}
                        Failed</span>

                    <div class="progress h-7px bg-danger bg-opacity-50 mt-7">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $percentage }}%"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-2">
            <!--begin: Statistics Widget 6-->
            <div class="card bg-light-dark card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    <a href="#" class="card-title fw-bold text-dark fs-5 mb-3 d-block">
                        Replied </a>
                    @php
                        $percentage = UtillsHelper::percentageCalculator($item->recipients_count, $item->replied_count);
                    @endphp
                    <div class="py-1">
                        <span class="text-gray-900 fs-1 fw-bold me-2">{{ $percentage }}%</span>

                    </div>
                    <span class="fw-semibold text-muted fs-7">{{ $item->replied_count }}/{{ $item->recipients_count }}
                        Replied</span>

                    <div class="progress h-7px bg-dark bg-opacity-50 mt-7">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: {{ $percentage }}%"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pb-0">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-pending">
                        Pending </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-sent">
                        Sent </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-delivered">
                        Delivered </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-seen">
                        Seen </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-failed">
                        Failed </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-replied">
                        Replied </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-pending" role="tabpanel"
            aria-labelledby="pills-pending-tab">
            @include('admin.pages.whatsappBroadcast.child.messages', [
                'tabtitle' => 'Pending',
                'list' => $pending,
            ])
        </div>
        <div class="tab-pane fade show" id="pills-sent" role="tabpanel" aria-labelledby="pills-pending-tab">
            @include('admin.pages.whatsappBroadcast.child.messages', [
                'tabtitle' => 'Sent',
                'list' => $sent,
            ])
        </div>
        <div class="tab-pane fade show" id="pills-delivered" role="tabpanel" aria-labelledby="pills-pending-tab">
            @include('admin.pages.whatsappBroadcast.child.messages', [
                'tabtitle' => 'Delivered',
                'list' => $delivered,
            ])
        </div>
        <div class="tab-pane fade show" id="pills-seen" role="tabpanel" aria-labelledby="pills-pending-tab">
            @include('admin.pages.whatsappBroadcast.child.messages', [
                'tabtitle' => 'Seen',
                'list' => $seen,
            ])
        </div>
        <div class="tab-pane fade show" id="pills-failed" role="tabpanel" aria-labelledby="pills-pending-tab">
            @include('admin.pages.whatsappBroadcast.child.messages', [
                'tabtitle' => 'Failed',
                'list' => $failed,
            ])
        </div>
        <div class="tab-pane fade show" id="pills-replied" role="tabpanel" aria-labelledby="pills-pending-tab">
            @include('admin.pages.whatsappBroadcast.child.messages', [
                'tabtitle' => 'Replied',
                'list' => $replied,
            ])
        </div>
    </div>
</x-default-layout>
