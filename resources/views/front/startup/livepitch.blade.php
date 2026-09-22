@extends('front.layouts.dashboard')
@push('custom-scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
@endpush
@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="update_content">
                <div class="top_section">
                    <h3>{{ getPageTitle() }}</h3>
                </div>
                <input type="text" id="datetime" name="datetime">
            </div>
        </div>
    </div>
@endsection



@push('custom-scripts')

<script>
  $(function() {
            $('#datetime').datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'HH:mm:ss'
            });
        });
  </script>
@endpush