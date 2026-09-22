    @if ($value->type == '1')
        <a class="card_custom" href="{{ route('front.pages.blog.view', $value->url_slug) }}">
        @else
            <a class="card_custom" href="{{ $value->long_description }}" target="_blank">
    @endif
    <div>

        <div class="image">
            <img class="lazy shimmer" data-src="{{ FileUpDownHelper::get_page_blog_banner_url($value->banner) }}"
                alt="">
        </div>
        <div class="info">
            <div class="user_date">
                <div class="date">
                    <div class="icon"><i class="fa-solid fa-calendar-days"></i></div>
                    <p>{{ DateTimeHelper::viewDate($value->created_at, 'd M Y') }}</p>
                </div>
            </div>
            <div class="title">
                <h3>{{ UtillsHelper::read_more_hide($value->title, 22) }}</h3>
                <p>{{ UtillsHelper::read_more_hide($value->short_description, 50) }}</p>
            </div>
            <button class="button_plain">
                <span>Read More</span> <i class="fa-solid fa-arrow-right-long"></i>
            </button>
        </div>
    </div>
    </a>
