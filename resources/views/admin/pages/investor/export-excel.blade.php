<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; font-weight: bold; font-size: 16px;">
                Investor List Report
            </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: left;">
                <!-- Simplified filter display using null-safe operator -->
                Status: {{ ucfirst($filters['status'] ?? 'All') }} |
                Partner: {{ ($filters['partner'] ?? '') === 'with' ? 'With Partner' : 'Without Partner' }} |
                KYC: {{ ($filters['kyc'] ?? '') === 'with' ? 'With KYC' : 'Without KYC' }} |
                Access: {{ match($filters['access'] ?? '') {
                'primary' => 'Primary Access',
                'secondary' => 'Secondary Access',
                'preipo' => 'Pre-IPO Access',
                default => 'All'
                } }} |
                Registration: {{ ($filters['date_filter'] ?? '') === 'after_june_9' ? 'After June 9, 2025' : 'Before
                June 9, 2025' }} |

                Active: {{
                match($filters['active_filter'] ?? '') {
                'today' => 'Active Today',
                'overall' => 'Active Overall',
                default => 'All'
                }
                }} |

                <!-- Safe startup name display -->
                @if($filters['startup_filter'] ?? false)
                Startup: {{ $investors?->first()?->primaryTransactions?->first()?->startup?->brand_name ?? 'N/A' }} |
                @endif

                @if($filters['preipo_filter'] ?? false)
                Pre-IPO Company: {{ $investors?->first()?->preIpoTransactions?->first()?->company?->brand_name ?? 'N/A'
                }}
                @endif
            </th>
        </tr>
        <tr>
            <th style="background-color: #f2f2f2; font-weight: bold;">#</th>
            <th style="background-color: #f2f2f2; font-weight: bold;">Investor Type</th>
            <th style="background-color: #f2f2f2; font-weight: bold;">Name</th>
            <th style="background-color: #f2f2f2; font-weight: bold;">Partner</th>
            <th style="background-color: #f2f2f2; font-weight: bold;">Mobile</th>
            <th style="background-color: #f2f2f2; font-weight: bold;">Email</th>
            {{-- <th style="background-color: #f2f2f2; font-weight: bold;">Status</th> --}}
            <th style="background-color: #f2f2f2; font-weight: bold;">Registration Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($investors as $index => $investor)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ ucfirst(str_replace('_', ' ', $investor->investor_type)) }}</td>
            <td>{{ $investor->name }}</td>
            <td>{{ $investor->partner->name ?? '—' }}</td>
            <td>{{ $investor->mobile_country_code }} {{ $investor->mobile_number }}</td>
            <td>{{ $investor->email }}</td>
            {{-- <td>{{ $investor->is_active ? 'Active' : 'Inactive' }}</td> --}}
            <td>{{ $investor->created_at->format('d M, Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align: center;">No investors found</td>
        </tr>
        @endforelse
    </tbody>
</table>