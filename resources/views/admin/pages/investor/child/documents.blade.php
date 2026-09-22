<div class="card">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Documents</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Total: {{ count($documents) }} documents</span>
        </h3>
    </div>

    <div class="card-body py-3">
        @if(count($documents) > 0)
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-150px">Document Name</th>
                        <th class="min-w-100px">Type</th>
                        <th class="min-w-120px">Created Date</th>
                        <th class="min-w-100px text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px me-5">
                                    <span class="symbol-label bg-light">
                                        {!! getIcon('document', 'fs-2x text-gray-600') !!}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-start flex-column">
                                    <span class="text-dark fw-bold text-hover-primary fs-6">
                                        {{ $document->display_name ?? 'Document' }}
                                    </span>
                                    @if($document->description)
                                    <span class="text-muted fw-semibold text-muted d-block fs-7">
                                        {{ Str::limit($document->description, 50) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-light-info">{{ ucfirst($document->type) }}</span>
                        </td>
                        <td>
                            <span class="text-muted fw-semibold text-muted d-block fs-7">
                                {{ $document->created_at->format('M d, Y') }}
                            </span>
                            <span class="text-muted fw-semibold text-muted d-block fs-8">
                                {{ $document->created_at->format('h:i A') }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                @if($document->signed_path)
                                <a href="{{ route('download.web', ['path' => $document->signed_path, 'name' => $document->display_name ?? 'document']) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    {!! getIcon('cloud-download', 'fs-2') !!}
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="d-flex flex-column flex-center">
            <img src="{{ asset('admin/media/illustrations/sketchy-1/5.png') }}" alt="" class="mw-300px">
            <div class="fs-3 fw-bolder text-dark mb-4">No Documents Found</div>
            <div class="fs-6">No documents are available for this investor yet.</div>
        </div>
        @endif
    </div>
</div>