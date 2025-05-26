<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, StoreCategoryRequest $category)
    {
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StoreCategoryRequest $category, $id)

    {
        $category = Category::find($id);
        if ($category->update($request->all())) {
            return response()->json(['status' => true, 'event' => $category]);
        }
        return response()->json(['status' => false, 'message' => 'Category not updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Delete successfully']);
    }
}
