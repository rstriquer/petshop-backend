<?php

namespace App\Transformers;

use App\Contracts\TransformerItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Login output transformer
 */
class AdminUserLogin implements TransformerItem
{
    public function transform(Model $payload) : array
    {
        return [
            Str::singular($payload->getTable()) => [
                'id' => data_get($payload, 'uuid'),
                'email' => data_get($payload, 'email'),
                'access_token' => data_get($payload, 'token'),
                'token_type' => 'bearer',
                'expires_in' => now(),
            ],
        ];
    }
}
