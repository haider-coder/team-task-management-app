@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @auth()
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="container">
                                <h2>Your Tasks</h2>
                                <!-- Cards for total tasks -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <a href="{{route('tasks.pending')}}">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Pending Tasks</h5>
                                                <p class="card-text">{{ max(auth()->user()->tasks()->pending()->count(), 0) }}</p>
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <a href="{{route('tasks.inProgress')}}">
                                            <div class="card-body">
                                                <h5 class="card-title">Total In Progress Tasks</h5>
                                                <p class="card-text">{{ max(auth()->user()->tasks()->inProgress()->count(), 0) }}</p>
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <a href="{{route('tasks.completed')}}">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Completed Tasks</h5>
                                                <p class="card-text">{{ max(auth()->user()->tasks()->completed()->count(), 0) }}</p>
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Filter dropdown or buttons -->

                                <div class="mb-3">
                                    <label for="statusFilter" class="form-label">All Tasks:</label>
                                </div>
                                <ul id="taskList" class="list-group">

                                    @foreach($tasks as $task)
                                <!-- Task list -->
                                    <x-task-list :task="$task"/>

                                    @endforeach
                                </ul>



                            </div>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
