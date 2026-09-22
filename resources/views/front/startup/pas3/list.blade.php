@extends('front.layouts.dashboard')
@section('child-content')
    <div class="noob tab-pane fade show" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="top_section">
            <h3>{{ getPageTitle() }}</h3>
            @if ($transactions > 0)
                @if (!$last || $last->status != App\Enums\Utills\StatusEnum::pending->value)
                    <a href="{{ route('front.raise.pas3.create') }}" class="btn_custom">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Upload PAS-3</span>
                    </a>
                @endif
            @endif
        </div>
        @if ($list->count() > 0)
            <div class="scroll_content">
                <div class="card-list">
                    @foreach ($list->get() as $key => $value)
                        <div class="card-item">
                            <div class="row">
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    <div class="user_info">
                                        <div class="logo">
                                            <img src="{{ asset('front-assets/images/pas-3.png') }}" alt="" />
                                        </div>
                                        <div class="name_type">
                                            <h3>SRN No. : {{ $value->srn_no }}</h3>
                                            <p><b>Status : </b>{{ $value->status }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <div>
                                        <div style="text-align: right;" class="mb-4">
                                            <a href="{{ route('download.web', ['path' => $value->zipDocument->signed_path, 'name' => $value->zipDocument->meta->name]) }}"
                                                class="btn_custom small-btn">
                                                <i class="fa-solid fa-download"></i>
                                                <span>Download Zip</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @include('front.common.nodata', ['text' => 'MGT-14'])
        @endif
    </div>
@endsection
