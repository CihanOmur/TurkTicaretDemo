<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\TodoResource;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'sometimes|required|string|max:100',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $category->update($validated);
        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Category not found.',
                'data'    => null,
                'meta'    => [],
                'errors'  => []
            ], 204);
        }
        $category->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Category deleted successfully.',
            'data'    => null,
            'meta'    => [],
            'errors'  => []
        ], 200);
    }

    public function todos($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 400);
        }
        $todos = $category->todos()->with('categories')->paginate(10);

        return response()->json([
            'status'  => 'success',
            'message' => 'Todos retrieved successfully.',
            'data'    => TodoResource::collection($todos),
            'meta'    => [
                'current_page' => $todos->currentPage(),
                'last_page'    => $todos->lastPage(),
                'per_page'     => $todos->perPage(),
                'total'        => $todos->total(),
                'from'         => $todos->firstItem(),
                'to'           => $todos->lastItem(),
            ],
            'errors'  => []
        ]);
    }
}
