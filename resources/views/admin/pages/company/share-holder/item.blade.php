<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('company.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.company.shareHoldersSave') }}"
                enctype="multipart/form-data">
                @csrf
                <div id="price-list" class="py-4">
                    {{-- @include('admin.pages.company.share-holder.partials.row', ['item' => false]) --}}
                    @if ($company->shareHolders)
                        @foreach ($company->shareHolders as $item)
                            @include('admin.pages.company.share-holder.partials.row', [
                                'item' => $item,
                            ])
                        @endforeach
                    @endif
                </div>
                <div class="card card-flush py-4">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-10  justify-content-end">
                            <button type="button" id="btn_add_share_holder" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add Share Holder
                            </button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <input type="hidden" name="item" value="{{ $company->id }}">
                    <input type="hidden" name="delete" value="">
                    <a href="{{ route('admin.company.list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            let removedIds = [];
            $(document).ready(function() {
                $(document).on("click", "#btn_add_share_holder", function(event) {
                    let newRow = $(`{!! addslashes(view('admin.pages.company.share-holder.partials.row', ['item' => false])->render()) !!}`);
                    $('#price-list').append(newRow);
                    updateNames();
                });

                $(document).on("click", ".btn-add-percentage", function(event) {
                    let newRow = $(`{!! addslashes(view('admin.pages.company.share-holder.partials.percentage', ['item' => false])->render()) !!}`);
                    $(this).closest('.card').find('.percentage-list').append(newRow);
                    updateNames();
                });

                $(document).on('click', '.btn-removeTeam', function() {
                    $(this).closest('.card').remove();
                    updateNames();
                });

                $(document).on('click', '.btn-removePercentage', function() {
                    $(this).closest('.percentage-item').remove();
                    updateNames();
                });
            });

            function updateNames() {
                $('.card').each(function(shareholderIndex) {
                    // Update the Shareholder name input
                    $(this).find('.name-input').attr('name', `shareholders[${shareholderIndex}][name]`);

                    // Update the names for each percentage row
                    $(this).find('.percentage-item').each(function(percentageIndex) {
                        $(this).find('.year-input').attr('name',
                            `shareholders[${shareholderIndex}][percentages][${percentageIndex}][year]`);
                        $(this).find('.percentage-input').attr('name',
                            `shareholders[${shareholderIndex}][percentages][${percentageIndex}][percentage]`
                        );
                    });
                });
            }
        </script>
    @endpush

</x-default-layout>
