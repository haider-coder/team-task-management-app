<div class="card">
    <div class="card-header">Quick Links</div>
    <div class="card-body">
        <ul>
            <li><a href="{{ route('admin.tasks.index') }}">Manage Tasks</a></li>

            @if(auth()->user()->type == 'admin')
            <li><a href="{{ route('admin.users.index') }}">Manage Users</a></li>


            @endif

        </ul>
    </div>
</div>
