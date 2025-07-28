@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-chart-bar me-2"></i>Task Dashboard</span>
                    <span class="badge bg-light text-dark">{{ $tasks->count() }} tasks</span>
                </div>

                <div class="card-body">
                    @auth
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                <i class="fa fa-check-circle me-1"></i> {{ session('status') }}
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <a href="{{ route('tasks.pending') }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-muted">Pending</h5>
                                            <h3 class="text-warning">{{ max(auth()->user()->tasks()->pending()->count(), 0) }}</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('tasks.inProgress') }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-muted">In Progress</h5>
                                            <h3 class="text-primary">{{ max(auth()->user()->tasks()->inProgress()->count(), 0) }}</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('tasks.completed') }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-muted">Completed</h5>
                                            <h3 class="text-success">{{ max(auth()->user()->tasks()->completed()->count(), 0) }}</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><i class="fa fa-tasks me-2"></i>All Tasks</h5>
                        </div>

                        @if ($tasks->isEmpty())
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle me-1"></i> No tasks found.
                            </div>
                        @else
                            <ul id="taskList" class="list-group list-group-flush">
                                @foreach ($tasks as $task)
                                    <x-task-list :task="$task"/>
                                @endforeach
                            </ul>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
