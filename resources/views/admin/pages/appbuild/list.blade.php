<x-default-layout>

    @section('title')
    {{ getPageTitle() }}
    @endsection

    <div class="card card-flush">

        <div class="card-header">
            <div class="card-title">
                <h2>App Builds</h2>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.systemConfiguration.appbuild.create') }}" class="btn btn-primary">
                    Upload Build
                </a>
            </div>
        </div>

        <div class="card-body">
            {{--
            @if(session('download_link'))
            <div class="alert alert-success d-flex align-items-center mb-5">
                <span class="me-2">✅ Build uploaded! Shareable download link:</span>
                <a href="{{ session('download_link') }}" target="_blank" class="fw-bold">
                    {{ session('download_link') }}
                </a>
            </div>
            @endif --}}

            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable">
                <thead>
                    <tr class="fw-bold text-muted">
                        {{-- <th>#</th> --}}
                        <th>Version</th>
                        {{-- <th>File</th> --}}
                        <th>Uploaded At</th>
                        <th>Download Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $item)
                    <tr>
                        {{-- <td>{{ $item->id }}</td> --}}
                        <td>{{ $item->version ?? '—' }}</td>
                        {{-- <td>{{ basename($item->file) }}</td> --}}
                        <td>{{ $item->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <a href="{{ route('download.web', ['path' => $item->file, 'name' => 'build ' . $item->version]) }}"
                                target="_blank" class="text-primary">
                                {{ route('download.web', ['path' => $item->file, 'name' => 'build ' . $item->version])
                                }}
                            </a>
                        </td>
                        <td>
                            {{-- Download --}}
                            <a href="{{ route('download.web', ['path' => $item->file, 'name' => 'build ' . $item->version]) }}"
                                class="btn btn-success hover-elevate-up btn-icon btn-sm me-1" title="Download">
                                <i class="fas fa-download fs-6"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.systemConfiguration.appbuild.delete', $item->id) }}"
                                method="POST" style="display:inline;" id="delete-form-{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1" title="Delete"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                                    <i class="fas fa-trash fs-6"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</x-default-layout>