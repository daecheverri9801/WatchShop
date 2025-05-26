<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Material;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => Product::with('category', 'brand', 'color', 'material')->get(),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'colors' => Color::all(),
            'materials' => Material::all(),
            'message' => session('message')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::all(),
            'selectedCategorie' => request('category_id'),
            'brands' => Brand::all(),
            'selectedBrand' => request('brand_id'),
            'colors' => Color::all(),
            'selectedColor' => request('color_id'),
            'materials' => Material::all(),
            'selectedMaterial' => request('material_id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('main_image')) {
            // Almacena la imagen en el directorio correcto
            $path = $request->file('main_image')->store('products', 'public');
            // Guarda solo el nombre del archivo o ruta relativa
            $validated['main_image'] = $path; // Esto guardará "products/nombrearchivo.jpg"
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('message', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [
            'product' => $product->load('category', 'brand', 'color', 'material')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'colors' => Color::all(),
            'materials' => Material::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'fk_category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'product_ref' => 'required|string|max:255',
            'fk_brand_id' => 'required|exists:brands,id',
            'genre' => 'required|string|max:255',
            'fk_color_id' => 'required|exists:colors,id',
            'fk_material_id' => 'required|exists:materials,id',
            'uv_protection' => 'boolean',
            'water_resistance' => 'string|max:255',
            'size' => 'string|max:255',
            'price' => 'required|numeric|min:0',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('main_image')) {
            // Almacena la imagen en el directorio correcto
            $path = $request->file('main_image')->store('products', 'public');
            // Guarda solo el nombre del archivo o ruta relativa
            $validated['main_image'] = $path; // Esto guardará "products/nombrearchivo.jpg"
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('message', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('message', 'Producto eliminado exitosamente.');
    }
}
