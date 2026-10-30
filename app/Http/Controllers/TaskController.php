<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request, AuthRepository $authRepository, TaskRepository $taskRepository)
    {
        $user = $authRepository->userFromToken($request->bearerToken());

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->json(['data' => $taskRepository->allForUser($user)]);
    }

    public function store(Request $request, AuthRepository $authRepository, TaskRepository $taskRepository)
    {
        $user = $authRepository->userFromToken($request->bearerToken());

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ]);

        $task = $taskRepository->createForUser($user, $data);

        return response()->json(['data' => $task], 201);
    }
}
