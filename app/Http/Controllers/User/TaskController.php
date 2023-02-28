<?php

namespace App\Http\Controllers\User;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function taskData(Request $request)
    {
        $tasks = Task::where('project_id', $request->project_id)->get();
        return view('user.components.tasks', compact('tasks'))->render();
    }

    public function taskDraggable(Request $request)
    {
        if ($request->pending_taskboard) {
            $pending_taskboard = explode(',', $request->pending_taskboard);
            foreach ($pending_taskboard as $key => $task_id) {
                $task = Task::where('id', $task_id)->first();
                $task->update([
                    'serial_number' => $key,
                    'status' => 'pending',
                ]);
            }
        }
        if ($request->in_progress_taskboard) {
            $in_progress_taskboard = explode(',', $request->in_progress_taskboard);
            foreach ($in_progress_taskboard as $key => $task_id) {
                $task = Task::where('id', $task_id)->first();
                $task->update([
                    'serial_number' => $key,
                    'status' => 'in_progress',
                ]);
            }
        }
        if ($request->complete_taskboard) {
            $complete_taskboard = explode(',', $request->complete_taskboard);
            foreach ($complete_taskboard as $key => $task_id) {
                $task = Task::where('id', $task_id)->first();
                $task->update([
                    'serial_number' => $key,
                    'status' => 'complete',
                ]);
            }
        }
        return response()->json(['message' => 'Rearrange tasks complete'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required',
            'deadline' => 'required',
            'priority' => 'required',
        ]);

        Task::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'success'], 200);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required',
            'deadline' => 'required',
            'priority' => 'required',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
        ]);

        return response()->json(['message' => 'success'], 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'success'], 200);
    }
}
