@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Manager Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h4>Welcome, Manager!</h4>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <x-card-summary-statistics :totalTasks="$totalTasks" :totalUsers="$totalUsers"/>
                            </div>

                            <div class="col-md-6">
                                <x-card-recent-activty :recentTasks="$recentTasks" :recentUsers="$recentUsers"/>
                            </div>
                        </div>
                        <hr>
                        <x-card-quick-links>

                        </x-card-quick-links>
                        <br>
                        <p>Here's what you can do:</p>

                        <hr>
                        <h3>Your Tasks</h3>
                        @foreach($tasks as $task)
                            <!-- Task list -->
                            <hr>
                            <x-task-list :task="$task"/>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection()
