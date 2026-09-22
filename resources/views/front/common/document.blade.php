@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content custom-mis-list" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <h3>{{ getPageTitle() }}</h3>
            <div class="mis_upload mis_upload_list">
                @if ($documents->count() > 0)
                    <div class="scroll_content">
                        <div class="mis_list update_list">
                            <div class="all-p-cards">
                                @foreach ($documents->get() as $document)
                                    <div class="card-p-custom">
                                        <div class="user_info">
                                            <div class="logo">
                                                <img src="{{ asset('front-assets/images/doc.jpg') }}" alt="" />
                                            </div>
                                            <div class="name_type">
                                                @if (Auth::guard('startup')->check())
                                                    <h3>{{ $document->meta->sname }}</h3>
                                                @else
                                                    <h3>{{ $document->meta->name }}</h3>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="descriptions">
                                            <p>
                                                Updated At :
                                                <span
                                                    class="bold">{{ DateTimeHelper::formatDateTime($document->created_at, 'd-m-Y') }}</span>
                                            </p>
                                        </div>
                                        <div class="actions">
                                            <a href="{{ route('download.web', ['path' => $document->signed_path, 'name' => $document->meta->name]) }}"
                                                class="download btn_custom_line">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    @include('front.common.nodata', ['text' => 'Document'])
                @endif
            </div>
        </div>

    </div>
@endsection
