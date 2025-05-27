<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Mail\MaterialDeleted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Materials/Index', [
            'materials' => Material::all(),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Materials/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'material_name' => 'required|string|max:50',
            'state' => 'boolean',
        ]);

        Material::create($validate);

        return redirect()->route('materials.index')->with('message', 'Material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return Inertia::render('Materials/Show', [
            'materials' => $material
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return Inertia::render('Materials/Edit', [
            'materials' => $material
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validate = $request->validate([
            'material_name' => 'required|string|max:50',
            'state' => 'boolean',
        ]);

        $material->update($validate);

        return redirect()->route('materials.index')->with('message', 'Material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        Mail::to('destinatario@ejemplo.com')->send(new MaterialDeleted($material));
        $material->delete();
        return redirect()->route('materials.index')->with('message', 'Material deleted successfully.');
    }
}
