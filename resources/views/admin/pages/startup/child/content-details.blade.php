<div class="card mb-5 mb-xl-10">

    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Basic Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">One Liner</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $startup->cms->one_liner ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Website</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $startup->cms->website ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Highlights</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $startup->cms->highlights ?? 'N/A' }}</span>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10">
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Idea</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <p>
                {!! $startup->cms->idea ?? 'N/A' !!}
            </p>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10">
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Key Information</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <p>
                {!! $startup->cms->key_information ?? 'N/A' !!}
            </p>
        </div>
    </div>
</div>
