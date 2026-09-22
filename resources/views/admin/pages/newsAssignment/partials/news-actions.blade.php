<div class="d-flex justify-content-center align-items-center gap-2">
    <button type="button" class="btn btn-sm btn-light-primary btn-change-company text-nowrap" data-id="{{ $news->id }}">
        Change Company
    </button>
    <form action="{{ route('admin.news-assignment.deleteNews', $news->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this news?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-light-danger btn-icon">
            <i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
        </button>
    </form>
</div>
