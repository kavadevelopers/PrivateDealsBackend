<div class="d-flex align-items-center gap-1">
    <a href="{{ route('admin.broadcast.whatsapp.view', ['item' => $row->id]) }}"
        class="btn btn-primary hover-elevate-up btn-icon btn-sm me-1" title="View Details">
        <i class="fas fa-eye fs-6"></i>
    </a>

    @if ($row->pending_count > 0)
    <form action="{{ route('admin.broadcast.whatsapp.cancel', ['item' => $row->id]) }}" method="POST"
        style="display: inline;"
        onsubmit="return handleCancelSubmit(this, '{{ $row->pending_count }}', '{{ $row->template_name }}')">
        @csrf
        <button type="submit" class="btn btn-danger hover-elevate-up btn-icon btn-sm me-1 cancel-btn"
            title="Cancel Pending Messages">
            <i class="fas fa-times fs-6"></i>
        </button>
    </form>
    @endif

    @if($row->failed_count > 0)
    @if($row->pending_count == 0 && !$row->resend_clicked)
    <form action="{{ route('admin.broadcast.whatsapp.resend', ['item' => $row->id]) }}" method="POST"
        style="display: inline;"
        onsubmit="return handleResendSubmit(this, '{{ $row->failed_count }}', '{{ $row->template_name }}')">
        @csrf
        <button type="submit" class="btn btn-warning hover-elevate-up btn-icon btn-sm me-1 resend-btn"
            title="Create New Broadcast for Failed Messages">
            <i class="fas fa-redo fs-6"></i>
        </button>
    </form>
    @elseif($row->resend_clicked)
    <button type="button" class="btn btn-success btn-icon btn-sm me-1"
        title="Resend already processed - Check for new broadcast" disabled>
        <i class="fas fa-check fs-6"></i>
    </button>
    @endif
    @endif
</div>

@if($row->resend_clicked)
<small class="text-success d-block">Resend completed</small>
@endif