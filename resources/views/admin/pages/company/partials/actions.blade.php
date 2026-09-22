<div class="card-toolbar">
    <button type="button"
        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
        data-kt-menu-trigger="click"
        data-kt-menu-placement="bottom-end">
        <i class="ki-duotone ki-category fs-6">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
        </i>
    </button>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
        data-kt-menu="true">
        <div class="menu-item px-3">
            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Action</div>
        </div>
        <div class="separator mb-3 opacity-75"></div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.company.view', ['uuid' => $company->uuid]) }}" class="menu-link px-3">View</a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.company.edit', ['uuid' => $company->uuid]) }}" class="menu-link px-3">Edit Details</a>
        </div>
        @if (($company->approval_status ?? 'approved') === 'pending')
            <div class="menu-item px-3">
                <form method="POST" action="{{ route('admin.company.approveSeller', ['uuid' => $company->uuid]) }}">
                    @csrf
                    <button type="submit" class="menu-link px-3 border-0 bg-transparent w-100 text-start"
                        onclick="return confirm('Approve this company?')">Approve</button>
                </form>
            </div>
            <div class="menu-item px-3">
                <form method="POST" action="{{ route('admin.company.rejectSeller', ['uuid' => $company->uuid]) }}">
                    @csrf
                    <button type="submit" class="menu-link px-3 border-0 bg-transparent w-100 text-start text-danger"
                        onclick="return confirm('Reject this company?')">Reject</button>
                </form>
            </div>
        @endif
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 js-share-price-modal"
                data-uuid="{{ $company->uuid }}"
                data-name="{{ $company->brand_name }}">Share Prices</a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.company.shareHolders', ['uuid' => $company->uuid]) }}" class="menu-link px-3">Edit Share Holders</a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.company.promoter', ['uuid' => $company->uuid]) }}" class="menu-link px-3">Edit Promoter</a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.company.event', ['uuid' => $company->uuid]) }}" class="menu-link px-3">Edit Events</a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.company.peerRatio', ['uuid' => $company->uuid]) }}" class="menu-link px-3">Edit Peer Ratio</a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.company.customData', ['uuid' => $company->uuid]) }}" class="menu-link px-3">Edit Custom Data</a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.company.news', ['uuid' => $company->uuid]) }}" class="menu-link px-3">Edit News</a>
        </div>
        <div class="separator mt-3 opacity-75"></div>
        <div class="menu-item px-3">
            <div class="menu-content px-3 py-3">
                <a href="{{ route('admin.company.delete', ['uuid' => $company->uuid]) }}"
                    class="btn btn-danger btn-sm px-4"
                    onclick="return confirm('Are you sure ?')">
                    <i class="fas fa-trash fs-6"></i> Delete
                </a>
            </div>
        </div>
    </div>
</div>
