@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Welcome, Admin!</h2>

        <div class="row mt-4">
            <div class="col-md-6">
                <x-card-summary-statistics :totalTasks="$totalTasks" :totalUsers="$totalUsers"/>
            </div>

            <div class="col-md-6">
                <x-card-recent-activty :recentTasks="$recentTasks" :recentUsers="$recentUsers"/>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <x-card-quick-links/>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Actionable Items</div>
                    <div class="card-body">
                        <ul>
                            <li><a href="{{route('tasks.pending')}}">To Do tasks: {{ $pendingTasksCount  ?? 0  }}</a></li>
                            <li><a href="{{route('tasks.completed')}}">Completed tasks: {{ $completedTasksCount  ?? 0  }}</a></li>
                            <li>Users awaiting approval: {{ $pendingUsersCount  ?? 0  }}</li>
                            <!-- Add more actionable items as needed -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
