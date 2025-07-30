@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-list-check me-2"></i>In-Progress</span>
                    <span class="badge bg-light text-dark">{{ $tasks->count() }} tasks</span>
                </div>

                <div class="card-body">
                    @if($tasks->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle me-1"></i> No tasks found.
                        </div>
                    @else
                        {{-- <ul id="taskList" class="list-group list-group-flush">
                            @foreach($tasks as $task)
                                <x-task-list :task="$task"/>
                            @endforeach
                        </ul> --}}
                        <table id="tasks-table" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Assigned User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <x-task-list :task="$task"/>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
  $('#tasks-table').DataTable({
    responsive: true,
    pageLength: 10,
    order: [],
    language: { search: "_INPUT_", searchPlaceholder: "Search tasks..." }
  });
});
</script>
@endsection
