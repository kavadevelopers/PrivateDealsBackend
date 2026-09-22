@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="ui_content">
                <h3>{{ getPageTitle() }}</h3>
                <div class="d_card">
                    <form action="{{ route('front.investor.changepassword.post') }}" method="post" id="changePassForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="field_group show-hide-password">
                                    <label>New Password <span class="required">*</span></label>
                                    <input type="password" required class="form-control field" name="password"
                                        placeholder="Enter New Password" value="{{ old('password') }}">
                                    <i class="fa-solid fa-lock input_icon"></i>
                                    <span class="span-viewpassword fa-solid fa-eye field-icon"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="field_group show-hide-password">
                                    <label>Confirm Password <span class="required">*</span></label>
                                    <input type="password" required class="form-control field" name="cpassword"
                                        placeholder="Enter Confirm Password" value="{{ old('cpassword') }}">
                                    <i class="fa-solid fa-lock input_icon"></i>
                                    <span class="span-viewpassword fa-solid fa-eye field-icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <button class="btn_custom" type="submit">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        $(function() {
            $('#changePassForm').submit(function(e) {
                if (!regxForPassword.test($('#changePassForm input[name=password]').val())) {
                    showErrorMessage(
                        'Password should contain at least 1 upper case, 1 lower case, 1 numeric character, 1 special character and 8 characters long.',
                        'error');
                    return false;
                } else if ($('#changePassForm input[name=password]').val() != $(
                        '#changePassForm input[name=cpassword]').val()) {
                    showErrorMessage('New Password and Confirm Password do not match.', 'error');
                    return false;
                }
            });
        })
    </script>
@endpush
