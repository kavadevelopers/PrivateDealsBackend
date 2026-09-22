@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="update_content">
                <div class="top_section">
                    <h3>{{ getPageTitle() }}</h3>
                </div>
                <div class="">
                    <div class="d_card">
                        <form class="" action="{{ route('front.raise.mis.save') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>Title <span class="required">*</span></label>
                                        <input required class="d_field" value="{{ old('title') }}" type="text"
                                            name="title" placeholder="Enter title" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label for="name">MIS File <span class="required">*</span></label>
                                        <input class="d_file" type="file" name="document" required
                                            onchange="fileExAllowedWithSize(this,'.pdf,.xlsx,.csv','{{ CommonHelper::appSettings('file_document_max_size') }}')" />
                                        <i class="fa-solid fa-image input_icon"></i>
                                    </div>
                                    <p><strong>Note : </strong>Select .pdf,.xlsx,.csv files please</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d_field_group">
                                        <label>Description <span class="required">*</span></label>
                                        <textarea class="d_field_ta" name="description" placeholder="Enter Description" required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn_custom">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="scroll_content">
                        <div class="mis_list update_list">
                            <div class="all-p-cards">
                                @foreach ($list as $key => $value)
                                    <div class="card-p-custom">
                                        <div class="user_info">
                                            <div class="logo">
                                                <img class="lazy shimmer"
                                                    data-src="{{ FileUpDownHelper::get_startup_logo_url($value->startup) }}" />
                                            </div>
                                            <div class="name_type">
                                                <h3>{!! UtillsHelper::read_more_hide($value->title, 30) !!}</h3>
                                                <p>{{ ucfirst($value->status->value) }}</p>
                                            </div>
                                        </div>
                                        <div class="descriptions">
                                            <p>
                                                {!! UtillsHelper::stringReadMoreInline($value->description, 50) !!}
                                            </p>
                                            <p>
                                                Uploaded At :
                                                <span
                                                    class="bold">{{ DateTimeHelper::formatDateTime($value->created_at, 'd M, Y') }}</span>
                                            </p>
                                        </div>
                                        <div class="actions">
                                            <a href="{{ route('download.web', ['path' => $value->document, 'name' => 'MIS_' . $value->startup->brand_name . '_' . $value->title]) }}"
                                                class="download btn_custom_line">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                            @if ($value->status == \App\Enums\Utills\StatusEnum::pending)
                                                <a href="{{ route('front.raise.mis.delete', ['id' => $value->id]) }}"
                                                    class="delete btn_custom_line btn-delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
