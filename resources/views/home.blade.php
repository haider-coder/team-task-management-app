@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-chart-bar me-2"></i>Dashboard</span>
                    <span class="badge bg-light text-dark">{{ $tasks->count() }} tasks</span>
                </div>

                <div class="card-body">
                    @auth
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <h5 class="fw-semibold mb-3">Your Task Summary</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <a href="{{ route('tasks.pending') }}" class="text-decoration-none">
                                        <div class="card border-start border-4 border-warning shadow-sm">
                                            <div class="card-body text-dark">
                                                <h6 class="card-title mb-1"><i class="fa fa-hourglass-start me-2 text-warning"></i>Pending Tasks</h6>
                                                <p class="mb-0 fs-5">{{ max(auth()->user()->tasks()->pending()->count(), 0) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('tasks.inProgress') }}" class="text-decoration-none">
                                        <div class="card border-start border-4 border-info shadow-sm">
                                            <div class="card-body text-dark">
                                                <h6 class="card-title mb-1"><i class="fa fa-spinner me-2 text-info"></i>In Progress</h6>
                                                <p class="mb-0 fs-5">{{ max(auth()->user()->tasks()->inProgress()->count(), 0) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('tasks.completed') }}" class="text-decoration-none">
                                        <div class="card border-start border-4 border-success shadow-sm">
                                            <div class="card-body text-dark">
                                                <h6 class="card-title mb-1"><i class="fa fa-check-circle me-2 text-success"></i>Completed Tasks</h6>
                                                <p class="mb-0 fs-5">{{ max(auth()->user()->tasks()->completed()->count(), 0) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">All Tasks:</label>
                            @if($tasks->isEmpty())
                                <div class="alert alert-info text-center">
                                    <i class="fa fa-info-circle me-1"></i> No tasks found.
                                </div>
                            @else
                                <ul id="taskList" class="list-group list-group-flush">
                                    @foreach($tasks as $task)
                                        <x-task-list :task="$task"/>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
