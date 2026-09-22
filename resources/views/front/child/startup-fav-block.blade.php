{{-- @php
    $getInvested = Common::getInvested($value);
@endphp --}}
<a href="{{ route('front.deal',['slug' => $value->startup->url_slug]) }}" class="card_custom">
    <div class="video">
        <video class="card_video" src="{{ FileUpDownHelper::getStartupVideo($value->startup) }}" poster="{{ FileUpDownHelper::getStartupBanner($value->startup) }}" controlsList="nodownload" loop muted ></video>
    </div>
    <div class="card_body_info">
        <div class="card_top">
            <div class="co_profile">
                <div class="logo">
                    <img src="{{ FileUpDownHelper::get_startup_logo_url($value->startup) }}" alt="">
                </div>
                <div class="info">
                    <h3>{{ UtillsHelper::read_more_hide($value->startup->brand_name,15) }}</h3>
                    <p>by:{{ UtillsHelper::read_more_hide($value->startup->representative_name,20) }}</p>
                </div>
            </div>
            <button class="btn_custom fav-btn btn_favrited fav_active" data-isrefresh="1" data-action="{{ route('front.investor.markStartupFav') }}" data-startup="{{ $value->startup->id }}"><i class="fa-solid fa-star"></i><span>Favorite</span></button>
        </div>
        <div class="card_bottom">
            <div class="categoriy_city">
                <div class="category">
                    <div class="icon">
                        <img src="{{ asset('front-assets/icons/media_tech.svg') }}" alt="">
                    </div>
                    <p>{{$value->startup->sector->name }}</p>
                </div>
                <div class="city">
                    <div class="icon">
                        <img src="{{ asset('assets/media/flags/india.svg') }}" alt="">
                    </div>
                    <p>{{ UtillsHelper::read_more_hide($value->startup->city->name,15) }}</p>
                </div>
            </div>    
        </div>
    </div>
</a>