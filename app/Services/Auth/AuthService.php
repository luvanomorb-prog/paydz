<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\Merchant;
use App\Services\ApiKeyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected ApiKeyService $apiKeyService
    ) {}

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $merchant = Merchant::create([
                'user_id' => $user->id,
                'business_name' => $data['business_name'],
                'business_email' => $data['business_email'],
                'business_phone' => $data['business_phone'] ?? null,
                'country' => 'Algeria',
            ]);

$keys = $this->apiKeyService->create($merchant);

return [
    'user' => $user,
    'keys' => $keys,
];

        });
    }
}
