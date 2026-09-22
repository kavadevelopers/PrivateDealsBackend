<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('company.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.company.eventSave') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Events</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="required">Date</th>
                                                <th class="">File</th>
                                                <th class="required">Title</th>
                                                <th class="required">Description</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="teamBlock">
                                            @php
                                                $key = 0;
                                            @endphp
                                            @foreach ($company->events as $key => $event)
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="hidden" name="input[{{ $key }}][old_id]"
                                                            value="{{ $event->id }}">
                                                        <input type="text" class="form-control flat-datepicker"
                                                            name="input[{{ $key }}][date]"
                                                            value="{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}"
                                                            required>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="file" class="form-control"
                                                            name="input[{{ $key }}][file]"
                                                            onchange="fileExAllowedWithSize(this,'.pdf,.png,.jpg,.jpeg,.xlsx','{{ CommonHelper::appSettings('file_image_max_size') }}')">

                                                        @if ($event->file && $event->file != null && $event->file != '')
                                                            <p><a
                                                                    href="{{ route('download.web', ['path' => $event->file, 'name' => 'File of ' . $company->brand_name . ' - Event ' . $event->title]) }}">Download</a>
                                                            </p>
                                                        @endif
                                                    </td>
                                                    <td><input type="text" name="input[{{ $key }}][title]"
                                                            placeholder="Title" class="form-control"
                                                            value="{{ $event->title }}" required></td>
                                                    <td>
                                                        <textarea name="input[{{ $key }}][description]" placeholder="Description" class="form-control" required>{{ $event->description }}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1 btn-removeTeam"
                                                            type="button">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1"
                                                        id="btn-add-mem">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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
            $(document).ready(function() {
                let i = parseInt('{{ $key + 1 }}');
                $('#btn-add-mem').on('click', function() {
                    let newRow = $(`<tr>
                 <td class="text-center">
                    <input type="hidden" name="input[` + i + `][old_id]" value="">
                    <input type="text" class="form-control flat-datepicker"  placeholder="Date" name="input[` + i + `][date]" required>
                 </td>
                 <td class="text-center">
                    <input type="file" class="form-control" name="input[` + i + `][file]" onchange="fileExAllowedWithSize(this,'.pdf,.png,.jpg,.jpeg,.xlsx','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                 </td>
                 <td><input type="text" name="input[` + i + `][title]" placeholder="Title" class="form-control" required></td>
                 <td><textarea name="input[` + i + `][description]" placeholder="Description" class="form-control" required></textarea></td>
                 <td class="text-center">
                     <button class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1 btn-removeTeam" type="button">
                         <i class="fa fa-trash"></i>
                     </button>
                 </td>
             </tr>`);
                    $('#teamBlock').append(newRow);
                    newRow.find(".flat-datepicker").flatpickr({
                        dateFormat: "d-m-Y",
                        defaultDate: "today"
                    });
                    i++;
                });

                $(document).on('click', '.btn-removeTeam', function() {
                    var $row = $(this).closest('tr');
                    var oldIdValue = $row.find('input[name*="[old_id]"]').val();
                    if (oldIdValue != "") {
                        var $form = $(this).closest('form');
                        var existingValues = $form.find('input[name=delete]').val();
                        var updatedValues = existingValues ? existingValues + ',' + oldIdValue : oldIdValue;
                        $form.find('input[name=delete]').val(updatedValues);
                    }
                    $row.remove();
                });
            });
        </script>
    @endpush
</x-default-layout>
<!-- End Team Members Section -->
