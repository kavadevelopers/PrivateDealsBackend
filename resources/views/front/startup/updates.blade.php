@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="update_content">
                <h3>{{ getPageTitle() }}</h3>
                <div class="scroll_content">
                    <div class="d_card">
                        <form class="" action="{{ route('front.raise.updates.save') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>Thumbnail <span class="required">*</span></label>
                                        <input class="d_file" type="file" name="image"
                                            onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg','{{ CommonHelper::appSettings('file_image_max_size') }}')"
                                            required />
                                        <i class="fa-solid fa-image input_icon"></i>
                                    </div>
                                    <p><strong>Note : </strong>Select image size like (512x512 or 1024x1024) for better
                                        view</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>Title <span class="required">*</span></label>
                                        <input required class="d_field" value="{{ old('title') }}" type="text"
                                            name="title" placeholder="Enter title" required />
                                    </div>
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
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="update_list">
                        <div class="all-p-cards">
                            @foreach ($list as $key => $value)
                                <div class="card-p-custom">
                                    <div class="user_info">
                                        <div class="logo">
                                            <img class="lazy shimmer"
                                                data-src="{{ FileUpDownHelper::get_startup_updates_url($value->image) }}" />
                                        </div>
                                        <div class="name_type">
                                            <h3>{!! UtillsHelper::read_more_hide($value->title, 30) !!}</h3>
                                            <p>{{ ucfirst($value->status->value) }}</p>
                                        </div>
                                    </div>
                                    <div class="descriptions">
                                        <p>
                                            {!! UtillsHelper::stringReadMoreInline($value->description, 200) !!}
                                        </p>
                                    </div>
                                    <div class="actions">
                                        <a class="delete btn_custom_line btn-delete"
                                            href="{{ route('front.raise.updates.delete', ['id' => $value->id]) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
