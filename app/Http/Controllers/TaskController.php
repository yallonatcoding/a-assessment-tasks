<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Auth\UserPermissionValidatorInterface;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\Task;
use App\Domain\UserTask\UserTask;
use App\Domain\UserTask\UserTaskRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class TaskController
 *
 * Handles task-related requests.
 */
class TaskController extends Controller
{
    private $tasks;
    private $usersTasks;

    public function __construct(
        TaskRepositoryInterface $tasks,
        UserTaskRepositoryInterface $usersTasks
    ) {
        $this->tasks = $tasks;
        $this->usersTasks = $usersTasks;
    }

    public function index()
    {
        return inertia('Tasks/Index');
    }

    public function showAllByUser(Request $request)
    {
        $tasks = [];

        $validator = Validator::make($request->all(), [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1'],
            'filters' => ['nullable', 'array'],
            'filters.search' => ['nullable', 'string', 'max:255'],
            'filters.sort_by' => ['nullable', 'string', 'in:title,is_completed,created_at,updated_at'],
            'filters.sort_dir' => ['nullable', 'string', 'in:asc,desc'],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $filters = $validator->validated()['filters'] ?? [];
        $page = $validator->validated()['page'] ?? [];
        $perPage = $validator->validated()['per_page'] ?? [];

        try {
            $tasks = $this->usersTasks->searchByUser(
                $request->user()->id,
                $filters['filters'] ?? [],
                $page ?? 1,
                $perPage ?? 10
            );
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

        DB::beginTransaction();
        
        try {
            $task = new Task(
                0,
                $request->user()->id,
                $data['title'],
                $data['description'] ?? '',
                false,
                new \DateTimeImmutable((new \DateTime())->format('Y-m-d H:i:s')),
                new \DateTimeImmutable((new \DateTime())->format('Y-m-d H:i:s'))
            );

            $task = $this->tasks->create($task);

            $userTask = new UserTask(
                0,
                $request->user()->id,
                $task->id(),
                new \DateTimeImmutable((new \DateTime())->format('Y-m-d H:i:s')),
                new \DateTimeImmutable((new \DateTime())->format('Y-m-d H:i:s'))
            );

            $this->usersTasks->create($userTask);

            DB::commit();

            return response()->json([
                'message' => 'Task created successfully',
                'success' => true,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Error creating task: ' . $e->getMessage(),
                'success' => false,
            ], 400);
        }
    }

    public function update(Request $request, int $id, UserPermissionValidatorInterface $validator)
    {
        if (! $validator->canModify($request->user()->id, $id)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false,
            ], 403);
        }

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
            $id,
            $request->user()->id,
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

    public function destroy(Request $request, int $id, UserPermissionValidatorInterface $validator)
    {
        if (! $validator->canModify($request->user()->id, $id)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false,
            ], 403);
        }

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
