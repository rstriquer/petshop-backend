<?php

namespace App\Transformers;

use App\Contracts\TransformerCollection;
use Illuminate\Support\Collection;

/**
 * Admin user listing output transformer
 */
class AdminUserList implements TransformerCollection
{
    public function transform(Collection $payload) : array
    {
        $result = ['users' => []];
        $index = 0;
        foreach($payload AS $user) {
            $result['users'][$index++] = $user->toArray();
        }
        return $result;
    }
}
