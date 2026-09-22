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
                            <div class="graphics"><img src="{{ asset('front-assets/images/business_login.png') }}"
                                    alt=""></div>
                            <div class="form" id="forgetContent">
                                <div class="heading">
                                    <h2>Forgot Password?</h2>
                                    <p>Enter your mobile number to reset your password</p>
                                </div>
                                <form class="" action=""
                                    data-action="{{ route('front.business.auth.post.forgot.post') }}" method="POST"
                                    id="investor-forgot-form">
                                    @csrf
                                    <div class="field_group">
                                        <label>Mobile Number <span class="required">*</span></label>
                                        <input class="field input-number" type="text" name="mobile_no"
                                            placeholder="Enter Mobile Number">
                                        <i class="fa-solid fa-phone input_icon"></i>
                                    </div>
                                    <div class="submit_forget">
                                        <button type="submit" class="btn_custom">Verify</button>
                                        <a href="{{ route('front.business.auth.login') }}" class="forget">Login here</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
