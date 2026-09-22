@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content custom-mis-list" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="top_section">
                <h3>{{ getPageTitle() }}</h3>
            </div>
            <div class="scroll_custom">
                @if ($startups->count() > 0)
                    @foreach ($startups->get() as $item)
                        @include('front.investor.partials.mis', ['item' => $item])
                    @endforeach
                @else
                    @include('front.common.nodata', ['text' => 'MIS'])
                @endif
            </div>
        </div>

    </div>
@endsection
