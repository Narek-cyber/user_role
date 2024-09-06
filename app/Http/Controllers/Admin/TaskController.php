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

    /**
     * @param $id
     * @return View|Factory|Application
     */
    public function assignUser($id): View|Factory|Application
    {
        $users = User::query()->where('role', 'user')->where('invited', true)->get();
        $task = Task::query()->findOrFail($id);
        return view('admin.assign', compact('users', 'task'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function assignTaskToUser(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);
        $task = Task::query()->findOrFail($id);
        $task->update([
            'assigned_to' => $request->input('assign-task')
        ]);
        return redirect()->route('admin.tasks.index')->with('success', 'Task assigned successfully');
    }

    /**
     * @param $id
     * @return View|Factory|Application
     */
    public function taskStatus($id): View|Factory|Application
    {
        $task = Task::query()->findOrFail($id);
        $task_statuses = array_filter(Task::getStatuses(), function ($key) {
            return in_array($key, [Task::STATUS_NEW, Task::STATUS_DONE]);
        }, ARRAY_FILTER_USE_KEY);
        return view('admin.task-status', compact('task', 'task_statuses'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function taskStatusUpdate(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Task::getStatuses())),
        ]);

        Task::query()->findOrFail($id)->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Task status updated successfully');
    }

    /**
     * @param $id
     * @return View|Factory|Application
     */
    public function edit($id): View|Factory|Application
    {
        $task = Task::query()->findOrFail($id);
        return view('admin.task-edit', compact('task'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        Task::query()->findOrFail($id)->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        Task::query()->findOrFail($id)->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully');
    }
}
