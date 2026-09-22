@extends('front.layouts.dashboard')

@section('child-content')

  
<div class="tab-pane fade show active" id="star" role="tabpanel" aria-labelledby="v-pills-home-tab">
    <h3 class="main_title">{{ getPageTitle() }}</h3>
    <div class="portfolio_content">
        <div class="all_cards">
            @if ($favlist->count() > 0)
                @foreach ($favlist->get() as $key => $value)
                    @include('front.child.startup-fav-block', array('value' => $value))
                @endforeach
            @else
                @include('front.common.nodata', ['text' => 'Favourite Startup'])
            @endif
        </div>
    </div>
</div>
                            
@stop