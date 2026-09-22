<form enctype="multipart/form-data" action="{{ route('admin.primarytransactions.uploadDocument.store') }}" method="POST" class="form">
    @csrf

    <input type="hidden" name="document" value="{{ $document }}">
    <input type="hidden" name="selectedStartup" value="{{ $selectedStartup }}">
    <input type="hidden" name="selectedRound" value="{{ $selectedRound }}">
    <input type="hidden" name="selectedTransactions" value="{{ json_encode($selectedTransactions) }}">

    <div class="fv-row w-100 flex-md-root">
        <label class="required form-label">Type</label>
        <select class="form-select" wire:model.live="document">
            <option value="">-- Select Document --</option>
            @foreach ($documentTypes as $doc)
                <option value="{{ $doc->value }}">{{ $doc->value }}</option>
            @endforeach
        </select>
        @error('document') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <!-- File Upload Field -->
    <div class="fv-row w-100 flex-md-root mt-3">
        <label class="required form-label">File</label>
        <input type="file" name="file" class="form-control" accept=".pdf" required>
        @error('file') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <!-- Startup and Round Selection -->
    @if (in_array($document, $primaryDocuments))
        <div class="fv-row w-100 flex-md-root mt-3">
            <label class="required form-label">Select Startup</label>
            <select class="form-select" wire:model.live="selectedStartup">
                <option value="">-- Select Startup --</option>
                @foreach ($startups as $startup)
                    <option value="{{ $startup->id }}">{{ $startup->brand_name }}</option>
                @endforeach
            </select>
        </div>

        @if ($selectedStartup)
            <div class="fv-row w-100 flex-md-root mt-3">
                <label class="form-label">Select Round</label>
                <select class="form-select" wire:model.live="selectedRound">
                    <option value="">-- Select Round --</option>
                    @foreach ($rounds as $round)
                        <option value="{{ $round->id }}">{{ $round->name . ', ' . $round->instrument . ', ' . DateTimeHelper::viewDate($round->created_at) }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    @endif

   <!-- Transactions Table -->
   @if ($document && count($transactions) > 0)
   <div class="card card-flush py-4 mt-5" wire:key="transaction-table">
       <div class="card-header">
           <div class="card-title">
               <h2>Transaction List</h2>
           </div>
           <!-- Search Box -->
           <div class="card-toolbar">
               <div class="d-flex align-items-center position-relative">
                   <span class="svg-icon svg-icon-1 position-absolute ms-4">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                           <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                       </svg>
                   </span>
                   <input type="text" wire:model.live.debounce.50ms="search" class="form-control ps-14" placeholder="Search transactions..." />
               </div>
           </div>
       </div>
       <div class="card-body pt-0">
           <div class="table-responsive">
               <table class="table table-row-bordered gy-5 gs-7">
                   <thead>
                       <tr class="fw-semibold fs-6 text-gray-800">
                           <th class="w-25px">
                               <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    @if(in_array($document, $allowedMultipleSelection))
                                    <input type="checkbox" wire:click="toggleSelectAll"
                                        class="form-check-input checkAll"
                                        @if(count($selectedTransactions) === $transactions->count() && $transactions->count() > 0) checked @endif>
                                    @endif
                               </div>
                           </th>
                           <th>Investor</th>
                           <th>Startup</th>

                           @if(in_array($document, $secondaryDocuments))
                           <th>Seller</th>
                           @endif
                           @if(in_array($document, $secondaryDocuments) || in_array($document, $preipoDocuments))
                           <th>Startup</th>
                           @endif
                           <th>Instrument</th>
                           <th>Shares</th>
                           <th>Investment</th>
                           {{-- <th>Current Status</th> --}}
                       </tr>
                   </thead>
                   <tbody>
                       @foreach ($transactions as $item)
                           <tr>
                               <td>
                                   @if (in_array($document, $allowedMultipleSelection))
                                       <input type="checkbox" wire:model.live="selectedTransactions" value="{{ $item->id }}" class="form-check-input transactionCheckbox">
                                   @else
                                       <input type="radio" wire:model.live="selectedTransactions" value="{{ $item->id }}" class="form-check-input">
                                   @endif
                               </td>
                               <td>{{ $item->investor->name ?? 'N/A' }}</td>
                               <td>{{ $item->startup->brand_name ?? 'N/A' }} <br> {{ $item->round->name }}</td>
                               @if(in_array($document, $secondaryDocuments))
                               <td>{{ $item->seller->name ?? 'N/A' }}</td>
                               @endif
                               @if(in_array($document, $secondaryDocuments) || in_array($document, $preipoDocuments))
                               <td>{{ $item->startup->brand_name ?? 'N/A' }}</td>
                               @endif
                               <td>{{ $item->instrument }}</td>
                               <td>{{ $item->shares }}</td>
                               <td>{{ $item->investment_amount }}</td>
                               {{-- <td>{{ $item->current_status }}</td> --}}
                           </tr>
                       @endforeach
                   </tbody>
               </table>
           </div>

           <!-- Pagination Controls -->
           <div class="d-flex justify-content-between align-items-center mt-5">
               <div>
                   <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto;">
                       <option value="10">10</option>
                       <option value="25">25</option>
                       <option value="50">50</option>
                       <option value="100">100</option>
                   </select>
               </div>
               <div>
                   {{ $transactions->links() }}
               </div>
           </div>
       </div>
   </div>


@elseif ($document)
   <div class="alert alert-info mt-4">
       No transactions available for the selected document type.
   </div>
@endif

    <!-- Submit Button -->
    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary" @disabled(empty($selectedTransactions))>
            <span class="indicator-label">Upload</span>
        </button>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('input[name="file"]').addEventListener("change", function () {
        document.querySelector("button[type='submit']").disabled = !this.files.length;
    });
});
</script>