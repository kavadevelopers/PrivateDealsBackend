{{-- @extends('admin.layouts.app')

@section('content') --}}
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pre‑IPO Transactions (Current Month)</h1>

    @if($transactions->isEmpty())
    <p class="text-gray-600">No Pre‑IPO transactions found for this investor.</p>
    @else
    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Investor</th>
                <th class="px-4 py-2 text-left">Company</th>
                <th class="px-4 py-2 text-left">Amount</th>
                <th class="px-4 py-2 text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $tx)
            <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2">
                    @if($tx->investor)
                        {{ $tx->investor->name }}
                    @else
                        <em>Unknown investor</em>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($tx->company)
                    {{ $tx->company->brand_name }}
                    @else
                    <em>Unknown company</em>
                    @endif
                </td>
                <td class="px-4 py-2">{{ number_format($tx->investment_amount, 2) }}</td>
                <td class="px-4 py-2">{{ $tx->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
{{-- @endsection --}}