@if(!isset($small))
    <div class="startup_lock_content">
        <div class="image"><img src="{{ url('weba/assets/images/startup_lock_Illustration.png') }}" alt=""></div>
        <div class="info">
            <div class="icon"><img src="{{ url('weba/assets/icons/startup_lock.svg') }}" alt=""></div>
            <div class="text">
                <h3>Complete KYC to get access to more details about The {{ $startup->brand }} Startup</h3>
                <p>To comply with financial regulations, we can only show full campaign details to
                    verified users.</p>
            </div>
            <div class="btn_group">
                <a href="{{ url('/investor/kyc') }}"><button class="btn_custom" style="max-width: 100%;">Click to Complete</button></a>
            </div>
        </div>
    </div>
@else
<div class="startup_lock_content">
    <div class="icon"><img src="{{ url('weba/assets/icons/startup_lock.svg') }}" alt=""></div>
    <div class="info">
        <h3>Complete KYC to get access to more details about The {{ $startup->brand }} Startup</h3>
        <p>To comply with financial regulations, we can only show full campaign details to
                    verified users.</p>
        <div class="btn_group">
            <a href="{{ url('/investor/kyc') }}"><button class="btn_custom" style="max-width: 100%;">Click to Complete</button></a>
        </div>
    </div>
</div>
@endif