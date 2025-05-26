<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Colors/Index', [
            'colors' => Color::all(),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Colors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'color_name' => 'required|string|max:100',
            'color_hex' => 'required|string|max:7',
        ]);

        Color::create($validate);

        return redirect()->route('colors.index')->with('message', 'Color created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        return Inertia::render('Colors/Show', [
            'colors' => $color
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return Inertia::render('Colors/Edit', [
            'colors' => $color
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $validate = $request->validate([
            'color_name' => 'required|string|max:100',
            'color_hex' => 'required|string|max:7',
        ]);

        $color->update($validate);

        return redirect()->route('colors.index')->with('message', 'Color updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('colors.index')->with('message', 'Color deleted successfully.');
    }
}
