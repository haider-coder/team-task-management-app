<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Display all users
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function showTasks($id)
    {
        // Display tasks for a specific user
        $user = User::findOrFail($id);
        $tasks = $user->tasks;
        return view('users.show-tasks', compact('user', 'tasks'));
    }

    public function destroy($id)
    {
        // Delete a user
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function updateType(Request $request, User $user)
    {
        $request->validate([
            'type' => 'required|in:0,1,2', //  0 is user, 1 is admin, and 2 is manager
        ]);

        $user->type = $request->input('type');
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User type updated successfully.');
    }
}
