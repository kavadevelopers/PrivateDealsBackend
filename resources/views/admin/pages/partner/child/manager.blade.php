@if (Auth::guard('admin')->user()->role == 'admin')
    @php
        $managers = App\Models\UserAdminModel::where('is_deleted', '0')->get();
    @endphp
    <div class="modal fade" id="editManagerModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.partner.manager') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="partner_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Manager</h1>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Select Manager</label>
                                <select class="form-select" name="manager_id" required>
                                    <option value="">-- Select Manager --</option>
                                    @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}">
                                            {{ ucfirst($manager->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="submitform" class="btn btn-primary" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif

@push('scripts')
    <script>
        $(function() {
            $(document).on("click", ".edit-manager", function(event) {
                event.preventDefault();
                $('#editManagerModel select[name=manager_id]').val($(this).data('manager'));
                $('#editManagerModel input[name=partner_id]').val($(this).data('partner'));
                $('#editManagerModel').modal('show');
            });
        })
    </script>
@endpush
