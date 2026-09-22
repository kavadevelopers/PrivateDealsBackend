<div class="d-flex align-items-center justify-content-center gap-1">
    <button type="button"
        class="btn btn-primary hover-elevate-up btn-icon btn-sm view-contact"
        data-id="{{ $row->id }}"
        title="View Details">
        <i class="fas fa-eye fs-6"></i>
    </button>
    <button type="button"
        class="btn btn-danger hover-elevate-up btn-icon btn-sm delete-contact"
        data-id="{{ $row->id }}"
        title="Delete">
        <i class="fas fa-trash fs-6"></i>
    </button>
</div>
