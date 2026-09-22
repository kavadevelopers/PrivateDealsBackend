@if (request()->routeIs('front.business.*'))
    <a href="{{ url(Common::business('startup/' . Illuminate\Support\Facades\Crypt::encrypt($value->id))) }}"
        class="card_custom card_one">
    @else
        <a href="{{ route('front.deal', ['slug' => $value->startup->url_slug]) }}" class="card_custom card_one">
@endif
<div class="video">
    <video class="card_video" src="{{ FileUpDownHelper::getStartupVideo($value->startup) }}"
        poster="{{ FileUpDownHelper::getStartupBanner($value->startup) }}" controlsList="nodownload" loop muted></video>

</div>
<div class="card_body_info">
    <div class="co_profile">
        <div class="logo">
            <img src="{{ FileUpDownHelper::get_startup_logo_url($value->startup) }}" class="lazy shimmer"
                alt="">
        </div>
        <div class="info">
            <h3>{{ UtillsHelper::read_more_hide($value->startup->brand_name, 15) }}</h3>
            <p>{{ UtillsHelper::read_more_hide($value->startup->brief_information, 80) }}</p>
        </div>
    </div>
    <div class="categoriy_city">
        <div class="category">
            <div class="icon">
                <img src="{{ asset('front-assets/icons/media_tech.svg') }}" alt="">
            </div>
            <p>{{ UtillsHelper::read_more_hide($value->startup->sector->name, 15) }}</p>
        </div>
        <div class="city">
            <div class="icon">
                <img src="{{ asset('assets/media/flags/india.svg') }}" alt="">
            </div>
            <p>{{ UtillsHelper::read_more_hide($value->startup->city->name, 15) }}</p>
        </div>
    </div>
</div>
</a>
