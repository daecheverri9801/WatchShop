<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::with(['brand', 'category'])->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, StoreProductRequest $product)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Product::with(['brand', 'category'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StoreProductRequest $product, $id)
    {
        if ($product->update($request->all())) {
            return response()->json(['status' => true, 'event' => $product]);
        }
        return response()->json(['status' => false, 'message' => 'Product not updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Delete successfully']);
    }
}
