@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="ui_content">
                <h3>{{ getPageTitle() }}</h3>
                <div class="d_card">
                    <form action="{{ route('front.business.profile.post') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Name</label>
                                    <input type="text" class="d_field" name="name"
                                        value="{{ Auth::guard('partner')->user()->name }}" placeholder="Enter Name"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Mobile</label>
                                    <input type="text" class="d_field" name=""
                                        value="{{ Auth::guard('partner')->user()->mobile_number }}"
                                        placeholder="Enter Mobile" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Email <span class="required">*</span></label>
                                    <input type="email" class="d_field" name="email"
                                        value="{{ old('email', Auth::guard('partner')->user()->email) }}"
                                        placeholder="Enter Email" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Commission</label>
                                    <input type="text" class="d_field" name=""
                                        value="{{ Auth::guard('partner')->user()->commission }}"
                                        placeholder="Enter Commission" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <button class="btn_custom" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
