<!--begin::Complete-->
<div data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-12 text-center">
            <!--begin::Title-->
            <h1 class="fw-bold text-gray-900">Project Created!</h1>
            <!--end::Title-->

            <div class="text-muted fw-semibold fs-4">If you need more info, please check how to create project</div>

        </div>
        <!--end::Heading-->
        <!--begin::Actions-->
        <div class="d-flex flex-center pb-20">
            <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="complete-start">Create New
                Project</button>
            <a href="" class="btn btn-lg btn-primary" data-bs-toggle="tooltip" title="Coming Soon">View
                Project</a>
        </div>
        <!--end::Actions-->
        <!--begin::Illustration-->
        <div class="text-center px-4">
            <img src="{{ asset('illustrations/sketchy-1/9.png') }}" alt="" class="mww-100 mh-350px" />
        </div>
        <!--end::Illustration-->
    </div>
</div>
<!--end::Complete-->
    @php 
    $otherS = $value->other; 
    $detailS = $value->details;  
    $getInvested = Common::getInvested($value);  
    @endphp
    @if(Request::segment(1) == 'business')
        <a href="{{ url(Common::business('startup/'.Illuminate\Support\Facades\Crypt::encrypt($value->id))) }}" class="card_custom card_one">
    @elseif($value->status == '1')
        <a href="#" class="card_custom card_one btn-open-video-player" id="launching-soon{{ $value->id }}" data-video="{{ Common::getStartupVideo($value->video) }}">
    @elseif($value->status == '4')
        <a href="#" class="card_custom card_one btn-ask-pvt-key" data-id="{{ $value->id }}">
    @else
        <a href="{{ url('startup/'.Illuminate\Support\Facades\Crypt::encrypt($value->id)) }}" class="card_custom card_one">
    @endif
        <div class="video">
            <video class="card_video" src="{{ Common::getStartupVideo($value->video) }}" poster="{{ Common::getStartupBanner($value->banner) }}" controlsList="nodownload" loop muted ></video>
            @if(Request::segment(1) != 'business' && $value->status != '1')
                @if (Common::isLoggedInInvestor())
                    <button class="fav_btn fav-btn {{ Common::isFavStartup($value->id) }}" type="button" data-startup="{{ $value->id }}">   
                        <i class="fa-solid fa-star"></i>
                    </button>
                @else
                    <button class="fav_btn btn-red-login" type="button">
                        <i class="fa-solid fa-star"></i>
                    </button>
                @endif
            @endif
        </div>
        <div class="card_body_info">
            <div class="co_profile">
                <div class="logo">
                    <img src="{{ Common::getStartupLogo($value->logo) }}" alt="">
                </div>
                <div class="info">
                    <h3>{{ Common::read_more_hide($value->brand,15) }}</h3>
                    <p>{{ Common::read_more_hide(Common::isValidRow($otherS,'short_descr'),80) }}</p>
                </div>
            </div>
            <div class="categoriy_city">
                <div class="category">
                    <div class="icon">
                        <img src="{{ url('weba/assets/icons/media_tech.svg') }}" alt="">
                    </div>
                    <p>{{ Common::getSector($value) }}</p>
                </div>
                <div class="city">
                    <div class="icon">
                        <img src="{{ url('weba/assets/icons/flag.svg') }}" alt="">
                    </div>
                    <p>{{ Common::read_more_hide($value->city,15) }}</p>
                </div>
            </div>
            @if ($value->status != '1')
                {{-- <div class="progress_bar"> --}}
                    {{-- <div class="info">
                        <p class="raised">Raised {{ round($getInvested['percentage']) }}%</p>
                        <p class="time" style="display: none;">
                            @if($value->status  == '6')
                                Completed
                            @else
                                {{ Common::getStartupPendingDays($value->schedule) }} Days Left
                            @endif
                        </p>
                    </div>
                    <div class="progress">
                        <div class="progress-bar kava-bar-fill" role="progressbar" aria-valuenow="{{ round($getInvested['percentage']) }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div> --}}
                <div class="status_value">
                    <div class="value">
                        @if (Common::isLoggedInInvestor())
                            <h4>{{ count(Common::getInvestorsByStartUp($value->id)->get()) }}</h4>
                        @else
                            <button type="button" class="btn-sblock-text-lock btn-red-login" style="height:20px"><i class="fa fa-lock"></i></button>
                        @endif
                        <div class="title">
                            <span class="icon-investor-bag"></span>
                            <p>Investors</p>
                        </div>
                    </div>
                    <div class="value">
                        <h4>
                            @if (Common::isLoggedInInvestor())
                                {{ Common::rsSy() }}{{ Common::number_shorten($value->ask) }}
                            @else
                                <button type="button" class="btn-sblock-text-lock btn-red-login" style="height:20px"><i class="fa fa-lock"></i></button>
                            @endif
                        </h4>
                        <div class="title">
                            <span class="icon-target"></span>
                            <p>Target</p>
                        </div>
                    </div>
                    <div class="value">
                        @if (Common::isLoggedInInvestor())
                            <h4 class="<?= !Common::isLoggedInInvestor()?'blurry-text':'' ?>">
                                {{ Common::rsSy() }}{{ Common::number_shorten($detailS->valuation) }}
                            </h4>
                        @else
                            <button type="button" class="btn-sblock-text-lock btn-red-login" style="height:20px"><i class="fa fa-lock"></i></button>
                        @endif    
                        <div class="title">
                            <span class="icon-valuation"></span>
                            <p>Valuation</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </a>