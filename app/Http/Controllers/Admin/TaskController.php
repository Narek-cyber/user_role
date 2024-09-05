<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        $tasks = Task::query()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.tasks', compact('tasks'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'status' => ['in:new,in_progress,review,done'],
        ]);

        Task::query()->create([
            'title' => $request->input('title'),
            'description' => $request->input('title'),
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully');
    }

    public function assignUser($id)
    {
        $users = User::query()->where('role', 'user')->where('invited', true)->get();
        $task = Task::query()->first();
        return view('admin.assign', compact('users', 'task'));
    }

    public function assignTaskToUser(Request $request, $id)
    {
        $task = Task::query()->findOrFail($id);
        $task->update([
            'assigned_to' => $request->input('assign-task')
        ]);
        return redirect()->back();
    }
}
