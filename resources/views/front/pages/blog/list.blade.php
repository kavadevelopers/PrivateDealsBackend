@extends('front.layouts.master')
@section('content')
    <div class="blog_page">
        <div id="main">
            <div class="content">
                <div class="top">
                @section('title')
                    {{ getPageTitle() }}
                @endsection
            </div>
            <div class="container_custom">
                <div class="blog_cards">
                    <div class="all_cards">
                        @foreach ($blogs as $key => $value)
                            @include('front.partials.childs.blog-card', compact('value'))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
