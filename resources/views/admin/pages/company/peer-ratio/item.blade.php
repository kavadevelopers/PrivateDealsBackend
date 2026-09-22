<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('company.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.company.peerRatioSave') }}"
                enctype="multipart/form-data">
                @csrf
                <div id="peer-list" class="py-4">
                    @if ($company->peerratio)
                        @foreach ($company->peerratio as $item)
                            @include('admin.pages.company.peer-ratio.row', [
                                'item' => $item,
                            ])
                        @endforeach
                    @else
                        @include('admin.pages.company.peer-ratio.row', ['item' => false])
                    @endif
                </div>
                <div class="card card-flush py-4">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-10  justify-content-end">
                            <button type="button" id="btn_add_peer" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add Peer
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
                $('#btn_add_peer').click(function() {
                    $('#peer-list').append(`{!! addslashes(view('admin.pages.company.peer-ratio.row', ['item' => false])->render()) !!}`);
                });

                $(document).on('click', '.btn-removeTeam', function() {
                    let id = $(this).closest('.card').find('input[name="old[]"]').val();
                    if (id) {
                        removedIds.push(id);
                    }
                    $('input[name="delete"]').val(removedIds.join(','));
                    $(this).closest('.card').remove();
                });
            });
        </script>
    @endpush

</x-default-layout>
