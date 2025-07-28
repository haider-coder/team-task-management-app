@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-list-check me-2"></i>Completed Tasks</span>
                    <span class="badge bg-light text-dark">{{ $tasks->count() }} tasks</span>
                </div>

                <div class="card-body">
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
            </div>
        </div>
    </div>
</div>
@endsection
