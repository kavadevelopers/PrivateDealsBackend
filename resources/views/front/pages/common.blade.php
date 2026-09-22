@extends('front.layouts.master')
@section('content')
    <div id="main">
        <div class="content">
            <img data-src="{{ FileUpDownHelper::get_page_banner_url($page->banner) }}" class="spage-banner lazy shimmer">
        </div>
        <div class="text_style_demo container_custom">
            <div class="text_dynamic">
                <div class="content">
                    @if ($page->is_display_title == '1')
                        <h3>{{ $page->name }}</h3>
                    @endif
                    {!! $page->description !!}
                </div>
            </div>
        </div>
    </div>
@endsection
