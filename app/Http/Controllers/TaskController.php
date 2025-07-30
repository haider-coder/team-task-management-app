<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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
        $tags = Tag::all();


        return view('tasks.index', compact('tasks', 'tags'));
    }

    public function create()
    {
        // Display form to create a new task
        $users = User::all();
        $tags  = Tag::orderBy('name')->get();
        return view('tasks.create', compact('users', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|in:To Do,In Progress,Completed',
            'user_id'     => 'required|exists:users,id',
            'deadline'    => 'nullable|date',
            'tag_id'      => 'required|exists:tags,id',
        ]);

        // Create
        $task = Task::create($validated + ['created_at' => now()]);

        // Notify
        $user = User::find($validated['user_id']);
        if ($user) {
            $user->notify(new TaskAssigned($task));
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
        $tags  = Tag::orderBy('name')->get();
        return view('tasks.edit', compact('task', 'users', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|in:To Do,In Progress,Completed',
            'user_id'     => 'required|exists:users,id',
            'deadline'    => 'nullable|date',
            'tag_id'      => 'required|exists:tags,id',
        ]);

        $task = Task::findOrFail($id);
        $task->update($validated);

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

        $tags  = Tag::orderBy('name')->get();

        return view('tasks.pending', compact('tasks', 'tags'));
    }

    public function inProgressTasks()
    {
        $utype = auth()->user()->type;
        if ($utype == 'admin' || $utype == 'manager') {
            $tasks = Task::inProgress()->get();
        } else {
            $tasks = auth()->user()->tasks()->inProgress()->get();
        }

        $tags  = Tag::orderBy('name')->get();

        return view('tasks.in-progress', compact('tasks', 'tags'));
    }

    public function completedTasks()
    {
        $utype = auth()->user()->type;
        if ($utype == 'admin' || $utype == 'manager') {
            $tasks = Task::completed()->get();
        } else {
            $tasks = auth()->user()->tasks()->completed()->get();
        }

        $tags  = Tag::orderBy('name')->get();

        return view('tasks.completed', compact('tasks', 'tags'));
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
