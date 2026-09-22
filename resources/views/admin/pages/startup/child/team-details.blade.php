<div class="card card-xl-stretch mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Team Members</span>

            <span class="text-muted mt-1 fw-semibold fs-7">{{ $startup->teamMembers->count() }} members</span>
        </h3>
    </div>

    <div class="card-body py-3">
        <div class="tab-content">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-3">
                    <thead>
                        <tr>
                            <th class="p-0 w-50px"></th>
                            <th class="p-0 min-w-150px"></th>
                            <th class="p-0 min-w-140px"></th>
                            <th class="p-0 min-w-120px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($startup->teamMembers as $teamMember)
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img class="shimmer lazy"
                                            data-src="{{ FileUpDownHelper::get_startup_team_profile_photo_url($teamMember->profile_photo) }}" />
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $teamMember->name }}</span>
                                    <span
                                        class="text-muted fw-semibold d-block fs-7">{{ $teamMember->designation }}</span>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold d-block fs-7">
                                        {!! nl2br($teamMember->brief_information) !!}
                                    </span>

                                </td>
                                <td class="text-end">
                                    <a href="{{ $teamMember->linkedin_url }}" target="_blank"
                                        class="btn btn-icon btn-light-twitter btn-sm me-3">
                                        <i class="fa-brands fa-linkedin fs-4"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
            </div>


        </div>
    </div>
</div>
