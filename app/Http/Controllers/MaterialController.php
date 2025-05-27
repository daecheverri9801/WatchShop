<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use Illuminate\Http\Request;





class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Material::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, MaterialRequest $material)
    {
        $material = Material::create($request->all());
        return response()->json($material, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Material::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialRequest $material, $id)
    {
        $material = Material::find($id);
        if ($material->update($request->all())) {
            return response()->json(['status' => true, 'event' => $material]);
        }
        return response()->json(['status' => false, 'message' => 'Material not updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Material::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Delete successfully']);

        
    }
}
