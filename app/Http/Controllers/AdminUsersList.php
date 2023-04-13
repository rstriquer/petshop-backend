<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\RecordsNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AdminUsersList extends Controller
{
    /**
     * @var string
     */
    private string $sortBy;
    /**
     * @OA\Get  (
     *  operationId="AdminUsersList",
     *  path="/api/v1/admin/user-listing",
     *  summary="List all users",
     *  tags={"Admin"},
     *  security={{"bearer"={}}},
     *  @OA\Parameter(name="page", in="path", @OA\Schema(type="integer")),
     *  @OA\Parameter(name="limit", in="path", @OA\Schema(type="integer")),
     *  @OA\Parameter(name="sortBy", in="path", @OA\Schema(type="string")),
     *  @OA\Parameter(name="desc", in="path", @OA\Schema(type="boolean")),
     *  @OA\Parameter(name="first_name", in="path", @OA\Schema(type="string")),
     *  @OA\Parameter(name="email", in="path", @OA\Schema(type="string")),
     *  @OA\Parameter(name="phone", in="path", @OA\Schema(type="string")),
     *  @OA\Parameter(name="address", in="path", @OA\Schema(type="string")),
     *  @OA\Parameter(name="created_at", in="path", @OA\Schema(type="string")),
     *  @OA\Parameter(
     *      name="marketing",
     *      in="path",
     *      @OA\Schema(type="string", enum={"0", "1"})
     *  ),
     *  @OA\Response(response="200", description="Ok"),
     *  @OA\Response(response="401", description="Unauthorized"),
     *  @OA\Response(response="404", description="Page not found"),
     *  @OA\Response(response="422", description="Unprocessable Entity"),
     *  @OA\Response(response="500", description="Internal server error")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $user = app(User::class);

        $this->applyQueryFilters($user);

        $result = $user->get()->makeHidden(['id']);

        throw_if($result->isEmpty(), RecordsNotFoundException::class);

        return response()->json($result, Response::HTTP_OK);
    }
    /**
     * Appluy query filters
     */
    private function applyQueryFilters(User $user) : void
    {
        if ($this->buildSortBy()) {
            $user->orderBy($this->sortBy);
        }
    }
    /**
     * Build sortBy attribute and return true or false if there is no sort to be done
     */
    private function buildSortBy() : bool
    {
        if (request()->get('sortBy') === null) {
            return false;
        }
        $this->sortBy = implode('', array_intersect(
            [ /* valid fields */
                'uuid', 'first_name', 'last_name', 'is_admin', 'email',
                'email_verified_at', 'password', 'avatar', 'address',
                'phone_number', 'is_marketing', 'last_login_at',
            ],
            explode(',', str_replace(' ', '', request()->get('sortBy')))
        ));

        return $this->sortBy !== '';
    }
}
