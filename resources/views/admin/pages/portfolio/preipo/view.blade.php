<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Portfolio Details</h3>
                    </div>
                    <div class="d-flex my-5">
                        <a href="{{ route('admin.portfolioInsights.startupPortfolio.edit', ['id' => $portfolio->id]) }}"
                            class="btn btn-sm btn-primary fw-bold m-0">Edit</a>
                    </div>
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Startup Name</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ ucfirst($portfolio->startup->brand_name) }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Investor Name</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ ucfirst($portfolio->investor->name) }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">No of Shares</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $portfolio->shares }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Purchase Price</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $portfolio->purchase_price }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Investment Amount</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $portfolio->investment_amount }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Instrument Type</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $portfolio->instrument }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="pills-home2" role="tabpanel" aria-labelledby="pills-profile-tab">2</div>
        <div class="tab-pane fade" id="pills-home3" role="tabpanel" aria-labelledby="pills-contact-tab">3</div>
    </div>
</x-default-layout>
