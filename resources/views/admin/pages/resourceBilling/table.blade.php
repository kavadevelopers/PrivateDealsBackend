<table id="kt_datatable_dom_positioning" class="table table-row-bordered gy-5 gs-7">
    <thead>
        <tr class="fw-semibold fs-6 text-gray-800">
            <th class="pe-7">Project Name</th>
            <th class="pe-7">Resource Type</th>
            <th class="pe-7">Company</th>
            <th class="pe-7">Purchase Date</th>
            <th class="pe-7">Renewal Date</th>
            <th class="pe-7">Amount</th>
            <th class="pe-7">Renewal Amount</th>
            <th class="pe-7">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($resourceBilling as $item)
            <tr>
                <td>{{ ucfirst($item->projects->project_name) }}</td>
                <td>{{ ucfirst($item->resource_type) }}</td>
                <td>{{ ucfirst($item->company) }}</td>
                <td>{{ ucfirst($item->purchase_date) }}</td>
                <td>{{ ucfirst($item->renewal_date) }}</td>
                <td>{{ ucfirst($item->amount) }}</td>
                <td>{{ ucfirst($item->renewal_amount) }}</td>
                <td class="text-center">
                    <a href="#" class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1 addResourceHistory"
                        data-billing-id="{{ $item->id }}">
                        <i class="fas fa-add fs-6"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
