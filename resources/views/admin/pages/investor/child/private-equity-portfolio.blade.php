<div class="card mb-5 mb-xl-10">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Startup Portfolio</h3>
        </div>
    </div>
    <div class="card-body p-9">
        <table class="table table-bordered table-mini datatable">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Shares</th>
                    <th>Invested Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($investor->pportfolio as $portfolio)
                    <tr>
                        <td>{{ $portfolio->company->brand_name }}</td>
                        <td>{{ $portfolio->shares }}</td>
                        <td>{{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($portfolio->investment_amount) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
