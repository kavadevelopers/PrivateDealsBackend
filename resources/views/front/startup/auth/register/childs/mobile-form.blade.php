<div class="heading">
    <h2>Raise with {{ CommonHelper::appSettings('app_name') }}</h2>
    <p>Start raise In just 5 minutes</p>
</div>
<form action="#" method="post" id="register-phone" data-action="{{ route('front.raise.auth.post.register.mobile') }}">
    @csrf
    <div class="field_group">
        <label>Mobile number <span class="required">*</span></label>
        <input class="field input-number" type="text" name="mobile_number" placeholder="Enter Mobile number">
        <i class="fa-solid fa-phone input_icon"></i>
    </div>
    <div class="submit_forget">
        <button type="submit" class="btn_custom reg_step">Send Verification Code</button>
    </div>
</form>
