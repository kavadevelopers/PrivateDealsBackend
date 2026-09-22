<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('company.list') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Search Company" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                </div>
            </div>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('success', function() {
                    $('#kt_modal_add_user').modal('hide');
                    window.LaravelDataTables['news_assignment_table'].ajax.reload();
                });
            });
        </script>
        <script>
            const documentTitle = 'News_Assignment_Report';
            $('[data-kt-user-table-filter="search"]').on('keyup', function(e) {
                window.LaravelDataTables['news_assignment_table'].search(e.target.value).draw();
            });
        </script>
    @endpush
</x-default-layout>
