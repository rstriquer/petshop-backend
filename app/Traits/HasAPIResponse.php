<?php

namespace App\Traits;

use App\Contracts\TransformerCollection;
use App\Contracts\TransformerItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contains base API responses to aggregate into controlles
 */
trait HasAPIResponse
{
    /**
     * Reply 200 HTTP_OK for simple items contents
     */
    function replyOkItem(Model $payload, TransformerItem $mask) : Response
    {
        return response()->json(
            $mask->transform($payload),
            Response::HTTP_OK
        );
    }
    /**
     * Reply 200 HTTP_OK for collections of items
     * @param \Illuminate\Support\Collection<int, \Illuminate\Database\Eloquent\Model> $payload
     */
    function replyOkCollection(
        Collection $payload,
        TransformerCollection $mask
    ) : Response
    {
        if ($payload->isEmpty()) {
            return $this->replyNoContent();
        }
        return response()->json($mask->transform($payload), Response::HTTP_OK);
    }
    /**
     * Reply 201 HTTP_CREATED telling the item was created successfully
     * @param array<int, string> $messages The complementary error messages which will be passed to content return.
     */
    public function replyCreated(array $messages = null) : Response
    {
        if ($messages !== null) {
            return response()->json(
                ['message' => $messages],
                Response::HTTP_CREATED
            );
        }
        return response(null, Response::HTTP_CREATED);
    }
    /**
     * Reply 202 HTTP_ACCEPTED for when actions will be carried out later
     * - Used in HTTP actions like create, delete or update.
     * @param array<int, string> $messages The complementary error messages which will be passed to content return.
     */
    public function replyAccepted(array $messages = null) : Response
    {
        if ($messages !== null) {
            return response()->json(
                ['message' => $messages],
                Response::HTTP_ACCEPTED
            );
        }
        return response(null, Response::HTTP_ACCEPTED);
    }
    /**
     * Reply 204 HTTP_NO_CONTENT
     * - Should be used for empty lists, delete action and whenever we need no
     * content on response body.
     */
    public function replyNoContent() : Response
    {
        return response(null, Response::HTTP_NO_CONTENT);
    }
    /**
     * Reply 401 HTTP_UNAUTHORIZED
     * @param array<int, string> $messages The complementary error messages which will be passed to content return.
     */
    public function replyUnauthorized(array $messages = null) : Response
    {
        if ($messages !== null) {
            return response()->json(
                ['message' => $messages],
                Response::HTTP_UNAUTHORIZED
            );
        }
        return response(null, Response::HTTP_UNAUTHORIZED);
    }
    /**
     * Reply 403 HTTP_FORBIDDEN
     * @param array<int, string> $messages The complementary error messages which will be passed to content return.
     */
    public function replyForbidden(array $messages = null) : Response
    {
        if ($messages !== null) {
            return response()->json(
                ['message' => $messages],
                Response::HTTP_FORBIDDEN
            );
        }
        return response(null, Response::HTTP_FORBIDDEN);
    }
    /**
     * Reply 404 HTTP_NOT_FOUND
     */
    public function replyNotFound() : Response
    {
        return response(null, Response::HTTP_NOT_FOUND);
    }
    /**
     * Reply 422 HTTP_UNPROCESSABLE_ENTITY
     * - Describe user error when trying to submit a somehow incorrect payload to server;
     * @param array<int, string> $messages The complementary error messages which will be passed to content return.
     */
    public function replyUnprocessableEntity(array $messages = null) : Response
    {
        if ($messages !== null) {
            return response()->json(
                ['message' => $messages],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    /**
     * Reply 500 HTTP_INTERNAL_SERVER_ERROR
     * @param array<int, string> $messages The complementary error messages which will be passed to content return.
     */
    public function replyServerError(array $messages = null) : Response
    {
        if ($messages !== null) {
            return response()->json(
                ['message' => $messages],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
