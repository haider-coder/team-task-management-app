<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        // Display all tasks
        $utype = auth()->user()->type;
        if ($utype == 'admin' || $utype == 'manager') {
            $tasks = Task::all();
        } else {
            $tasks = auth()->user()->tasks()->completed()->get();
        }


        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Display form to create a new task
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Store a new task
        $task = new Task;
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->status = $request->input('status');
        $task->user_id = $request->input('user_id');
        $task->created_at = now();

        $user = User::find($request->input('user_id')); // Retrieve the User model instance

        if ($user) {
            $task->save(); // Save the task first to get the ID
            $user->notify(new TaskAssigned($task)); // Now generate the URL with the task ID
        } else {
            return redirect()->route('admin.tasks.index')->with('error', 'User not found.');
        }

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully');
    }


    public function edit($id)
    {
        // Display form to edit a task
        $task = Task::findOrFail($id);
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Update an existing task
        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->status = $request->input('status');
        $task->user_id = $request->input('user_id');
        $task->save();

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully');
    }

    public function destroy($id)
    {
        // Delete a task
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully');
    }

    public function pendingTasks()
    {
        $utype = auth()->user()->type;
        if ($utype == 'admin' || $utype == 'manager') {
            $tasks = Task::pending()->get();
        } else {
            $tasks = auth()->user()->tasks()->pending()->get();
        }
        return view('tasks.pending', compact('tasks'));
    }

    public function inProgressTasks()
    {
        $utype = auth()->user()->type;
        if ($utype == 'admin' || $utype == 'manager') {
            $tasks = Task::inProgress()->get();
        } else {
            $tasks = auth()->user()->tasks()->inProgress()->get();
        }

        return view('tasks.in-progress', compact('tasks'));
    }

    public function completedTasks()
    {
        $utype = auth()->user()->type;
        if ($utype == 'admin' || $utype == 'manager') {
            $tasks = Task::completed()->get();
        } else {
            $tasks = auth()->user()->tasks()->completed()->get();
        }

        return view('tasks.completed', compact('tasks'));
    }

    //updating tasks from user
    public function updateStatus(Task $task, Request $request)
    {
        $request->validate([
            'status' => 'required|in:To Do,In Progress,Completed',
            'feedback' => 'nullable|string|max:255', // New validation rule for feedback
        ]);

        $task->status = $request->input('status');
        $task->feedback = $request->input('feedback');
        $task->save();

        $redirectTo = $this->getRedirectRoute(Auth::user()->type);

        return redirect()->route($redirectTo)->with('status', 'Task status updated successfully.');
    }
    private function getRedirectRoute($userType)
    {
        switch ($userType) {
            case 'admin':
                return 'admin.home';
            case 'manager':
                return 'manager.home';
            default:
                return 'home';
        }
    }
}
