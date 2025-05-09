<?php

namespace App\Http\Controllers\Api;

use App\Models\Todos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);

        $todos = Todos::paginate($limit);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo listesi başarıyla getirildi.',
            'data' => TodoResource::collection($todos),
            'meta' => [
                'pagination' => [
                    'total' => $todos->total(),
                    'per_page' => $todos->perPage(),
                    'current_page' => $todos->currentPage(),
                    'last_page' => $todos->lastPage(),
                    'from' => $todos->firstItem(),
                    'to' => $todos->lastItem(),
                ]
            ],
            'errors' => []
        ]);
    }

    public function show($id)
    {
        $todo = Todos::with('categories')->findOrFail($id);
        return new TodoResource($todo);
    }

    public function store(StoreTodoRequest $request)
    {
        $validated = $request->validated();
        $todo = new Todos();
        $todo->title = $validated['title'];
        $todo->description = $validated['description'] ?? null;
        $todo->status = $validated['status'] ?? 'pending';
        $todo->priority = $validated['priority'] ?? 'low';
        $todo->due_date = $validated['due_date'] ?? null;
        $todo->save();

        $todo->categories()->attach($validated['category']);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo başarıyla oluşturuldu.',
            'data' => new TodoResource($todo),
            'meta' => [],
            'errors' => []
        ], 201);
    }

    public function update(UpdateTodoRequest $request, $id)
    {
        $todo = Todos::find($id);
        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo bulunamadı.',
                'data' => null,
                'meta' => [],
                'errors' => []
            ], 404);
        }
        $validated = $request->validated();
        $todo->title = $validated['title'];
        $todo->description = $validated['description'] ?? null;
        $todo->status = $validated['status'] ?? 'pending';
        $todo->priority = $validated['priority'] ?? 'low';
        $todo->due_date = $validated['due_date'] ?? null;
        $todo->save();
        if (isset($validated['category'])) {
            $todo->categories()->sync($validated['category']);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Todo başarıyla güncellendi.',
            'data' => new TodoResource($todo),
            'meta' => [],
            'errors' => []
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $todo = Todos::find($id);
        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo bulunamadı.',
                'data' => null,
                'meta' => [],
                'errors' => []
            ], 404);
        }
        $todo->update(['status' => $validated['status']]);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo durumu başarıyla güncellendi.',
            'data' => new TodoResource($todo),
            'meta' => [],
            'errors' => []
        ]);
    }
    public function destroy($id)
    {
        $todo = Todos::find($id);
        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo bulunamadı.',
                'data' => null,
                'meta' => [],
                'errors' => []
            ], 404);
        }
        $todo->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Todo başarıyla silindi.',
            'data' => null,
            'meta' => [],
            'errors' => []
        ]);
    }
    public function search(Request $request)
    {
        $q = $request->query('q');

        if (!$q) {
            return response()->json(['message' => 'Query param q is required.'], 400);
        }

        $results = Todos::where(function ($query) use ($q) {
            $query->where('title', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
        })
            ->with('categories')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Arama sonuçları başarıyla getirildi.',
            'data' => TodoResource::collection($results),
            'meta' => [
                'pagination' => [
                    'total' => $results->total(),
                    'per_page' => $results->perPage(),
                    'current_page' => $results->currentPage(),
                    'last_page' => $results->lastPage(),
                    'from' => $results->firstItem(),
                    'to' => $results->lastItem(),
                ]
            ],
            'errors' => []
        ]);
    }
}
