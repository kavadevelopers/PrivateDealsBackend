<div class="card mb-5 mb-xl-8">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">{{ $tabtitle }}</span>
        </h3>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-150px">User Type</th>
                        <th class="min-w-300px">Name</th>
                        <th class="min-w-150px">Mobile Number</th>
                        <th class="min-w-150px">Status</th>
                        @if ($tabtitle == 'Replied')
                            <th class="min-w-300px">Reply</th>
                        @endif
                        <th class="min-w-200px">At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $message)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary fs-6">{{ UtillsHelper::userModelToUserType($message->reference_model) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $message->username }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-start flex-column">
                                    <span
                                        class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $message->destination_mobile_no }}</span>
                                </div>

                            </td>
                            <td>
                                <div class="d-flex justify-content-start flex-column">
                                    <span
                                        class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $message->status }}</span>
                                </div>

                            </td>
                            @if ($tabtitle == 'Replied')
                                <td>
                                    <div class="d-flex justify-content-start flex-column">
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $message->replies->pluck('message')->implode(', ') }}</span>
                                    </div>

                                </td>
                            @endif
                            <td>
                                <span
                                    class="text-muted fw-semibold text-muted d-block fs-7">{{ DateTimeHelper::formatDateTime($message->created_at, 'd M Y h:i A') }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
