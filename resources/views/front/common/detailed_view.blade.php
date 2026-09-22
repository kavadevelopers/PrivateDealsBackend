@extends('front.layouts.master')
@section('content')

    <div class="startup_details">
        <div id="main">
            <div class="main_image">
                <div class="image" style="position: relative;">
                    <div class="container_custom">
                        <div class="btn-block-watch-video">
                            <a href="#" data-video="{{ FileUpDownHelper::getStartupVideo($startup) }}"
                                class="btn_custom btn-open-video-player btn-watch-video-banner"><i
                                    class="far fa-circle-play"></i> <span>Watch Concept Video</span></a>
                        </div>
                    </div>
                    <img src="{{ FileUpDownHelper::getStartupBannerLong($startup) }}" alt="">
                </div>
            </div>
            <div class="container_custom">
                <div class="main_details">
                    <div class="info">
                        <div class="company_details">
                            <div class="comp_info">
                                <div class="logo"><img src="{{ FileUpDownHelper::get_startup_logo_url($startup) }}"
                                        alt=""></div>
                                <div class="info">
                                    <h3>{{ $startup->brand_name }}</h3>
                                    <p>{{ $startup->brief_information }}</p>
                                </div>
                            </div>
                            <div class="btn_group">
                                <div class="share_group">
                                    @include('front.child.startup-share-block')
                                </div>
                            </div>
                        </div>
                        <div class="progress_info">
                            {{-- <p class="days">
                                @if ($startup->status == '6')
                                    Completed
                                @else
                                    {{ CommonHelperHelper::getStartupPendingDays($startup->schedule) }} Days Left
                                @endif
                            </p>
                            <div class="progress">
                                <div class="progress-bar kava-bar-fill" role="progressbar"  aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <div class="progress_bottom_info">
                                <p class="investor">{{ CommonHelper::rsSy() }}{{ CommonHelper::moneyFormatIndia(CommonHelper::getInvested($startup)['done'],true) }} from {{ count(CommonHelper::getInvestorsByStartUp($startup->id)->get()) }} investors</p>
                                <p class="raised">Raised {{ round(CommonHelper::getInvested($startup)['percentage']) }}%</p>
                                <p class="target">{{ CommonHelper::rsSy() }}{{ CommonHelper::moneyFormatIndia($startup->ask,true) }} target</p>
                            </div> --}}
                        </div>
                        <div class="more_info">
                            <div class="overview">
                                <h4>Startup Overview</h4>
                                <table>
                                    <tr>
                                        <td>Location</td>
                                        <td>{{ $startup->city->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Social media</td>
                                        <td>
                                            {{-- @foreach ($startup_social as $key => $value) --}}
                                            {{-- <a href="{{ CommonHelper::isValidUrl($value->link) }}" class="social-btn-startup-det" target="_blank"><i class="fab {{ CommonHelper::getMasterSocialMedia($value->type)->icon }}"></i></a> --}}
                                            {{-- @endforeach --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Website</td>
                                        <td class="web">{{ $startup->website }}</td>
                                    </tr>
                                    <tr>
                                        <td>Company number</td>
                                        <td class="co_no">{{ $startup->cin }}</td>
                                    </tr>
                                    <tr>
                                        <td>Incorporation date </td>
                                        {{-- <td>{{ CommonHelper::cusDateTime($startup->incorporation_date,'d M Y') }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            {{-- <a href="#" data-video="{{ FileUpDownHelper::getStartupVideo($startup) }}" class="btn_custom_line btn-open-video-player"><i class="far fa-circle-play"></i> <span>Watch Video</span></a> --}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="summary">
                                {{--  @if (Auth::guard('partner')->check())
                                        <h4>Investment Summary</h4>
                                        <table>
                                            <tr>
                                                <td>Type</td>
                                                <td>{{ $startup_details->stype }}</td>
                                            </tr>
                                            @if ($startup_details->stype == 'Equity')
                                                <tr>
                                                    <td>Valuation</td>
                                                    <td>{{ CommonHelper::rsSy() }}{{ CommonHelper::number_shorten($startup_details->valuation) }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>Floor</td>
                                                    <td>{{ CommonHelper::rsSy() }}{{ CommonHelper::number_shorten($startup_details->floor) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cap</td>
                                                    <td>{{ CommonHelper::rsSy() }}{{ CommonHelper::number_shorten($startup_details->cap) }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Equity offered</td>
                                                <td>{{ $startup_details ->eq_offered }}%</td>
                                            </tr>
                                            <tr>
                                                <td>Share price</td>
                                                <td>{{ CommonHelper::rsSy() }}{{ CommonHelper::moneyFormatIndia($startup->pshareprice,true) }}</td>
                                            </tr>
                                        </table>
                                @else
                                    @include('front.child.lock-block',['small' => true])
                                @endif
                            </div>
                            <div class="highlights">
                                <h4>Startup Highlights</h4>
                                <div class="text_dynamic">
                                    <div class="content">
                                        {!! $startup->berif_startup !!}
                                    </div>
                                </div>
                            </div>
                            <div class="key_feature">
                                @if (CommonHelper::isLoggedInBusiness())
                                    @if ($startup->status != '6')
                                        <a href="#" id="investNowBusiness" style="display:block; margin-top: 10px;">
                                            <button style="width:100%;" class="favorite btn_custom">Invest Now</button>
                                        </a>
                                    @endif
                                @endif --}}
                                <a href="{{ route('front.investor.investment', ['slug' => $startup->url_slug]) }}"
                                    style="display:block; margin-top: 10px;">
                                    <button style="width:100%;" class="favorite btn_custom">Invest Now</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tabs_section">
                    <div class="tabs_button">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#idea" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Idea</button>
                            </li>
                            @if ($startup->startup_category == '2' || $startup->startup_category == '3')
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#market" type="button"
                                        role="tab" aria-controls="pills-profile" aria-selected="false">Market</button>
                                </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#key-information" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false">Key Informations</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#team"
                                    type="button" role="tab" aria-controls="pills-contact"
                                    aria-selected="false">Team</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#meet"
                                    type="button" role="tab" aria-controls="pills-contact"
                                    aria-selected="false">PrivateDeals-Meet</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#update" type="button" role="tab" aria-controls="pills-contact"
                                    aria-selected="false">Updates</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#faq" type="button" role="tab" aria-controls="pills-contact"
                                    aria-selected="false">FAQ's</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#documents" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Documents</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade" id="market" role="tabpanel" aria-labelledby="pills-profile-tab">
                            @if (Auth::guard('investor')->check())
                                @if (CommonHelper::isKycDoneInvestor())
                                    <div class="market_cards">
                                        <h3 class="text-center">No Data Found</h3>
                                    </div>
                                @else
                                    @include('front.child.kyc-lock-block')
                                @endif
                            @else
                                @include('front.child.lock-block')
                            @endif
                        </div>
                        <div class="tab-pane fade show active" id="idea" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            @if (Auth::guard('investor')->check())
                                @if (CommonHelper::isKycDoneInvestor())
                                    <div class="image" style="margin:0 auto; text-align: center;">
                                        <video class="big-video video-hov-out" controls
                                            src="{{ FileUpDownHelper::getStartupVideo($startup) }}"
                                            style="width: 60%;  max-height: 100vh; margin: 0 auto;"
                                            controlsList="nodownload">

                                        </video>
                                    </div>
                                    <div class="text_dynamic">
                                        <?= CommonHelper::isValidRow($other, 'infocontent') ?>
                                    </div>
                                @else
                                    @include('front.child.kyc-lock-block')
                                @endif
                            @else
                                @include('front.child.lock-block')
                            @endif
                        </div>
                        <div class="tab-pane fade" id="key-information" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            @if (Auth::guard('investor')->check())
                                @if (CommonHelper::isKycDoneInvestor())
                                    <div class="text_dynamic">
                                        <?= CommonHelper::isValidRow($other, 'keyinformation') ?>
                                    </div>
                                @else
                                    @include('front.child.kyc-lock-block')
                                @endif
                            @else
                                @include('front.child.lock-block')
                            @endif
                        </div>
                        <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="pills-contact-tab">
                            @if (Auth::guard('investor')->check())
                                {{-- @if (CommonHelper::isKycDoneInvestor())
                                    <h3>Team List</h3>
                                    <div class="all_card">
                                        @foreach ($team as $key => $value)
                                        <div class="card_custom">
                                            <div class="card_header">
                                                <div class="user">
                                                    <div class="image"><img src="{{ CommonHelper::getTeamImage($value->photo) }}" alt=""></div>
                                                    <div class="user_des">
                                                        <h5>{{ $value->tname }}</h5>
                                                        <p>Designation: <span class="dark_bold">{{ $value->designation }}</span> </p>
                                                    </div>
                                                </div>
                                                <div class="social">
                                                    <!-- <a class="fb" href="#"><i class="fab fa-facebook-f"></i></a>
                                                    <a class="tw" href="#"><i class="fab fa-twitter"></i></a>
                                                    <a class="ins" href="#"><i class="fab fa-instagram"></i></a> -->
                                                    <a class="in" href="{{ $value->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                                </div>
                                            </div>
                                            <div class="card_body">
                                                <p>{!! nl2br($value->berif_info) !!}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    @include('front.child.kyc-lock-block')
                                @endif --}}
                            @else
                                @include('front.child.lock-block')
                            @endif
                        </div>
                        <div class="tab-pane fade" id="meet" role="tabpanel" aria-labelledby="pills-contact-tab">
                            @if (Auth::guard('investor')->check())
                                @if (CommonHelper::isKycDoneInvestor())
                                    <h3>Meet List</h3>
                                    <div class="card-list">
                                        @foreach ($pitch as $livepitchlist)
                                            <div class="d_card">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="user_info">
                                                            <div class="name_type">
                                                                <p><span class="bold"> Title:
                                                                    </span>{{ $livepitchlist->title }}</p>
                                                                <p><span class="bold"> Description:
                                                                    </span>{{ $livepitchlist->description }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div>
                                                            <p>Time: <span
                                                                    class="bold">{{ \Carbon\Carbon::parse($livepitchlist->scheduled_date)->format('h:i:s') }}</span>
                                                            </p>
                                                            <p>date : <span
                                                                    class="bold">{{ \Carbon\Carbon::parse($livepitchlist->scheduled_date)->format('d-m-Y') }}</span>
                                                            </p>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-3">
                                                        <div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    @include('front.child.kyc-lock-block')
                                @endif
                            @else
                                @include('front.child.lock-block')
                            @endif
                        </div>
                        <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="pills-contact-tab">
                            @if (Auth::guard('investor')->check())
                                @if (CommonHelper::isKycDoneInvestor())
                                    {{-- @if ($updates->count() > 0)
                                        <h3>Updates</h3>
                                        <div class="all_card">
                                            @foreach ($updates as $sKey => $sValue)
                                            <div class="card_custom">
                                                <div class="card_header">
                                                    <div class="user">
                                                        <div class="image">
                                                            <img src="{{ CommonHelper::getUpdatesImage($sValue->image) }}" alt="" />
                                                        </div>
                                                        <div class="user_des">
                                                            <h5>{{ $sValue->title }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="time"><p>{{ CommonHelper::cusDateTime($sValue->cat,'d M, Y') }}</p></div>
                                                </div>
                                                <div class="card_body">
                                                    <p>
                                                        {!! CommonHelper::stringReadMoreInline($sValue->descr,500) !!}
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>    
                                    @else
                                        <div class="all_card">
                                            <div class="col-xl-4 text-center" style="margin:0 auto;">
                                                <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_1tc23tia/1.json"  background="transparent"  speed="1"  style="width: 100%;"    autoplay></lottie-player>
                                                <h3 class="text-center">Updates will be added soon</h3>
                                            </div>
                                        </div>
                                    @endif --}}
                                @else
                                    @include('front.child.kyc-lock-block')
                                @endif
                            @else
                                @include('front.child.lock-block')
                            @endif
                        </div>
                        <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="pills-contact-tab">
                            @if (Auth::guard('investor')->check())
                                {{-- @if (CommonHelper::isKycDoneInvestor())
                                    <h3>Frequently Asked Questions</h3>        
                                    <div class="faq_section">
                                        <div class="accordion" id="accordionFAQ">
                                            @foreach ($faqs as $fkey => $faq)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne{{ $fkey }}" aria-expanded="false"
                                                        aria-controls="collapseThree"><span class="ques">Q</span>
                                                        {{ $faq->que }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne{{ $fkey }}" class="accordion-collapse faq_ans collapse"
                                                    aria-labelledby="headingThree" data-bs-parent="#accordionFAQ">
                                                    <div class="accordion-body">
                                                        <span class="ans">A</span>
                                                        <span>{!! nl2br($faq->ans) !!}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    @include('front.child.kyc-lock-block')
                                @endif --}}
                            @else
                                @include('front.child.lock-block')
                            @endif
                        </div>
                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="pills-contact-tab">
                            @if (Auth::guard('investor')->check())
                                {{-- @if (CommonHelper::isKycDoneInvestor())
                                    <h3>Documents</h3>
                                    <div class="all_card">
                                        <div class="small_card card_custom">
                                            <div class="icon"><img src="{{ url('weba/assets/icons/doc_1.svg') }}" alt=""></div>
                                            <h2>Pitch-deck</h2>
                                            {!! CommonHelper::startupDocIsUploadedViewWeb($startup,'pitch_deck') !!}
                                        </div>
                                        <div class="small_card card_custom">
                                            <div class="icon"><img src="{{ url('weba/assets/icons/doc_2.svg') }}" alt=""></div>
                                            <h2>Finacial Projections</h2>
                                            {!! CommonHelper::startupDocIsUploadedViewWeb($startup,'fina_projection') !!}
                                        </div>
                                        <div class="small_card card_custom">
                                            <div class="icon"><img src="{{ url('weba/assets/icons/doc_3.svg') }}" alt=""></div>
                                            <h2>DD Report</h2>
                                            {!! CommonHelper::startupDocIsUploadedViewWeb($startup,'dd_report') !!}
                                        </div>
                                        <div class="small_card card_custom">
                                            <div class="icon"><img src="{{ url('weba/assets/icons/doc_4.svg') }}" alt=""></div>
                                            <h2>DIPP start-up certificate</h2>
                                            {!! CommonHelper::startupDocIsUploadedViewWeb($startup,'master_data_file') !!}
                                        </div>
                                        <div class="small_card card_custom">
                                            <div class="icon"><img src="{{ url('weba/assets/icons/doc_5.svg') }}" alt=""></div>
                                            <h2>{{ CommonHelper::setting('app_name') }} Research Report</h2>
                                            {!! CommonHelper::startupDocIsUploadedViewWeb($startup,'pancard') !!}
                                        </div>
                                        <div class="small_card card_custom">
                                            <div class="icon"><img src="{{ url('weba/assets/icons/doc_6.svg') }}" alt=""></div>
                                            <h2>Valuation Report</h2>
                                            {!! CommonHelper::startupDocIsUploadedViewWeb($startup,'vreport') !!}
                                        </div>
                                    </div>
                                @else
                                    @include('front.child.kyc-lock-block')
                                @endif --}}
                            @else
                                @include('front.child.lock-block')
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- <form action="{{ CommonHelperHelper::business('invest-investors') }}" method="post" id="investAginstInvestor">
        {{ csrf_field() }}
            <div class="modal fade investBuModal" id="investor_modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">

                    </div>
                </div>
            </div>
        </form> --}}
    </div>

    {{-- <script type="text/javascript">
        $(function() {
            $(document).on('click','.btn-apply-pitch', function(e){
                e.preventDefault();
                state = "yes";
                if ($(this).data('applied') == "yes") {
                    state = "no";
                    $(this).removeClass('applied');
                    $(this).addClass('apply');
                    $(this).html('Apply');
                    $(this).data('applied','no');
                }else{
                    $(this).data('applied','yes');
                    $(this).removeClass('apply');
                    $(this).addClass('applied');
                    $(this).html('Applied');
                }

                $.ajax({
                    url: "{{ url('/pitch-apply') }}",
                    type: 'POST',
                    data: {
                        _token  : '{{ csrf_token() }}',
                        state   : state,
                        pitch   : $(this).data('pitch'),
                        startup : $(this).data('startup')
                    },
                    dataType: 'JSON',
                    success: function (data) {

                    }
                });
            });
        })
    </script> --}}

    {{-- <script type="text/javascript">
        $(function(){
            $(document).on('click','#investNowBusiness', function(e){
                e.preventDefault();
                var AjaxParam = {
                    'url'       : "{{ CommonHelperHelper::business('get-investors') }}",
                    'data'      : {
                        _token  : '{{ csrf_token() }}',
                        'startup' : '{{ $startup->id }}'
                    },
                    'dataType'  : 'json',
                    'successCb' : handleGetInvestors
                };
                doAjax(AjaxParam);
            })

            $(document).on('submit','#investAginstInvestor', function(e){
                if ($('#investAginstInvestor input[name=error]').val() > 0) {
                    e.preventDefault();
                    alert('Please fix all errors','error');
                }
            })
            $('.share_group .share').click(function () {
                $('.share_group .share_link').toggleClass('share_active');
            });
        })

        function handleGetInvestors(res) {
            $('.investBuModal .modal-content').html(res.view);
            $('.investBuModal').modal('show');
        }
    </script> --}}


@stop
{{-- @endsection --}}
