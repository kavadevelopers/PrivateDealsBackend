@extends('front.layouts.master')
@section('content')
<script src="https://www.google.com/recaptcha/api.js?render={{ CommonHelper::appSettings('google_recaptcha_sitekey') }}" async defer></script>
    <div class="feedback_page">
        <div id="main">
            <section class="hero"
                style="background-image:url({{ asset('front-assets/images/feedback_banner_bg.png') }});  background-position: center; background-size: cover;background-repeat: no-repeat;">
                <div class="container_custom">
                    <h2>
                        Provide Your Feedback
                    </h2>
                </div>
            </section>
            <div class="feedback_form">
                <div class="container_custom">
                    <div class="content">
                        <div class="top">
                            <h2>How Can We Help?</h2>
                            <!-- <p>Lorem ipsum dolor sit amet consetetur sadipscing elitr sed diam nonumy eirmod tempor
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    invidunt.</p> -->
                        </div>
                        <div class="form_section">
                            <div class="toggle_group">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#bug" type="button" role="tab" aria-controls="pills-home"
                                            aria-selected="true">I want to report a
                                            bug</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#feature" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">I want to share a
                                            features</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="bug" role="tabpanel"
                                        aria-labelledby="pills-home-tab">
                                        <form action="" id="form-bug">
                                            @csrf
                                            <div class="group">
                                                <div class="field_group">
                                                    <label for="name">Your Name <span class="required">*</span></label>
                                                    <input class="field" type="text" name="name" id="name"
                                                        placeholder="Enter Your Name" required>
                                                    <i class="fa-solid fa-user input_icon"></i>
                                                </div>
                                                <div class="field_group">
                                                    <label for="email">Your Email <span class="required">*</span></label>
                                                    <input class="field" type="email" name="email" id="email"
                                                        placeholder="Enter Your Email" required>
                                                    <i class="fa-solid fa-envelope input_icon"></i>
                                                </div>
                                            </div>
                                            <div class="field_group">
                                                <label for="address">Provide a short description of the bug <span
                                                        class="required">*</span></label>
                                                <textarea class="big_field" name="description" id="address" placeholder="Write Your report" required></textarea>
                                                <i class="fa-solid fa-comment input_icon"></i>
                                            </div>
                                            <br>
                                            {{-- <div class="field_group">
                                                <div class="g-recaptcha"
                                                    data-sitekey="{{ CommonHelper::appSettings('google_recaptcha_sitekey') }}">
                                                </div>
                                            </div> --}}
                                            <input type="hidden" name="type" value="bug">
                                            <input type="hidden" name="recaptcha_token" class="recaptcha_token">
                                            <button type="submit" class="btn_custom">Send Now</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="feature" role="tabpanel"
                                        aria-labelledby="pills-profile-tab">
                                        <form action="" id="form-feature">
                                            @csrf
                                            <div class="group">
                                                <div class="field_group">
                                                    <label for="aname">Your Name <span class="required">*</span></label>
                                                    <input class="field" type="text" name="name" id="aname"
                                                        placeholder="Enter Your Name" required>
                                                    <i class="fa-solid fa-user input_icon"></i>
                                                </div>
                                                <div class="field_group">
                                                    <label for="aemail">Your Email <span class="required">*</span></label>
                                                    <input class="field" type="email" name="email" id="aemail"
                                                        placeholder="Enter Your Email" required>
                                                    <i class="fa-solid fa-envelope input_icon"></i>
                                                </div>
                                            </div>
                                            <div class="field_group">
                                                <label for="aaddress">Provide a short description of the feature you want
                                                    to
                                                    share <span class="required">*</span></label>
                                                <textarea class="big_field" name="description" id="aaddress" placeholder="Write Your feature details" required></textarea>
                                                <i class="fa-solid fa-comment input_icon"></i>
                                            </div>
                                            <br>
                                            {{-- <div class="field_group">
                                                <div class="g-recaptcha"
                                                    data-sitekey="{{ CommonHelper::appSettings('google_recaptcha_sitekey') }}">
                                                </div>
                                            </div> --}}
                                            <input type="hidden" name="type" value="feature">
                                            <input type="hidden" name="recaptcha_token" class="recaptcha_token">
                                            <button type="submit" class="btn_custom">Send Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ CommonHelper::appSettings('google_recaptcha_sitekey') }}', {action: 'submit'}).then(function(token) {
                    var elements = document.getElementsByClassName('recaptcha_token');
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].value = token;
                    }
                });
            });
            $('#form-bug,#form-feature').submit(function(e){
                e.preventDefault();
                let form;
                if ($('#bug').hasClass('active')) {
                    form = '#form-bug';
                } else {
                    form = '#form-feature';
                }
                if ($(form + ' input[name="name"]').val() == '') {
                    showErrorMessage('Name is required');
                } else if ($(form + ' input[name="email"]').val() == '') {
                    showErrorMessage('Email is required');
                } else if ($(form + ' textarea[name="description"]').val() == '') {
                    showErrorMessage('Description is required');
                } else {
                    showAjaxLoader();
                    $.ajax({
                        url: "{{ route('front.pages.feedback.save') }}",
                        type: 'POST',
                        data: $(form).serialize(),
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
