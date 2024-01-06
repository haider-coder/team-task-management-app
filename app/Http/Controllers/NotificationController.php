<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskStatusNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notifyUser($taskId)
    {
        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($task->user_id);

        // Notify the user
        $user->notify(new TaskStatusNotification($task));

        return redirect()->route('admin.tasks.index')->with('success', 'Notification sent successfully');
    }

    // show notified task

    public function showtask($taskId)
    {
        $task = Task::findOrFail($taskId);
//dd($task);
        return view('tasks.showtask', compact('task'));
    }
}
