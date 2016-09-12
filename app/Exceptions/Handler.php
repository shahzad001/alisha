<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        if($request->wantsJson()) {
            $class_name = get_class($e);
            $class_name = explode('\\', $class_name);
            if(count($class_name) > 1) {
                $class_name = array_reverse($class_name);
            }
            $class_name = $class_name[0];
            $file = '';
            $line = 0;
            $status_code = 500;
            $exception_message = $e->getMessage();
            if(method_exists($e, 'getStatusCode')) $status_code = $e->getStatusCode();
            if($status_code === 500) {
                $status_code = 200;
                if($e->getFile()) $file = $e->getFile();
                if($e->getLine()) $line = $e->getLine();
            } else if($class_name == 'JWTException') {
                $status_code = 200;
                $exception_message = 'Sorry! you are not authorized to perform this action, please try again after re-login';
            }
            return response()->json([
                'error' => [
                    'type' => $class_name,
                    'message' => $exception_message,
                    'file' => $file,
                    'line' => $line
                ]
            ], $status_code);
        }
        return parent::render($request, $e);
    }
}
