<table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
    <thead>
        <tr class="fw-semibold fs-6 text-gray-800">
            <th class="pe-7">Round Name</th>
            <th class="pe-7">Round Type</th>
            <th class="pe-7">Round Status</th>
            <th class="pe-7">Instrument Type</th>
            <th class="pe-7">Fund Requirement</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rounds as $round)
            <tr>
                <td>{{ ucfirst($round->name) }}</td>
                <td>{{ ucfirst($round->round_type) }}</td>
                <td>{{ ucfirst($round->round_status) }}</td>
                <td>{{ ucfirst($round->instrument) }}</td>
                <td>{{ ucfirst($round->fund_requirement) }}</td>

                <td class="text-center">
                    <a href="#" class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1 editRoundDetails"
                        data-id="{{ $round->id }}">
                        <i class="fas fa-pencil fs-6"></i>
                    </a>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
