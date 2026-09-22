<!--begin::Step 3-->
<div data-kt-stepper-element="content">
    <div class="w-100">

        <div class="fv-row mb-10">

            <label class="required fs-5 fw-semibold mb-2">Database Name</label>

            <!--begin::Input-->
            <input type="text" class="form-control form-control-lg form-control-solid" name="dbname" placeholder=""
                value="master_db" />
            <!--end::Input-->
        </div>


        <div class="fv-row">

            <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                <span class="required">Select Database Engine</span>
                <span class="ms-1" data-bs-toggle="tooltip" title="Select your app database engine"></span>
            </label>

            <!--begin:Option-->
            <label class="d-flex flex-stack cursor-pointer mb-5">

                <span class="d-flex align-items-center me-2">
                    <!--begin::Icon-->
                    <span class="symbol symbol-50px me-6">
                        <span class="symbol-label bg-light-success">
                            <i class="fas fa-database text-success fs-2x"></i>
                        </span>
                    </span>
                    <!--end::Icon-->
                    <!--begin::Info-->
                    <span class="d-flex flex-column">
                        <span class="fw-bold fs-6">MySQL</span>
                        <span class="fs-7 text-muted">Basic MySQL database</span>
                    </span>
                    <!--end::Info-->
                </span>

                <!--begin::Input-->
                <span class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" name="dbengine" checked="checked" value="1" />
                </span>
                <!--end::Input-->
            </label>
            <!--end::Option-->
            <!--begin:Option-->
            <label class="d-flex flex-stack cursor-pointer mb-5">

                <span class="d-flex align-items-center me-2">
                    <!--begin::Icon-->
                    <span class="symbol symbol-50px me-6">
                        <span class="symbol-label bg-light-danger">
                            <i class="fab fa-google text-danger fs-2x"></i>
                        </span>
                    </span>
                    <!--end::Icon-->
                    <!--begin::Info-->
                    <span class="d-flex flex-column">
                        <span class="fw-bold fs-6">Firebase</span>
                        <span class="fs-7 text-muted">Google based app data management</span>
                    </span>
                    <!--end::Info-->
                </span>

                <!--begin::Input-->
                <span class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" name="dbengine" value="2" />
                </span>
                <!--end::Input-->
            </label>
            <!--end::Option-->
            <!--begin:Option-->
            <label class="d-flex flex-stack cursor-pointer">

                <span class="d-flex align-items-center me-2">
                    <!--begin::Icon-->
                    <span class="symbol symbol-50px me-6">
                        <span class="symbol-label bg-light-warning">
                            <i class="fab fa-amazon text-warning fs-2x"></i>
                        </span>
                    </span>
                    <!--end::Icon-->
                    <!--begin::Info-->
                    <span class="d-flex flex-column">
                        <span class="fw-bold fs-6">DynamoDB</span>
                        <span class="fs-7 text-muted">Amazon Fast NoSQL Database</span>
                    </span>
                    <!--end::Info-->
                </span>

                <!--begin::Input-->
                <span class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" name="dbengine" value="3" />
                </span>
                <!--end::Input-->
            </label>
            <!--end::Option-->
        </div>

    </div>
</div>
<!--end::Step 3-->
