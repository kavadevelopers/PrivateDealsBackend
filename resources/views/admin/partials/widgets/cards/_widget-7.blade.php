{{--
<!--begin::Card widget 7-->
<div class="card card-flush h-md-50 mb-5 mb-xl-10">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <div class="card-title d-flex flex-column">
            <!--begin::Amount-->
            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">357</span>
            <!--end::Amount-->
            <!--begin::Subtitle-->
            <span class="text-gray-500 pt-1 fw-semibold fs-6">Professionals</span>
            <!--end::Subtitle-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Header-->

    <div class="card-body d-flex flex-column justify-content-end pe-0">
        <!--begin::Title-->
        <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Today’s Heroes</span>
        <!--end::Title-->
        <!--begin::Users group-->
        <div class="symbol-group symbol-hover flex-nowrap">
            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
            </div>
            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
                <img alt="Pic" src="{{ image('avatars/300-11.jpg') }}" />
            </div>
            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
            </div>
            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
                <img alt="Pic" src="{{ image('avatars/300-2.jpg') }}" />
            </div>
            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
                <span class="symbol-label bg-danger text-inverse-danger fw-bold">P</span>
            </div>
            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Barry Walter">
                <img alt="Pic" src="{{ image('avatars/300-12.jpg') }}" />
            </div>
            <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                data-bs-target="#kt_modal_view_users">
                <span class="symbol-label bg-dark text-gray-300 fs-8 fw-bold">+42</span>
            </a>
        </div>
        <!--end::Users group-->
    </div>

</div>
<!--end::Card widget 7--> --}}



<div class="card card-flush h-md-50 mb-5 mb-xl-10">
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $active_user_today }}</span>
            <span class="text-gray-500 pt-1 fw-semibold fs-6">Today's Active Users</span>
        </div>
    </div>
    <div class="card-body d-flex flex-column justify-content-end pe-0">
        <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Today's Heroes</span>
        <div class="d-flex flex-wrap gap-2 w-100" style="overflow:hidden;">
            @foreach ($active_investors_today_names as $user)
            <span class="badge bg-primary text-white fs-7 fw-semibold px-3 py-2 rounded-pill"
                style="white-space:nowrap; max-width: 150px; text-overflow:ellipsis; overflow:hidden;">
                {{ $user['name'] }}
            </span>
            @endforeach
        </div>
    </div>
</div>