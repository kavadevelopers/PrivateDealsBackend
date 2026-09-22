{{--
<!--begin::Chart widget 8-->
<div class="card card-flush h-xl-100">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Performance Overview</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-6">Users from all channels</span>
        </h3>
        <!--end::Title-->
        <!--begin::Toolbar-->
        <div class="card-toolbar">
            <ul class="nav" id="kt_chart_widget_8_tabs">
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1"
                        data-bs-toggle="tab" id="kt_chart_widget_8_week_toggle"
                        href="#kt_chart_widget_8_week_tab">Month</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active"
                        data-bs-toggle="tab" id="kt_chart_widget_8_month_toggle"
                        href="#kt_chart_widget_8_month_tab">Week</a>
                </li>
            </ul>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-6">
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <div class="tab-pane fade" id="kt_chart_widget_8_week_tab" role="tabpanel">
                <!--begin::Statistics-->
                <div class="mb-5">
                    <!--begin::Statistics-->
                    <div class="d-flex align-items-center mb-2">
                        <span class="fs-1 fw-semibold text-gray-500 me-1 mt-n1">$</span>
                        <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">18,89</span>
                        <span class="badge badge-light-success fs-base">{!! getIcon('arrow-up', 'fs-5 text-success
                            ms-n1') !!} 4,8%</span>
                    </div>
                    <!--end::Statistics-->

                    <span class="fs-6 fw-semibold text-gray-500">Avarage cost per interaction</span>

                </div>
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="kt_chart_widget_8_week_chart" class="ms-n5 min-h-auto" style="height: 275px"></div>
                <!--end::Chart-->
                <!--begin::Items-->
                <div class="d-flex flex-wrap pt-5">
                    <!--begin::Item-->
                    <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-3 mb-sm-6">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Social Campaigns</span>

                        </div>
                        <!--ed::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-&lt;gray-600 fs-6">Google Ads</span>

                        </div>
                        <!--ed::Item-->
                    </div>
                    <!--ed::Item-->
                    <!--begin::Item-->
                    <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-3 mb-sm-6">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Email Newsletter</span>

                        </div>
                        <!--ed::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-warning me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Courses</span>

                        </div>
                        <!--ed::Item-->
                    </div>
                    <!--ed::Item-->
                    <!--begin::Item-->
                    <div class="d-flex flex-column pt-sm-3 pt-6">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-3 mb-sm-6">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-info me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">TV Campaign</span>

                        </div>
                        <!--ed::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Radio</span>

                        </div>
                        <!--ed::Item-->
                    </div>
                    <!--ed::Item-->
                </div>
                <!--ed::Items-->
            </div>
            <!--end::Tab pane-->
            <!--begin::Tab pane-->
            <div class="tab-pane fade active show" id="kt_chart_widget_8_month_tab" role="tabpanel">
                <!--begin::Statistics-->
                <div class="mb-5">
                    <!--begin::Statistics-->
                    <div class="d-flex align-items-center mb-2">
                        <span class="fs-1 fw-semibold text-gray-500 me-1 mt-n1">$</span>
                        <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">8,55</span>
                        <span class="badge badge-light-success fs-base">{!! getIcon('arrow-up', 'fs-5 text-success
                            ms-n1') !!} 2.2%</span>
                    </div>
                    <!--end::Statistics-->

                    <span class="fs-6 fw-semibold text-gray-500">Avarage cost per interaction</span>

                </div>
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="kt_chart_widget_8_month_chart" class="ms-n5 min-h-auto" style="height: 275px"></div>
                <!--end::Chart-->
                <!--begin::Items-->
                <div class="d-flex flex-wrap pt-5">
                    <!--begin::Item-->
                    <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-3 mb-sm-6">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Social Campaigns</span>

                        </div>
                        <!--ed::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Google Ads</span>

                        </div>
                        <!--ed::Item-->
                    </div>
                    <!--ed::Item-->
                    <!--begin::Item-->
                    <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-3 mb-sm-6">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Email Newsletter</span>

                        </div>
                        <!--ed::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-warning me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Courses</span>

                        </div>
                        <!--ed::Item-->
                    </div>
                    <!--ed::Item-->
                    <!--begin::Item-->
                    <div class="d-flex flex-column pt-sm-3 pt-6">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-3 mb-sm-6">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-info me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">TV Campaign</span>

                        </div>
                        <!--ed::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                            <!--end::Bullet-->

                            <span class="fw-bold text-gray-600 fs-6">Radio</span>

                        </div>
                        <!--ed::Item-->
                    </div>
                    <!--ed::Item-->
                </div>
                <!--ed::Items-->
            </div>
            <!--end::Tab pane-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Body-->
</div>
<!--end::Chart widget 8--> --}}




{{-- Performance Overview Widget --}}
{{-- <div style="margin-top: 3rem;"></div> --}}

<div class="row gx-5 gx-xl-10">
    <div class="col-xxl-12 mb-5 mb-xl-10">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Performance Overview</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Investments by Type</span>
                </h3>
            </div>
            <div class="card-body pt-6">
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-2">
                        <span class="fs-1 fw-semibold text-gray-500 me-1 mt-n1">₹</span>
                        <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">
                            {{ number_format($chartData['totalThisMonth'] ?? 0) }}
                        </span>
                        <span class="badge badge-light-success fs-base">
                            {!! getIcon('arrow-up', 'fs-5 text-success ms-n1') !!}
                            {{ $chartData['growth'] ?? 0 }}%
                        </span>
                    </div>
                    <span class="fs-6 fw-semibold text-gray-500">Total Investments This Month</span>
                </div>

                <canvas id="investmentChart" style="height: 300px; width: 100%;"></canvas>

                <div class="d-flex flex-wrap pt-5 gap-4">
                    <div class="d-flex align-items-center">
                        <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
                        <span class="fw-bold text-gray-600 fs-6">Primary</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
                        <span class="fw-bold text-gray-600 fs-6">Secondary</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="bullet bullet-dot bg-purple me-2 h-10px w-10px"></span>
                        <span class="fw-bold text-gray-600 fs-6">Pre-IPO</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Include Chart.js CDN if not already in layout --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('investmentChart').getContext('2d');

    const labels = {!! json_encode($chartData['labels']) !!};
    const primary = {!! json_encode($chartData['series'][0]['data']) !!};
    const secondary = {!! json_encode($chartData['series'][1]['data']) !!};
    const preipo = {!! json_encode($chartData['series'][2]['data']) !!};

    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Primary',
                data: primary,
                borderColor: 'rgba(13, 110, 253, 1)',
                backgroundColor: 'rgba(13, 110, 253, 0.2)',
                tension: 0.3,
                fill: true,
            },
            {
                label: 'Secondary',
                data: secondary,
                borderColor: 'rgba(220, 53, 69, 1)',
                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                tension: 0.3,
                fill: true,
            },
            {
                label: 'Pre-IPO',
                data: preipo,
                borderColor: 'rgba(162, 89, 219, 1)',
                backgroundColor: 'rgba(162, 89, 219, 0.2)',
                tension: 0.3,
                fill: true,
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false,
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ₹${context.formattedValue}`;
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        },
    };

    new Chart(ctx, config);
</script>