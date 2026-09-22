<div class="card mb-5 mb-xl-10">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Relation Manager</h3>
        </div>
    </div>
    <div class="card-body p-9">
        <table class="table table-bordered table-mini datatable">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Investor</th>
                    <th>Mobile</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allPartner as $relationManagerItem)
                    <tr>
                        <td>{{ $relationManagerItem->type }}</td>
                        <td>{{ $relationManagerItem->name }}</td>
                        <td>{{ $relationManagerItem->mobile_number }}</td>
                        <td>{{ $relationManagerItem->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
