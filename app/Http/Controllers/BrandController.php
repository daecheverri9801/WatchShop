<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Brand::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, BrandRequest $brand)

    {
        $brand = Brand::create($request->all());
        return response()->json($brand, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Brand::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BrandRequest $brand, $id)
    {
        $brand = Brand::find($id);
        if ($brand->update($request->all())) {
            return response()->json(['status' => true, 'event' => $brand]);
        }
        return response()->json(['status' => false, 'message' => 'Brand not updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Delete successfully']);
    }
}
