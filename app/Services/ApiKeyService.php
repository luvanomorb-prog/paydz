<?php

namespace App\Services;

use App\Models\ApiKey;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiKeyService
{
    public function create(Merchant $merchant, string $name = 'Default'): array
    {
        $publicKey = 'pk_live_' . Str::random(40);
        $secretKey = 'sk_live_' . Str::random(64);

        ApiKey::create([
            'merchant_id' => $merchant->id,
            'name' => $name,
            'public_key' => $publicKey,
            'secret_key_hash' => Hash::make($secretKey),
            'active' => true,
        ]);

        return [
            'public_key' => $publicKey,
            'secret_key' => $secretKey,
        ];
    }
}
