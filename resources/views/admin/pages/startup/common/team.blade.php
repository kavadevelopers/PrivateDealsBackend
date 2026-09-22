<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('investor.edit') }}
    @endsection
    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.startup.updateteam.post') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Team Details</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="required">Photo</th>
                                                <th class="required">Name</th>
                                                <th class="required">Designation</th>
                                                <th class="required">Experience</th>
                                                <th class="required">LinkedIn Link</th>
                                                <th class="required">Brief Introduction</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="teamBlock">
                                            @foreach ($item->teamMembers as $key => $team)
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="hidden" name="input[{{ $key }}][old_id]"
                                                            value="{{ $team->id }}">
                                                        <input type="file" class="form-control"
                                                            name="input[{{ $key }}][photo]"
                                                            onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                                        <div class="symbol symbol-50px me-5 mt-5">
                                                            <img class="shimmer lazy"
                                                                data-src="{{ FileUpDownHelper::get_startup_team_profile_photo_url($team->profile_photo) }}" />
                                                        </div>
                                                    </td>
                                                    <td><input type="text" name="input[{{ $key }}][name]"
                                                            placeholder="Name" class="form-control"
                                                            value="{{ $team->name }}" required></td>
                                                    <td><input type="text"
                                                            name="input[{{ $key }}][designation]"
                                                            placeholder="Designation" class="form-control"
                                                            value="{{ $team->designation }}" required></td>
                                                    <td>
                                                        <input type="text"
                                                        name="input[{{ $key }}][experience]"
                                                        placeholder="Experience" class="form-control"
                                                        value="{{ $team->experience }}" required>
                                                        <small class="text-danger">Note: Use the "::" symbol to separate multiple details in the experience field</small>
                                                    </td>
                                                    <td><input type="text"
                                                            name="input[{{ $key }}][linkedin]"
                                                            placeholder="LinkedIn Link" class="form-control"
                                                            value="{{ $team->linkedin_url }}" required></td>
                                                    <td>
                                                        <textarea name="input[{{ $key }}][berif]" placeholder="Brief Introduction" class="form-control">{{ $team->brief_information }}</textarea>
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
                                                <td colspan="5"></td>
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
                    <input type="hidden" name="uuid" value="{{ $uuid }}">
                    <input type="hidden" name="delete" value="">
                    <a href="{{ url()->previous() }}" class="btn btn-light me-3">Cancel</a>
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
                    let newRow = `<tr>
                         <td class="text-center">
                            <input type="hidden"
                                                            name="input[` + i + `][old_id]"
                                                            value="">
                             <input type="file" class="form-control" name="input[` + i + `][photo]"
                                 onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')" >
                         </td>
                         <td><input type="text" name="input[` + i + `][name]" placeholder="Name" class="form-control"></td>
                         <td><input type="text" name="input[` + i + `][designation]" placeholder="Designation" class="form-control"></td>
                         <td><input type="text" name="input[` + i + `][experience]" placeholder="Experience" class="form-control">
                            <small class="text-danger">Note: Use the "::" symbol to separate multiple details in the experience field</small></td>
                         <td><input type="text" name="input[` + i + `][linkedin]" placeholder="LinkedIn Link" class="form-control"></td>
                         <td><textarea name="input[` + i + `][berif]" placeholder="Brief Introduction" class="form-control" ></textarea></td>
                         <td class="text-center">
                             <button class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1 btn-removeTeam" type="button">
                                 <i class="fa fa-trash"></i>
                             </button>
                         </td>
                     </tr>`;
                    $('#teamBlock').append(newRow);
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
