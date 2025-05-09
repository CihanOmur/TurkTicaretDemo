<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Todos;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    // GET /api/stats/todos
    public function todoStatusCounts(): JsonResponse
    {
        $statuses = Todos::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return response()->json([
            'status' => 'success',
            'message' => 'Todo durumu istatistikleri başarıyla getirildi.',
            'data' => $statuses,
            'meta' => [],
            'errors' => []
        ], 200);
    }

    // GET /api/stats/priorities
    public function todoPriorityCounts(): JsonResponse
    {
        $priorities = Todos::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority');

        return response()->json([
            'status' => 'success',
            'message' => 'Todo öncelik istatistikleri başarıyla getirildi.',
            'data' => $priorities,
            'meta' => [],
            'errors' => []
        ], 200);
    }
}
