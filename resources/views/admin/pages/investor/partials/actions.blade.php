<div class="card-toolbar">
    <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
            <a href="{{ route('admin.investor.view', ['uuid' => $row->uuid]) }}" class="menu-link px-3">
                View
            </a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('admin.investor.edit', ['uuid' => $row->uuid]) }}" class="menu-link px-3">
                Edit
            </a>
        </div>
        {{-- @if (!$row->kyc_status)
        <div class="menu-item px-3">
            <a href="{{ route('admin.investor.manual-kyc.create', ['uuid' => $row->uuid]) }}" class="menu-link px-3">
                Complete KYC
            </a>
        </div>
        @endif
        @if (!$row->aif_status)
        <div class="menu-item px-3">
            <a href="{{ route('admin.investor.manual-aif.create', ['uuid' => $row->uuid]) }}" class="menu-link px-3">
                Complete AIF
            </a>
        </div>
        @endif --}}

        @if (Auth::guard('admin')->user()->role == 'admin')
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 edit-manager" data-investor="{{ $row->id }}"
                data-manager="{{ $row->created_by }}">
                Manager
            </a>
        </div>
        @endif
        <div class="menu-item px-3">
            <a href="{{ route('admin.investor.mark-demo', ['uuid' => $row->uuid]) }}" class="menu-link px-3"
                onclick="return confirm('Are you sure?')">
                {{ $row->is_demo ? 'Mark as Live' : 'Mark as Demo' }}
            </a>
        </div>
        {{-- @if (Auth::guard('admin')->user()->role == 'admin')
        <div class="menu-item px-3">
            <a href="{{ route('admin.investor.markBlock', ['uuid' => $row->uuid]) }}" class="menu-link px-3"
                onclick="return confirm('Are you sure?')">
                {{ $row->is_blocked ? 'Unblock' : 'Block' }}
            </a>
        </div>
        @endif --}}
        <div class="separator mt-3 opacity-75"></div>
        <div class="menu-item px-3">
            <div class="menu-content px-3 py-3 text-center">
                <a href="#" class="btn btn-danger hover-elevate-up btn-sm px-4 deleteInvestor"
                    data-uuid="{{ $row->id }}">
                    <i class="fas fa-trash fs-6"></i> Delete
                </a>
            </div>
        </div>
    </div>
</div>