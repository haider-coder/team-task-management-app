<div class="card">
    <div class="card-header">Recent Activity</div>
    <div class="card-body">
        <ul>
            <li>Recent Task: <b>{{ optional($recentTasks)->title ?? 'N/A' }}</b> - {{ optional($recentTasks)->created_at ? $recentTasks->created_at->diffForHumans() : 'N/A' }}</li>
            <li>User registered: <b>{{ optional($recentUsers)->name ?? 'N/A' }}</b> - {{ optional($recentUsers)->created_at ? $recentUsers->created_at->diffForHumans() : 'N/A' }}</li>

        </ul>
    </div>
</div>
