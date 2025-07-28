@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tasks for {{ $user->name }}</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tasks-table" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th colspan="3" class="text-center"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>
                                        <span class="badge bg-{{ $task->status == 'Completed' ? 'success' : ($task->status == 'In Progress' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                         <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this task?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                   
                                </tr>

                                <!-- Task Modal -->
                                <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">{{ $task->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Title:</strong> {{ $task->title }}</p>
                                                <p><strong>Description:</strong> {{ $task->description }}</p>
                                                <p><strong>Status:</strong>
                                                    <span class="badge bg-{{ $task->status == 'Completed' ? 'success' : ($task->status == 'In Progress' ? 'warning' : 'secondary') }}">
                                                        {{ ucfirst($task->status) }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- /table-responsive -->
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#tasks-table').DataTable();
    });
</script>
@endsection
