<div class="heading">
    <h2>{{ $title }}</h2>
    <p>Password should contain at least 1 upper case, 1 lower case, 1 numeric character, 1 special character and 8
        characters long.</p>
</div>
<form class="" action="" data-action="{{ $action }}" data-redirect="{{ $redirect }}" method="POST"
    id="change-password-form">
    @csrf
    <div class="field_group show-hide-password">
        <label>New Password <span class="required">*</span></label>
        <input type="password" class="form-control field" name="password" placeholder="Enter Password">
        <i class="fa-solid fa-lock input_icon"></i>
        <span class="span-viewpassword fa-solid fa-eye field-icon"></span>
    </div>
    <div class="field_group show-hide-password">
        <label>Confirm Password <span class="required">*</span></label>
        <input type="password" class="form-control field" name="cpassword" placeholder="Enter Confirm Password">
        <i class="fa-solid fa-lock input_icon"></i>
        <span class="span-viewpassword fa-solid fa-eye field-icon"></span>
    </div>
    <div class="submit_forget">
        <button type="submit" class="btn_custom">Continue</button>
    </div>
</form>
