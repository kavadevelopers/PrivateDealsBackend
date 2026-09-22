<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    <div class="card card-flush">
        <div class="card-header">
            <div class="card-title"><h2>AI Share Prices</h2></div>
        </div>
        <div class="card-body">
            <p class="text-muted mb-0">Coming soon. This AutoWork job is not implemented yet.</p>
            <a class="btn btn-sm btn-light mt-5" href="{{ route('admin.ai-autowork.share-prices.guide') }}">AI Guide placeholder</a>
        </div>
    </div>
</x-default-layout>
