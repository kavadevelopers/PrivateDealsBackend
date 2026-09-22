<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('activeToday.list') }}
    @endsection


    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>List</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column gap-5 gap-md-7">
                        <div class="table-responsive">
                            <table class="table table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="pe-7">Screen</th>
                                        <th class="pe-7">Discription</th>
                                        {{-- <th class="pe-7">Device ID</th>
                                        <th class="pe-7">Useragent</th> --}}
                                        <th class="pe-7">Start Time</th>
                                        <th class="pe-7">Time Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($list as $item)
                                        <tr>
                                            <td>{{ UtillsHelper::getProperFunctionForAppLogs($item->url) }}</td>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td>{{ $item->deviceid }}</td>
                                            <td>{{ $item->useragent }}</td>
                                            <td>
                                                <span
                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{ DateTimeHelper::formatDateTime($item->created_at, 'd M Y h:i A') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ $item['screen_name'] }}</td>
                                            <td>{{ $item['description'] }}</td>
                                            <td>
                                                {{ DateTimeHelper::formatDateTime($item['start_time'], 'h:i:s A') }}
                                            </td>
                                            <td>
                                                @php
                                                    $timeSpent = $item['time_spent'];
                                                    if (is_numeric($timeSpent)) {
                                                        if ($timeSpent >= 3600) {
                                                            $hours = floor($timeSpent / 3600);
                                                            $minutes = floor(($timeSpent % 3600) / 60);
                                                            echo "{$hours} hours {$minutes} minutes";
                                                        } elseif ($timeSpent >= 60) {
                                                            $minutes = floor($timeSpent / 60);
                                                            echo "{$minutes} minutes";
                                                        } else {
                                                            echo "{$timeSpent} seconds";
                                                        }
                                                    } else {
                                                        echo $timeSpent;
                                                    }
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $("#kt_datatable_dom_positioning").DataTable({
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "order": [],
                    "dom": "<'row mb-2'" +
                        "<'col-sm-6 d-flex align-items-center justify-conten-start dt-toolbar'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">"
                });
            })
        </script>
    @endpush
</x-default-layout>
