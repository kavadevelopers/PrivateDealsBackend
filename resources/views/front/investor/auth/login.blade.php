@extends('front.layouts.master')

@section('content')
    <div class="login">
        <div id="main">
            <div class="login_section">
                <div class="container_custom">
                    <div class="content bg_style">
                        <div class="overlay_shape"><img src="{{ asset('front-assets/images/overlay_sign_in.png') }}"
                                alt=""></div>
                        <div class="main_content">
                            <div class="graphics"><img src="{{ asset('front-assets/images/sign-in_graphics.png') }}"
                                    alt=""></div>
                            <div class="form" id="loginContent">
                                <div class="heading">
                                    <h2>Welcome Back!</h2>
                                    <p>Enter your mobile number and password to login</p>
                                </div>
                                <form action="" data-action="{{ route('front.investor.post.login') }}"
                                    {{-- data-redirect="{{ route('front.investor.dashboard') }}"  --}} method="POST" id="investor-login-form">
                                    @csrf
                                    <div class="field_group">
                                        <label>Mobile Number <span class="required">*</span></label>
                                        <input class="field input-number" type="text" name="mobile_no"
                                            placeholder="Enter Mobile Number">
                                        <i class="fa-solid fa-user input_icon"></i>
                                    </div>
                                    <div class="field_group show-hide-password">
                                        <label>Password <span class="required">*</span></label>
                                        <input type="password" class="form-control field" name="password"
                                            placeholder="Enter Password">
                                        <i class="fa-solid fa-lock input_icon"></i>
                                        <span class="span-viewpassword fa-solid fa-eye field-icon"></span>
                                    </div>
                                    <div class="submit_forget">
                                        <button type="submit" class="btn_custom">Login</button>
                                        <a href="{{ route('front.investor.forgot') }}" class="forget">Forget password?</a>
                                    </div>
                                    <input type="hidden" name="firebase_token" />
                                </form>
                            </div>
                        </div>
                        <div class="register_bottom">
                            {{-- <p>Don't have any account?</p> <a class="register" href="register.html">Register Now</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
