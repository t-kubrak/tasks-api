<?php


namespace App\Http\Controllers;


use App\Board;
use App\Jobs\ProcessImage;
use App\Label;
use App\Log;
use App\Task;
use App\TaskLabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends \Illuminate\Routing\Controller
{
    public function get(Request $request): JsonResponse
    {
        $tasks = DB::table('tasks AS t')
            ->leftJoin('tasks_labels AS tl', 't.id', '=', 'tl.task_id')
            ->selectRaw('t.*');

        if ($request->has('label_id')) {
            $tasks->where('tl.label_id', $request->label_id);
        }

        if ($request->has('status')) {
            $tasks->where('t.status', $request->status);
        }

        return response()->json($tasks->get());
    }

    public function create(Request $request): JsonResponse
    {
        Board::findOrFail($request->board_id);

        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status = Task::STATUS_DEVELOPMENT;
        $task->board_id = $request->board_id;
        $task->save();

        $this->log('create-task', $task);

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

        $this->log('attach-label', $taskLabel);

        return response()->json($taskLabel);
    }

    public function attachImage(Request $request, int $taskId): JsonResponse
    {
        Task::findOrFail($taskId);

        $image = $request->file('image');

        if (!Storage::exists('temp')) {
            Storage::makeDirectory('temp');
        }

        $image->storeAs('temp', $image->getClientOriginalName());
        $imageTempFilePath = storage_path('app/temp/' . $image->getClientOriginalName());

        ProcessImage::dispatch($imageTempFilePath, $taskId);

        return response()->json();
    }

    private function log(string $operation, Model $entity): void
    {
        $log = new Log();

        $log->operation = $operation;
        $log->user_id = Auth::id();
        $log->entity = get_class($entity);
        $log->object = $entity->toArray();

        $log->save();
    }
}
