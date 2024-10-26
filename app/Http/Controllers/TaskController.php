<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

// filter data by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

// filter data by due date
        if ($request->has('due_date')) {
            $query->where('due_date', $request->due_date);
        }

// paginate
        $tasks = $query->paginate(10);

        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json($task);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tasks|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,completed',
            'due_date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tasks,title,' . $id . '|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,completed',
            'due_date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task->update($request->all());
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => ' Deleted successfully']);
    }
}
