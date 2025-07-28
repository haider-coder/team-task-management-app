@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Card --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 "><b>User Management</b> </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Summary</th>
                                    <th>Tasks</th>
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
                                        @if($user->pending_tasks_count > 0)
                                            <span class="badge bg-danger p-2">
                                                {{ $user->pending_tasks_count }} pending
                                            </span>
                                        @endif
                                        
                                        @if($user->in_progress_tasks_count > 0)
                                            <span class="badge bg-warning text-dark p-2">
                                                {{ $user->in_progress_tasks_count }} in-progress
                                            </span>
                                        @endif

                                        @if($user->completed_tasks_count > 0)
                                            <span class="badge bg-success p-2">
                                                {{ $user->completed_tasks_count }} completed
                                            </span>
                                        @endif
                                        
                                       
                                        
                                    </td>

                                    <td>
                                         <a href="{{ route('admin.users.show_tasks', $user->id) }}" class="btn btn-sm btn-outline-info"> <i class="fa fa-tasks"></i> Tasks</a>
                                    </td>

                                    <td>
                                        <form action="{{ route('admin.users.update-type', $user->id) }}" method="post" class="d-flex flex-column gap-1">
                                            @csrf
                                            @method('patch')
                                            <select name="type" class="form-select form-select-sm">
                                                <option value="1" {{ old('type', $user->type) === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="2" {{ old('type', $user->type) === 'manager' ? 'selected' : '' }}>Manager</option>
                                                <option value="0" {{ old('type', $user->type) === 'user' ? 'selected' : '' }}>User</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                           
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- /table-responsive -->
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            columnDefs: [
                { orderable: false, targets: [3, 4, 5] } // disable sorting for Role, Tasks, Delete
            ]
        });
    });
</script>
@endsection


