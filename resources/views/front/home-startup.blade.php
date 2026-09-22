@extends('front.layouts.master')
@section('content')

    <div class="startup">
        <div id="main">
            <section class="slider">
                <div class="container_custom">
                    <div class="info">
                        <h2>Fuel your startup by funding and great mentorship.</h2>
                        <p></p>
                        <div class="btn_group">
                            <a class="btn_custom_line" href="#">Find out more about PrivateDeals Funding</a>
                            <a class="rise btn_custom" href="{{ url('raise/apply') }}">Apply to Raise</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="services">
                <div class="container_custom">
                    <div class="content">
                        <div class="info">
                            <h3>End to end services in support of your fundraise journey</h3>
                            <p></p>
                        </div>
                        <div class="all_card">
                            <div class="card_custom">
                                <div class="icon one"><img src="{{ asset('front-assets/icons/startup_s_1.svg') }}"
                                        alt=""></div>
                                <h3>Raise funds</h3>
                                <p>Whether it's raising privately or a secondary sale, find out how we can Accommodate your
                                    fundraising needs.</p>
                                <a href="#" class="button_plain"><i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                            <div class="card_custom">
                                <div class="icon two"><img src="{{ asset('front-assets/icons/startup_s_2.svg') }}"
                                        alt=""></div>
                                <h3>Mentorship</h3>
                                <p>We provide guidance and mentorship to find the easiest way of success.</p>
                                <a href="#" class="button_plain"><i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                            <div class="card_custom">
                                <div class="icon three"><img src="{{ asset('front-assets/icons/startup_s_3.svg') }}"
                                        alt=""></div>
                                <h3>Digital equity transfer & documentation</h3>
                                <p>From cap table management to legal documents, we offer a range of equity management
                                    services completely digital.</p>
                                <a href="#" class="button_plain"><i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="insights home-insights blog" style="margin-top:50px;">
                <div class="container_custom">
                    <div class="content">
                        <div class="top">
                            <h2>Featured</h2>
                        </div>
                        <div class="all_cards">
                            @foreach (App\Models\MasterBlogModel::where('is_deleted', '0')->orderby('display_order', 'asc')->limit(4)->get() as $key => $value)
                                @include('front.partials.childs.blog-card', compact('value'))
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            @include('front.partials.childs.home-terms-condition')
        </div>
    </div>

@stop
