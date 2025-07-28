@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="fw-bold mb-4">Welcome, Admin!</h2>

    <!-- Summary & Recent Activity -->
    <div class="row g-4">
        <div class="col-lg-6">
            <x-card-quick-links />
        </div>
        <div class="col-lg-6">
            <x-card-recent-activty :recentTasks="$recentTasks" :recentUsers="$recentUsers" />
        </div>
    </div>

    <!-- Quick Links & Actionable Items -->
    <div class="row g-4 mt-1">
        <div class="col-lg-6">
            <x-card-summary-statistics :totalTasks="$totalTasks" :totalUsers="$totalUsers" />
        </div>
        

        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Actionable Items</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('tasks.pending') }}" class="text-decoration-none">To Do Tasks</a>
                            <span class="badge bg-primary rounded-pill">{{ $pendingTasksCount ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('tasks.inProgress') }}" class="text-decoration-none">In-Progress Tasks</a>
                            <span class="badge bg-danger rounded-pill">{{ $inprogressTasksCount ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('tasks.completed') }}" class="text-decoration-none">Completed Tasks</a>
                            <span class="badge bg-success rounded-pill">{{ $completedTasksCount ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Users Awaiting Approval
                            <span class="badge bg-warning text-dark rounded-pill">{{ $pendingUsersCount ?? 0 }}</span>
                        </li>
                        {{-- Add more items here as needed --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
