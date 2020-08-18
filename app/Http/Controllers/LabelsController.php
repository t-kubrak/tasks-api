<?php


namespace App\Http\Controllers;


use App\Label;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LabelsController
{
    public function create(Request $request): JsonResponse
    {
        $label = new Label();
        $label->name = $request->name;
        $label->save();

        return response()->json($label);
    }
}
