<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
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
        if ($exception instanceof \Ultraware\Roles\Exceptions\PermissionDeniedException) {
            /** Exception catch when deny access by permissions */
            $request->session()->flash('message', [
                'type' => 'deny', 'msg' => 'No dispone de permisos para acceder a esta funcionalidad'
            ]);
            return redirect()->back();
        }

        if ($exception instanceof \Ultraware\Roles\Exceptions\LevelDeniedException) {
            /** Exception catch when deny access by levels */
            $request->session()->flash('message', [
                'type' => 'deny', 'msg' => 'Su nivel de acceso no le permite acceder a esta funcionalidad'
            ]);
            return redirect()->back();
        }

        if ($exception instanceof \Ultraware\Roles\Exceptions\RoleDeniedException) {
            /** Exception catch when deny access by roles */
            $request->session()->flash('message', [
                'type' => 'deny', 'msg' => 'El rol asignado no le permite acceder a esta funcionalidad'
            ]);
            return redirect()->back();
        }
        return parent::render($request, $exception);
    }
}
