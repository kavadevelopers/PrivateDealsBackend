<div class="card-toolbar">
    <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary show menu-dropdown"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        <i class="ki-duotone ki-category fs-6"><span class="path1"></span><span class="path2"></span><span
                class="path3"></span><span class="path4"></span></i>
    </button>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
        data-kt-menu="true" data-popper-placement="bottom-end">
        <div class="menu-item px-3">
            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                Action
            </div>
        </div>
        <div class="separator mb-3 opacity-75"></div>

        @if ($transaction->status == 1)
        <div class="menu-item px-3">
            <a href="#" onclick="retrieveTransaction({{ $transaction->id }}); return false;" class="menu-link px-3"
                title="Retrieve this cancelled transaction">
                <span>{!! getIcon('arrows-repeat', 'fs-2') !!}</span> Retrieve Transaction
            </a>
        </div>
        <div class="separator my-3 opacity-75"></div>
        @endif

        @if ($transaction->status == 3 || $transaction->status == 4)
        <div class="menu-item px-3">
            <a onclick="return confirm('Are you sure?')"
                href="{{ route('admin.preipotransaction.status', ['transaction_id' => $transaction->id]) }}"
                class="menu-link px-3">
                <span>{!! getIcon('arrows-loop', 'fs-2') !!}</span>
                {{ $transaction->status == 3 ? 'Amount Transferred' : 'Shares Transferred' }}
            </a>
        </div>
        @endif

        @if ($transaction->status == 2)
        <div class="menu-item px-3">
            <a onclick="return confirm('Are you sure?')"
                href="{{ route('admin.preipotransaction.slipStatus', ['transaction_id' => $transaction->id]) }}"
                class="menu-link px-3">
                <span>{!! getIcon('arrows-loop', 'fs-2') !!}</span> Deal Slip Status
            </a>
        </div>
        {{-- Add Resend Deal Slip option for status 2 (Deal Slip sent but not signed) --}}
        <div class="menu-item px-3">
            <a onclick="return confirm('Are you sure you want to resend the deal slip?')"
                href="{{ route('admin.preipotransaction.resendDealSlip', ['transaction_id' => $transaction->id]) }}"
                class="menu-link px-3">
                <span>{!! getIcon('send', 'fs-2') !!}</span> Resend Deal Slip
            </a>
        </div>
        @endif

        <div class="menu-item px-3">
            <a href="#" onclick="downloadDealSlipPDF({{ $transaction->id }}); return false;"
                class="menu-link px-3 deal-slip-download-btn" data-transaction-id="{{ $transaction->id }}">
                <span class="download-icon">{!! getIcon('cloud-download', 'fs-2') !!}</span>
                <span class="loading-icon d-none">
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                </span>
                <span class="download-text">Download Deal Slip PDF</span>
            </a>
        </div>

        @if ($transaction->deal_slip && $transaction->deal_slip->status == '1' )
        <div class="menu-item px-3">
            <a href="{{ route('download.web', ['path' => $transaction->deal_slip->signed_path, 'name' => $transaction->deal_slip->display_name]) }}"
                class="menu-link px-3">
                <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> Deal Slip
            </a>
        </div>
        @endif

        @if ($transaction->approval_file)
        <div class="menu-item px-3">
            <a href="{{ route('download.web', ['path' => $transaction->approval_file->signed_path, 'name' => $transaction->approval_file->display_name]) }}"
                class="menu-link px-3">
                <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> Approval File
            </a>
        </div>
        @endif

        @if ($transaction->rejection_file)
        <div class="menu-item px-3">
            <a href="{{ route('download.web', ['path' => $transaction->rejection_file->signed_path, 'name' => $transaction->rejection_file->display_name]) }}"
                class="menu-link px-3">
                <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> Rejection File
            </a>
        </div>
        @endif

        <div class="separator mt-3 opacity-75"></div>

        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 uploadDocumentBtn" data-transactionid="{{ $transaction->id }}">
                Upload Documents
            </a>
        </div>

        <div class="menu-item px-3">
            <div class="menu-content px-3 py-3">
                <form action="{{ route('admin.preipotransaction.delete', ['id' => $transaction->id]) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-3">
                        <i class="fas fa-trash fs-6"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>