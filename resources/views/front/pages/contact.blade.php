@extends('front.layouts.master')
@section('content')
    <script src="https://www.google.com/recaptcha/api.js?render={{ CommonHelper::appSettings('google_recaptcha_sitekey') }}" async defer></script>
    <div class="contact">
        <section class="hero"
            style="background:url({{ asset('front-assets/images/contact-bg.png') }}); background-position: center; background-size: cover;background-repeat: no-repeat;">
            <div class="container_custom">
                <h2 class="hero__title">
                    <!-- Contact Us -->
                </h2>
            </div>
        </section>

        <section class="contact-info">
            <div class="container_custom">
                <div class="contact-info__box">
                    <div class="contact-info__box-icon">
                        <img src="{{ asset('front-assets/icons/envelope.svg') }}" alt="Email">
                    </div>
                    <a href="mailto:{{ CommonHelper::appSettings('branding_content_contact_email') }}"
                        class="contact-info__box-text">
                        {{ CommonHelper::appSettings('branding_content_contact_email') }}
                    </a>
                </div>
                <div class="contact-info__box">
                    <div class="contact-info__box-icon">
                        <img src="{{ asset('front-assets/icons/phone-call.svg') }}" alt="Phone">
                    </div>
                    <a href="tel:" class="contact-info__box-text">
                        {!! CommonHelper::appSettings('branding_content_contact_mobile') !!}
                    </a>
                </div>
                <div class="contact-info__box">
                    <div class="contact-info__box-icon">
                        <img src="{{ asset('front-assets/icons/map-marker.svg') }}" alt="Location">
                    </div>
                    <a class="contact-info__box-text">
                        {{ CommonHelper::appSettings('branding_content_contact_address') }}
                    </a>
                </div>
            </div>
        </section>

        <section class="map">
            <div class="container_custom">
                <iframe src="{{ CommonHelper::appSettings('branding_content_google_map_url') }}"
                    style="border-radius: 16px;" class="google-map__contact" allowfullscreen></iframe>
            </div>
        </section>

        <section class="message">
            <div class="container_custom">
                <div class="message__customer">
                    <div class="support_img">
                        <img src="{{ asset('front-assets/images/customer.png') }}" alt="" srcset="">
                    </div>
                    <h2 class="support_title">
                        We Love to Hear <br> From You
                    </h2>
                </div>
                <form class="message__form" id="form-contact">
                    @csrf
                    <div class="message__form__input-group">
                        <div class="first_name">
                            <label for="first_name">First Name<span class="required">*</span></label>
                            <input type="text" name="firstname" id="first_name" placeholder="Enter First Name" required>
                            <i class="fa-solid fa-user input_icon"></i>
                        </div>
                        <div class="last_name">
                            <label for="last_name">Last Name<span class="required">*</span></label>
                            <input type="text" name="lastname" id="last_name" placeholder="Enter Last Name" required>
                            <i class="fa-solid fa-user input_icon"></i>
                        </div>
                    </div>
                    <div class="message__form__input-group">
                        <div class="email">
                            <label for="email">Email Address<span class="required">*</span></label>
                            <input type="email" name="email" id="email" placeholder="Enter Email" required>
                            <i class="fa-solid fa-envelope input_icon"></i>
                        </div>
                        <div class=" phone">
                            <label for="phone">Mobile no.<span class="required">*</span></label>
                            <input type="text" class="numbers" name="mobile_no" maxlength="10" minlength="10"
                                id="phone" placeholder="Enter Mobile Number" required>
                            <i class="fa-solid fa-phone input_icon"></i>
                        </div>
                    </div>
                    <div class="message__form__input-message">
                        <label for="message">Your Message<span class="required">*</span></label>
                        <textarea name="description" id="message" placeholder="Enter Your Message" required></textarea>
                        <i class="fa-solid fa-comment input_icon"></i>
                    </div>
                    {{-- <div class="message__form__input-group">
                        <div class="g-recaptcha" data-sitekey="{{ CommonHelper::appSettings('google_recaptcha_sitekey') }}">
                        </div>
                    </div> --}}
                    <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                    <button class="btn_custom message__btn" type="submit">Send Message</button>
                </form>
            </div>
        </section>
    </div>
    @push('custom-scripts')
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ CommonHelper::appSettings('google_recaptcha_sitekey') }}', {action: 'submit'}).then(function(token) {
                    document.getElementById('recaptcha_token').value = token;
                });
            });
            $('#form-contact').submit(function(e){
                e.preventDefault();
                if ($('#form-contact input[name="firstname"]').val() == '') {
                    showErrorMessage('Firstname is required');
                } else if ($('#form-contact input[name="lastname"]').val() == '') {
                    showErrorMessage('Lastname is required');
                } else if ($('#form-contact input[name="email"]').val() == '') {
                    showErrorMessage('Email is required');
                } else if ($('#form-contact input[name="mobile_no"]').val() == '') {
                    showErrorMessage('Mobile is required');
                } else if ($('#form-contact textarea[name="description"]').val() == '') {
                    showErrorMessage('Message is required');
                } else {
                    showAjaxLoader();
                    $.ajax({
                        url: "{{ route('front.pages.contact.save') }}",
                        type: 'POST',
                        data: $('#form-contact').serialize(),
                        dataType: 'JSON',
                        success: function(data) {
                            showAjaxLoader(false);
                            if (data.status) {
                                location.reload();
                                // showErrorMessage(data.message, 'success');
                            } else {
                                showErrorMessage(data.message);
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
