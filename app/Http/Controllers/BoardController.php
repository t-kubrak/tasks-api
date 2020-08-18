<?php


namespace App\Http\Controllers;


use App\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BoardController extends \Illuminate\Routing\Controller
{
    public function create(Request $request): JsonResponse
    {
        $board = new Board();
        $board->name = $request->name;
        $board->save();

        return response()->json($board);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $board = Board::findOrFail($id);
        $board->name = $request->name;
        $board->save();

        return response()->json($board);
    }
}
