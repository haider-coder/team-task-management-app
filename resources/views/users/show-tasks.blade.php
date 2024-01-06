@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">

                        <h2>Tasks for {{ $user->name }}</h2>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#taskModal{{ $task->id }}">
                                            View Details
                                        </button>
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="post" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Task Modal -->
                                <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="taskModalLabel">{{ $task->title }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Title:</strong> {{ $task->title }}</p>
                                                <p><strong>Description:</strong> {{ $task->description }}</p>
                                                <p><strong>Status:</strong> {{ $task->status }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
