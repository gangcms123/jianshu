<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
       /* // 没有权限访问
        if ($exception instanceof ForbiddenException) {
            $message      = $exception->getMessage() ?: '您没有权限操作';
            $code     = $exception->getCode() ?: 401;
            $redirect = $exception->getRedirect() ?: route('error.401');

            return $request->ajax() || $request->wantsJson() ? response()->json([ 'message' => $message ],
                $code) : response(view('message.401', compact('code', 'message', 'redirect')), $code);
        }*/

       /* // FirstOrFail 和 FindOrFail 异常处理
        if ($exception instanceof ModelNotFoundException) {
            // 如果删除的内容已经不存在了，就没必要报错了，直接成功处理
            if ('DELETE' === strtoupper(Request::method())) {
                return Response::json([ 'success' => true ]);
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([ 'message' => '没有找到' ], 404);
            } else {
                return response()->view('errors.404', [ ], 404);
            }
        }*/
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
