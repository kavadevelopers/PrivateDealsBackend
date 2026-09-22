{{--
<!--begin::Card widget 18-->
<div class="card card-flush h-xl-100">
    <!--begin::Body-->
    <div class="card-body py-9">

        <div class="row gx-9 h-100">
            <!--begin::Col-->
            <div class="col-sm-6 mb-10 mb-sm-0">
                <!--begin::Image-->
                <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-400px min-h-sm-100 h-100"
                    style="background-size: 100% 100%;background-image:url('assets/media/stock/600x600/img-65.jpg')">
                </div>
                <!--end::Image-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column h-100">
                    <!--begin::Header-->
                    <div class="mb-7">
                        <!--begin::Headin-->
                        <div class="d-flex flex-stack mb-6">
                            <!--begin::Title-->
                            <div class="flex-shrink-0 me-5">
                                <span class="text-gray-500 fs-7 fw-bold me-2 d-block lh-1 pb-1">Featured</span>
                                <span class="text-gray-800 fs-1 fw-bold">9 Degree</span>
                            </div>
                            <!--end::Title-->
                            <span class="badge badge-light-primary flex-shrink-0 align-self-center py-3 px-4 fs-7">In
                                Process</span>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Items-->
                        <div class="d-flex align-items-center flex-wrap d-grid gap-2">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center me-5 me-xl-13">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px symbol-circle me-3">
                                    <img src="{{ image('avatars/300-3.jpg') }}" class="" alt="" />
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Info-->
                                <div class="m-0">
                                    <span class="fw-semibold text-gray-500 d-block fs-8">Manager</span>
                                    <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-7">Robert
                                        Fox</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px symbol-circle me-3">
                                    <span class="symbol-label bg-success">{!! getIcon('abstract-41', 'fs-5 text-white')
                                        !!}</span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Info-->
                                <div class="m-0">
                                    <span class="fw-semibold text-gray-500 d-block fs-8">Budget</span>
                                    <span class="fw-bold text-gray-800 fs-7">$64.800</span>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="mb-6">
                        <!--begin::Text-->
                        <span class="fw-semibold text-gray-600 fs-6 mb-8 d-block">Flat cartoony illustrations with vivid
                            unblended colors and asymmetrical beautiful purple hair lady</span>
                        <!--end::Text-->
                        <!--begin::Stats-->
                        <div class="d-flex">
                            <!--begin::Stat-->
                            <div
                                class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 me-6 mb-3">
                                <!--begin::Date-->
                                <span class="fs-6 text-gray-700 fw-bold">Feb 6, 2021</span>
                                <!--end::Date-->

                                <div class="fw-semibold text-gray-500">Due Date</div>

                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 mb-3">
                                <!--begin::Number-->
                                <span class="fs-6 text-gray-700 fw-bold">$
                                    <span class="ms-n1" data-kt-countup="true"
                                        data-kt-countup-value="284,900.00">0</span></span>
                                <!--end::Number-->

                                <div class="fw-semibold text-gray-500">Budget</div>

                            </div>
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="d-flex flex-stack mt-auto bd-highlight">
                        <!--begin::Users group-->
                        <div class="symbol-group symbol-hover flex-nowrap">
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
                                <img alt="Pic" src="{{ image('avatars/300-2.jpg') }}" />
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                title="Michael Eberon">
                                <img alt="Pic" src="{{ image('avatars/300-3.jpg') }}" />
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                title="Susan Redwood">
                                <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                            </div>
                        </div>
                        <!--end::Users group-->
                        <!--begin::Actions-->
                        <a href="#"
                            class="d-flex align-items-center text-primary opacity-75-hover fs-6 fw-semibold">View
                            Project {!! getIcon('exit-right-corner', 'fs-4 ms-1') !!}</a>
                        <!--end::Actions-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Body-->
</div>
<!--end::Card widget 18--> --}}

<div class="col-xxl-6">
    <div class="card card-flush h-xl-100">
        <div class="card-header pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800">Recent Platform Activity</span>
                <span class="text-gray-500 mt-1 fw-semibold fs-6">Today & This Week</span>
            </h3>
        </div>
        <div class="card-body pt-6">
            {{-- Recent Activity Feed --}}
            <h5 class="mb-3">Latest Actions</h5>
            <ul class="list-unstyled mb-5">
                @if(isset($primary_made_today) && $primary_made_today > 0)
                <li>
                    <span class="badge bg-primary me-2">Primary</span>
                    New investment of ₹{{ number_format($primary_made_today, 2) }} made today
                </li>
                @endif
                @if(isset($secondary_made_today) && $secondary_made_today > 0)
                <li>
                    <span class="badge bg-danger me-2">Secondary</span>
                    New investment of ₹{{ number_format($secondary_made_today, 2) }} made today
                </li>
                @endif
                @if(isset($preipo_made_today) && $preipo_made_today > 0)
                <li>
                    <span class="badge bg-purple me-2">Pre-IPO</span>
                    New investment of ₹{{ number_format($preipo_made_today, 2) }} made today
                </li>
                @endif
                @if(isset($request_access_today) && $request_access_today)
                <li>
                    <span class="badge bg-warning me-2 text-dark">Investor</span>
                    New registration request received today
                </li>
                @endif
                @if(isset($pre_request_access_today) && $pre_request_access_today)
                <li>
                    <span class="badge bg-info me-2 text-dark">Pre-IPO</span>
                    Pre-IPO access requested today
                </li>
                @endif
                @if(!empty($active_investors_today_names) && is_array($active_investors_today_names))
                <li>
                    <span class="badge bg-success me-2">Hero</span>
                    Today's Active Investors:
                    @foreach ($active_investors_today_names as $name)
                    <span class="badge bg-light text-dark border me-1">{{ $name }}</span>
                    @endforeach
                </li>
                @endif
                @if(empty($primary_made_today) && empty($secondary_made_today) && empty($preipo_made_today) &&
                empty($request_access_today) && empty($pre_request_access_today) &&
                empty($active_investors_today_names))
                <li><span class="text-muted">No major events recorded today</span></li>
                @endif
            </ul>

            <hr>

            {{-- Investment Breakdown Table --}}
            <h5 class="mb-3">Investment Breakdown</h5>
            <table class="table align-middle table-row-dashed table-hover">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Today</th>
                        <th>All Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="text-primary">Primary</span></td>
                        <td>₹{{ number_format($primary_made_today ?? 0, 2) }}</td>
                        <td>₹{{ number_format($primary_total ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><span class="text-danger">Secondary</span></td>
                        <td>₹{{ number_format($secondary_made_today ?? 0, 2) }}</td>
                        <td>₹{{ number_format($secondary_total ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><span class="text-purple">Pre-IPO</span></td>
                        <td>₹{{ number_format($preipo_made_today ?? 0, 2) }}</td>
                        <td>₹{{ number_format($preipo_total ?? 0, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>