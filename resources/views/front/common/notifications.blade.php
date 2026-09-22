@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="notifications" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="notification_content">
                <h3>{{ getPageTitle() }}</h3>
                @if ($list->count() > 0)
                    <div class="scroll_content">
                        <div class="all-p-cards">
                            @foreach ($list->get() as $key => $value)
                                <div class="card-p-custom">
                                    <div class="user_info">
                                        <div class="logo">
                                            <i class="fa-brands fa-accusoft"></i>
                                        </div>
                                        <div class="name_type">
                                            <h3>{{ $value->title }}</h3>
                                            <p>{{ $value->body }}</p>
                                        </div>
                                    </div>
                                    <div class="descriptions">
                                        <p>
                                            <span
                                                class="bold">{{ DateTimeHelper::formatDateTime($value->created_at, 'd M Y h:i A') }}</span>
                                        </p>
                                    </div>
                                    <div class="actions">
                                        <a href="{{ route($value->url) }}" class="download btn_custom_line">
                                            <i class="fa-solid fa-link"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    @include('front.common.nodata', ['text' => 'Notifications'])
                @endif
            </div>

        </div>
    </div>
@endsection
