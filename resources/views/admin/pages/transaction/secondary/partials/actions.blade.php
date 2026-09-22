
<div class="card-toolbar">
    <button type="button"
        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary show menu-dropdown"
        data-kt-menu-trigger="click"
        data-kt-menu-placement="bottom-end">
        <i class="ki-duotone ki-category fs-6"><span
            class="path1"></span><span class="path2"></span><span
            class="path3"></span><span class="path4"></span></i>
    </button>

<!-- Dropdown Menu -->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
        data-kt-menu="true">
        
        <!-- Download Documents Header -->
        <div class="menu-item px-3">
            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                Download Documents
            </div>
        </div>
        <div class="separator mb-3 opacity-75"></div>

        <!-- Document Download Links -->
        @if ($transaction->sh4_document)
            <div class="menu-item px-3">
                <a href="{{ route('download.web', ['path' => $transaction->sh4_document->signed_path, 'name' => $transaction->sh4_document->display_name]) }}"
                    class="menu-link px-3">
                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> SS4
                </a>
            </div>
        @endif
        @if ($transaction->share_transfer_receipt)
            <div class="menu-item px-3">
                <a href="{{ route('download.web', ['path' => $transaction->share_transfer_receipt->signed_path, 'name' => $transaction->share_transfer_receipt->display_name]) }}"
                    class="menu-link px-3">
                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> Share Transfer Receipt
                </a>
            </div>
        @endif
        @if ($transaction->payment_receipt)
            <div class="menu-item px-3">
                <a href="{{ route('download.web', ['path' => $transaction->payment_receipt->signed_path, 'name' => $transaction->payment_receipt->display_name]) }}"
                    class="menu-link px-3">
                    <span>{!! getIcon('cloud-download', 'fs-2') !!}</span> Payment Receipt
                </a>
            </div>
        @endif
        

        <div class="separator mt-3 opacity-75"></div>

        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 uploadDocumentBtn" data-transactionid="{{ $transaction->id }}">
                Upload Documents
            </a>
        </div>

        <!-- Delete Button -->
        <div class="menu-item px-3">
            <div class="menu-content px-3 py-3">
                <form action="{{ route('admin.primarytransactions.delete', ['id' => $transaction->id]) }}" method="POST"
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
