@extends('front.layouts.master')
{{-- @include('front.layouts.iheader') --}}

@section('content')
    <div class="dashboard">
        <div id="main">
            <div class="dashboard_container">
                <div class="content">
                    <div class="d-flex align-items-start">
                        @include('front.partials.sidebar')
                        <div class="d_content">
                            @yield('child-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
