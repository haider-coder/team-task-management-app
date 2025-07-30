@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Tasks</h5>
            @if(auth()->user()->type != 'user' && auth()->user()->type != 'manager')
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-plus"></i> Add Task
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="taskTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            @if(auth()->user()->type != 'user')
                                <th>User</th>
                            @endif
                            <th>Status</th>
                            <th>Deadline</th>
                            @if(auth()->user()->type != 'user')
                                <th>Notify by Mail</th>
                            @endif
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                     
                        <tr>
                            <td>
                                
                                {{$tags->firstWhere('id', $task->tag_id)->name ?? 'No Tag'}}-{{$task->id}}
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#taskModal{{ $task->id }}">
                                    {{ $task->title }}
                                </a>
                            </td>
                            @if(auth()->user()->type != 'user')
                                <td>{{ $task->user->name }} ({{ $task->user->type }})</td>
                            @endif
                            <td>
                                @php
                                    $statusColor = match($task->status) {
                                        'To Do' => 'bg-warning',
                                        'In Progress' => 'bg-info',
                                        'Completed' => 'bg-success',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusColor }}">{{ $task->status }}</span>
                            </td>
                            <td>
                                {{$task->deadline}}
                            </td>
                            @if(auth()->user()->type != 'user')
                                <td>
                                    <a href="{{ route('notify.user', ['taskId' => $task->id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-envelope"></i> Notify
                                    </a>
                                </td>
                            @endif
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#taskModal{{ $task->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    @if(auth()->user()->type != 'user' && auth()->user()->type != 'manager')
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="d-inline-block"
                                              onsubmit="return confirm('Are you sure you want to delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('tasks.update-status', $task) }}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning" name="status" value="In Progress">In Progress</button>
                                            <button type="submit" class="btn btn-sm btn-success" name="status" value="Completed">Completed</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                            
                        </tr>

                        {{-- Modal --}}
                        <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">
                                            
                                             {{$tags->firstWhere('id', $task->tag_id)->name ?? 'No Tag'}}-{{$task->id}}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Title:</strong> {{ $task->title }}</p>
                                        <p><strong>Description:</strong> {{ $task->description }}</p>
                                        <p><strong>Status:</strong> {{ $task->status }}</p>
                                        <p><strong>Deadline:</strong> {{ $task->deadline }}</p>
                                        <p><strong>User:</strong> {{ $task->user->name }}</p>
                                        <p><strong>Feedback:</strong> {{ $task->feedback }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#taskTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search tasks..."
            },
            columnDefs: [
                { orderable: false, targets: [-1, -2] } // prevent sorting on action columns
            ]
        });
    });
</script>
@endsection


