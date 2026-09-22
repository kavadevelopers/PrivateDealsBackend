<div class="card-toolbar">

    <button type="button" class="btn btn-sm btn-icon btn-secondary btn-active-light-primary"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">

        <i class="ki-duotone ki-category fs-6">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
        </i>

    </button>

    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">

        <div class="menu-item px-3">
            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                Action
            </div>
        </div>

        <div class="separator mb-3 opacity-75"></div>

        <div class="menu-item px-3">
            <a href="{{ asset($row->document) }}" target="_blank" class="menu-link px-3">
                View Document
            </a>
        </div>

        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 manual-kyc-btn" data-investor="{{ $row->investor_id }}">
                Manual KYC
            </a>
        </div>

    </div>
</div>