@php
    $offerRequesstGet = App\Models\StartupOfferRequestModel::orderby('id', 'desc')
        ->where('startup_id', Auth::guard('startup')->user()->id)
        ->first();
    $pendingTransactionCounter = App\Models\PrimaryTransactionModel::where('status', '4')
        ->where('startup_id', Auth::guard('startup')->user()->id)
        ->count();
@endphp

@if ($pendingTransactionCounter > 0)
    @if (!$offerRequesstGet)
        <a href="{{ route('front.raise.offerletter.request') }}">
            <button class="nav-link">
                <span class="fa fa-paper-plane"></span><span>Request to send offer Letter</span>
            </button>
        </a>
    @else
        @if ($offerRequesstGet->status == App\Enums\Utills\StatusEnum::pending->value)
            <a href="javascript:;">
                <button class="nav-link">
                    <span class="fa fa-lock"></span><span>Offer Letter request pending for approval</span>
                </button>
            </a>
        @endif
        @if ($offerRequesstGet->status == App\Enums\Utills\StatusEnum::rejected->value)
            <a href="#  ">
                <button class="nav-link">
                    <span class="fa fa-paper-plane"></span><span>Offer Letter request rejected. Click to resend
                        request</span>
                </button>
            </a>
        @endif
        @if ($offerRequesstGet->status == App\Enums\Utills\StatusEnum::approved->value)
            <a href="{{ route('front.raise.offerletter.send') }}" class="btn-confirm"
                data-message="Are you sure you want to send Offer letters ?">
                <button class="nav-link">
                    <span class="fa fa-paper-plane"></span><span>Send offer Letter now</span>
                </button>
            </a>
        @endif
    @endif
@else
    <a href="javascript:;">
        <button class="nav-link">
            <span class="fa fa-lock"></span><span>Waiting for MGT-14 Upload to send Offer Letter</span>
        </button>
    </a>

@endif
