<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\Task;
use Inertia\Inertia;

/**
 * Class TaskController
 *
 * Handles task-related requests.
 */
class TaskController extends Controller
{
    private $tasks;

    public function __construct(TaskRepositoryInterface $tasks)
    {
        $this->tasks = $tasks;
    }

    public function index()
    {
        $tasks = null;

        try {
            $tasks = $this->tasks->all();
        } catch (\Exception $e) {
            return Inertia::render('Error', [
                'message' => 'Error fetching tasks: ' . $e->getMessage(),
            ]);
        }

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
        ]);
    }

    public function showAll()
    {
        $tasks = null;

        try {
            $tasks = $this->tasks->all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching tasks: ' . $e->getMessage(),
                'success' => false,
            ], 400);
        }

        return response()->json([
            'data' => $tasks,
            'message' => 'Tasks fetched successfully',
            'success' => true,
        ]);
    }

    public function show(int $id)
    {
        $task = null;

        try {
            $task = $this->tasks->find($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching task: ' . $e->getMessage(),
                'success' => false,
            ], 400);
        }

        return response()->json([
            'data' => $task,
            'message' => 'Task fetched successfully',
            'success' => true,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = new Task(
            0,
            $data['title'],
            $data['description'] ?? '',
            false,
            new \DateTimeImmutable((new \DateTime())->format('Y-m-d H:i:s')),
            new \DateTimeImmutable((new \DateTime())->format('Y-m-d H:i:s'))
        );

        try {
            $this->tasks->create($task);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating task: ' . $e->getMessage(),
                'success' => false,
            ], 400);
        }

        return response()->json([
            'message' => 'Task created successfully',
            'success' => true,
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isCompleted' => 'required|boolean',
        ]);

        $task = null;

        try {
            $task = $this->tasks->find($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching task: ' . $e->getMessage(),
                'success' => false,
            ], 400);
        }

        $task = new Task(
            $task->id(),
            $data['title'],
            $data['description'] ?? $task->description(),
            $data['isCompleted'],
            $task->createdAt(),
            new \DateTimeImmutable((new \DateTime())->format('Y-m-d H:i:s'))
        );

        try {
            $this->tasks->update($task);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating task: ' . $e->getMessage(),
                'success' => false,
            ], 400);
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'success' => true,
        ]);
    }

    public function destroy(int $id)
    {
        try {
            $this->tasks->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting task: ' . $e->getMessage(),
                'success' => false,
            ], 400);
        }

        return response()->json([
            'message' => 'Task deleted successfully',
            'success' => true,
        ]);
    }
}
