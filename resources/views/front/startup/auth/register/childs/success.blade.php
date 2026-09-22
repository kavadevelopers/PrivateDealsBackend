<div class="register_steps reg_investor startup_register_step">
    <div id="main">
        <div class="extra_section">
            <div class="container_custom">
                <div class="content bg_style">
                    <div class="success_heading">
                        <h2>Raise With {{ CommonHelper::appSettings('app_name') }}</h2>
                        <p>Thank you for your submission</p>
                    </div>
                    <div class="success_body">
                        <div class="success_img"><img
                                src="{{ asset('front-assets/images/startup-register-success-vector.png') }}"
                                alt="">
                        </div>
                        <div class="info">
                            <h3>You Have Successfully Signed Up</h3>
                            <p>Thank you for choosing {{ CommonHelper::appSettings('app_name') }}</p>
                            <a href="{{ route('front.raise.dashboard') }}" class="btn_custom">Done</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    setInterval(function() {
        location.href = "{{ route('front.raise.dashboard') }}";
    }, 4000);
</script>
