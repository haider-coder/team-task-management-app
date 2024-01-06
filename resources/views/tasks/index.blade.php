@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">

                        <h2>All Tasks</h2>
                        @if(auth()->user()->type != 'user' && auth()->user()->type != 'manager')
                            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">Add Task</a>


                            <!-- Task list -->
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>User</th>
                                    <th>Actions</th>
                                    <th>Notify by mail</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->status }}</td>
                                        <td>{{ $task->user->name }}</td>
                                        <td>
                                            <button class="btn btn-info" data-toggle="modal"
                                                    data-target="#taskModal{{ $task->id }}">
                                                View Details
                                            </button>
                                            <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                               class="btn btn-warning">Edit</a>
                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="post"
                                                  style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this task?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('notify.user', ['taskId' => $task->id]) }}" class="btn btn-primary">
                                                Notify User
                                            </a>
                                    </tr>

                                    <!-- Task Modal -->
                                    <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="taskModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="taskModalLabel">{{ $task->title }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Title:</strong> {{ $task->title }}</p>
                                                    <p><strong>Description:</strong> {{ $task->description }}</p>
                                                    <p><strong>Status:</strong> {{ $task->status }}</p>
                                                    <p><strong>User:</strong> {{ $task->user->name }}</p>
                                                    <p><strong>Feedback:</strong> {{ $task->feedback}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    @if(auth()->user()->type == 'manager')
                                        <th>User</th>
                                    @endif
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        @php
                                            $statusColor = '';
                                            switch ($task->status) {
                                                case 'To Do':
                                                    $statusColor = 'bg-warning'; // Yellow for 'To Do'
                                                    break;
                                                case 'In Progress':
                                                    $statusColor = 'bg-info'; // Blue for 'In Progress'
                                                    break;
                                                case 'Completed':
                                                    $statusColor = 'bg-success'; // Green for 'Completed'
                                                    break;
                                                // Add more cases if needed
                                                default:
                                                    $statusColor = ''; // Default color
                                                    break;
                                            }
                                        @endphp
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#taskModal{{ $task->id }}">
                                                {{ $task->title }}
                                            </a>
                                        </td>
                                        @if(auth()->user()->type == 'manager')
                                            <td>{{ $task->user->name }} : {{ $task->user->type}}</td>
                                        @endif
                                        <td>
                                            <span class="badge {{ $statusColor }}">{{ $task->status }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                @if(auth()->user()->type == 'manager')
                                                    <a href="{{ route('notify.user', ['taskId' => $task->id]) }}" class="btn btn-primary btn-sm">
                                                        Notify User
                                                    </a>
                                                @endif
                                                <form action="{{ route('tasks.update-status', $task) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-warning btn-sm" name="status" value="In Progress">In Progress</button>
                                                    <button type="submit" class="btn btn-success btn-sm" name="status" value="Completed">Completed</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
