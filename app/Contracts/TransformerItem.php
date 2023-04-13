<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface TransformerItem extends Transformer
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $payload
     * @return array<string, array<string, string>>
     */
    public function transform(Model $payload) : array;
}
