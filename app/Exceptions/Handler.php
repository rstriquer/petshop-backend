<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use \Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        switch (get_class($e)) {
            case 'RecordsNotFoundException':
            case 'ModelNotFoundException':
                return app(Controller::class)->replyNotFound();
            case 'AuthenticationException':
                Log::info($e->getMessage());
                return app(Controller::class)->replyForbidden();
            case 'AuthorizationException':
                Log::notice($e->getMessage());
                return app(Controller::class)->replyUnauthorized();
        }

        if ($e instanceof Exception) {
            Log::error($e->getMessage());
            return app(Controller::class)->replyUnauthorized();
        }

        return parent::render($request, $e);
    }
}
