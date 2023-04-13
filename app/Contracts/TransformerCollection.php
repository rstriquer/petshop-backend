<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface TransformerCollection extends Transformer
{
    /**
     * @param \Illuminate\Support\Collection<int, \Illuminate\Database\Eloquent\Model> $payload
     * @return array<string, array<string, string>>
     */
    public function transform(Collection $payload) : array;
}
