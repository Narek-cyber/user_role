<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
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
        $user = auth()->user();
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(15);
        return view('user.tasks', compact('tasks'));
    }

    /**
     * @param $id
     * @return View|Factory|Application
     */
    public function taskStatus($id): View|Factory|Application
    {
        $task = Task::query()->findOrFail($id);
        $task_statuses = array_filter(Task::getStatuses(), function ($key) {
            return in_array($key, [Task::STATUS_NEW, Task::STATUS_IN_PROGRESS, Task::STATUS_REVIEW]);
        }, ARRAY_FILTER_USE_KEY);
        return view('user.task-status', compact('task', 'task_statuses'));
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

        return redirect()->route('user.tasks.index')->with('success', 'Task status updated successfully');
    }

    /**
     * @param $id
     * @return View|Factory|Application
     */
    public function show($id): View|Factory|Application
    {
        $task = Task::query()->findOrFail($id);
        return view('user.task-show', compact('task'));
    }
}
