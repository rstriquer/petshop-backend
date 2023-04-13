<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserLogin as AdminUserLoginRequest;
use App\Models\User;
use App\Services\Authenticator;
use App\Transformers\AdminUserLogin as AdminUserLoginTransformer;
use \Exception;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\Auth;
use \Log;
use Symfony\Component\HttpFoundation\Response;

class AdminUserLogin extends Controller
{
    /**
     * @OA\Post (
     *  operationId="AdminUserLogin",
     *  path="/api/v1/admin/login",
     *  tags={"Admin"},
     *  summary="Login an Admin account",
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              required={"email", "password"},
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  description="User email"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  description="User password"
     *              ),
     *          ),
     *      ),
     *  ),
     *  @OA\Response(response="200", description="Ok"),
     *  @OA\Response(response="401", description="Unauthorized"),
     *  @OA\Response(response="404", description="Page not found"),
     *  @OA\Response(response="422", description="Unprocessable Entity"),
     *  @OA\Response(response="500", description="Internal server error")
     * )
     */
    public function __invoke(AdminUserLoginRequest $payload) : Response
    {
        $credentials = array_merge($payload->validated(), ['is_admin' => '1']);

        if (Auth::once($credentials) === false) {
            return $this->replyUnauthorized();
        }

        $Authenticator = new Authenticator($payload, config('app.key'));
        
        /** @var $user \App\Models\User  */
        $user = Auth::user();
        
        return $this->replyOkItem(
            $user,
            app(AdminUserLoginTransformer::class)
        );
    }
}
