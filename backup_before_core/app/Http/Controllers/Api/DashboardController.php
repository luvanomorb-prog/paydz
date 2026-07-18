<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $merchant = $request->user()->merchant;

        return response()->json([
            'success' => true,
            'data' => $this->dashboardService->stats($merchant),
        ]);
    }
}
