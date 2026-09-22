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
                    <th>Startup</th>
                    <th>Instrument</th>
                    <th>Shares</th>
                    <th>Invested Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($investor->portfolio as $portfolio)
                    <tr>
                        <td>{{ $portfolio->startup->brand_name }}</td>
                        <td>{{ $portfolio->instrument }}</td>
                        <td>{{ $portfolio->shares }}</td>
                        <td>{{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($portfolio->investment_amount) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
