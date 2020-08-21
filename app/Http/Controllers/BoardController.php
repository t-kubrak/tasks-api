<?php


namespace App\Http\Controllers;


use App\Board;
use App\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $board = new Board();
        $board->name = $request->name;
        $board->user_id = Auth::id();
        $board->save();

        $this->log('create', $board);

        return response()->json($board);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $board = Board::findOrFail($id);

        $this->authorize('update', $board);

        $board->name = $request->name;
        $board->user_id = Auth::id();

        $board->save();

        $this->log('update', $board);

        return response()->json($board);
    }

    public function delete(Request $request, int $id): JsonResponse
    {
        $board = Board::findOrFail($id);

        $this->authorize('delete', $board);

        $board->delete();

        $this->log('delete', $board);

        return response()->json($board);
    }

    private function log(string $operation, Board $board): void
    {
        $log = new Log();

        $log->operation = $operation;
        $log->user_id = $board->user_id;
        $log->entity = Board::class;
        $log->object = $board->toArray();

        $log->save();
    }
}
