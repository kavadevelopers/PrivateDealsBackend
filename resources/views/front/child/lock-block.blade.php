@if(!isset($small))
    <div class="startup_lock_content">
        <div class="image"><img src="{{ url('weba/assets/images/startup_lock_Illustration.png') }}" alt=""></div>
        <div class="info">
            <div class="icon"><img src="{{ url('weba/assets/icons/startup_lock.svg') }}" alt=""></div>
            <div class="text">
                <h3>Open an account to get access to more details about The {{ $startup->brand }} Startup</h3>
                <p>To comply with financial regulations, we can only show full campaign details to
                    registered users.</p>
            </div>
            <div class="btn_group">
                @if(Request::segment(1) == 'business')
                    <a href="{{ url(Common::business('login')) }}"><button class="btn_custom_line">Login</button></a>
                @else
                    <a href="{{ url('signup') }}"><button class="btn_custom">Signup</button></a>
                    <a href="{{ url('login') }}"><button class="btn_custom_line">Login</button></a>
                @endif
            </div>
        </div>
    </div>
@else
<div class="startup_lock_content">
    <div class="icon"><img src="{{ url('weba/assets/icons/startup_lock.svg') }}" alt=""></div>
    <div class="info">
        <h3>Open an account to get access to more details about The {{ $startup->brand }} Startup</h3>
        <p>To comply with financial regulations, we can only show full campaign details to
                    registered users.</p>
        <div class="btn_group">
            @if(Request::segment(1) == 'business')
                <a href="{{ url(Common::business('login')) }}"><button class="btn_custom_line">Login</button></a>
            @else
                <a href="{{ url('signup') }}"><button class="btn_custom">Signup</button></a>
                <a href="{{ url('login') }}"><button class="btn_custom_line">Login</button></a>
            @endif
        </div>
    </div>
</div>
@endif