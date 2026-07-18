<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\Merchant;
use App\Services\ApiKeyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function __construct(
        protected ApiKeyService $apiKeyService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $merchant = Merchant::where('user_id', $request->user()->id)->firstOrFail();

        return response()->json([
            'success' => true,
            'keys' => $merchant->apiKeys,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $merchant = Merchant::where('user_id', $request->user()->id)->firstOrFail();

        $keys = $this->apiKeyService->create(
            $merchant,
            $request->input('name', 'Default')
        );

        return response()->json([
            'success' => true,
            'message' => 'API Key created successfully.',
            'keys' => $keys,
        ], 201);
    }
}
