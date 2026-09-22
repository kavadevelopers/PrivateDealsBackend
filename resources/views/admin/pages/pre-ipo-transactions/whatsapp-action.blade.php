<!DOCTYPE html>
<html>

<head>
    <title>Pre-IPO Transaction Action</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5" style="max-width: 600px">

        @if(session('success'))
        <div class="alert alert-warning">{{ session('success') }}</div>
        @elseif(isset($transaction))
        <div class="card shadow-sm">
            <div class="card-header bg-{{ $action === 'admin_accept_tran' ? 'success' : 'danger' }} text-white">
                <h5 class="mb-0">{{ $action === 'admin_accept_tran' ? '✅ Approve Transaction' : '❌ Cancel Transaction'
                    }}</h5>
            </div>
            <div class="card-body">

                {{-- Transaction Info --}}
                <table class="table table-sm table-bordered mb-4">
                    <tr>
                        <td>Id</td>
                        <td><strong>{{ $transaction->transaction_invoice_no }}</strong></td>
                    </tr>
                    <tr>
                        <td>Investor</td>
                        <td>{{ $transaction->investor->name }}</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>{{ $transaction->investor->mobile_number }}</td>
                    </tr>
                    <tr>
                        <td>Company</td>
                        <td>{{ $transaction->company->brand_name }}</td>
                    </tr>
                    <tr>
                        <td>Shares</td>
                        <td>{{ $transaction->shares }}</td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td>₹{{ number_format($transaction->investment_amount, 2) }}</td>
                    </tr>
                </table>

                <form id="action-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="transaction" value="{{ $transaction->id }}">
                    <input type="hidden" name="temptoken" value="{{ $token }}">
                    <input type="hidden" name="status"
                        value="{{ $action === 'admin_accept_tran' ? 'approve' : 'reject' }}">

                    @if ($action === 'admin_accept_tran')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Seller <span class="text-danger">*</span></label>
                        <select class="form-select" name="seller" required>
                            <option value="">-- Select Seller --</option>
                            @foreach ($sellers as $seller)
                            <option value="{{ $seller->id }}">{{ ucfirst($seller->company_name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="3"
                            placeholder="Enter notes if any"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Confirmation File</label> {{-- removed * --}}
                        <input type="file" name="confirmation_file" class="form-control"> {{-- removed required --}}
                    </div>

                    <div id="response-msg"></div>

                    <button type="submit" id="submit-btn"
                        class="btn btn-{{ $action === 'admin_accept_tran' ? 'success' : 'danger' }} w-100">
                        {{ $action === 'admin_accept_tran' ? 'Approve Deal' : 'Cancel Transaction' }}
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="alert alert-danger">Something went wrong. Please try again.</div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('action-form')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const btn = document.getElementById('submit-btn');
    const msg = document.getElementById('response-msg');

    btn.disabled = true;
    btn.innerText = 'Processing...';

    axios.post("{{ route('admin.preipotransaction.approve') }}", new FormData(this))
        .then(function (response) {
            if (response.data.status) {
                msg.innerHTML = `<div class="alert alert-success">${response.data.message}</div>`;
                
                btn.disabled = true;
                btn.innerText = 'Redirecting...';

                setTimeout(() => {
                    window.location.href = "{{ route('admin.preipotransaction.market') }}";
                }, 500);

            } else {
                msg.innerHTML = `<div class="alert alert-danger">${response.data.message}</div>`;
                
                btn.disabled = false;
                btn.innerText = '{{ $action === "admin_accept_tran" ? "Approve Deal" : "Cancel Transaction" }}';
            }
        })
        .catch(function (error) {
            msg.innerHTML = `<div class="alert alert-danger">Something went wrong. Please try again.</div>`;
            
            btn.disabled = false;
            btn.innerText = '{{ $action === "admin_accept_tran" ? "Approve Deal" : "Cancel Transaction" }}';
        });
});
    </script>
</body>

</html>