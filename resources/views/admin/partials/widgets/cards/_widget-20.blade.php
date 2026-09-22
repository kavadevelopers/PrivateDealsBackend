{{--
<!--begin::Card widget 20-->
<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
    style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <div class="card-title d-flex flex-column">
            <!--begin::Amount-->
            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">69</span>
            <!--end::Amount-->
            <!--begin::Subtitle-->
            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Projects</span>
            <!--end::Subtitle-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Header-->

    <div class="card-body d-flex align-items-end pt-0">
        <!--begin::Progress-->
        <div class="d-flex align-items-center flex-column mt-3 w-100">
            <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                <span>43 Pending</span>
                <span>72%</span>
            </div>
            <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <!--end::Progress-->
    </div>

</div>
<!--end::Card widget 20--> --}}



<!--begin::Card widget 20-->
<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
    style="background-color: #F1416C; background-image: url('{{ asset('assets/media/patterns/vector-1.png') }}')">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <div class="card-title d-flex flex-column">
            <!--begin::Amount-->
            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">
                ₹{{ number_format($current_month_total, 0) }}
            </span>
            <!--end::Amount-->
            <!--begin::Subtitle-->
            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">
                Current Month Total
            </span>
            <!--end::Subtitle-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body d-flex align-items-end pt-0">
        <div class="d-flex align-items-center flex-column mt-3 w-100">
            <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                <span>Progress</span>
                <span>{{ $progress }}%</span>
            </div>
            <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                <div class="bg-white rounded h-8px" role="progressbar"
                    style="width: {{ max(0, min($progress, 100)) }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!--end::Body-->
</div>
<!--end::Card widget 20-->