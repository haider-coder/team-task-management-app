<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
/**
* Create a new controller instance.
*
* @return void
*/
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userTasks = auth()->user()->tasks();

        // Retrieve only tasks with status 'To Do' or 'In Progress'
        $tasks = $userTasks->whereIn('status', ['To Do', 'In Progress'])->get();

        return view('/index', compact('tasks'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $totalTasks = Task::count();
        $totalUsers = User::count();

        // Example: Retrieve some recent activity data (replace with your actual logic)
        $recentTasks = Task::latest()->first();
        $recentUsers = User::latest()->first();
        $pendingTasksCount = Task::where('status', 'To Do')->count();
        $pendingTasksCount = Task::where('status', 'Completed')->count();
        $pendingUsersCount = User::where('email_verified_at', 'null')->count();

        return view('adminhome', [
            'totalTasks' => $totalTasks,
            'totalUsers' => $totalUsers,
            'recentTasks' => $recentTasks,
            'recentUsers' => $recentUsers,
            'pendingTasksCount' => $pendingTasksCount,
            'pendingUsersCount' => $pendingUsersCount,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome()
    {
            $totalTasks = Task::count();
            $totalUsers = User::count();

            // Example: Retrieve some recent activity data (replace with your actual logic)
            $recentTasks = Task::latest()->first();
            $recentUsers = User::latest()->first();
        $tasks = Task::where('user_id', Auth::id())->get();

        return view('managerhome', [
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
            'totalUsers' => $totalUsers,
            'recentTasks' => $recentTasks,
            'recentUsers' => $recentUsers,]);
    }
}
