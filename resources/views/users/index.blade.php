@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h2>All Users</h2>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.users.update-type', $user->id) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <select name="type" class="form-control">
                                                <option value="1" {{ old('type', $user->type) === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="2" {{ old('type', $user->type) === 'manager' ? 'selected' : '' }}>Manager</option>
                                                <option value="0" {{ old('type', $user->type) === 'user' ? 'selected' : '' }}>User</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm mt-2">Change Role</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show_tasks', $user->id) }}" class="btn btn-info btn-sm">View Tasks</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
