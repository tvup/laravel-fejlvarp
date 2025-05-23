<?php

namespace Tvup\LaravelFejlvarp\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as LaravelExceptionHandler;
use Illuminate\Foundation\Exceptions\Renderer\Listener;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LaravelFejlvarpExceptionHandler extends LaravelExceptionHandler
{
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc. oO(is it?)
     *
     * @param Throwable $e
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $e) : void
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        $this->fejlvarp_exception_handler($e);

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e)
    {
        return parent::render($request, $e);
    }

    private function fejlvarp_exception_handler(Throwable $exception) : void
    {
        // Generate unique hash from message + file + line number
        // We strip out revision-part of the file name.
        // Assuming a standard capistrano deployment path, this will prevent duplicates across deploys.
        $appName = config('app.name');
        assert(is_string($appName));
        $hash = $appName
            . $exception->getMessage()
            . preg_replace('~revisions/[0-9]{14}/~', '--', $exception->getFile())
            . $exception->getLine();
        $user = request()->user();

        $data = [
            'hash' => md5($hash),
            'subject' => $exception->getMessage() ? $exception->getMessage() : 'Subject is empty',
            'data' => json_encode([
                'application' => config('app.name'),
                'error' => [
                    'type' => get_class($exception),
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                ],
                'environment' => [
                    'GET' => $_GET ?: null,
                    'POST' => $_POST ?: null,
                    'SERVER' => $_SERVER ?: null,
                    'SESSION' => request()->hasSession() ? request()->session()->all() : null,
                ],
                'application_data' => $user ? [
                    'user' => $user->toArray(),
                ] : null,
                'queries' => app(Listener::class)->queries(),
            ], JSON_THROW_ON_ERROR),
        ];
        $request = Request::create(
            '/api/incidents',
            'POST',
            $data,
            [],
            [],
            ['CONTENT_TYPE'=>'application/x-www-form-urlencoded']
        );
        app()->handle($request);
    }
}
