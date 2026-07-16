<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $data = $this->dashboardService->getData($request->user()->id);

        return Inertia::render('Dashboard', [
            'merchant' => $data['merchant'],
            'stats' => $data['stats'],
            'payments' => $data['payments'],
        ]);
    }
}
