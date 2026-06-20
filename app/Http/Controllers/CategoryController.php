<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Category.index
     */
    public function index()
    {
        return Category::orderBy('display_order')->get();
    }


    /**
     * Category.store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'icon'          => 'nullable|string|max:255',
            'display_order' => 'integer'
        ]);

        return response()->json(Category::create($validated), 201);
    }

    /**
     * Category.show
     */
    public function show(Category $category)
    {
        return $category->load('services');
    }

    /**
     * Category.update
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'icon'          => 'nullable|string|max:255',
            'display_order' => 'integer',
        ]);

        $category->update($validated);

        return response()->json($category);
    }

    /**
     * Category.destroy
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
