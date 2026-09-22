@extends('front.layouts.master')

@section('content')
    <div class="blog_single_page">
        <div id="main">
            <div class="container_custom">
                <div class="content">
                    <div class="main_image"><img class="lazy shimmer"
                            data-src="{{ FileUpDownHelper::get_page_blog_banner_url($item->banner) }}"alt=""></div>
                    <div class="info">
                        <div class="top_head">
                            <div class="date">
                                <div class="icon"><i class="fa-solid fa-calendar-days"></i></div>
                                <span>{{ DateTimeHelper::viewDate($item->created_at, 'd M Y') }}</span>
                            </div>
                            <div class="social">
                                <p>Share On:</p>
                                <div>
                                    <a href="http://www.facebook.com/sharer.php?u={{ route('front.pages.blog.view', $item->url_slug) }}"
                                        target="_blank">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <a href="http://twitter.com/share?url={{ route('front.pages.blog.view', $item->url_slug) }}&text=Check this out on {{ CommonHelper::appSettings('app_name') }}"
                                        target="_blank">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                    <!-- <a href="#" target="_blank">
                                                                                        <i class="fa-brands fa-instagram"></i>
                                                                                    </a> -->
                                    <a href="http://pinterest.com/pin/create/link/?url={{ urlencode(route('front.pages.blog.view', $item->url_slug)) }}&media={{ urlencode(FileUpDownHelper::get_page_blog_banner_url($item->banner)) }}&description={{ $item->short_description }}"
                                        target="_blank">
                                        <i class="fa-brands fa-pinterest-p"></i>
                                    </a>
                                    <a
                                        href="mailto:?Subject=Check this blog on {{ CommonHelper::appSettings('app_name') }}&Body=I want to recommend this blog at {{ CommonHelper::appSettings('app_name') }} :- {{ route('front.pages.blog.view', $item->url_slug) }}">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="info_body">
                            <div class="text_dynamic">
                                <h3 class="title">{{ $item->title }}</h3>
                                <div class="content">
                                    {!! $item->long_description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
