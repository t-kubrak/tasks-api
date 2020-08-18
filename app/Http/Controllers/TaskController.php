<?php


namespace App\Http\Controllers;


use App\Board;
use App\Task;
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
}
