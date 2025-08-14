<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->canAccessDashboard()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Task::query();
        
        // Technicians only see their tasks
        if ($user->isTechnician()) {
            $query->where('technician', $user->name);
        }

        $tasks = $query->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'required|string',
            'technician' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $task = Task::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'data' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $user = auth()->user();
        $task = Task::findOrFail($id);
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'required|string',
            'technician' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $task->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        $user = auth()->user();
        $task = Task::findOrFail($id);
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }
}