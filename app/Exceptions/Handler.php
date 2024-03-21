<?php

namespace App\Exceptions;

use App\Traits\HttpResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    use HttpResponse;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (Throwable $e) {
            $message = "Internal Server Error";
            $responseCode = 500;
            $errorMessage = $e->getMessage();
            $payload = json_encode(request()->all());
            $errorTrace = json_encode($e->getTrace());
            Log::error('
                Message: '.$errorMessage.'
                Payload: '.$payload.'
                Error Trace: '.$errorTrace.'
            ');
            if(!auth()->user() && !auth()->guest()){
                $message = "Unauthorized";
                $responseCode = 401;
            }
            return $this->apiResponseErrors(message:$message, code: $responseCode);
        });
    }
}
