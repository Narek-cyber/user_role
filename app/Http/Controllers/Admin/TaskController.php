<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('admin.tasks');
    }

    public function store(Request $request)
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

        return redirect()->back()->with('success', 'Task created successfully');
    }
}
