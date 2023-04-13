<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenAPi\Annotations as OA;

/**
 * @OA\Info(
 *   title="Pet Shop Server", version="1.0-rc",
 *   description="<h2>Limits</h2> We will send 429 (too many requests) HTTP CODE whenever necessary."
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
