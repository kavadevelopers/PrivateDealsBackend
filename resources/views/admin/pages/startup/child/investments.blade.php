<div class="card mb-5 mb-xl-10">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Investments</h3>
        </div>
    </div>
    <div class="card-body p-9">
        <table class="table table-bordered table-mini datatable">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Investor</th>
                    <th>Instrument</th>
                    <th>Shares</th>
                    <th>Share Price</th>
                    <th>Invested Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($startup->primary_transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->type }}</td>
                        <td>{{ $transaction->investor->name }}</td>
                        <td>{{ $transaction->instrument }}</td>
                        <td>{{ $transaction->shares }}</td>
                        <td>{{ $transaction->share_price }}</td>
                        <td>{{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($transaction->investment_amount) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
