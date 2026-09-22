@extends('front.layouts.dashboard')
@section('child-content')
    <div class="noob tab-pane fade show" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="top_section">
            <h3>{{ getPageTitle() }}</h3>
            <div>
                <a href="#" class="btn_custom" id="btn-open-bulk-upload">
                    <i class="fa-solid fa-upload"></i>
                    <span>Bulk Upload</span>
                </a>
                <a href="{{ route('front.raise.manageCaptable.addShareHolder') }}" class="btn_custom">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Add Share Holder</span>
                </a>
            </div>
        </div>
        @if ($list->count() > 0)
            <div class="scroll_content">
                <div class="card-list">
                    @foreach ($list->get() as $key => $value)
                        <div class="card-item">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="user_info">
                                        <div class="logo">
                                            <img src="{{ asset('front-assets/images/user-common.png') }}" alt="" />
                                        </div>
                                        <div class="name_type">
                                            <h3>Name : {{ $value->name }}</h3>
                                            <p><b>Email : {{ $value->email }}</b></p>
                                            <p><b>Mobile : {{ $value->mobile_number }}</b></p>
                                            <p><b>Promoter : {{ $value->is_promoter == '1' ? 'Yes' : 'No' }}</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div>
                                        <p><b>Instrument Type : {{ $value->instrument_type }}</b></p>
                                        <p><b>Investor Type : {{ $value->investor_type }}</b></p>
                                        <p><b>Share : {{ $value->share }}</b></p>
                                        <p><b>Holding : {{ $value->holding_percentage }}%</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @include('front.common.nodata', ['text' => 'Investor'])
        @endif
    </div>

    <div class="modal fade global_modal" id="modalUploadBulk" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="" id="uploadForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-weight:bold;">Import File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12"><br></div> 
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="field_group">
                                    <label>Select File <span class="required">*</span></label>
                                    <input type="file" name="file" class="file"
                                        onchange="fileExAllowedWithSize(this,'.xls,.xlsx','{{ CommonHelper::appSettings('file_document_max_size') }}')"
                                        required />
                                    <i class="fa-solid fa-image input_icon"></i>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><br></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('front.raise.manageCaptable.download') }}"><i
                                        class="fa-solid fa-download"></i> Download Template</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Note:</b> The imported file has a limit of 1,000 rows. If the number of rows exceeds
                                    this limit, any additional data will be skipped.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn_custom btn_close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn_custom">Import</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('custom-scripts')
    <script>
        $('#btn-open-bulk-upload').click(function(e) {
            e.preventDefault();
            $('#modalUploadBulk').modal('show');
        });

        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            showAjaxLoader();
            axios
                .post('{{ route('front.raise.manageCaptable.upload') }}', formData)
                .then(function(response) {
                    if (!response.data.status) {
                        showAjaxLoader(false);
                        showErrorMessage(response.data.message);
                    } else {
                        location.reload();
                    }
                })
                .catch(function(error) {
                    showErrorMessage(error);
                    showAjaxLoader(false);
                });
        });
    </script>
@endpush
