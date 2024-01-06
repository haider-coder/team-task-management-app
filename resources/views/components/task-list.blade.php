@php
    $statusColor = '';
    switch ($task->status) {
        case 'To Do':
            $statusColor = 'bg-warning'; // Yellow for 'To Do'
            break;
        case 'In Progress':
            $statusColor = 'bg-info'; // Blue for 'In Progress'
            break;
        case 'Completed':
            $statusColor = 'bg-success'; // Green for 'Completed'
            break;
        // Add more cases if needed
        default:
            $statusColor = ''; // Default color
            break;
    }
@endphp
<li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex">
        <a href="#" data-toggle="modal" data-target="#taskModal{{ $task->id }}">
            {{ $task->title }}
        </a>

    </div>
    <span class="badge ml-2 {{ $statusColor }}">{{ $task->status }}</span>

</li>


<!-- Task Modal -->
<div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">{{ $task->title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ $task->description }}</p>
            </div>

            <div class="modal-footer">
                @if(auth()->user()->type == 'manager')
                    <a href="{{ route('notify.user', ['taskId' => $task->id]) }}" class="btn btn-primary btn-sm">
                        Notify User
                    </a>
                @endif
                <form action="{{ route('tasks.update-status', $task) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group py-2">
                            <label for="feedbackInput">Feedback:</label>
                            <textarea class="form-control" id="feedbackInput" name="feedback" rows="3">{{ $task->feedback }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-warning" name="status" value="In Progress">Set as In Progress</button>
                        <button type="submit" class="btn btn-success" name="status" value="Completed">Set as Completed</button>
                    </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
