@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="update_content">
                <div class="top_section">
                    <h3>{{ getPageTitle() }}</h3>
                </div>
                <div class="d_card">
                    <form action="{{ route('front.raise.livepitch.post') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d_field_group">
                                    <label>Meeting Time<span class="required">*</span></label>
                                    <input class="d_field datetimepicker" value="{{ old('schedule') }}" type="text"
                                        placeholder="Select Meeting Time" name="schedule" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d_field_group">
                                    <label>Title <span class="required">*</span></label>
                                    <input class="d_field" value="{{ old('title') }}" type="text" name="title"
                                        placeholder="Enter title" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d_field_group">
                                    <label>Description <span class="required">*</span></label>
                                    <textarea class="d_field_ta" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn_custom" id="meetschedule">Schedule Meeting</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
