@extends('front.layouts.master')
@section('content')
    <div class="" id="mainRegisterContainer">
        {{-- @include('front.startup.auth.register.childs.document') --}}
        <div class="register">
            <div id="main">
                <div class="login_section">
                    <div class="container_custom">
                        <div class="content bg_style">
                            <div class="overlay_shape_reg"><img src="{{ asset('front-assets/images/register_overlay.png') }}"
                                    alt=""></div>
                            <div class="main_content">
                                <div class="graphics"><img
                                        src="{{ asset('front-assets/images/startup-register-vector.png') }}" alt="">
                                </div>
                                <div class="form" id="registerFormContent">
                                    @include('front.startup.auth.register.childs.mobile-form')
                                </div>
                            </div>
                            <div class="register_bottom login_bottom" style="">
                                <p>Already have an account? </p> <a class="register"
                                    href="{{ route('front.raise.auth.login') }}">Login
                                    Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('custom-scripts')
    <script>
        temporaryData.set('startup_register_team_item',
            `{!! view('front.startup.auth.register.childs.mini.team')->render() !!}`
        );
        temporaryData.set('startup_register_social_media_item_item',
            `{!! view('front.startup.auth.register.childs.mini.social-media')->render() !!}`
        );
    </script>
@endpush --}}
