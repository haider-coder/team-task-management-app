@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fa fa-tasks me-2"></i>Tasks for {{ $user->name }}
                    </h5>
                    <span class="badge bg-light text-dark">{{ $tasks->count() }} total</span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tasks-table" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="fa fa-heading"></i> ID</th>
                                    <th><i class="fa fa-heading"></i> Title</th>
                                    <th><i class="fa fa-tag"></i> Tag</th>
                                    <th><i class="fa fa-flag"></i> Status</th>
                                    <th><i class="fa fa-calendar"></i> Deadline</th>
                                    <th class="text-center"><i class="fa fa-cogs"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                @php
                                    $statusClass = $task->status === 'Completed'
                                        ? 'success'
                                        : ($task->status === 'In Progress' ? 'warning' : 'secondary');

                                    $deadlineFormatted = $task->deadline
                                        ? \Carbon\Carbon::parse($task->deadline)->format('M d, Y h:i A')
                                        : 'N/A';
                                @endphp
                                <tr>
                                    <td>{{$tags->firstWhere('id', $task->tag_id)->name ?? 'No Tag'}}-{{$task->id}}</td>
                                    <td>{{ $task->title }}</td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="fa fa-tag"></i>
                                            {{ optional($task->tag)->name ?? 'No tag' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ $task->status }}
                                        </span>
                                    </td>

                                    <td class="text-nowrap">
                                        <i class="fa fa-calendar-o"></i>
                                        {{ $deadlineFormatted }}
                                    </td>

                                    <td class="text-center">
                                        <div class="d-inline-flex flex-wrap gap-1">
                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Task Modal -->
                                <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content shadow-sm border-0">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">
                                                    {{$tags->firstWhere('id', $task->tag_id)->name ?? 'No Tag'}}-{{$task->id}}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-2">
                                                    <strong><i class="fa fa-heading me-1"></i>Title:</strong>
                                                    <span class="text-muted">{{ $task->title }}</span>
                                                </p>
                                                <p class="mb-2">
                                                    <strong><i class="fa fa-file-text-o me-1"></i>Description:</strong>
                                                    <span class="text-muted">{{ $task->description }}</span>
                                                </p>

                                                <p class="mb-2">
                                                    <strong><i class="fa fa-flag me-1"></i>Status:</strong>
                                                    <span class="badge bg-{{ $statusClass }}">{{ $task->status }}</span>
                                                </p>

                                                <p class="mb-2">
                                                    <strong><i class="fa fa-tag me-1"></i>Tag:</strong>
                                                    <span class="badge bg-secondary">{{ optional($task->tag)->name ?? 'No tag' }}</span>
                                                </p>

                                                <p class="mb-2">
                                                    <strong><i class="fa fa-calendar me-1"></i>Deadline:</strong>
                                                    <span class="text-muted">{{ $deadlineFormatted }}</span>
                                                </p>

                                                <p class="mb-0">
                                                    <strong><i class="fa fa-comments-o me-1"></i>Feedback:</strong>
                                                    <span class="text-muted">{{ $task->feedback ?: '—' }}</span>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fa fa-times"></i> Close
                                                </button>
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

<script>
    $(document).ready(function () {
        $('#tasks-table').DataTable({
            responsive: true,
            pageLength: 10,
            order: [], // keep natural order unless user sorts
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search tasks..."
            },
            columnDefs: [
                { orderable: false, targets: -1 } // Actions not sortable
            ]
        });
    });
</script>
@endsection


