@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Change User Type</h1>
        <form action="{{ route('admin.change-user-type', $user) }}" method="post">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="type">Select New User Type:</label>
                <select name="type" id="type" class="form-control">
                    <option value="admin" {{ $user->type === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ $user->type === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="user" {{ $user->type === 'user' ? 'selected' : '' }}>User</option>
                    <!-- Add more options if needed -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Change User Type</button>
        </form>
    </div>
@endsection
