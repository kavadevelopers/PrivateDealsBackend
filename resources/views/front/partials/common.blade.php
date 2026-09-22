<div id="ajaxLoad" style="display: none;">
    <div class="ajaxLoad-spinner">
        <span class="ajaxLoad-spinner-round"></span>
    </div>
</div>

<div class="modal global_modal fade data_change" id="modalConfirm" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data change notice</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div> -->
            <div class="modal-body">
                <div class="success_icon icon_warning">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="warning">
                        <circle class="solid" fill="none" stroke-linecap="round" stroke-width="4"
                            stroke-miterlimit="10" cx="32" cy="32" r="30" />
                        <circle class="animation" fill="none" stroke-linecap="round" stroke-width="4"
                            stroke-miterlimit="10" cx="32" cy="32" r="30" />
                        <path fill="none" stroke="#000" stroke-width="6" stroke-linecap="round"
                            stroke-miterlimit="10" d="M32 15v20" />
                        <line fill="none" stroke="#000" stroke-width="8" stroke-linecap="round"
                            stroke-miterlimit="10" x1="32" y1="46" x2="32" y2="46" />
                    </svg>
                </div>
                <h5 class="modal-title">Are you Sure?</h5>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Error maiores perspiciatis eius pariatur,
                    ut
                    veniam.</p>
                <div class="btn_group">
                    <button type="button" class="btn_custom btn_close btn_close_warning"
                        data-bs-dismiss="modal">Cancel</button>
                    <a href="" class="btn_custom okay_btn">Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal global_modal fade data_change" id="modalCommonDoubleButton" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="success_icon">
                </div>
                <h5 class="modal-title">Are you Sure?</h5>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Error maiores perspiciatis eius pariatur,
                    ut
                    veniam.
                </p>
                <div class="btn_group">
                    <button type="button" class="btn_custom btn_close close-modal-custom"
                        data-id="modalCommonDoubleButton" data-bs-dismiss="modal">Close</button>
                    <a href="" class="btn_custom ok-btn">Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal global_modal fade data_change" id="modalSuccess" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="success_icon">
                    <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200"
                        height="200" viewBox="0 0 70 70">
                        <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#5CB85C"
                            stroke-width="3" stroke-linecap="round" fill="transparent" />
                        <polyline id="successAnimationCheck" stroke="#5CB85C" stroke-width="4"
                            points="23 34 34 43 47 27" fill="transparent" />
                    </svg>
                </div>
                <h5 class="modal-title">Success</h5>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Error maiores perspiciatis eius pariatur,
                    ut veniam.</p>
                <button type="button" class="btn_custom close-modal-custom" data-id="modalSuccess"
                    data-bs-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<div class="modal global_modal fade data_change" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="success_icon">
                    <svg id="failureAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200"
                        height="200" viewBox="0 0 70 70">
                        <circle id="failureAnimationCircle" cx="35" cy="35" r="24" stroke="#ED1C24"
                            stroke-width="3" stroke-linecap="round" fill="transparent" />
                        <polyline class="failureAnimationCheckLine" stroke="#ED1C24" stroke-width="3"
                            points="25,25 45,45" fill="transparent" />
                        <polyline class="failureAnimationCheckLine" stroke="#ED1C24" stroke-width="3"
                            points="45,25 25,45" fill="transparent" />
                    </svg>
                </div>
                <h5 class="modal-title">Error</h5>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Error maiores perspiciatis eius pariatur,
                    ut veniam.</p>
                <button type="button" class="btn_custom close-modal-custom" data-id="modalError"
                    data-bs-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade global_modal" id="modalReadmore" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered d_modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:bold;">Full Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="info_body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn_custom close-modal-custom" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- 
<div class="modal fade global_modal" id="modalUploadPaymentReceipt" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{ route('front.investor.uploadPaymentReceipt') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight:bold;">Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12"><br></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="field_group">
                                <label>Select Receipt <span class="required">*</span></label>
                                <input type="file" name="receipt" class="file"
                                    placeholder="Enter Shares to sell"
                                    onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.pdf','{{ CommonHelper::appSettings('file_document_max_size') }}')"
                                    required />
                                <i class="fa-solid fa-image input_icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><br></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><br></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn_custom btn_close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn_custom">Upload</button>
                    <input type="hidden" name="transaction_id" />
                </div>
            </div>
        </div>
    </form>
</div> --}}
