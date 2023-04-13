<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use \Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\RecordsNotFoundException;
use \Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof Exception) {
            switch (get_class($e)) {
                case ValidationException::class:
                    break;
                case RecordsNotFoundException::class:
                case ModelNotFoundException::class:
                    return app(Controller::class)->replyNotFound();
                case AuthenticationException::class:
                    Log::info($e->getMessage());
                    break;
                case AuthorizationException::class:
                    Log::notice($e->getMessage());
                    break;
                default:
                    Log::error(get_class($e) . ' ' . $e->getMessage());
                    return app(Controller::class)->replyUnauthorized();
            }
        }

        return parent::render($request, $e);
    }
}
