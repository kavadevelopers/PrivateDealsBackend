<div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Investor Holdings</h3>
        </div>
    </div>
    <div class="card-body p-9">
        <table class="table table-bordered table-mini datatable">
            <thead>
                <tr>
                    <th>Investor</th>
                    <th>Startup</th>
                    <th class="text-center">Shares</th>
                    <th class="text-right">Amount Invested</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partner->investor as $invItem)
                @foreach ($invItem->portfolio as $portfolio)
                <tr>
                    <td>{{ $invItem->name }}</td>
                    <td>{{ $portfolio->startup->brand_name }}</td>
                    <td class="text-center">{{ $portfolio->shares }}</td>
                    <td class="text-right">{{ UtillsHelper::moneyFormatIndia($portfolio->investment_amount) }}
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>