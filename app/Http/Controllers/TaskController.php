<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Utils\Constants;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Configuration\Constant;
use App\Exceptions\TasksException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::with('category')->where('user_id', 1)->get();
            return response()->json(['status' => Constants::$statusSuccess, 'tasks' => $tasks]);
        } catch (\Exception $e) {
            return response()->json(['status' => Constants::$statusError, 'message' => 'Something went wrong']);
        }
    }

    public function store(Request $request)
    {
        try {

            $request->merge(['user_id' => 1]);

            $validated = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'priority' => 'required',
                'date_due' => 'required',
                'category_id' => 'required',
                'user_id' => 'required'
            ]);

            $task = Task::create($validated);

            return response()->json(['status' => Constants::$statusSuccess, 'message' => Constants::$messageTaskCreated, 'task' => $task]);

        } catch (\Throwable $e) {

            return response()->json(['status' => Constants::$statusError, 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {


        $task = Task::with('category')->where('user_id', 1)->find($id);

        if($task == null){
            return response()->json(['status' => Constants::$statusError, 'message' => Constants::$errorTaskNotFound]);
        }

        return response()->json(['status' => Constants::$statusSuccess, 'task' => $task]);
    }

    public function update(Request $request, $id)
    {
        try {

            $task = Task::findOrFail($id);

            $task->fill($request->only([
                'name',
                'description',
                'priority',
                'category_id'
            ]));

            $task->save();

            return response()->json([ 'status' => Constants::$statusSuccess, 'message' => Constants::$messageTaskUpdated, 'task' => $task]);

        } catch (\Throwable $e) {

            return response()->json(['status' => Constants::$statusError, 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {

            $task = Task::find($id);

            if (!$task) {
                throw new TasksException(Constants::$errorTaskNotFound, 1);
            }

            $task->delete();

            return response()->json(['status' => Constants::$statusSuccess, 'message' => Constants::$messageTaskDeleted], Constants::$httpCodeOk);

        } catch (\Throwable $e) {

            return response()->json(['status' => Constants::$statusError, 'message' => $e->getMessage()], Constants::$httpCodeNotFound);
        }
    }

    public function completed($id)
    {
        try {

            $task = Task::find($id);

            if (!$task) {
                throw new TasksException(Constants::$errorTaskNotFound, 1);
            }

            $task->completed = true;
            $task->save();

            return response()->json(['status' => Constants::$statusSuccess, 'message' => Constants::$messageTaskCompleted, 'task' => $task], Constants::$httpCodeOk);
        } catch (\Throwable $e) {

            return response()->json(['status' => Constants::$statusError, 'message' => $e->getMessage()], Constants::$httpCodeNotFound);
        }
    }


    public function overview()
    {
        $user = User::with('tasks')->find(1);

        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('completed', true)->count();

        $today = Carbon::now()->format('Y-m-d');
        $todayTasks = $user->tasks()->whereDate('date_due', $today)->count();

        $highPriorityTasks = $user->tasks()->where('priority', 'high')->count();
        $mediumPriorityTasks = $user->tasks()->where('priority', 'medium')->count();
        $lowPriorityTasks = $user->tasks()->where('priority', 'low')->count();

        return response()->json([
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'todayTasks' => $todayTasks,
            'highPriorityTasks' => $highPriorityTasks,
            'mediumPriorityTasks' => $mediumPriorityTasks,
            'lowPriorityTasks' => $lowPriorityTasks,
        ]);
    }
}
