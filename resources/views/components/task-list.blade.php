@php
    $statusColor = match($task->status) {
        'To Do' => 'bg-warning text-dark',
        'In Progress' => 'bg-info text-white',
        'Completed' => 'bg-success',
        default => 'bg-secondary text-white'
    };
@endphp

<li class="list-group-item d-flex justify-content-between align-items-center">
    <div>
        <a href="#" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}" class="fw-bold text-decoration-none">
            <i class="fa fa-tasks me-2 text-muted"></i>{{ $task->title }}
        </a>
    </div>
    <span class="badge {{ $statusColor }} px-3 py-2 rounded-pill">{{ $task->status }}</span>
</li>

<!-- Task Modal -->
<div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">
                    <i class="fa fa-tasks me-2"></i>{{ $task->title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="mb-3">{{ $task->description }}</p>

                @if(auth()->user()->type == 'manager')
                    <a href="{{ route('notify.user', ['taskId' => $task->id]) }}" class="btn btn-primary btn-sm mb-3">
                        <i class="fa fa-bell me-1"></i> Notify User
                    </a>
                @endif

                <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="feedbackInput{{ $task->id }}" class="form-label fw-semibold">Feedback:</label>
                        <textarea class="form-control" id="feedbackInput{{ $task->id }}" name="feedback" rows="3">{{ $task->feedback }}</textarea>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" name="status" value="In Progress" class="btn btn-warning">
                            <i class="fa fa-spinner me-1"></i> Set as In Progress
                        </button>
                        <button type="submit" name="status" value="Completed" class="btn btn-success">
                            <i class="fa fa-check me-1"></i> Set as Completed
                        </button>
                        <button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i> Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
