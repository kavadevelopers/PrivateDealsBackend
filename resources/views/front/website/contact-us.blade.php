@extends('front.website.master')
@section('title')
Contact Us
@endsection
@section('content')
<script src="https://www.google.com/recaptcha/api.js?render={{ CommonHelper::appSettings('google_recaptcha_sitekey') }}"
    async defer></script>
<div class="container">
    <div class="contact-page d-flex align-items-center" style="    margin-top: 100px;">
        <div class="row">
            <div class="col-6 col-md-6 text-white p-5 left-section" id="contactSection">
                {{-- <h6>Get in touch</h6> --}}
                <h2><span class="highlight-blue">Get in touch </span> with us</h2>
                <p class="paragraph">We’re here to help you explore new opportunities and answer any
                    questions
                    you may have. Whether
                    you're an investor looking to learn more about our portfolio, a startup seeking strategic
                    partnerships, or simply curious about what we do, feel free to reach out. Our team is ready to
                    connect and provide the support you need.</p>

                <div class="contact-info d-flex justify-content-between mt-5 mb-4">
                    <div class="text-center d-flex flex-column align-items-center">
                        <img src="{{ asset('website-assets/images/contact-us/email-icon.svg') }}">
                        <p class="m-0 paragraph text-center">
                            <span class="d-block live-support ">Email Us</span>
                            <span class="support-email">{{ CommonHelper::appSettings('branding_content_contact_email')
                                }}</span>
                        </p>
                    </div>
                    <div class="text-center d-flex flex-column align-items-center">
                        <img src="{{ asset('website-assets/images/contact-us/phone-iconwithbackground.svg') }}">
                        <p class="m-0 paragraph text-center">
                            <span class="d-block live-support">Call Us</span>
                            <span class="support-email">{!! CommonHelper::appSettings('branding_content_contact_mobile')
                                //+91 9867052562,+91 9638070093
                                !!}</span>
                        </p>
                    </div>
                    <div class="text-center d-flex flex-column align-items-center">
                        <img src="{{ asset('website-assets/images/contact-us/location-iconwithbackground.svg') }}">
                        <p class="m-0 paragraph text-center">
                            <span class="d-block live-support">Our Address</span>
                            <span class="support-email">{!!
                                nl2br(CommonHelper::appSettings('branding_content_contact_address')) !!}</span>
                        </p>
                    </div>
                    <div class="text-center d-flex flex-column align-items-center">
                        <img src="{{ asset('website-assets/images/contact-us/time-iconwithbackground.svg') }}">
                        <p class="m-0 paragraph text-center">
                            <span class="d-block live-support">Work Hours</span>
                            <span class="support-email">Mon-Sat 10:30am - 7:30pm</span>
                        </p>
                    </div>
                </div>
                <hr class="divider mb-4">

                <h6>Follow Us On</h6>
                <div class="socialmediasection mt-2">
                    <div class="social-media d-flex flex-wrap gap-2">
                        @foreach (App\Models\MasterWebsiteSocialmediaModel::where('is_deleted',
                        0)->orderby('display_order', 'asc')->get() as $linkKey => $linkValue)
                        <a href="{{ $linkValue->link }}" target="_blank" title="{{ $linkValue->name }}"
                            class="social-icon">
                            <i class="fab {{ $linkValue->icon }}"></i>
                        </a>
                        @endforeach

                        <iframe src="{{ CommonHelper::appSettings('branding_content_google_map_url') }}" width="280"
                            height="140" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
            <div class="col-6 col-md-6 form-section">
                <h4 class="text-white mb-4">Send us a message</h4>
                <p class="mb-4 paragraph">Feel free to reach out to us with any questions, feedback, or inquiries.
                    We're here to assist and connect with you!</p>
                <form action="{{ route('front.contactus.post') }}" method="POST" id="contactForm">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name" class="text-white">Name<span class="required-label">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                value="{{ old('name') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="company" class="text-white">Company</label>
                            <input type="text" class="form-control" name="company" placeholder="Company"
                                value="{{ old('company') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="mobile_number" class="text-white">Mobile no.<span
                                    class="required-label">*</span></label>
                            <input type="text" class="form-control" name="mobile_number"
                                placeholder="Enter Mobile Number" value="{{ old('mobile_number') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="text-white">Email<span class="required-label">*</span></label>
                            <input type="text" class="form-control" name="email" placeholder="Email"
                                value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="text-white">Subject<span class="required-label">*</span></label>
                        <input type="text" class="form-control" name="subject" placeholder="Subject"
                            value="{{ old('subject') }}">
                    </div>
                    <div class="form-group">
                        <label for="message" class="text-white">Message</label>
                        <textarea class="form-control" name="message" rows="4"
                            placeholder="Message">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-light custom-button" id="sendMessageBtn">Send
                        Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script>
    grecaptcha.ready(function() {
             grecaptcha.execute('{{ CommonHelper::appSettings('google_recaptcha_sitekey') }}', {
                 action: 'submit'
             }).then(function(token) {
                 document.getElementById('recaptcha_token').value = token;
             });
         });
         $(function() {
             @if ($errors->any())
                 var errors = {!! json_encode($errors->keys()) !!};
                 if (errors.length > 0) {
                     $('input[name=' + errors[0] + '], textarea[name=' + errors[0] + ']').focus();
                 }
             @elseif (Session::has('success') || Session::has('error'))
                 $('input[name="name"]').focus();
             @endif
         });
</script>
@endpush