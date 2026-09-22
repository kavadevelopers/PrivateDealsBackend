<div class="heading">
    <h2>Verify Your Mobile Number</h2>
    <p>Verification Code Sent to {{ $mobile_no }}</p>
</div>
<form action="" data-action="{{ $form_route }}" method="POST" id="verify-otp-form">
    @csrf
    <div class="field_group">
        <label>Verification Code <span class="required">*</span></label>
        <input maxlength="6" minlength="6" class="field input-number" type="text" name="otp"
            placeholder="Enter Verification Code">
        <i class="fa-solid fa-shield input_icon"></i>
        <a href="#" id="resend-otp-btn" data-action="{{ $resend_route }}">Resend
            verification code</a>
    </div>
    <div class="submit_forget">
        <button type="submit" class="btn_custom reg_otp">Verify Code</button>
    </div>
</form>
