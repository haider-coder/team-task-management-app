@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-list-check me-2"></i>Todo</span>
                    <span class="badge bg-light text-dark">{{ $tasks->count() }} tasks</span>
                </div>

                <div class="card-body">
                    @if($tasks->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle me-1"></i> No tasks found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="todo-tasks-table" class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fa fa-tag"></i> ID</th>
                                        <th><i class="fa fa-heading"></i> Title</th>
                                        <th class="text-nowrap"><i class="fa fa-calendar"></i> Deadline</th>
                                        <th><i class="fa fa-user"></i> Assigned User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        @php
                                            $deadlineFormatted = $task->deadline
                                                ? \Carbon\Carbon::parse($task->deadline)->format('M d, Y h:i A')
                                                : 'N/A';
                                        @endphp
                                        <tr>
                                            {{-- Tag (name + id) --}}
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <i class="fa fa-tag"></i>
                                                   {{ $tags->firstWhere('id', $task->tag_id)->name ?? 'No Tag' }}-{{ $task->id }}
                                                </span>
                                            </td>

                                            {{-- Title --}}
                                            <td>{{ $task->title }}</td>

                                            {{-- Deadline --}}
                                            <td class="text-nowrap">
                                                <i class="fa fa-calendar-o"></i>
                                                {{ $deadlineFormatted }}
                                            </td>

                                            {{-- Assigned user --}}
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><i class="fa fa-id-badge me-1 text-muted"></i>{{ $task->user->name }}</span>
                                                    @if(!empty($task->user->email))
                                                        <small class="text-muted"><i class="fa fa-envelope me-1"></i>{{ $task->user->email }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /table-responsive -->
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#todo-tasks-table').DataTable({
            responsive: true,
            pageLength: 10,
            order: [], // keep natural order unless the user sorts
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search todo tasks..."
            }
        });
    });
</script>
@endsection
