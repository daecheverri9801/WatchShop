<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::all(),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:100',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('main_image')) {
            // Almacena la imagen en el directorio correcto
            $path = $request->file('main_image')->store('categories', 'public');

            // Guarda solo el nombre del archivo o ruta relativa
            $data['main_image'] = $path; // Esto guardará "categories/nombrearchivo.jpg"
        }

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('message', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return Inertia::render('Categories/Show', [
            'categories' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'categories' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:100',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            // Actualizar nombre de categoría
            $category->category_name = $data['category_name'];

            // Manejar la imagen si se subió una nueva
            if ($request->hasFile('main_image')) {
                // Eliminar imagen anterior si existe
                if ($category->main_image && Storage::exists($category->main_image)) {
                    Storage::delete($category->main_image);
                }
                // Guardar nueva imagen
                $path = $request->file('main_image')->store('categories', 'public');

                // Guarda solo el nombre del archivo o ruta relativa
                $data['main_image'] = $path; // Esto guardará "categories/nombrearchivo.jpg"
            } else {
                // Si no se subió una nueva imagen, mantener la anterior
                $data['main_image'] = $category->main_image;
            }
            $category->update($data);

            return redirect()->route('categories.index')->with('message', 'Categoría actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('message', 'Category deleted successfully.');
    }
}
