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
                        <form class="" action="{{ route('front.raise.pas3.save') }}" method="post" id="pass3"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>SRN.No <span class="required">*</span></label>
                                        <input readonly class="d_field" value="{{ old('srn_no', $last->srn_no) }}"
                                            type="text" name="srn_no" placeholder="Enter SRN.No" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label for="name">PAS3 Zip File <span class="required">*</span></label>
                                        <input class="d_file" type="file" name="pas3_zip_file" required
                                            onchange="fileExAllowedWithSize(this,'.zip','{{ CommonHelper::appSettings('file_document_max_size') }}')" />
                                        <i class="fa-solid fa-image input_icon"></i>
                                    </div>
                                    <p><strong>Note : </strong>Select .zip file please</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id="checkedAll">
                                            <span class="fw-bold">Select All</span>
                                        </label>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group">
                                            @foreach ($transactions as $key => $item)
                                                <div class="list-group-item">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="transactions[]"
                                                            class="form-check-input chkTransactions checkSingle"
                                                            value="{{ $item->id }}">
                                                        <span class="fw-bold">{{ $item->investor->name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <input type="hidden" name="mgt14" value="{{ $last->id }}">
                                    <button type="submit" class="btn_custom">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        $(function() {
            $('#pass3').submit(function() {
                if ($('input.chkTransactions:checked').length == 0) {
                    notifyF('Please slect investors', 'error');
                    return false;
                }
            });
            $("#checkedAll").change(function() {
                if (this.checked) {
                    $(".checkSingle").each(function() {
                        this.checked = true;
                    });
                } else {
                    $(".checkSingle").each(function() {
                        this.checked = false;
                    });
                }
            });
            $(".checkSingle").click(function() {
                if ($(this).is(":checked")) {
                    var isAllChecked = 0;
                    $(".checkSingle").each(function() {
                        if (!this.checked)
                            isAllChecked = 1;
                    });
                    if (isAllChecked == 0) {
                        $("#checkedAll").prop("checked", true);
                    }
                } else {
                    $("#checkedAll").prop("checked", false);
                }
            });
        })
    </script>
@endpush
