<?php


namespace App\Http\Controllers;


use App\Board;
use App\Label;
use App\Task;
use App\TaskLabel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Image as ImageModel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TaskController extends \Illuminate\Routing\Controller
{
    private const PATH_IMAGES_DESKTOP = 'app/images/desktop/';
    private const PATH_IMAGES_MOBILE = 'app/images/mobile/';

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

    public function attachImage(Request $request, int $taskId): JsonResponse
    {
        Task::findOrFail($taskId);

        if (!Storage::exists('images/desktop')) {
            Storage::makeDirectory('images/desktop');
        }

        if (!Storage::exists('images/mobile')) {
            Storage::makeDirectory('images/mobile');
        }

        $image = $request->file('image');
        $img = Image::make($image);

        $img->fit(1280, 720);

        $pathDesktop = storage_path(self::PATH_IMAGES_DESKTOP) . $image->getClientOriginalName();
        $img->save($pathDesktop);

        $img->fit(640, 360);

        $pathMobile = storage_path(self::PATH_IMAGES_MOBILE) . $image->getClientOriginalName();
        $img->save($pathMobile);

        $imageRecord = new ImageModel();
        $imageRecord->task_id = $taskId;
        $imageRecord->path_desktop = $pathDesktop;
        $imageRecord->path_mobile = $pathMobile;
        $imageRecord->save();

        return response()->json($imageRecord);
    }
}
