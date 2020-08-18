<?php


namespace App\Http\Controllers;


use App\Board;
use App\Label;
use App\Task;
use App\TaskLabel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends \Illuminate\Routing\Controller
{
    public function create(Request $request): JsonResponse
    {
        Board::findOrFail($request->board_id);

        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status = Task::STATUS_DEVELOPMENT;
        $task->board_id = $request->board_id;
        $task->save();

        return response()->json($task);
    }

    public function attachLabel(Request $request, int $taskId, int $labelId): JsonResponse
    {
        Task::findOrFail($taskId);
        Label::findOrFail($labelId);

        $taskLabel = new TaskLabel();
        $taskLabel->task_id = $taskId;
        $taskLabel->label_id = $labelId;
        $taskLabel->save();

        return response()->json($taskLabel);
    }
}
