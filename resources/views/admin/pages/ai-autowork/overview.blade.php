<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    <div class="d-flex flex-column gap-6">
        <div class="card card-flush">
            <div class="card-header">
                <div class="card-title">
                    <h2>AI AutoWork</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <p class="text-muted">Autonomous AI jobs land in staging first. Admins review and approve before master data changes.</p>
                <div class="row g-5">
                    <div class="col-md-6">
                        <div class="border rounded p-6 h-100">
                            <h3 class="mb-2">Company Ingest</h3>
                            <p class="text-muted mb-4">AI posts company + related data into temp staging.</p>
                            <div class="mb-4">
                                <span class="badge badge-light-warning">Pending: {{ $pendingCompanies }}</span>
                            </div>
                            <a href="{{ route('admin.ai-autowork.company-ingest.inbox') }}" class="btn btn-sm btn-primary me-2">Open Inbox</a>
                            <a href="{{ route('admin.ai-autowork.company-ingest.guide') }}" class="btn btn-sm btn-light">AI Guide</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-6 h-100">
                            <h3 class="mb-2">Share Prices</h3>
                            <p class="text-muted mb-4">Future job — not available yet.</p>
                            <span class="badge badge-light mb-4">Coming soon</span>
                            <div>
                                <a href="{{ route('admin.ai-autowork.share-prices.stub') }}" class="btn btn-sm btn-light me-2">Stub</a>
                                <a href="{{ route('admin.ai-autowork.share-prices.guide') }}" class="btn btn-sm btn-light">AI Guide (placeholder)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
