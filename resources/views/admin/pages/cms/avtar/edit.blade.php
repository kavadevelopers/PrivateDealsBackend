<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('cms.avtar.edit') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        @if (isset($item))
            <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
                <form class="form" method="POST" action="{{ route('admin.cms.avtar.update', ['avtar' => $item->uuid]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card card-flush py-4" data-select2-id="select2-data-129-k1bv">

                        <div class="card-header">
                            <div class="card-title">
                                <h2>Edit</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0" data-select2-id="select2-data-128-idrh">
                            <div class="d-flex flex-wrap gap-10" data-select2-id="select2-data-127-fpwl">
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                    <label class="form-label">Avtar</label>
                                    <input name="avtar_img" class="form-control mb-2 input" placeholder="Enter Avtar"
                                        tabindex="0" type="file" value="{{ old('avtar_img', $item->avtar_img) }}">
                                    <div class="text-muted fs-7">Set the avtar of the pages. size must be (2560w x
                                        891h)</div>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="form-label">Display Order</label>
                                    <input name="display_order" class="form-control mb-2 input"
                                        placeholder="Enter Display Order" tabindex="0" type="text" min="1"
                                        maxlength="4" value="{{ old('display_order', $item->display_order) }}">
                                    <div class="text-muted fs-7">Set the display order of the master avtar.</div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.cms.avtar.index') }}" class="btn btn-light me-5">
                                    Cancel
                                </a>
                                <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        Update
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-default-layout>
