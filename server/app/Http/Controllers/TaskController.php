<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Exception;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $tasks = Task::where('user_id', $request->user_id)->get();
            return response()->json($tasks);
        } catch (Exception $e) {
            return ResponseHelper::handleException($e, 'Failed to fetch tasks');
        }
    }

    public function save(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->user_id,
            ]);

            return response()->json($task, 201);
            } catch (Exception $e) {
            return ResponseHelper::handleException($e, 'Failed to create task');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate(['title' => 'required|string|max:255', 
            'description' => 'nullable|string']);

            $task = Task::findOrFail($id);
            $task->update([
                'title' => $request->title,
                'description' => $request->description
            ]);

            $task->save();

            return response()->json($task);
        } catch (Exception $e) {
            return ResponseHelper::handleException($e, 'Failed to update task');
        }
    }

    public function toggleTask($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->completed = !$task->completed;
            $task->save();

            return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
        } catch (Exception $e) {
            return ResponseHelper::handleException($e, 'Failed to toggle task');
        }
    }
    
    public function delete($id)
    {
        try {
            $task = Task::findOrFail($id)->delete();
            return response()->json(['message' => 'Task deleted successfully',$task]);
        } catch (Exception $e) {
            return ResponseHelper::handleException($e, 'Failed to delete task');
        }
    }
}
