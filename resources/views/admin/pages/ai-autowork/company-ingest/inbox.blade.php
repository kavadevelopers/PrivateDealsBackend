<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    <div class="card card-flush">
        <div class="card-header">
            <div class="card-title">
                <h2>Company Ingest Inbox</h2>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.ai-autowork.company-ingest.guide') }}" class="btn btn-sm btn-light me-2">AI Guide</a>
                <a href="{{ route('admin.ai-autowork.overview') }}" class="btn btn-sm btn-light">Overview</a>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="mb-5">
                @foreach (['pending' => 'Pending', 'rejected' => 'Rejected', 'approved' => 'Approved', 'all' => 'All'] as $key => $label)
                    <a href="{{ route('admin.ai-autowork.company-ingest.inbox', $key === 'all' ? [] : ['status' => $key]) }}"
                        class="btn btn-sm {{ ($status ?? 'pending') === $key ? 'btn-primary' : 'btn-light' }} me-1">
                        {{ $label }}
                        @if ($key === 'pending')
                            ({{ $pendingCount }})
                        @endif
                    </a>
                @endforeach
            </div>
            <div class="table-responsive">
                <table class="table table-row-bordered gy-5 gs-7">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>Received</th>
                            <th>CIN</th>
                            <th>Brand</th>
                            <th>Intent</th>
                            <th>Match</th>
                            <th>Status</th>
                            <th class="min-w-200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $row)
                            @php $rowStatus = $row->status->value ?? $row->status; @endphp
                            <tr>
                                <td>{{ $row->created_at?->format('d M Y H:i') }}</td>
                                <td>{{ $row->cin ?: '—' }}</td>
                                <td>{{ $row->brand_name ?: '—' }}</td>
                                <td>
                                    <span class="badge badge-light-{{ ($row->intent->value ?? $row->intent) === 'update' ? 'info' : 'success' }}">
                                        {{ $row->intent->value ?? $row->intent }}
                                    </span>
                                </td>
                                <td>{{ $row->matchedCompany?->brand_name ?: '—' }}</td>
                                <td>
                                    <span class="badge badge-light-{{ $rowStatus === 'pending' ? 'warning' : ($rowStatus === 'approved' ? 'success' : 'danger') }}">
                                        {{ $rowStatus }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('admin.ai-autowork.company-ingest.review', $row->uuid) }}"
                                            class="btn btn-sm btn-light-primary">
                                            {{ $rowStatus === 'pending' ? 'Review' : 'View' }}
                                        </a>

                                        @if (in_array($rowStatus, ['approved', 'rejected'], true))
                                            <form method="POST" action="{{ route('admin.ai-autowork.company-ingest.reopen', $row->uuid) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-light-warning"
                                                    onclick="return confirm('Reopen this record as pending so you can edit and approve again?')">
                                                    Reopen
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('admin.ai-autowork.company-ingest.destroy', $row->uuid) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger"
                                                onclick="return confirm('Delete this ingest record? This does not delete the live company.')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $list->links() }}
        </div>
    </div>
</x-default-layout>
