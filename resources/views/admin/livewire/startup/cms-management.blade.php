<div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
    <div class="d-flex flex-column flex-lg-row-fluid gap-6 gap-lg-10">
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>CMS Details</h2>
                </div>
                <div class="card-toolbar">
                    <button class="btn btn-sm btn-primary" wire:click="$emit('openCreateModal')">
                        Create
                    </button>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex flex-column gap-5 gap-md-7">
                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <ul>
                        {{-- @forelse ($cmsEntries as $entry)
                            <li>{{ $entry->title }} - {{ $entry->content }}</li>
                        @empty
                            <li>No CMS entries found.</li>
                        @endforelse --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Create -->
    <div wire:ignore.self class="modal fade" tabindex="-1" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="create">
                    <div class="modal-header">
                        <h5 class="modal-title">Create CMS Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" class="form-control" wire:model="title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea id="content" class="form-control" wire:model="content"></textarea>
                            @error('content')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
