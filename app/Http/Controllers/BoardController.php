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

        return response()->json($board);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $board = Board::findOrFail($id);

        $this->authorize('update', $board);

        $board->name = $request->name;
        $board->user_id = Auth::id();

        $board->save();

        return response()->json($board);
    }

    public function delete(Request $request, int $id): JsonResponse
    {
        $board = Board::findOrFail($id);

        $this->authorize('delete', $board);

        $board->delete();

        return response()->json($board);
    }
}
