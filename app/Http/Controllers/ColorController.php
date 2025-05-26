<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;


class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Color::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ColorRequest $color)
    {
        $color = Color::create($request->all());
        return response()->json($color, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Color::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ColorRequest $color, $id)
    {
        $color = Color::find($id);
        if ($color->update($request->all())) {
            return response()->json(['status' => true, 'event' => $color]);
        }
        return response()->json(['status' => false, 'message' => 'Color not updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Color::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Delete successfully']);
    }
}
